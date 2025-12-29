<?php

namespace App\Http\Controllers;

use App\Models\LTRSubmission;
use Barryvdh\DomPDF\Facade\Pdf;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;

class GrantContractController extends Controller
{
    public function download($id)
    {
        $submission = LTRSubmission::with(['user', 'scheme', 'period', 'budgetDetails'])
            ->findOrFail($id);

        if ($submission->status !== 'APPROVED') {
            abort(403, 'Dokumen kontrak belum tersedia.');
        }

        if (auth()->id() !== $submission->user_id && !auth()->user()->hasRole(['super-admin', 'reviewer'])) {
            abort(403, 'Unauthorized.');
        }
        $validationUrl = route('grants.detail', $submission->id);

        $qrCode = new QrCode(
            data: $validationUrl,
            encoding: new Encoding('UTF-8'),
            size: 150,
            margin: 5,
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            roundBlockSizeMode: RoundBlockSizeMode::Margin
        );

        $writer = new PngWriter();

        $result = $writer->write($qrCode);
        $qrCodeDataUri = $result->getDataUri();

        $data = [
            's' => $submission,
            'qrCode' => $qrCodeDataUri,
            'nomor_kontrak' => 'KONTRAK/' . $submission->period->year . '/' . $submission->scheme->code . '/' . str_pad($submission->id, 3, '0', STR_PAD_LEFT),
            'tanggal_cetak' => now()->translatedFormat('d F Y'),
        ];

        $pdf = Pdf::loadView('pdf.grant-contract', $data);
        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream('Kontrak_Penelitian_' . $submission->user->name . '.pdf');
    }
}