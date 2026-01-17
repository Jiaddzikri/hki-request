<div>
<x-slot name="sidebar">
  <x-layouts.app.sidebar-pengajuan-surat />
</x-slot>

<div class="p-6">
  @if(session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">{{ session('success') }}</div>
  @endif

  @if(session('error'))
    <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">{{ session('error') }}</div>
  @endif

  {{-- Status Alerts --}}
  @if($assignment->status === 'REVISION')
    <div class="mb-6 bg-orange-50 border-l-4 border-orange-400 p-4">
      <div class="flex">
        <svg class="h-5 w-5 text-orange-400 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
        </svg>
        <div class="ml-3">
          <h3 class="text-sm font-medium text-orange-800">Permohonan Memerlukan Revisi</h3>
          <p class="mt-2 text-sm text-orange-700">Permohonan penugasan Anda memerlukan perbaikan. Silakan periksa catatan reviewer dan lakukan revisi yang diperlukan.</p>
        </div>
      </div>
    </div>
  @endif

  @if($assignment->status === 'REJECTED')
    <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4">
      <div class="flex">
        <svg class="h-5 w-5 text-red-400 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
        </svg>
        <div class="ml-3">
          <h3 class="text-sm font-medium text-red-800">Permohonan Ditolak</h3>
          <p class="mt-2 text-sm text-red-700">Permohonan penugasan Anda ditolak. Silakan periksa alasan penolakan di bagian review.</p>
        </div>
      </div>
    </div>
  @endif

  @if($assignment->status === 'APPROVED')
    <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4">
      <div class="flex">
        <svg class="h-5 w-5 text-green-400 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        <div class="ml-3">
          <h3 class="text-sm font-medium text-green-800">Permohonan Disetujui</h3>
          <p class="mt-2 text-sm text-green-700">Selamat! Permohonan penugasan Anda telah disetujui oleh reviewer.</p>
        </div>
      </div>
    </div>
  @endif

  @php
    $statusColors = [
      'DRAFT' => 'bg-gray-100 text-gray-800',
      'SUBMITTED' => 'bg-blue-100 text-blue-800',
      'REVISION' => 'bg-orange-100 text-orange-800',
      'APPROVED' => 'bg-green-100 text-green-800',
      'REJECTED' => 'bg-red-100 text-red-800',
    ];
    $statusLabels = [
      'DRAFT' => 'Draft',
      'SUBMITTED' => 'Diajukan',
      'REVISION' => 'Revisi',
      'APPROVED' => 'Disetujui',
      'REJECTED' => 'Ditolak',
    ];
  @endphp

  {{-- Header --}}
  <div class="mb-6 flex items-center justify-between">
    <div class="flex items-center gap-3">
      <h1 class="text-2xl font-bold text-gray-900">Detail Permohonan Penugasan</h1>
      <span class="px-3 py-1 inline-flex text-sm font-semibold rounded-full {{ $statusColors[$assignment->status] ?? 'bg-gray-100 text-gray-800' }}">
        {{ $statusLabels[$assignment->status] ?? $assignment->status }}
      </span>
    </div>
    <div class="flex items-center gap-3">
      @if($assignment->review)
        <button onclick="document.getElementById('reviewModal').classList.remove('hidden')" 
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
          </svg>
          Lihat Catatan Review
        </button>
      @endif
      @if($assignment->status === 'REVISION' && !$isEditMode)
        <button wire:click="enableEditMode" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
          </svg>
          Mulai Revisi
        </button>
      @endif
      @if($isEditMode)
        <button wire:click="saveRevision" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
          </svg>
          Simpan & Ajukan Ulang
        </button>
        <button wire:click="cancelEdit" class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50">Batal</button>
      @endif
      @if($assignment->status === 'DRAFT')
        <button wire:click="submitForReview" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          Ajukan untuk Review
        </button>
        <button wire:click="confirmDelete" class="inline-flex items-center px-4 py-2 border border-red-300 text-red-700 text-sm font-medium rounded-lg hover:bg-red-50">Hapus</button>
      @endif
      <a href="{{ route('letter.assignment.index') }}" wire:navigate class="text-sm text-gray-600 hover:text-gray-900">← Kembali</a>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
      {{-- Section 1: Jenis Ajuan --}}
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center gap-3 mb-4">
          <div class="w-8 h-8 rounded-full bg-blue-800 text-white flex items-center justify-center text-sm font-bold">1</div>
          <h2 class="text-lg font-semibold text-gray-900">Jenis Ajuan</h2>
        </div>
        <div class="ml-11">
          @if($isEditMode)
            <select wire:model="assignment_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
              <option value="">Pilih jenis ajuan</option>
              <option value="penelitian">Penelitian</option>
              <option value="pkm">PKM</option>
              <option value="penunjang">Penunjang</option>
              <option value="seminar_workshop">Seminar/Workshop</option>
            </select>
            @error('assignment_type')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
          @else
            @php $typeLabels = ['penelitian' => 'Penelitian', 'pkm' => 'PKM', 'penunjang' => 'Penunjang', 'seminar_workshop' => 'Seminar/Workshop']; @endphp
            <span class="px-3 py-1.5 rounded-lg text-sm font-medium bg-blue-100 text-blue-800">{{ $typeLabels[$assignment->assignment_type] ?? $assignment->assignment_type }}</span>
          @endif
        </div>
      </div>

      {{-- Section 2: Data Pengaju --}}
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center gap-3 mb-4">
          <div class="w-8 h-8 rounded-full bg-blue-800 text-white flex items-center justify-center text-sm font-bold">2</div>
          <h2 class="text-lg font-semibold text-gray-900">Data Pengaju</h2>
        </div>
        <div class="ml-11 space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
            @if($isEditMode)
              <input type="text" wire:model="full_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
              @error('full_name')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            @else
              <p class="text-gray-900">{{ $assignment->full_name }}</p>
            @endif
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">NIDN</label>
            @if($isEditMode)
              <input type="text" wire:model="nidn" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
              @error('nidn')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            @else
              <p class="text-gray-900">{{ $assignment->nidn }}</p>
            @endif
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Fakultas</label>
            @if($isEditMode)
              <input type="text" wire:model="faculty" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
              @error('faculty')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            @else
              <p class="text-gray-900">{{ $assignment->faculty }}</p>
            @endif
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Jabatan Akademik</label>
            @if($isEditMode)
              <div class="space-y-2">
                <label class="flex items-center">
                  <input type="checkbox" wire:model="academic_positions" value="asisten_ahli" class="w-4 h-4 text-blue-600 rounded">
                  <span class="ml-2 text-sm text-gray-700">Asisten Ahli</span>
                </label>
                <label class="flex items-center">
                  <input type="checkbox" wire:model="academic_positions" value="lektor" class="w-4 h-4 text-blue-600 rounded">
                  <span class="ml-2 text-sm text-gray-700">Lektor</span>
                </label>
                <label class="flex items-center">
                  <input type="checkbox" wire:model="academic_positions" value="lektor_kepala" class="w-4 h-4 text-blue-600 rounded">
                  <span class="ml-2 text-sm text-gray-700">Lektor Kepala</span>
                </label>
                <label class="flex items-center">
                  <input type="checkbox" wire:model="academic_positions" value="guru_besar" class="w-4 h-4 text-blue-600 rounded">
                  <span class="ml-2 text-sm text-gray-700">Guru Besar</span>
                </label>
              </div>
              @error('academic_positions')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            @else
              @php
                $posLabels = ['asisten_ahli' => 'Asisten Ahli', 'lektor' => 'Lektor', 'lektor_kepala' => 'Lektor Kepala', 'guru_besar' => 'Guru Besar'];
                $positions = is_array($assignment->academic_positions) ? $assignment->academic_positions : json_decode($assignment->academic_positions ?? '[]', true);
              @endphp
              <div class="flex flex-wrap gap-2">
                @foreach($positions as $pos)
                  <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">{{ $posLabels[$pos] ?? $pos }}</span>
                @endforeach
              </div>
            @endif
          </div>
        </div>
      </div>

      {{-- Section 3: Periode Kegiatan --}}
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">3. Periode Kegiatan</h2>
        
        @if($isEditMode)
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
              <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">
                Tanggal Mulai <span class="text-red-500">*</span>
              </label>
              <input type="date" id="start_date" wire:model="start_date" 
                     class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent">
              @error('start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
              <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">
                Tanggal Berakhir <span class="text-red-500">*</span>
              </label>
              <input type="date" id="end_date" wire:model="end_date" 
                     class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent">
              @error('end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
              <label for="academic_year" class="block text-sm font-medium text-gray-700 mb-1">
                Tahun Akademik <span class="text-red-500">*</span>
              </label>
              <input type="text" id="academic_year" wire:model="academic_year" 
                     class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent"
                     placeholder="2025/2026">
              @error('academic_year') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
          </div>
        @else
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
              <div class="text-sm text-gray-600 mb-1">Tanggal Mulai</div>
              <div class="text-base font-medium text-gray-900">
                {{ $assignment->start_date ? $assignment->start_date->format('d F Y') : '-' }}
              </div>
            </div>

            <div>
              <div class="text-sm text-gray-600 mb-1">Tanggal Berakhir</div>
              <div class="text-base font-medium text-gray-900">
                {{ $assignment->end_date ? $assignment->end_date->format('d F Y') : '-' }}
              </div>
            </div>

            <div>
              <div class="text-sm text-gray-600 mb-1">Tahun Akademik</div>
              <div class="text-base font-medium text-gray-900">{{ $assignment->academic_year ?? '-' }}</div>
            </div>
          </div>
        @endif
      </div>

      {{-- Section 4: Detail Kegiatan --}}
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">4. Detail Kegiatan</h2>
        
        @if($isEditMode)
          <div class="space-y-4">
            <div>
              <label for="institution_name" class="block text-sm font-medium text-gray-700 mb-1">
                Nama Instansi/Lembaga Tujuan <span class="text-red-500">*</span>
              </label>
              <input type="text" id="institution_name" wire:model="institution_name" 
                     class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent"
                     placeholder="Nama institusi atau lembaga yang dituju">
              @error('institution_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
              <label for="institution_address" class="block text-sm font-medium text-gray-700 mb-1">
                Alamat Instansi/Lembaga <span class="text-red-500">*</span>
              </label>
              <textarea id="institution_address" wire:model="institution_address" rows="2"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent"
                        placeholder="Alamat lengkap institusi"></textarea>
              @error('institution_address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
              <label for="research_title" class="block text-sm font-medium text-gray-700 mb-1">
                Judul Penelitian/Tema Kegiatan/Topik <span class="text-red-500">*</span>
              </label>
              <input type="text" id="research_title" wire:model="research_title" 
                     class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent"
                     placeholder="Judul atau tema kegiatan">
              @error('research_title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
              <label for="estimated_budget" class="block text-sm font-medium text-gray-700 mb-1">
                Estimasi Biaya (Rp)
              </label>
              <input type="number" id="estimated_budget" wire:model="estimated_budget" 
                     class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent"
                     placeholder="0">
              @error('estimated_budget') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label for="leader_name" class="block text-sm font-medium text-gray-700 mb-1">
                  Nama Pimpinan Instansi <span class="text-red-500">*</span>
                </label>
                <input type="text" id="leader_name" wire:model="leader_name" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent"
                       placeholder="Nama pimpinan institusi">
                @error('leader_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
              </div>

              <div>
                <label for="pic_name" class="block text-sm font-medium text-gray-700 mb-1">
                  Nama PIC/Penanggung Jawab <span class="text-red-500">*</span>
                </label>
                <input type="text" id="pic_name" wire:model="pic_name" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent"
                       placeholder="Nama penanggung jawab">
                @error('pic_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
              </div>
            </div>
          </div>
        @else
          <div class="space-y-4">
            <div>
              <div class="text-sm text-gray-600 mb-1">Nama Instansi/Lembaga Tujuan</div>
              <div class="text-base font-medium text-gray-900">{{ $assignment->institution_name ?? '-' }}</div>
            </div>

            <div>
              <div class="text-sm text-gray-600 mb-1">Alamat Instansi/Lembaga</div>
              <div class="text-base text-gray-900">{{ $assignment->institution_address ?? '-' }}</div>
            </div>

            <div>
              <div class="text-sm text-gray-600 mb-1">Judul Penelitian/Tema Kegiatan/Topik</div>
              <div class="text-base font-medium text-gray-900">{{ $assignment->research_title ?? '-' }}</div>
            </div>

            <div>
              <div class="text-sm text-gray-600 mb-1">Estimasi Biaya</div>
              <div class="text-base font-medium text-gray-900">
                {{ $assignment->estimated_budget ? 'Rp ' . number_format($assignment->estimated_budget, 0, ',', '.') : '-' }}
              </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <div class="text-sm text-gray-600 mb-1">Nama Pimpinan Instansi</div>
                <div class="text-base font-medium text-gray-900">{{ $assignment->leader_name ?? '-' }}</div>
              </div>

              <div>
                <div class="text-sm text-gray-600 mb-1">Nama PIC/Penanggung Jawab</div>
                <div class="text-base font-medium text-gray-900">{{ $assignment->pic_name ?? '-' }}</div>
              </div>
            </div>
          </div>
        @endif
      </div>

      {{-- Section 5: Anggota Tim --}}
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">5. Anggota Tim</h2>
        
        @php
          $members = $assignment->members ?? collect();
        @endphp

        @if($members->count() > 0)
          <div class="space-y-3">
            @foreach($members as $index => $member)
              <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg">
                <div class="flex items-start justify-between">
                  <div class="flex-1">
                    <h4 class="text-sm font-medium text-gray-900">{{ $member->name }}</h4>
                    <p class="text-sm text-gray-600 mt-1">{{ $member->email }}</p>
                    @if($member->nidn_nip_nim)
                      <p class="text-sm text-gray-600">NIDN/NIP/NIM: {{ $member->nidn_nip_nim }}</p>
                    @endif
                    @if($member->faculty)
                      <p class="text-sm text-gray-600">Fakultas: {{ $member->faculty }}</p>
                    @endif
                    @if($member->institutions)
                      @php
                        $institutions = is_array($member->institutions) ? $member->institutions : json_decode($member->institutions ?? '[]', true);
                      @endphp
                      <div class="flex flex-wrap gap-1 mt-2">
                        @foreach($institutions as $institution)
                          <span class="px-2 py-0.5 text-xs font-medium bg-blue-100 text-blue-800 rounded">
                            {{ $institution === 'dosen_unsap' ? 'Dosen UNSAP' : ($institution === 'mahasiswa_unsap' ? 'Mahasiswa UNSAP' : $institution) }}
                          </span>
                        @endforeach
                      </div>
                    @endif
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
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @else
          <p class="text-gray-600 text-sm">Tidak ada anggota tim.</p>
        @endif
      </div>

      {{-- Section 6: Dokumen & Publikasi --}}
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">6. Dokumen & Publikasi</h2>
        
        @if($isEditMode)
          <div class="space-y-4">
            <div>
              <label for="report_file" class="block text-sm font-medium text-gray-700 mb-1">
                Upload File Laporan
                <span class="text-xs text-gray-500">(PDF/DOC/DOCX, Max 10MB)</span>
              </label>
              <input type="file" id="report_file" wire:model="report_file" accept=".pdf,.doc,.docx"
                     class="block w-full text-sm text-gray-500 
                            file:mr-4 file:py-2 file:px-4 
                            file:rounded-lg file:border-0 
                            file:text-sm file:font-medium 
                            file:bg-blue-50 file:text-blue-800 
                            hover:file:bg-blue-100 
                            cursor-pointer border border-gray-300 rounded-lg">
              @error('report_file') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

              <div wire:loading wire:target="report_file" class="mt-2">
                <div class="flex items-center text-sm text-blue-800">
                  <svg class="animate-spin h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                  </svg>
                  Uploading...
                </div>
              </div>
              
              @if($assignment->report_file_path)
                <p class="mt-2 text-sm text-gray-600">
                  File saat ini: <span class="font-medium">{{ basename($assignment->report_file_path) }}</span>
                </p>
              @endif
            </div>

            <div>
              <label for="publication_link" class="block text-sm font-medium text-gray-700 mb-1">
                Link Publikasi/Dokumen Online
              </label>
              <input type="url" id="publication_link" wire:model="publication_link" 
                     class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent"
                     placeholder="https://example.com/document">
              @error('publication_link') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
          </div>
        @else
          <div class="space-y-4">
            <div>
              <div class="text-sm text-gray-600 mb-2">File Laporan</div>
              @if($assignment->report_file_path)
                <button wire:click="downloadReport" 
                        class="inline-flex items-center px-4 py-2 bg-blue-800 text-white text-sm font-medium rounded-lg hover:bg-blue-900">
                  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                  </svg>
                  Download Laporan
                </button>
                <p class="mt-2 text-sm text-gray-600">{{ basename($assignment->report_file_path) }}</p>
              @else
                <p class="text-gray-600 text-sm">Belum ada file laporan.</p>
              @endif
            </div>

            <div>
              <div class="text-sm text-gray-600 mb-2">Link Publikasi/Dokumen Online</div>
              @if($assignment->publication_link)
                <a href="{{ $assignment->publication_link }}" target="_blank" 
                   class="text-blue-800 hover:underline inline-flex items-center">
                  {{ $assignment->publication_link }}
                  <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                  </svg>
                </a>
              @else
                <p class="text-gray-600 text-sm">Belum ada link publikasi.</p>
              @endif
            </div>
          </div>
        @endif
      </div>
    </div>

    {{-- Sidebar --}}
    <div class="lg:col-span-1 space-y-6">
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Timeline</h3>
        <div class="space-y-4">
          <div class="flex gap-3">
            <div class="flex flex-col items-center">
              <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
              </div>
              @if($assignment->submitted_at || $assignment->reviewed_at)<div class="w-0.5 h-full bg-gray-200"></div>@endif
            </div>
            <div class="flex-1 pb-4">
              <p class="text-sm font-medium text-gray-900">Dibuat</p>
              <p class="text-xs text-gray-600">{{ $assignment->created_at->format('d M Y, H:i') }}</p>
            </div>
          </div>
          @if($assignment->submitted_at)
            <div class="flex gap-3">
              <div class="flex flex-col items-center">
                <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                  </svg>
                </div>
                @if($assignment->reviewed_at)<div class="w-0.5 h-full bg-gray-200"></div>@endif
              </div>
              <div class="flex-1 pb-4">
                <p class="text-sm font-medium text-gray-900">Diajukan</p>
                <p class="text-xs text-gray-600">{{ $assignment->submitted_at->format('d M Y, H:i') }}</p>
              </div>
            </div>
          @endif
          @if($assignment->reviewed_at)
            <div class="flex gap-3">
              <div class="w-8 h-8 rounded-full {{ $assignment->status === 'APPROVED' ? 'bg-green-100 text-green-600' : ($assignment->status === 'REJECTED' ? 'bg-red-100 text-red-600' : 'bg-orange-100 text-orange-600') }} flex items-center justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
              </div>
              <div class="flex-1">
                <p class="text-sm font-medium text-gray-900">Direview</p>
                <p class="text-xs text-gray-600">{{ $assignment->reviewed_at->format('d M Y, H:i') }}</p>
              </div>
            </div>
          @endif
        </div>
      </div>

      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pengajuan</h3>
        <dl class="space-y-3">
          <div>
            <dt class="text-xs font-medium text-gray-600 uppercase tracking-wider">ID Pengajuan</dt>
            <dd class="mt-1 text-sm text-gray-900 font-mono">{{ substr($assignment->id, 0, 8) }}...</dd>
          </div>
          <div>
            <dt class="text-xs font-medium text-gray-600 uppercase tracking-wider">Pengaju</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ $assignment->user->name }}</dd>
          </div>
          <div>
            <dt class="text-xs font-medium text-gray-600 uppercase tracking-wider">Status</dt>
            <dd class="mt-1">
              <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full {{ $statusColors[$assignment->status] ?? 'bg-gray-100 text-gray-800' }}">
                {{ $statusLabels[$assignment->status] ?? $assignment->status }}
              </span>
            </dd>
          </div>
        </dl>
      </div>
    </div>
  </div>
</div>

{{-- Review Modal --}}
@if($assignment->review)
  <div id="reviewModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-lg bg-white">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-xl font-semibold text-gray-900">Catatan Review</h3>
        <button onclick="document.getElementById('reviewModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>
      <div class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Keputusan</label>
          <span class="px-3 py-1.5 inline-flex text-sm font-semibold rounded-full {{ $assignment->review->decision === 'APPROVED' ? 'bg-green-100 text-green-800' : ($assignment->review->decision === 'REJECTED' ? 'bg-red-100 text-red-800' : 'bg-orange-100 text-orange-800') }}">
            {{ $assignment->review->decision === 'APPROVED' ? 'Disetujui' : ($assignment->review->decision === 'REJECTED' ? 'Ditolak' : 'Perlu Revisi') }}
          </span>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Reviewer</label>
          <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
            <p class="text-gray-900 whitespace-pre-wrap">{{ $assignment->review->notes }}</p>
          </div>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Reviewer</label>
          <p class="text-gray-900">{{ $assignment->review->reviewer->name }}</p>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Review</label>
          <p class="text-gray-900">{{ $assignment->review->reviewed_at->format('d M Y, H:i') }}</p>
        </div>
      </div>
      <div class="mt-6 flex justify-end">
        <button onclick="document.getElementById('reviewModal').classList.add('hidden')" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">Tutup</button>
      </div>
    </div>
  </div>
@endif
</div>