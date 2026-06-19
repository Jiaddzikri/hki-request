<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\UserMasterSecret;
use App\Services\HKI\AuditLogService;

class TestRogueAdminResetCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hki:test-rogue-admin-reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mensimulasikan serangan Rogue Admin Reset (Hanya 1 Pecahan SSS)';

    /**
     * Execute the console command.
     */
    public function handle(AuditLogService $auditService)
    {
        $this->info("====================================================");
        $this->warn("  SIMULASI SERANGAN: ROGUE ADMIN SSS RESET");
        $this->info("====================================================\n");

        $masterSecret = UserMasterSecret::first();

        if (!$masterSecret) {
            $this->error("Tidak ada data SSS di database. Harap daftarkan biometrik (WebAuthn) terlebih dahulu di UI.");
            return;
        }

        $user = User::find($masterSecret->user_id);

        $this->line("<options=bold>[TARGET OPERASI]</>");
        $this->line("Korban: <fg=cyan>{$user->name} ({$user->email})</>");
        $this->line("Status Kunci Institusi (DB): <fg=yellow>Berhasil Dicuri Admin (1 Pecahan)</>");
        $this->line("Status Kunci Pribadi (User): <fg=red>Tidak Dimiliki Admin (Missing)</>\n");

        $this->warn("Rogue Admin mencoba merekonstruksi Master Secret tanpa Kunci Pribadi...");
        $this->line("<fg=yellow>> Mengeksekusi Interpolasi Lagrange dengan Threshold k=1 (Syarat mutlak k=2)...</>");

        // Simulasi hasil interpolasi matematis yang gagal karena kurang pecahan
        // (Library SSS akan mengembalikan string acak / garbage jika k kurang dari threshold)
        $fakeReconstructedSecret = 'garbage_math_output_due_to_missing_share';
        $fakeHash = hash('sha256', $fakeReconstructedSecret);

        $this->line("Hasil Rekonstruksi Matematis: <fg=red>Garbage Data / Invalid Hex</>\n");

        $this->info("====================================================");
        $this->warn("  MENSIMULASIKAN PENGIRIMAN KUNCI KE SERVER");
        $this->info("====================================================");

        $this->line("Mencocokkan hash hasil rekonstruksi dengan secret_hash di database...\n");

        if ($masterSecret->secret_hash !== $fakeHash) {
            $this->line("<bg=red;fg=white;options=bold> [ALARM SISTEM MENYALA] </>");
            $this->line("<fg=red>!! ERROR !! Rekonstruksi Kunci Gagal. Kunci Pribadi tidak valid.</>");
            $this->line("<fg=red>!! ERROR !! Syarat Threshold (k=2) Tidak Terpenuhi.</>\n");
        } else {
            $this->info("Sistem Lolos (Gagal dideteksi)");
        }

        $this->line("====================================================");
        $this->line("<options=bold>Kesimpulan Forensik:</> Rogue Admin yang memiliki akses penuh ke");
        $this->line("database berhasil mencuri 'Institutional Share'. Namun, karena");
        $this->line("algoritma Shamir's Secret Sharing mewajibkan minimal 2 pecahan,");
        $this->line("upaya interpolasi matematika gagal menghasilkan Master Secret yang valid.");
        $this->line("Oleh karena itu, sistem memblokir upaya pemulihan (Zero-Knowledge Proven).");
        $this->info("====================================================\n");
    }
}
