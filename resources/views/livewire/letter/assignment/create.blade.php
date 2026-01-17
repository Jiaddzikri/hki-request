<x-slot name="sidebar">
  <x-layouts.app.sidebar-pengajuan-surat />
</x-slot>

<div class="p-6">
  {{-- Header --}}
  <div class="mb-6">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Buat Surat Ajuan Tugas Baru</h1>
        <p class="mt-1 text-sm text-gray-600">Lengkapi formulir pengajuan surat tugas sesuai kebutuhan</p>
      </div>
      <a href="{{ route('letter.assignment.index') }}" wire:navigate class="text-sm text-gray-600 hover:text-gray-900">
        ← Kembali
      </a>
    </div>
  </div>

  {{-- Form Container --}}
  <div class="bg-white rounded-lg border border-gray-200 p-6">
    <form wire:submit="save">
      <div class="space-y-6">
        {{-- 1. Jenis Ajuan --}}
        <div class="border-t border-gray-200 pt-6 first:border-t-0 first:pt-0">
          <h3 class="text-lg font-medium text-gray-900 mb-4">
            1. Jenis Ajuan
          </h3>

          <div>
            <label for="assignment_type" class="block text-sm font-medium text-gray-700 mb-1">
              Ajuan Untuk <span class="text-red-500">*</span>
            </label>
            <select id="assignment_type" wire:model="assignment_type"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent">
              <option value="">Pilih Jenis Ajuan</option>
              <option value="penelitian">Penelitian</option>
              <option value="pkm">PKM</option>
              <option value="penunjang">Penunjang</option>
              <option value="seminar_workshop">Seminar/Workshop</option>
            </select>
            @error('assignment_type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
          </div>
        </div>

        {{-- 2. Data Pengaju --}}
        <div class="border-t border-gray-200 pt-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">
            2. Data Pengaju
          </h3>

          <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">
                  Nama Lengkap dengan Gelar <span class="text-red-500">*</span>
                </label>
                <input type="text" id="full_name" wire:model="full_name"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent"
                  placeholder="Contoh: Dr. Ahmad Santoso, M.Pd">
                @error('full_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
              </div>

              <div>
                <label for="nidn" class="block text-sm font-medium text-gray-700 mb-1">
                  NIDN <span class="text-red-500">*</span>
                </label>
                <input type="text" id="nidn" wire:model="nidn"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent"
                  placeholder="Nomor Induk Dosen Nasional">
                @error('nidn') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
              </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label for="faculty" class="block text-sm font-medium text-gray-700 mb-1">
                  Fakultas <span class="text-red-500">*</span>
                </label>
                <select id="faculty" wire:model="faculty"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent">
                  <option value="">Pilih Fakultas</option>
                  <option value="FKIP">Fakultas Keguruan dan Ilmu Pendidikan (FKIP)</option>
                  <option value="FIB">Fakultas Ilmu Budaya (FIB)</option>
                  <option value="FEB">Fakultas Ekonomi dan Bisnis (FEB)</option>
                  <option value="FISIP">Fakultas Ilmu Sosial dan Ilmu Pemerintahan (FISIP)</option>
                  <option value="FTI">Fakultas Teknologi Informasi (FTI)</option>
                  <option value="FIKES">Fakultas Ilmu Kesehatan (FIKES)</option>
                </select>
                @error('faculty') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                  Jabatan Akademik <span class="text-red-500">*</span>
                </label>
                <div class="space-y-2 mt-2">
                  <label class="flex items-center">
                    <input type="checkbox" wire:model="academic_positions" value="asisten_ahli"
                      class="w-4 h-4 text-blue-800 border-gray-300 rounded focus:ring-blue-800">
                    <span class="ml-2 text-sm text-gray-700">Asisten Ahli</span>
                  </label>
                  <label class="flex items-center">
                    <input type="checkbox" wire:model="academic_positions" value="lektor"
                      class="w-4 h-4 text-blue-800 border-gray-300 rounded focus:ring-blue-800">
                    <span class="ml-2 text-sm text-gray-700">Lektor</span>
                  </label>
                  <label class="flex items-center">
                    <input type="checkbox" wire:model="academic_positions" value="lektor_kepala"
                      class="w-4 h-4 text-blue-800 border-gray-300 rounded focus:ring-blue-800">
                    <span class="ml-2 text-sm text-gray-700">Lektor Kepala</span>
                  </label>
                  <label class="flex items-center">
                    <input type="checkbox" wire:model="academic_positions" value="guru_besar"
                      class="w-4 h-4 text-blue-800 border-gray-300 rounded focus:ring-blue-800">
                    <span class="ml-2 text-sm text-gray-700">Guru Besar</span>
                  </label>
                </div>
                @error('academic_positions') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
              </div>
            </div>
          </div>
        </div>

        {{-- 3. Periode Kegiatan --}}
        <div class="border-t border-gray-200 pt-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">
            3. Periode Kegiatan
          </h3>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
              <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">
                Tanggal Mulai <span class="text-red-500">*</span>
              </label>
              <input type="date" id="start_date" wire:model="start_date"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent">
              @error('start_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">
                Tanggal Berakhir <span class="text-red-500">*</span>
              </label>
              <input type="date" id="end_date" wire:model="end_date"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent">
              @error('end_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="academic_year" class="block text-sm font-medium text-gray-700 mb-1">
                Tahun Akademik <span class="text-red-500">*</span>
              </label>
              <input type="text" id="academic_year" wire:model="academic_year"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent"
                placeholder="2025/2026">
              @error('academic_year') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
          </div>
        </div>

        {{-- 4. Detail Kegiatan --}}
        <div class="border-t border-gray-200 pt-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">
            4. Detail Kegiatan
          </h3>

          <div class="space-y-4">
            <div>
              <label for="institution_name" class="block text-sm font-medium text-gray-700 mb-1">
                Nama Instansi/Lembaga Tujuan <span class="text-red-500">*</span>
              </label>
              <input type="text" id="institution_name" wire:model="institution_name"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent"
                placeholder="Nama institusi atau lembaga yang dituju">
              @error('institution_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="institution_address" class="block text-sm font-medium text-gray-700 mb-1">
                Alamat Instansi/Lembaga <span class="text-red-500">*</span>
              </label>
              <textarea id="institution_address" wire:model="institution_address" rows="2"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent"
                placeholder="Alamat lengkap institusi"></textarea>
              @error('institution_address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="research_title" class="block text-sm font-medium text-gray-700 mb-1">
                Judul Penelitian/Tema Kegiatan/Topik <span class="text-red-500">*</span>
              </label>
              <input type="text" id="research_title" wire:model="research_title"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent"
                placeholder="Judul atau tema kegiatan">
              @error('research_title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="estimated_budget" class="block text-sm font-medium text-gray-700 mb-1">
                Estimasi Biaya (Rp)
              </label>
              <input type="number" id="estimated_budget" wire:model="estimated_budget"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent"
                placeholder="0">
              @error('estimated_budget') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label for="leader_name" class="block text-sm font-medium text-gray-700 mb-1">
                  Nama Pimpinan Instansi <span class="text-red-500">*</span>
                </label>
                <input type="text" id="leader_name" wire:model="leader_name"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent"
                  placeholder="Nama pimpinan institusi">
                @error('leader_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
              </div>

              <div>
                <label for="pic_name" class="block text-sm font-medium text-gray-700 mb-1">
                  Nama PIC/Penanggung Jawab <span class="text-red-500">*</span>
                </label>
                <input type="text" id="pic_name" wire:model="pic_name"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent"
                  placeholder="Nama penanggung jawab">
                @error('pic_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
              </div>
            </div>
          </div>
        </div>

        {{-- 5. Anggota Tim --}}
        <div class="border-t border-gray-200 pt-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">
            5. Anggota Tim
          </h3>

          @if (session()->has('member_success'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
              <p class="text-sm text-green-800">{{ session('member_success') }}</p>
            </div>
          @endif

          {{-- Existing Members List --}}
          @if(count($members) > 0)
            <div class="space-y-3 mb-4">
              @foreach($members as $index => $member)
                <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg">
                  <div class="flex items-start justify-between">
                    <div class="flex-1">
                      <h4 class="text-sm font-medium text-gray-900">{{ $member['name'] }}</h4>
                      <p class="text-sm text-gray-600 mt-1">{{ $member['email'] }}</p>
                      @if(!empty($member['nidn_nip_nim']))
                        <p class="text-sm text-gray-600">NIDN/NIP/NIM: {{ $member['nidn_nip_nim'] }}</p>
                      @endif
                      @if(!empty($member['faculty']))
                        <p class="text-sm text-gray-600">Fakultas: {{ $member['faculty'] }}</p>
                      @endif
                      @if(!empty($member['institutions']))
                        <div class="flex flex-wrap gap-1 mt-1">
                          @foreach($member['institutions'] as $institution)
                            <span class="px-2 py-0.5 text-xs font-medium bg-blue-100 text-blue-800 rounded">
                              {{ $institution === 'dosen_unsap' ? 'Dosen UNSAP' : ($institution === 'mahasiswa_unsap' ? 'Mahasiswa UNSAP' : $institution) }}
                            </span>
                          @endforeach
                        </div>
                      @endif
                    </div>
                    <button type="button" wire:click="removeMember({{ $index }})" class="text-red-600 hover:text-red-800">
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                          d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                          clip-rule="evenodd" />
                      </svg>
                    </button>
                  </div>
                </div>
              @endforeach
            </div>
          @endif

          {{-- Add New Member Form --}}
          <div class="border border-gray-300 rounded-lg p-4 bg-white">
            <h4 class="text-sm font-medium text-gray-900 mb-4">Tambah Anggota Tim</h4>
            <div class="space-y-4">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label for="member_name" class="block text-sm font-medium text-gray-700 mb-1">
                    Nama Lengkap <span class="text-red-500">*</span>
                  </label>
                  <input type="text" id="member_name" wire:model="member_name"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent"
                    placeholder="Nama lengkap">
                  @error('member_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                  <label for="member_email" class="block text-sm font-medium text-gray-700 mb-1">
                    Email <span class="text-red-500">*</span>
                  </label>
                  <input type="email" id="member_email" wire:model="member_email"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent"
                    placeholder="email@example.com">
                  @error('member_email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
              </div>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label for="member_nidn_nip_nim" class="block text-sm font-medium text-gray-700 mb-1">
                    NIDN/NIP/NIM
                  </label>
                  <input type="text" id="member_nidn_nip_nim" wire:model="member_nidn_nip_nim"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent"
                    placeholder="NIDN/NIP/NIM">
                </div>

                <div>
                  <label for="member_faculty" class="block text-sm font-medium text-gray-700 mb-1">
                    Fakultas
                  </label>
                  <select id="member_faculty" wire:model="member_faculty"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent">
                    <option value="">Pilih Fakultas</option>
                    <option value="FKIP">FKIP</option>
                    <option value="FIB">FIB</option>
                    <option value="FEB">FEB</option>
                    <option value="FISIP">FISIP</option>
                    <option value="FTI">FTI</option>
                    <option value="FIKES">FIKES</option>
                  </select>
                </div>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                  Jabatan Akademik
                </label>
                <div class="space-y-2 mt-2">
                  <label class="flex items-center">
                    <input type="checkbox" wire:model="member_academic_positions" value="asisten_ahli"
                      class="w-4 h-4 text-blue-800 border-gray-300 rounded focus:ring-blue-800">
                    <span class="ml-2 text-sm text-gray-700">Asisten Ahli</span>
                  </label>
                  <label class="flex items-center">
                    <input type="checkbox" wire:model="member_academic_positions" value="lektor"
                      class="w-4 h-4 text-blue-800 border-gray-300 rounded focus:ring-blue-800">
                    <span class="ml-2 text-sm text-gray-700">Lektor</span>
                  </label>
                  <label class="flex items-center">
                    <input type="checkbox" wire:model="member_academic_positions" value="lektor_kepala"
                      class="w-4 h-4 text-blue-800 border-gray-300 rounded focus:ring-blue-800">
                    <span class="ml-2 text-sm text-gray-700">Lektor Kepala</span>
                  </label>
                  <label class="flex items-center">
                    <input type="checkbox" wire:model="member_academic_positions" value="guru_besar"
                      class="w-4 h-4 text-blue-800 border-gray-300 rounded focus:ring-blue-800">
                    <span class="ml-2 text-sm text-gray-700">Guru Besar</span>
                  </label>
                </div>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                  Asal Instansi <span class="text-red-500">*</span>
                </label>
                <div class="space-y-2">
                  <label class="flex items-center">
                    <input type="checkbox" wire:model="member_institutions" value="dosen_unsap"
                      class="w-4 h-4 text-blue-800 border-gray-300 rounded focus:ring-blue-800">
                    <span class="ml-2 text-sm text-gray-700">Dosen UNSAP</span>
                  </label>
                  <label class="flex items-center">
                    <input type="checkbox" wire:model="member_institutions" value="mahasiswa_unsap"
                      class="w-4 h-4 text-blue-800 border-gray-300 rounded focus:ring-blue-800">
                    <span class="ml-2 text-sm text-gray-700">Mahasiswa UNSAP</span>
                  </label>
                  <input type="text" wire:model="member_custom_institution"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent"
                    placeholder="Atau tulis instansi lain...">
                </div>
                @error('member_institutions') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
              </div>

              <div class="flex justify-end">
                <button type="button" wire:click="addMember"
                  class="px-4 py-2 bg-blue-800 text-white text-sm font-medium rounded-lg hover:bg-blue-900">
                  Tambah Anggota
                </button>
              </div>
            </div>
          </div>
        </div>

        {{-- 6. Dokumen & Publikasi --}}
        <div class="border-t border-gray-200 pt-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">
            6. Dokumen & Publikasi
          </h3>

          <div class="space-y-4">
            <div>
              <label for="report_file" class="block text-sm font-medium text-gray-700 mb-1">
                Upload File Laporan
                <span class="text-xs text-gray-500">(PDF/DOC/DOCX, Max 10MB)</span>
              </label>
              <input type="file" id="report_file" wire:model="report_file" accept=".pdf,.doc,.docx" class="block w-full text-sm text-gray-500 
                                          file:mr-4 file:py-2 file:px-4 
                                          file:rounded-lg file:border-0 
                                          file:text-sm file:font-medium 
                                          file:bg-blue-50 file:text-blue-800 
                                          hover:file:bg-blue-100 
                                          cursor-pointer border border-gray-300 rounded-lg">
              @error('report_file') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror

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
            </div>

            <div>
              <label for="publication_link" class="block text-sm font-medium text-gray-700 mb-1">
                Link Publikasi/Dokumen Online
              </label>
              <input type="url" id="publication_link" wire:model="publication_link"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent"
                placeholder="https://example.com/document">
              @error('publication_link') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
          </div>
        </div>

        {{-- Submit Buttons --}}
        <div class="border-t border-gray-200 pt-6">
          <div class="flex items-center justify-between">
            <a href="{{ route('letter.assignment.index') }}" wire:navigate
              class="px-6 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50">
              Batal
            </a>
            <button type="submit"
              class="px-6 py-2 bg-blue-800 text-white text-sm font-medium rounded-lg hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-800">
              Simpan sebagai Draft
            </button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>