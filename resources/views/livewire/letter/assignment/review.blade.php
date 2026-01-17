<x-slot name="sidebar">
  <x-layouts.app.sidebar-pengajuan-surat />
</x-slot>

<div class="py-12">
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

    {{-- Header --}}
    <div class="mb-6 flex justify-between items-center">
      <div>
        <a href="{{ route('letter.assignment.reviewer.inbox') }}"
          class="text-blue-600 hover:text-blue-800 mb-2 inline-block">
          ← Kembali ke Inbox
        </a>
        <h2 class="text-2xl font-bold">Review Surat Ajuan Tugas</h2>
      </div>
    </div>

    {{-- Flash Messages --}}
    @if (session()->has('success'))
      <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
        {{ session('success') }}
      </div>
    @endif
    @if (session()->has('error'))
      <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
        {{ session('error') }}
      </div>
    @endif

    {{-- Status Badge --}}
    <div class="bg-white shadow rounded-lg p-6 mb-6">
      <div class="flex items-center justify-between">
        <div>
          <h3 class="text-lg font-semibold mb-2">Status Ajuan</h3>
          <span class="px-3 py-1 text-sm font-semibold rounded 
            {{ $assignment->status === 'SUBMITTED' ? 'bg-blue-100 text-blue-800' : '' }}
            {{ $assignment->status === 'APPROVED' ? 'bg-green-100 text-green-800' : '' }}
            {{ $assignment->status === 'REJECTED' ? 'bg-red-100 text-red-800' : '' }}
            {{ $assignment->status === 'REVISION' ? 'bg-orange-100 text-orange-800' : '' }}">
            {{ $assignment->status }}
          </span>
        </div>
        <div class="text-sm text-gray-500">
          Disubmit: {{ $assignment->created_at->format('d M Y H:i') }}
        </div>
      </div>
    </div>

    {{-- 1. Jenis Ajuan --}}
    <div class="bg-white shadow rounded-lg p-6 mb-6">
      <h3 class="text-lg font-semibold mb-4">1. Jenis Ajuan</h3>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Ajuan</label>
          <span class="inline-block px-3 py-1 text-sm font-medium rounded 
            {{ $assignment->assignment_type === 'penelitian' ? 'bg-purple-100 text-purple-800' : '' }}
            {{ $assignment->assignment_type === 'pkm' ? 'bg-green-100 text-green-800' : '' }}
            {{ $assignment->assignment_type === 'penunjang' ? 'bg-yellow-100 text-yellow-800' : '' }}
            {{ $assignment->assignment_type === 'seminar_workshop' ? 'bg-blue-100 text-blue-800' : '' }}">
            {{ ucwords(str_replace('_', ' ', $assignment->assignment_type)) }}
          </span>
        </div>
      </div>
    </div>

    {{-- 2. Data Pengaju --}}
    <div class="bg-white shadow rounded-lg p-6 mb-6">
      <h3 class="text-lg font-semibold mb-4">2. Data Pengaju</h3>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
          <p class="text-gray-900">{{ $assignment->full_name }}</p>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">NIDN</label>
          <p class="text-gray-900">{{ $assignment->nidn ?? '-' }}</p>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Fakultas</label>
          <p class="text-gray-900">{{ $assignment->faculty }}</p>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan Akademik</label>
          <div class="flex flex-wrap gap-2">
            @foreach ($assignment->academic_positions ?? [] as $position)
              <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded">{{ ucfirst($position) }}</span>
            @endforeach
          </div>
        </div>
      </div>
    </div>

    {{-- 3. Periode Kegiatan --}}
    <div class="bg-white shadow rounded-lg p-6 mb-6">
      <h3 class="text-lg font-semibold mb-4">3. Periode Kegiatan</h3>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
          <p class="text-gray-900">{{ $assignment->start_date->format('d M Y') }}</p>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
          <p class="text-gray-900">{{ $assignment->end_date->format('d M Y') }}</p>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Akademik</label>
          <p class="text-gray-900">{{ $assignment->academic_year ?? '-' }}</p>
        </div>
      </div>
    </div>

    {{-- 4. Detail Kegiatan --}}
    <div class="bg-white shadow rounded-lg p-6 mb-6">
      <h3 class="text-lg font-semibold mb-4">4. Detail Kegiatan</h3>
      <div class="grid grid-cols-1 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Nama Instansi Tujuan</label>
          <p class="text-gray-900">{{ $assignment->institution_name }}</p>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Instansi</label>
          <p class="text-gray-900">{{ $assignment->institution_address }}</p>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Judul Penelitian/Tema Kegiatan</label>
          <p class="text-gray-900">{{ $assignment->research_title }}</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Estimasi Biaya</label>
            <p class="text-gray-900">Rp {{ number_format($assignment->estimated_budget, 0, ',', '.') }}</p>
          </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pimpinan Instansi</label>
            <p class="text-gray-900">{{ $assignment->leader_name ?? '-' }}</p>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama PIC</label>
            <p class="text-gray-900">{{ $assignment->pic_name ?? '-' }}</p>
          </div>
        </div>
      </div>
    </div>

    {{-- 5. Anggota Tim --}}
    <div class="bg-white shadow rounded-lg p-6 mb-6">
      <h3 class="text-lg font-semibold mb-4">5. Anggota Tim ({{ $assignment->members->count() }} orang)</h3>
      @if ($assignment->members->count() > 0)
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIDN/NIP/NIM</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fakultas</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jabatan</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Asal Instansi</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @foreach ($assignment->members as $index => $member)
                <tr>
                  <td class="px-4 py-3 text-sm text-gray-900">{{ $index + 1 }}</td>
                  <td class="px-4 py-3 text-sm text-gray-900">{{ $member->name }}</td>
                  <td class="px-4 py-3 text-sm text-gray-900">{{ $member->email }}</td>
                  <td class="px-4 py-3 text-sm text-gray-900">{{ $member->nidn_nip_nim ?? '-' }}</td>
                  <td class="px-4 py-3 text-sm text-gray-900">{{ $member->faculty ?? '-' }}</td>

                    <td class="px-4 py-3 text-sm">
                     @if($member->academic_position)
                      @php
                        $positions = is_array($member->academic_position) ? $member->academic_position : json_decode($member->academic_position ?? '[]', true);
                        $posLabels = ['asisten_ahli' => 'Asisten Ahli', 'lektor' => 'Lektor', 'lektor_kepala' => 'Lektor Kepala', 'guru_besar' => 'Guru Besar'];
                      @endphp
                      <div class="flex flex-wrap gap-1 mt-1">
                        @foreach($positions as $pos)
                          <span class="px-2 py-0.5 text-xs font-medium bg-green-100 text-green-800 rounded">
                            {{ $posLabels[$pos] ?? $pos }}
                          </span>
                        @endforeach
                      </div>
                    @endif
                  </td>
                  <td class="px-4 py-3 text-sm">
                    <div class="flex flex-wrap gap-1">
                      @foreach ($member->institutions ?? [] as $institution)
                        <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded">
                          {{ $institution === 'dosen_unsap' ? 'Dosen UNSAP' : ($institution === 'mahasiswa_unsap' ? 'Mahasiswa UNSAP' : $institution) }}
                        </span>
                      @endforeach
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @else
        <p class="text-gray-500">Belum ada anggota tim</p>
      @endif
    </div>

    {{-- 6. Dokumen & Publikasi --}}
    <div class="bg-white shadow rounded-lg p-6 mb-6">
      <h3 class="text-lg font-semibold mb-4">6. Dokumen & Publikasi</h3>
      <div class="grid grid-cols-1 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">File Laporan</label>
          @if ($assignment->report_file_path)
            <div class="flex items-center gap-2">
              <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                </path>
              </svg>
              <span class="text-gray-900">{{ basename($assignment->report_file_path) }}</span>
              <button wire:click="downloadReport" class="ml-2 text-blue-600 hover:text-blue-800 text-sm">
                Download
              </button>
            </div>
          @else
            <p class="text-gray-500">Tidak ada file</p>
          @endif
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Link Publikasi</label>
          @if ($assignment->publication_link)
            <a href="{{ $assignment->publication_link }}" target="_blank"
              class="text-blue-600 hover:text-blue-800 break-all">
              {{ $assignment->publication_link }}
            </a>
          @else
            <p class="text-gray-500">-</p>
          @endif
        </div>
      </div>
    </div>

    {{-- Review Form --}}
    @if ($assignment->status === 'SUBMITTED')
      <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h3 class="text-lg font-semibold mb-4">Review Decision</h3>

        <form wire:submit="submitReview">
          <div class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Keputusan <span
                  class="text-red-500">*</span></label>
              <div class="space-y-2">
                <label class="flex items-center">
                  <input type="radio" wire:model="decision" value="APPROVED"
                    class="rounded-full border-gray-300 text-green-600 shadow-sm focus:border-green-500 focus:ring-green-500">
                  <span class="ml-2 text-sm">
                    <span class="font-medium text-green-700">Approve</span> - Ajuan disetujui
                  </span>
                </label>
                <label class="flex items-center">
                  <input type="radio" wire:model="decision" value="REVISION"
                    class="rounded-full border-gray-300 text-orange-600 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                  <span class="ml-2 text-sm">
                    <span class="font-medium text-orange-700">Request Revision</span> - Perlu perbaikan
                  </span>
                </label>
                <label class="flex items-center">
                  <input type="radio" wire:model="decision" value="REJECTED"
                    class="rounded-full border-gray-300 text-red-600 shadow-sm focus:border-red-500 focus:ring-red-500">
                  <span class="ml-2 text-sm">
                    <span class="font-medium text-red-700">Reject</span> - Ajuan ditolak
                  </span>
                </label>
              </div>
              @error('decision')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Review <span
                  class="text-red-500">*</span> <span class="text-xs text-gray-500">(Wajib untuk Revision dan
                  Reject)</span></label>
              <textarea wire:model="review_notes" rows="4"
                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                placeholder="Berikan catatan atau alasan untuk keputusan Anda..."></textarea>
              @error('review_notes')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>

            <div class="flex gap-2">
              <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Submit Review
              </button>
              <a href="{{ route('letter.assignment.reviewer.inbox') }}"
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                Batal
              </a>
            </div>
          </div>
        </form>
      </div>
    @else
      <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
        <p class="text-gray-600">
          Ajuan ini sudah direview dengan status: <span class="font-semibold">{{ $assignment->status }}</span>
        </p>
      </div>
    @endif

  </div>
</div>