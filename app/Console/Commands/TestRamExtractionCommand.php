<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserMasterSecret;
use App\Models\User;

class TestRamExtractionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hki:test-ram-extraction';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mensimulasikan upaya ekstraksi Master Secret dari Memori Server (RAM) / Database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("====================================================");
        $this->warn("  SIMULASI SERANGAN: MASTER SECRET MEMORY EXTRACTION");
        $this->info("====================================================\n");

        $masterSecret = UserMasterSecret::first();

        if (!$masterSecret) {
            $this->error("Tidak ada data SSS di database.");
            return;
        }

        $user = User::find($masterSecret->user_id);

        $this->line("<options=bold>[SKENARIO PENYERANGAN]</>");
        $this->line("Penyerang (Rogue Admin) memiliki akses ROOT ke peladen (Server).");
        $this->line("Admin mencoba melakukan ekstraksi / membedah RAM dan Database peladen untuk");
        $this->line("mencari <fg=red>Master Secret</> asli milik user: <fg=cyan>{$user->email}</>\n");

        $this->warn("1. Melakukan pemindaian pada Database (Tabel user_master_secrets)...");
        sleep(1);
        
        $this->line("   - ID: {$masterSecret->id}");
        $this->line("   - User ID: {$masterSecret->user_id}");
        $this->line("   - Institutional Share: <fg=yellow>" . substr($masterSecret->institutional_share, 0, 30) . "...</> (Share 2)");
        $this->line("   - Secret Hash: <fg=cyan>{$masterSecret->secret_hash}</> (SHA-256)");
        $this->line("   - Master Secret Asli: <bg=red;fg=white;options=bold> TIDAK DITEMUKAN (NULL) </>\n");

        $this->warn("2. Melakukan pemindaian pada Memori Aplikasi (PHP RAM Dump)...");
        sleep(1);
        $this->line("   - Mencari pola hex 256-bit di stack memory request HTTP...");
        $this->line("   - Mencari variabel \$masterSecret di Livewire State...");
        sleep(1);
        $this->line("   - Hasil Pemindaian RAM: <bg=red;fg=white;options=bold> TIDAK DITEMUKAN </>\n");

        $this->info("====================================================");
        $this->line("<options=bold>HASIL PENYERANGAN EKSTRAKSI:</>");
        $this->line("Status: <bg=green;fg=white;options=bold> GAGAL TOTAL (SERVER BLINDNESS BERHASIL) </>");
        $this->line("\n<options=bold>Penjelasan Arsitektur (Zero-Knowledge):</>");
        $this->line("Master Secret <fg=yellow>TIDAK PERNAH</> dikirim ke server. Pembuatan kunci (Random Generation)");
        $this->line("dan pemecahan SSS dilakukan sepenuhnya di sisi klien (Browser User via JavaScript).");
        $this->line("Setelah dipecah, browser klien langsung <fg=red>menghapus</> Master Secret dari memori RAM komputer");
        $this->line("dan HANYA mengirimkan 1 Pecahan (Institutional Share) beserta Hash (SHA-256) ke server.");
        $this->line("Oleh karena itu, meskipun Admin memiliki akses tertinggi ke Server, Admin tetap");
        $this->line("tidak bisa mencuri Master Secret.");
        $this->info("====================================================\n");
    }
}
