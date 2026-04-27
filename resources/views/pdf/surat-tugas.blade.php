<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Surat Tugas</title>
  <style>
    @page {
      margin: 2.5cm 2.5cm 2.5cm 2.5cm;
      size: A4 portrait;
    }

    body {
      font-family: 'Times New Roman', Times, serif;
      font-size: 12pt;
      line-height: 1.3;
      color: #000;
    }

    /* Helper Classes */
    .text-center {
      text-align: center;
    }

    .text-justify {
      text-align: justify;
    }

    .text-bold {
      font-weight: bold;
    }

    .uppercase {
      text-transform: uppercase;
    }

    .mb-1 {
      margin-bottom: 5px;
    }

    .mt-2 {
      margin-top: 10px;
    }

    /* KOP SURAT */
    .header-table {
      width: 100%;
      border-bottom: 3px double #000;
      /* Garis ganda tebal tipis */
      margin-bottom: 20px;
      padding-bottom: 10px;
    }

    .logo {
      width: 85px;
      /* Sesuaikan ukuran logo */
      height: auto;
    }

    .header-text {
      text-align: center;
    }

    .header-univ {
      font-size: 14pt;
      font-weight: bold;
    }

    .header-inst {
      font-size: 12pt;
      font-weight: bold;
    }

    .header-addr {
      font-size: 10pt;
      font-style: normal;
    }

    /* JUDUL SURAT */
    .title-container {
      text-align: center;
      margin-bottom: 20px;
    }

    .surat-tugas {
      font-size: 14pt;
      font-weight: bold;
      text-decoration: underline;
    }

    .nomor-surat {
      font-size: 12pt;
    }

    /* TABEL PENELITI (DINAMIS) */
    /* Menggunakan tabel agar rapi saat loop data banyak */
    .table-data {
      width: 100%;
      border-collapse: collapse;
      table-layout: auto;
      margin-top: 10px;
      margin-bottom: 15px;
    }

    .table-data th,
    .table-data td {
      border: 1px solid #000;
      padding: 6px;
      vertical-align: top;
      text-align: left;
    }

    .table-data th {
      background-color: #f0f0f0;
      /* Opsional: beri sedikit warna abu di header */
      text-align: center;
      font-size: 10pt;
      line-height: 1.25;
      white-space: normal;
      padding: 7px 4px;
      vertical-align: middle;
    }

    .table-data td {
      word-break: break-word;
    }

    thead {
      display: table-header-group;
    }

    thead tr {
      page-break-inside: avoid;
    }

    /* Mengatur agar baris tabel tidak terpotong jelek saat pindah halaman */
    tbody tr {
      page-break-inside: avoid;
    }

    /* DETAIL KEGIATAN */
    .activity-table {
      width: 100%;
      margin-left: 20px;
      /* Indentasi sedikit */
    }

    .activity-table td {
      vertical-align: top;
      padding-bottom: 5px;
    }

    .label-col {
      width: 80px;
    }

    .sep-col {
      width: 10px;
    }

    /* TANDA TANGAN */
    .signature-container {
      margin-top: 30px;
      width: 100%;
      display: table;
      /* Hack untuk float di PDF */
    }

    .signature-box {
      float: right;
      /* Posisi kanan */
      width: 45%;
      text-align: left;
      /* Teks rata kiri tapi box di kanan */
    }

    /* TEMBUSAN */
    .tembusan {
      margin-top: 20px;
      font-size: 10pt;
    }

    /* Page Break Helper */
    .page-break {
      page-break-after: always;
    }
  </style>
</head>

<body>

  <table class="header-table">
    <tr>
      <td style="width: 15%; vertical-align: middle;">
        <img src="{{ public_path('UNSAP-1.png') }}" class="logo" alt="Logo UNSAP">
      </td>
      <td class="header-text" style="width: 85%;">
        <div class="header-univ uppercase">UNIVERSITAS SEBELAS APRIL</div>
        <div class="header-inst uppercase">LEMBAGA PENELITIAN DAN PENGABDIAN MASYARAKAT</div>
        <div class="header-addr">
          Alamat: Jl. Angkrek No. 19, Kelurahan Situ, Kecamatan Sumedang Utara,<br>
          Kabupaten Sumedang, Jawa Barat, Indonesia 45353<br>
          Website: https://lppm.unsap.ac.id Email: lppm@unsap.ac.id research@unsap.ac.id
        </div>
      </td>
    </tr>
  </table>

  <div class="title-container">
    <div class="surat-tugas uppercase">SURAT TUGAS</div>
    <div class="nomor-surat">Nomor: {{ $assignment->letter_number }}</div>
  </div>

  <div class="text-justify mb-1">
    Kepala Lembaga Penelitian dan Pengabdian kepada Masyarakat (LPPM) Universitas Sebelas April (UNSAP) menugaskan
    kepada:
  </div>

  <table class="table-data">
    <thead>
      <tr>
        <th style="width: 6%">No</th>
        <th style="width: 34%">Nama<br>Peneliti</th>
        <th style="width: 22%">NIDN</th>
        <th style="width: 38%">Jabatan</th>
      </tr>
    </thead>
    <tbody>
      @php
        $positionLabels = [
          'asisten_ahli' => 'Asisten Ahli',
          'lektor' => 'Lektor',
          'lektor_kepala' => 'Lektor Kepala',
          'guru_besar' => 'Guru Besar',
        ];

        $memberRows = collect($members ?? [])->all();

        if (empty($memberRows)) {
          $assignmentPositions = $assignment->academic_positions;

          if (is_string($assignmentPositions)) {
            $decoded = json_decode($assignmentPositions, true);
            $assignmentPositions = is_array($decoded) ? $decoded : [];
          }

          if (! is_array($assignmentPositions)) {
            $assignmentPositions = [];
          }

          $memberRows = [[
            'name' => $assignment->full_name,
            'gelar' => null,
            'nidn_nip_nim' => $assignment->nidn,
            'academic_position' => $assignmentPositions,
          ]];
        }
      @endphp

      @foreach($memberRows as $member)
        <tr>
          <td class="text-center">{{ $loop->iteration }}</td>
          <td>
            {{ $member['name'] }}
            @if(isset($member['gelar'])) <br>{{ $member['gelar'] }} @endif
          </td>
          <td class="text-center">{{ $member['nidn_nip_nim'] }}</td>
          <td>
            @php
              $positions = is_array($member['academic_position']) ? $member['academic_position'] : [];
              $displayPositions = array_map(function($pos) use ($positionLabels) {
                return $positionLabels[$pos] ?? ucwords(str_replace('_', ' ', $pos));
              }, $positions);
            @endphp
            {{ implode(', ', $displayPositions) }}
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <div class="text-justify mb-1">
    Untuk Melaksanakan Kegiatan {{ strtoupper($assignment->assignment_type) }}, yang dilaksanakan pada:
  </div>

  <table class="activity-table">
    <tr>
      <td class="label-col">Tanggal</td>
      <td class="sep-col">:</td>
      <td>{{ $assignment->start_date->format('d M Y') }}</td>
    </tr>
    <tr>
      <td class="label-col">Tempat</td>
      <td class="sep-col">:</td>
      <td class="uppercase">
        {{ $assignment->institution_name }}
      </td>
    </tr>
    <tr>
      <td class="label-col">Topik</td>
      <td class="sep-col">:</td>
      <td>{{ $assignment->research_title }}</td>
    </tr>
  </table>

  <div class="text-justify mt-2" style="margin-bottom: 20px;">
    Demikian Surat Tugas ini diberikan untuk dipergunakan sebaik-baiknya serta penuh tanggung jawab dan akan memberikan
    laporan akhir Kegiatan PPM ke Lembaga Penelitian dan Pengabdian kepada Masyarakat (LPPM) Universitas Sebelas April
    (UNSAP).
  </div>

  <div class="signature-container">
    <table style="width: 100%">
      <tr>
        <td style="width: 50%"></td>
        <td style="width: 50%">
          <div>Sumedang, {{ $assignment->created_at->format('d M Y') }}</div>
          <div class="mb-1">Kepala LPPM Universitas Sebelas April</div>

          <br><br><br><br>

          <div class="text-bold underline" style="text-decoration: underline;">
            Muhammad Agreindra Helmiawan, S.Kom., M.T
          </div>
          <div>NUPTK: 0420108603</div>
        </td>
      </tr>
    </table>
  </div>

  <div class="tembusan">
    <div>Tembusan:</div>
    <ol style="margin-top: 0; padding-left: 15px;">
      <li>Rektor Universitas Sebelas April</li>
      <li>Wakil Rektor I, II & III</li>
      <li>Kepala Lembaga Penjamin Mutu dan Audit (LPMA)</li>
      <li>Arsip</li>
    </ol>
  </div>

</body>

</html>