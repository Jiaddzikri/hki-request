<?php

namespace App\Http\Controllers\Hki;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    /**
     * Download the HKI certificate.
     */
    public function download(string $id): void
    {
        // TODO: Implement certificate download logic
        abort(501, 'Certificate download not yet implemented.');
    }
}
