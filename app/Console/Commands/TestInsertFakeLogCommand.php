<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\HKIProposal;
use App\Models\HKIAuditLog;
use App\Services\HKI\AuditLogService;

class TestInsertFakeLogCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hki:test-insert-fake-log';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mensimulasikan skenario Insert Fake Log oleh Insider Threat';

    /**
     * Execute the console command.
     */
    public function handle(AuditLogService $auditService)
    {
        $this->info("====================================================");
        $this->warn("  SIMULASI SERANGAN: INSERT FAKE LOG");
        $this->info("====================================================\n");

        // Cari log terakhir yang valid
        $lastLog = HKIAuditLog::orderBy('id', 'desc')->first();

        if (!$lastLog) {
            $this->error("Tidak ada log di database. Silakan seed database terlebih dahulu.");
            return;
        }

        $proposal = HKIProposal::find($lastLog->model_id);

        if (!$proposal) {
            $this->error("Proposal untuk log ini tidak ditemukan.");
            return;
        }

        $this->line("<options=bold>[TARGET OPERASI]</>");
        $this->line("Proposal ID: <fg=cyan>{$proposal->id}</>");
        $this->line("Log Terakhir ID: {$lastLog->id} (Action: {$lastLog->action})\n");

        $this->warn("Hacker mengeksekusi INSERT query langsung ke database...");
        
        $fakePayload = json_encode(['status' => 'APPROVED_BY_HACKER', 'notes' => 'Disetujui via Backdoor']);
        $fakeHash = hash('sha256', 'FAKE_HASH_DATA_YANG_SALAH');
        $timestamp = now()->format('Y-m-d H:i:s');

        $this->line("<fg=red>> INSERT INTO hki_audit_logs (action, payload, current_hash, digital_signature) VALUES ('APPROVED', '...', '{$fakeHash}', NULL);</>\n");

        // 1. Hacker menyisipkan log palsu
        $fakeLogId = DB::table('hki_audit_logs')->insertGetId([
            'user_id' => 1, // Asumsi ID hacker
            'model_type' => get_class($proposal),
            'model_id' => $proposal->id,
            'action' => 'APPROVED',
            'payload' => $fakePayload,
            'previous_hash' => $lastLog->current_hash, // Hacker mencoba menyambung rantai
            'current_hash' => $fakeHash, // Tapi gagal mengkalkulasi ulang hash yang valid
            'digital_signature' => null, // Tidak punya private key untuk membuat signature
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ]);

        $this->line("Log Palsu berhasil disisipkan dengan ID: <fg=red>{$fakeLogId}</>\n");

        $this->info("====================================================");
        $this->warn("  MENSIMULASIKAN AUDITOR MENJALANKAN VERIFIKASI");
        $this->info("====================================================");

        // 2. Sistem melakukan Audit
        $this->line("Menjalankan verifyChain() pada entitas proposal...");
        $result = $auditService->verifyChain($proposal->id, get_class($proposal));

        if (!$result['is_valid']) {
            $this->line("\n<bg=red;fg=white;options=bold> [ALARM SISTEM MENYALA] </>");
            foreach ($result['errors'] as $error) {
                if ($error['id'] == $fakeLogId) {
                    $this->line("<fg=red>!! ERROR DETECTED PADA LOG {$fakeLogId} !!</>");
                    $this->line("<fg=red>-> {$error['error']}</>");
                }
            }
        } else {
            $this->info("Sistem Lolos (Gagal dideteksi)");
        }

        $this->line("\n====================================================");
        $this->line("<options=bold>Kesimpulan:</> Hacker berhasil menyisipkan log persetujuan palsu");
        $this->line("tanpa menyertakan Digital Signature. Karena ia juga gagal");
        $this->line("memvalidasi kalkulasi algoritma SHA-256 yang diwajibkan sistem,");
        $this->line("modul integritas langsung mendeteksi bahwa rantai log tersebut");
        $this->line("mengalami cacat (Hash Mismatch) dan memblokir dokumen!");
        $this->info("====================================================\n");

        // Hapus log palsu agar tidak mengotori database untuk tes selanjutnya
        // DB::table('hki_audit_logs')->where('id', $fakeLogId)->delete();
    }
}
