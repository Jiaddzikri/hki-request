<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserMasterSecret;
use Illuminate\Support\Facades\File;

class TestHackerReconstructCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hki:test-hacker-reconstruct {physical_share?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mensimulasikan peretas yang menggunakan Share 2 (DB) dan Share 3 (Fisik) untuk merekonstruksi Master Secret';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("====================================================");
        $this->warn("  SIMULASI PERETAS: REKONSTRUKSI SSS (SHARE 2 & 3)");
        $this->info("====================================================\n");

        $physicalShare = $this->argument('physical_share') ?? '03d232aa167542e8e9f606250e0dcefb01f7d6aaef7f2d9fb034929cd1114510a3';

        // 1. Ekstrak Institutional Share (Share 2) dari tabel
        $this->line("1. Mengambil Institutional Share (Share 2) dari Database...");
        $masterSecret = UserMasterSecret::first();

        if (!$masterSecret) {
            $this->error("Tidak ada data SSS di database.");
            return;
        }

        $institutionalShare = $masterSecret->institutional_share;
        $this->line("<fg=green>Berhasil didapatkan!</> -> <fg=gray>" . substr($institutionalShare, 0, 16) . "...</>");
        $this->line("Target Hash di DB: <fg=cyan>{$masterSecret->secret_hash}</>\n");

        // 2. Gunakan Physical Share (Share 3) yang dicuri
        $this->line("2. Menggunakan Physical Backup Share (Share 3) hasil curian...");
        $this->line("<fg=yellow>Share Fisik:</> <fg=gray>" . substr($physicalShare, 0, 16) . "...</>\n");

        // 3. Eksekusi Rekonstruksi via Node.js Script
        $this->line("3. Mengeksekusi Interpolasi Lagrange (menggabungkan Share 2 & 3)...");

        // Kita buat script JS temporary untuk menggunakan modul 'shamir' NPM
        $jsScriptPath = storage_path('app/temp_reconstruct.js');
        $jsCode = <<<JS
            import { join } from 'shamir';
            import crypto from 'crypto';

            try {
                const shares = [
                    "{$physicalShare}",
                    "{$institutionalShare}"
                ];

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
                
                // Hash hasil untuk dicocokkan dengan DB
                const hash = crypto.createHash('sha256').update(secretHex).digest('hex');
                
                console.log(JSON.stringify({
                    success: true,
                    secret: secretHex,
                    hash: hash
                }));
            } catch (err) {
                console.log(JSON.stringify({
                    success: false,
                    error: err.message
                }));
            }
            JS;
        File::put($jsScriptPath, $jsCode);

        // Eksekusi Node.js
        $nodeOutput = shell_exec("node {$jsScriptPath}");
        File::delete($jsScriptPath); // Hapus file temporary

        $result = json_decode(trim($nodeOutput), true);

        if (!$result || !isset($result['success'])) {
            $this->error("Gagal mengeksekusi library NPM 'shamir'. Pastikan node.js terinstall.");
            return;
        }

        if (!$result['success']) {
            $this->error("Rekonstruksi Gagal: " . $result['error']);
            return;
        }

        $this->line("<fg=green>Rekonstruksi Berhasil!</>\n");
        $this->line("<options=bold>Master Secret (Raw Hex):</>");
        $this->line("<fg=magenta>{$result['secret']}</>\n");

        $this->line("<options=bold>Hash Master Secret (Untuk Login Server):</>");
        
        if ($result['hash'] === $masterSecret->secret_hash) {
            $this->line("<bg=green;fg=white;options=bold> MATCH </> <fg=green>{$result['hash']}</>");
            $this->info("\nKESIMPULAN: Peretas BERHASIL merekonstruksi kunci dan mendapatkan akses penuh ke akun karena mendapatkan minimal k=2 pecahan (Share 2 & Share 3).");
        } else {
            $this->line("<bg=red;fg=white;options=bold> MISMATCH </> <fg=red>{$result['hash']}</>");
            $this->warn("\nKESIMPULAN: Share tidak valid atau bukan berasal dari set Master Secret yang sama.");
        }
        
        $this->info("====================================================\n");
    }
}
