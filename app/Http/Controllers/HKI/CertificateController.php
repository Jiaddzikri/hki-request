<?php

namespace App\Http\Controllers\Hki;

use App\Http\Controllers\Controller;
use App\Models\HkiProposal;
use Barryvdh\DomPDF\Facade\Pdf;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class CertificateController extends Controller
{
    public function download($id)
    {
        $proposal = HkiProposal::with(['user', 'type'])->findOrFail($id);

        if ($proposal->status !== 'APPROVED') {
            abort(403, 'Dokumen ini belum disetujui.');
        }

        $urlVerifikasi = route('public.verifier', $proposal->id);

        $qrCode = new QrCode(
            data: $urlVerifikasi,
            encoding: new Encoding('UTF-8'),
            size: 200, 
            margin: 10
        );

        $writer = new PngWriter();
        $result = $writer->write($qrCode);


        $qrcodeBase64 = $result->getDataUri();

        $data = [
            'proposal' => $proposal,
            'qr_code' => $qrcodeBase64, 
            'nomor_surat' => 'HKI/' . date('Y') . '/' . str_pad($proposal->id, 4, '0', STR_PAD_LEFT),
            'tanggal_approve' => $proposal->updated_at->format('d F Y')
        ];
        $pdf = Pdf::loadView('pdf.certificate', $data);
        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream('Sertifikat-HKI-' . $proposal->id . '.pdf');
    }
}