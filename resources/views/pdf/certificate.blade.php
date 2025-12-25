<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat HKI - {{ $proposal->title }}</title>
    <style>
        /* SETUP HALAMAN A4 LANDSCAPE */
        @page {
            margin: 0;
            size: A4 landscape;
        }
        
        body {
            font-family: 'Times New Roman', serif;
            margin: 0;
            padding: 0;
            background-color: #fff;
            color: #000;
        }

        /* BINGKAI SERTIFIKAT */
        .container {
            position: absolute;
            top: 20px;
            right: 20px;
            bottom: 20px;
            left: 20px;
            border: 5px double #1e3a8a; /* Warna Biru Tua Formal */
            padding: 40px;
            text-align: center;
        }

        /* WATERMARK BACKGROUND (Opsional) */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 150px;
            color: #f3f4f6;
            z-index: -1;
            font-weight: bold;
            opacity: 0.5;
            transform: translate(-50%, -50%) rotate(-45deg);
        }

        /* KOP SURAT */
        .header-text {
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 14px;
            color: #555;
            margin-bottom: 5px;
        }
        
        .main-title {
            font-size: 36px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 10px 0;
            color: #111;
            border-bottom: 2px solid #111;
            display: inline-block;
            padding-bottom: 5px;
        }

        .nomor-surat {
            font-size: 16px;
            margin-top: 5px;
            margin-bottom: 40px;
        }

        /* KONTEN UTAMA */
        .content {
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .highlight-name {
            font-size: 28px;
            font-weight: bold;
            margin: 15px 0;
            color: #1e3a8a;
            text-decoration: underline;
        }

        .highlight-title {
            font-size: 20px;
            font-weight: bold;
            font-style: italic;
            margin: 15px 0;
            display: block;
        }

        /* BAGIAN TANDA TANGAN (MENGGUNAKAN TABEL AGAR RAPI DI PDF) */
        .footer-table {
            width: 100%;
            margin-top: 50px;
        }
        
        .qr-column {
            width: 40%;
            text-align: center;
            vertical-align: bottom;
        }

        .sign-column {
            width: 60%;
            text-align: center;
            vertical-align: bottom;
        }

        .sign-name {
            font-weight: bold;
            text-decoration: underline;
            margin-top: 80px; /* Jarak untuk tanda tangan manual jika perlu */
            font-size: 16px;
        }

        .sign-title {
            font-size: 14px;
        }

        /* FORENSIK FOOTER */
        .forensic-footer {
            position: absolute;
            bottom: 10px;
            left: 40px;
            right: 40px;
            font-size: 10px;
            color: #888;
            border-top: 1px solid #ddd;
            padding-top: 5px;
            text-align: left;
            font-family: 'Courier New', monospace;
        }
    </style>
</head>
<body>

    <div class="watermark">COPYRIGHT</div>

    <div class="container">
        
        <div class="header-text">Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi</div>
        <div class="header-text">Lembaga Penelitian dan Pengabdian Kepada Masyarakat</div>
        <div class="header-text">Universitas Dummy Indonesia</div>
        
        <br>
        
        <div class="main-title">Surat Pencatatan Ciptaan</div>
        <div class="nomor-surat">Nomor: {{ $nomor_surat }}</div>

        <div class="content">
            <p>Berdasarkan Undang-Undang Nomor 28 Tahun 2014 tentang Hak Cipta,<br>dengan ini menerangkan bahwa:</p>

            <div class="highlight-name">{{ $proposal->user->name }}</div>
            
            <p>Telah mencatatkan ciptaan berupa <strong style="text-transform: uppercase">{{ $proposal->type->name ?? 'KARYA UMUM' }}</strong> dengan judul:</p>

            <span class="highlight-title">"{{ $proposal->title }}"</span>

            <p style="margin-top: 20px; font-size: 14px;">
                Ciptaan ini telah diverifikasi secara administratif dan teknis, serta tercatat dalam<br>
                Pangkalan Data Kekayaan Intelektual Kampus yang terjamin integritasnya.
            </p>
        </div>

        <table class="footer-table">
            <tr>
                <td class="qr-column">
                    {{-- 
                        PENTING:
                        $qr_code sudah berisi string base64 lengkap (data:image/png;base64,...)
                        dari Controller Endroid tadi. Jadi tinggal echo saja.
                    --}}
                    <img src="{{ $qr_code }}" width="130" style="border: 1px solid #ddd; padding: 5px;">
                    <br>
                    <span style="font-size: 10px; display: block; margin-top: 5px;">
                        Scan untuk verifikasi keaslian dokumen
                    </span>
                </td>

                <td class="sign-column">
                    <p style="margin-bottom: 5px;">Ditetapkan di: Bandung</p>
                    <p>Pada Tanggal: {{ $tanggal_approve }}</p>
                    
                    <p style="margin-top: 20px;">Kepala Sentra HKI,</p>
                    
                    <div style="height: 60px;"></div> 

                    <div class="sign-name">Dr. Reviewer Killer, M.Kom.</div>
                    <div class="sign-title">NIP. 19850101 201001 1 001</div>
                </td>
            </tr>
        </table>

        <div class="forensic-footer">
            <strong>DIGITAL FOOTPRINT (SHA-256):</strong><br>
            {{ $proposal->auditLogs->last()->current_hash ?? 'ERROR_INTEGRITY_CHECK_FAILED' }}
            <br>
            <span style="font-style:italic">Dokumen ini sah dan ditandatangani secara elektronik. Tanda tangan basah tidak diperlukan.</span>
        </div>

    </div>

</body>
</html>