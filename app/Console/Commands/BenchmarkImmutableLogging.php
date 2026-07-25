<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\HKIProposal;
use App\Models\User;
use App\Events\AuditLogRequested;
use Illuminate\Support\Facades\DB;

class BenchmarkImmutableLogging extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hki:benchmark-logging {--iterations=100 : Jumlah iterasi pengujian}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menguji dan membandingkan performa pencatatan (waktu eksekusi) saat menggunakan Immutable Logging vs tanpa Immutable Logging.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $iterations = (int) $this->option('iterations');
        
        $this->info("Memulai Benchmark Performa Immutable Logging...");
        $this->info("Jumlah iterasi: {$iterations}");
        $this->newLine();

        if (app()->environment('production')) {
            $this->error("PENGUJIAN DIBATALKAN: Anda berada di environment production. Immutable logging tidak bisa dimatikan di production.");
            return;
        }

        // Siapkan data dummy
        $user = User::first() ?? User::factory()->create();
        $proposal = HKIProposal::first();

        if (!$proposal) {
            $this->error("Tidak ada data proposal di database untuk pengujian. Silakan buat 1 proposal terlebih dahulu.");
            return;
        }

        $dummyPayload = [
            'action' => 'BENCHMARK_TEST',
            'data' => 'This is a sample payload to simulate average audit log size.',
            'timestamp' => now()->toIso8601String()
        ];
        $dummySignature = str_repeat('a', 64);

        // --- SKENARIO 1: TANPA IMMUTABLE LOGGING ---
        $this->info("Skenario 1: MENJALANKAN TANPA IMMUTABLE LOGGING (Forensik Mati)...");
        config(['hki.features.immutable_logging' => false]);
        
        $startWithout = microtime(true);
        $this->withProgressBar($iterations, function () use ($proposal, $dummyPayload, $dummySignature, $user) {
            AuditLogRequested::dispatch(
                HKIProposal::class,
                $proposal->id,
                'BENCHMARK_TEST_WITHOUT_LOG',
                $dummyPayload,
                $dummySignature,
                $user->id
            );
        });
        $endWithout = microtime(true);
        $timeWithout = $endWithout - $startWithout;
        $this->newLine(2);

        // --- SKENARIO 2: DENGAN IMMUTABLE LOGGING ---
        $this->info("Skenario 2: MENJALANKAN DENGAN IMMUTABLE LOGGING (Forensik Aktif)...");
        config(['hki.features.immutable_logging' => true]);
        
        $startWith = microtime(true);
        $this->withProgressBar($iterations, function () use ($proposal, $dummyPayload, $dummySignature, $user) {
            AuditLogRequested::dispatch(
                HKIProposal::class,
                $proposal->id,
                'BENCHMARK_TEST_WITH_LOG',
                $dummyPayload,
                $dummySignature,
                $user->id
            );
        });
        $endWith = microtime(true);
        $timeWith = $endWith - $startWith;
        $this->newLine(2);

        // --- KALKULASI HASIL ---
        $diff = $timeWith - $timeWithout;
        $diffPercentage = $timeWithout > 0 ? ($diff / $timeWithout) * 100 : 0;
        
        $avgWithout = ($timeWithout / $iterations) * 1000; // dalam ms
        $avgWith = ($timeWith / $iterations) * 1000; // dalam ms

        $this->table(
            ['Metrik Pengujian', 'Tanpa Immutable Logging (Mati)', 'Dengan Immutable Logging (Aktif)', 'Selisih / Overhead'],
            [
                [
                    'Total Waktu (' . $iterations . ' iterasi)', 
                    number_format($timeWithout, 4) . ' detik', 
                    number_format($timeWith, 4) . ' detik', 
                    number_format($diff, 4) . ' detik'
                ],
                [
                    'Rata-rata Waktu per Request', 
                    number_format($avgWithout, 2) . ' ms', 
                    number_format($avgWith, 2) . ' ms', 
                    '+' . number_format($avgWith - $avgWithout, 2) . ' ms'
                ]
            ]
        );

        $this->newLine();
        $this->info("Kesimpulan:");
        if ($diffPercentage > 0) {
            $this->warn("Fitur Immutable Logging (SHA-256 Hashing & Database Insert) memberikan overhead performa sebesar " . number_format($diffPercentage, 2) . "% (" . number_format($avgWith - $avgWithout, 2) . " ms per request).");
        } else {
            $this->info("Fitur Immutable Logging tidak memberikan overhead yang signifikan.");
        }

        // Hapus log sampah hasil benchmark
        $this->info("Membersihkan data log hasil benchmark...");
        DB::table('hki_audit_logs')->where('action', 'BENCHMARK_TEST_WITH_LOG')->delete();
        $this->info("Selesai.");
    }
}
