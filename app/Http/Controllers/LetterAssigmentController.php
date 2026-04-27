<?php

namespace App\Http\Controllers;

use App\Models\LtrAssignmentRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;

class LetterAssigmentController extends Controller
{
    public function download($id)
    {
        try {
            $submission = LtrAssignmentRequest::with(['members'])->findOrFail($id);

            if ($submission->status !== 'APPROVED') {
                throw new Exception('Dokumen kontrak belum tersedia.', 400);
            }

            $data = [
                'members' => $submission->members,
                'assignment' => $submission,
            ];

            $pdf = Pdf::loadView('pdf.surat-tugas', $data);
            $pdf->setPaper('a4', 'portrait');

            return $pdf->download('Surat Tugas No '.str_replace('/', '-', $submission->letter_number).'.pdf');
        } catch (Exception $error) {
            return redirect()->back()->with('error', $error->getMessage());
        }
    }
}
