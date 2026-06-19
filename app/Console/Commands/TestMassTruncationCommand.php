<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\HkiSystemState;
use App\Services\HKI\AuditLogService;

class TestMassTruncationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hki:test-mass-truncation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mensimulasikan serangan Mass Log Truncation pada sistem HKI';

    /**
     * Execute the console command.
     */
    public function handle(AuditLogService $auditService)
    {
        $this->info("====================================================");
        $this->warn("  SIMULASI SERANGAN: MASS LOG TRUNCATION");
        $this->info("====================================================\n");

        $state = HkiSystemState::where('key', 'global_audit_state')->first();
        $totalLogs = DB::table('hki_audit_logs')->count();

        $this->line("<options=bold>[STATUS AWAL]</>");
        $this->line("Global Hash Asli: " . ($state ? substr($state->current_global_hash, 0, 20) . "..." : "Kosong"));
        $this->line("Total Log di Database: <fg=green>{$totalLogs} baris</>\n");

        $this->warn("Mengeksekusi Serangan Penghapusan Masif...");
        $this->line("<fg=red>> DELETE FROM hki_audit_logs;</>");

        // 1. Hacker menghapus seluruh isi tabel audit log
        DB::table('hki_audit_logs')->delete();

        $logsAfter = DB::table('hki_audit_logs')->count();
        $this->line("Total Log Sekarang: <fg=red>{$logsAfter} baris (Hacker berhasil menghapus jejak!)</>\n");

        $this->info("====================================================");
        $this->warn("  MENSIMULASIKAN AUDITOR MENJALANKAN GLOBAL AUDIT");
        $this->info("====================================================");

        // 2. Sistem melakukan Audit Menyeluruh (Global Audit)
        $this->line("Menjalankan verifyChain() secara Global...");
        $result = $auditService->verifyChain();

        if (!$result['is_valid']) {
            $this->line("\n<bg=red;fg=white;options=bold> [ALARM SISTEM MENYALA] </>");
            foreach ($result['errors'] as $error) {
                if (strpos($error['error'], 'GLOBAL_TRUNCATION') !== false || strpos($error['error'], 'TRUNCATION_ATTACK') !== false) {
                    $this->line("<fg=red>!! ERROR !! {$error['error']}</>");
                }
            }
        } else {
            $this->info("Sistem Lolos (Gagal dideteksi)");
        }

        $this->line("\n====================================================");
        $this->line("<options=bold>Kesimpulan:</> Hacker berhasil menghapus seluruh log di tabel,");
        $this->line("tetapi karena dia tidak bisa merekayasa ulang 'Global Hash'");
        $this->line("di tabel hki_system_states (yang menyimpan kompresi total),");
        $this->line("sistem langsung mendeteksi adanya penghapusan masif!");
        $this->info("====================================================\n");
    }
}
