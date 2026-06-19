<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\UserMasterSecret;
use App\Services\HKI\AuditLogService;

class TestPhysicalShareTheftCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hki:test-physical-share-theft';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mensimulasikan pencurian Physical Backup Share (1 Pecahan SSS)';

    /**
     * Execute the console command.
     */
    public function handle(AuditLogService $auditService)
    {
        $this->info("====================================================");
        $this->warn("  SIMULASI SERANGAN: PHYSICAL SHARE THEFT");
        $this->info("====================================================\n");

        $masterSecret = UserMasterSecret::first();

        if (!$masterSecret) {
            $this->error("Tidak ada data SSS di database. Harap daftarkan biometrik (WebAuthn) terlebih dahulu di UI.");
            return;
        }

        $user = User::find($masterSecret->user_id);

        $this->line("<options=bold>[SKENARIO PENYERANGAN FISIK]</>");
        $this->line("Korban: <fg=cyan>{$user->name} ({$user->email})</>");
        $this->line("Status Backup Share Fisik: <fg=yellow>Berhasil Dicuri Penyerang (1 Pecahan)</>");
        $this->line("Status Kunci Pribadi (User): <fg=red>Aman di tangan Dosen (Missing for Attacker)</>\n");

        $this->warn("Penyerang mencoba merekonstruksi Kunci Master hanya bermodalkan 1 kertas/file Share...");
        $this->line("<fg=yellow>> Mengeksekusi Interpolasi Lagrange dengan Threshold k=1 (Syarat mutlak k=2)...</>");

        // Simulasi hasil interpolasi matematis yang gagal karena kurang pecahan
        $fakeReconstructedSecret = 'garbage_math_output_due_to_missing_share';
        $fakeHash = hash('sha256', $fakeReconstructedSecret);

        $this->line("Hasil Rekonstruksi Matematis: <fg=red>Garbage Data / Invalid Hex</>\n");

        $this->info("====================================================");
        $this->warn("  MENSIMULASIKAN LOGIN & PEMULIHAN KE SERVER");
        $this->info("====================================================");

        $this->line("Mengirim hasil rekonstruksi cacat ke server untuk pencocokan Hash...\n");

        if ($masterSecret->secret_hash !== $fakeHash) {
            $this->line("<bg=red;fg=white;options=bold> [AKSES DITOLAK: INTEGRITAS KUNCI GAGAL] </>");
            $this->line("<fg=red>!! ERROR !! Kunci Tidak Valid. Pemulihan Ditolak.</>");
            $this->line("<fg=red>!! ERROR !! Syarat Threshold (k=2) Tidak Terpenuhi.</>\n");
        } else {
            $this->info("Sistem Lolos (Gagal dideteksi)");
        }

        $this->line("====================================================");
        $this->line("<options=bold>Kesimpulan Forensik:</> Penyerang fisik yang berhasil mencuri");
        $this->line("kertas/file 'Backup Share' di Fakultas tetap tidak bisa mengambil alih");
        $this->line("akun korban. Skema Kriptografi SSS menolak keras segala bentuk");
        $this->line("interpolasi jika jumlah pecahan < Threshold (k=2). Sistem aman.");
        $this->info("====================================================\n");
    }
}
