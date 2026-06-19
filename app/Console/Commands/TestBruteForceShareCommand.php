<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserMasterSecret;
use Illuminate\Support\Facades\File;

class TestBruteForceShareCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hki:test-brute-force {iterations=10000}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mensimulasikan Brute-Force Attack pada Share SSS (Membuktikan Information Theoretic Security)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $iterations = (int) $this->argument('iterations');

        $this->info("====================================================");
        $this->warn("  SIMULASI SERANGAN: BRUTE-FORCE PADA SSS SHARE");
        $this->info("====================================================\n");

        $masterSecret = UserMasterSecret::first();

        if (!$masterSecret) {
            $this->error("Tidak ada data SSS di database.");
            return;
        }

        $institutionalShare = $masterSecret->institutional_share;
        $targetHash = $masterSecret->secret_hash;

        $this->line("<options=bold>[SKENARIO PENYERANGAN]</>");
        $this->line("1. Penyerang hanya memiliki <fg=yellow>1 Pecahan (Share 2)</> dari Database.");
        $this->line("   Share 2: <fg=gray>" . substr($institutionalShare, 0, 16) . "...</>");
        $this->line("2. Threshold adalah k=2. Penyerang butuh 1 pecahan lagi.");
        $this->line("3. Penyerang mencoba melakukan <fg=red>Brute-Force</> dengan menebak-nebak Share 3 (Random Hex).");
        $this->line("4. Jumlah tebakan (Iterasi): <fg=cyan>{$iterations} kali</>\n");

        $this->warn("Memulai proses Brute-Force (Node.js script worker)...");
        
        $bar = $this->output->createProgressBar($iterations);
        $bar->start();

        //  Node.js script untuk menjalankan brute force secara cepat di background
        $jsScriptPath = storage_path('app/temp_bruteforce.js');
        $jsCode = <<<JS
            import { join } from 'shamir';
            import crypto from 'crypto';

            const args = process.argv.slice(2);
            const institutionalShare = args[0];
            const targetHash = args[1];
            const iterations = parseInt(args[2]);

            // Share structure in our system: [ID (1 byte hex)] + [Data (32 bytes hex)]
            // e.g. "03" + "d232aa167542e8e9f606250e0dcefb01f7d6aaef7f2d9fb034929cd1114510a3"
            
            let matched = false;
            let matchedSecret = null;
            let matchedShare = null;
            
            for (let i = 0; i < iterations; i++) {
                // Generate a random Share 3 guess (64 hex characters = 32 bytes)
                const randomBytes = crypto.randomBytes(32).toString('hex');
                const fakeShare3 = "03" + randomBytes; // ID 03 = Share 3
                
                try {
                    const shares = [institutionalShare, fakeShare3];
                    const parts = {};
                    shares.forEach(share => {
                        const id = parseInt(share.substring(0, 2), 16);
                        const dataHex = share.substring(2);
                        const dataMatches = dataHex.match(/.{1,2}/g);
                        if (dataMatches) {
                            parts[id] = new Uint8Array(dataMatches.map(byte => parseInt(byte, 16)));
                        }
                    });

                    const secret = join(parts);
                    const secretHex = Array.from(secret).map(b => b.toString(16).padStart(2, '0')).join('');
                    
                    const hash = crypto.createHash('sha256').update(secretHex).digest('hex');
                    
                    if (hash === targetHash) {
                        matched = true;
                        matchedSecret = secretHex;
                        matchedShare = fakeShare3;
                        break;
                    }
                } catch (e) {
                    // Ignore errors during brute force (e.g. invalid array bounds)
                }
            }

            console.log(JSON.stringify({
                success: true,
                matched: matched,
                matchedSecret: matchedSecret,
                matchedShare: matchedShare,
                iterationsDone: iterations
            }));
            JS;

        File::put($jsScriptPath, $jsCode);

        // Eksekusi Node.js dengan argument
        $command = sprintf("node %s %s %s %d", 
            $jsScriptPath, 
            escapeshellarg($institutionalShare), 
            escapeshellarg($targetHash), 
            $iterations
        );

        $nodeOutput = shell_exec($command);
        File::delete($jsScriptPath);

        $bar->finish();
        $this->line("\n");

        $result = json_decode(trim($nodeOutput), true);

        if (!$result || !isset($result['success'])) {
            $this->error("Gagal mengeksekusi script Brute-Force.");
            return;
        }

        $this->info("====================================================");
        $this->line("<options=bold>HASIL PENYERANGAN BRUTE-FORCE:</>");
        $this->line("Total Percobaan: <fg=cyan>{$iterations}</>");
        
        if ($result['matched']) {
            $this->line("Status: <bg=red;fg=white;options=bold> BERHASIL DIRETAS (KEMUNGKINAN 1 BANDING 2^256) </>");
            $this->line("Ditemukan Share: " . $result['matchedShare']);
            $this->line("Master Secret: " . $result['matchedSecret']);
        } else {
            $this->line("Status: <bg=green;fg=white;options=bold> GAGAL TOTAL </>");
            $this->line("\n<options=bold>Penjelasan Kriptografi (Information Theoretic Security):</>");
            $this->line("Meskipun penyerang membuat {$iterations} kombinasi tebakan, Shamir's Secret Sharing");
            $this->line("secara matematis memastikan bahwa tanpa jumlah pecahan yang memenuhi Threshold (k=2),");
            $this->line("setiap tebakan akan menghasilkan Master Secret yang <fg=red>berbeda dan sepenuhnya acak</>.");
            $this->line("Tidak ada satupun pola yang membocorkan bagian dari Master Secret asli, menjadikan SSS");
            $this->line("sangat mustahil untuk di-Brute-Force (Kebal Tebakan).");
        }
        $this->info("====================================================\n");
    }
}
