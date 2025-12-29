<!DOCTYPE html>
<html>

<head>
  <title>Kontrak Penelitian</title>
  <style>
    body {
      font-family: 'Times New Roman', Times, serif;
      font-size: 12pt;
      line-height: 1.5;
    }

    .header {
      text-align: center;
      border-bottom: 3px double black;
      padding-bottom: 10px;
      margin-bottom: 20px;
    }

    .logo {
      width: 80px;
      height: auto;
      position: absolute;
      left: 0;
      top: 0;
    }

    .title {
      font-weight: bold;
      text-decoration: underline;
      text-align: center;
      margin-bottom: 20px;
      font-size: 14pt;
    }

    .nomor {
      text-align: center;
      margin-top: -20px;
      margin-bottom: 30px;
    }

    .content {
      text-align: justify;
    }

    .pasal {
      font-weight: bold;
      margin-top: 15px;
      margin-bottom: 5px;
    }

    .table-data {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
      margin-bottom: 10px;
    }

    .table-data td {
      vertical-align: top;
      padding: 2px;
    }

    .ttd-area {
      margin-top: 50px;
      width: 100%;
    }

    .ttd-col {
      width: 50%;
      float: left;
      text-align: center;
    }

    .qr-box {
      position: fixed;
      bottom: 30px;
      right: 30px;
      opacity: 0.8;
    }

    .page-break {
      page-break-after: always;
    }
  </style>
</head>

<body>

  {{-- HEADER KOP SURAT --}}
  <div class="header">
    {{-- Ganti src dengan path logo kampusmu --}}
    {{-- <img src="{{ public_path('images/logo.png') }}" class="logo"> --}}
    <h3 style="margin:0">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI</h3>
    <h2 style="margin:0">UNIVERSITAS TEKNOLOGI MASA DEPAN</h2>
    <h4 style="margin:0">LEMBAGA PENELITIAN DAN PENGABDIAN KEPADA MASYARAKAT</h4>
    <small>Jl. Teknologi No. 1, Bandung, Jawa Barat. Telp: (022) 1234567</small>
  </div>

  {{-- JUDUL SURAT --}}
  <div class="title">SURAT PERJANJIAN PELAKSANAAN PENELITIAN</div>
  <div class="nomor">Nomor: {{ $nomor_kontrak }}</div>

  <div class="content">
    <p>Pada hari ini, <strong>{{ $tanggal_cetak }}</strong>, kami yang bertanda tangan di bawah ini:</p>

    <table class="table-data">
      <tr>
        <td width="30px">1.</td>
        <td width="150px"><strong>Prof. Dr. Admin LPPM</strong></td>
        <td>: Ketua LPPM Universitas Teknologi Masa Depan, dalam hal ini bertindak untuk dan atas nama LPPM, selanjutnya
          disebut <strong>PIHAK PERTAMA</strong>.</td>
      </tr>
      <tr>
        <td>2.</td>
        <td><strong>{{ $s->user->name }}</strong></td>
        <td>: Dosen Pengusul, NIDN/NIP: {{ $s->user->nidn_nip ?? '-' }}, dalam hal ini bertindak sebagai Ketua Peneliti,
          selanjutnya disebut <strong>PIHAK KEDUA</strong>.</td>
      </tr>
    </table>

    <p>Kedua belah pihak sepakat mengadakan perjanjian pelaksanaan penelitian dengan ketentuan sebagai berikut:</p>

    <div class="pasal">PASAL 1: JUDUL & SKEMA</div>
    <p>PIHAK KEDUA berkewajiban melaksanakan penelitian dengan rincian:</p>
    <table class="table-data" style="margin-left: 20px;">
      <tr>
        <td width="120px">Judul Penelitian</td>
        <td>: <strong>{{ $s->title }}</strong></td>
      </tr>
      <tr>
        <td>Skema Hibah</td>
        <td>: {{ $s->scheme->name }}</td>
      </tr>
      <tr>
        <td>Periode</td>
        <td>: {{ $s->period->name }}</td>
      </tr>
    </table>

    <div class="pasal">PASAL 2: PENDANAAN</div>
    <p>PIHAK PERTAMA memberikan dana penelitian kepada PIHAK KEDUA sebesar:</p>
    <h3 style="text-align: center;">Rp {{ number_format($s->total_budget_proposed, 0, ',', '.') }},-</h3>
    <p>Dana tersebut akan dicairkan dalam 2 (dua) tahap sesuai dengan ketentuan pencairan dana hibah internal yang
      berlaku.</p>

    <div class="pasal">PASAL 3: KEWAJIBAN</div>
    <p>PIHAK KEDUA berkewajiban menyerahkan Laporan Kemajuan, Laporan Akhir, Laporan Keuangan, dan Luaran Penelitian
      sesuai jadwal yang ditetapkan.</p>

  </div>

  {{-- TANDA TANGAN --}}
  <div class="ttd-area">
    <div class="ttd-col">
      <p>PIHAK KEDUA<br>Ketua Peneliti,</p>
      <br><br><br><br>
      <p><strong><u>{{ $s->user->name }}</u></strong><br>NIDN: {{ $s->user->nidn_nip ?? '....................' }}</p>
    </div>
    <div class="ttd-col">
      <p>PIHAK PERTAMA<br>Ketua LPPM,</p>
      <br><br><br><br>
      <p><strong><u>Prof. Dr. Admin LPPM</u></strong><br>NIP: 19800101 200001 1 001</p>
    </div>
    <div style="clear: both;"></div>
  </div>

  {{-- QR CODE VALIDASI --}}
  <div class="qr-box">
    <img src="data:image/svg+xml;base64, {{ $qrCode }}" width="80">
    <div style="font-size: 8pt; margin-top: 5px;">Dokumen ini sah<br>secara digital.</div>
  </div>

</body>

</html>