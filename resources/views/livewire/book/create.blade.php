<x-slot name="sidebar">
    <x-layouts.app.sidebar-book />
</x-slot>

<div class="p-6">
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Permohonan ISBN Baru</h1>
                <p class="mt-1 text-sm text-gray-600">Lengkapi formulir permohonan ISBN sesuai standar Perpustakaan Nasional</p>
            </div>
            <a href="{{ route('book.index') }}" wire:navigate 
               class="text-sm text-gray-600 hover:text-gray-900">
                ← Kembali
            </a>
        </div>
    </div>

    {{-- Progress Steps --}}
    <div class="mb-8">
        <div class="flex items-center justify-between">
            @foreach([
                1 => 'Informasi ISBN & Kepengarangan',
                2 => 'Detail Publikasi & Spesifikasi',
                3 => 'Upload File'
              ] as $step => $label)
                  <div class="flex items-center {{ $step < 3 ? 'flex-1' : '' }}">
                      <div class="flex items-center">
                          <div class="flex items-center justify-center w-10 h-10 rounded-full border-2 {{ $currentStep >= $step ? 'bg-blue-800 border-blue-800 text-white' : 'border-gray-300 text-gray-500' }}">
                              @if($currentStep > $step)
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                              @else
                                <span class="text-sm font-medium">{{ $step }}</span>
                              @endif
                          </div>
                          <span class="ml-2 text-sm font-medium {{ $currentStep >= $step ? 'text-gray-900' : 'text-gray-500' }}">
                              {{ $label }}
                          </span>
                      </div>
                      @if($step < 3)
                        <div class="flex-1 h-0.5 mx-4 {{ $currentStep > $step ? 'bg-blue-800' : 'bg-gray-300' }}"></div>
                      @endif
                  </div>
            @endforeach
        </div>
    </div>

    {{-- Form Container --}}
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <form wire:submit.prevent="submit">
            {{-- Step 1: Informasi ISBN & Kepengarangan --}}
            @if($currentStep === 1)
              <div class="space-y-6">
                  {{-- 1. Jenis Permohonan ISBN --}}
                  <div>
                      <div class="block text-sm font-medium text-gray-700 mb-2">
                          Jenis Permohonan ISBN <span class="text-red-500">*</span>
                      </div>
                      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                          <label class="flex flex-col p-4 border-2 rounded-lg cursor-pointer {{ $isbn_request_type === 'LEPAS' ? 'border-blue-800 bg-blue-50' : 'border-gray-200 hover:border-gray-300' }}">
                              <div class="flex items-start">
                                  <input type="radio" wire:model.live="isbn_request_type" value="LEPAS" 
                                         class="mt-1 w-4 h-4 text-blue-800 border-gray-300 focus:ring-blue-800">
                                  <div class="ml-3">
                                      <div class="font-medium text-gray-900">ISBN Lepas</div>
                                      <div class="text-sm text-gray-600 mt-1">Penerbit akan mendapatkan 1 nomor ISBN untuk setiap judul yang diminta</div>
                                  </div>
                              </div>
                          </label>
                          <label class="flex flex-col p-4 border-2 rounded-lg cursor-pointer {{ $isbn_request_type === 'JILID' ? 'border-blue-800 bg-blue-50' : 'border-gray-200 hover:border-gray-300' }}">
                              <div class="flex items-start">
                                  <input type="radio" wire:model.live="isbn_request_type" value="JILID" 
                                         class="mt-1 w-4 h-4 text-blue-800 border-gray-300 focus:ring-blue-800">
                                  <div class="ml-3">
                                      <div class="font-medium text-gray-900">ISBN Jilid</div>
                                      <div class="text-sm text-gray-600 mt-1">Untuk permohonan jilid baru, penerbit akan menerima 2 ISBN yaitu ISBN jilid lengkap, serta 1 ISBN yang spesifik untuk jilidnya</div>
                                  </div>
                              </div>
                          </label>
                      </div>
                      @error('isbn_request_type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                  </div>

                  {{-- 2. Judul Buku --}}
                  <div>
                      <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                          Judul Buku <span class="text-red-500">*</span>
                      </label>
                      <input type="text" id="title" wire:model="title" 
                             class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent"
                             placeholder="Masukkan judul buku">
                      @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                  </div>

                  {{-- 3. Kepengarangan --}}
                  <div class="border-t border-gray-200 pt-6">
                      <h3 class="text-lg font-medium text-gray-900 mb-4">Kepengarangan</h3>
                      
                      {{-- Existing Authors List --}}
                      @if(count($authors) > 0)
                        <div class="space-y-3 mb-4">
                            @foreach($authors as $index => $author)
                              <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg">
                                  <div class="flex items-start justify-between">
                                      <div class="flex-1">
                                          <div class="flex items-center gap-2 flex-wrap">
                                              <h4 class="text-sm font-medium text-gray-900">{{ $author['name'] }}</h4>
                                              <span class="px-2 py-0.5 text-xs font-medium bg-blue-100 text-blue-800 rounded">
                                                  {{ ucfirst(strtolower(str_replace('_', ' ', $author['role_category']))) }}
                                              </span>
                                              @if($author['is_corresponding'])
                                                <span class="px-2 py-0.5 text-xs font-medium bg-green-100 text-green-800 rounded">
                                                    Korespondensi
                                                </span>
                                              @endif
                                          </div>
                                          <p class="text-sm text-gray-600 mt-1">{{ $author['email'] }}</p>
                                          <p class="text-sm text-gray-600">{{ $author['affiliation'] }}</p>
                                          @if(!empty($author['nidn_nip']))
                                            <p class="text-sm text-gray-600">NIDN/NIP: {{ $author['nidn_nip'] }}</p>
                                          @endif
                                      </div>
                                      <div class="flex items-center gap-2">
                                          @if(!$author['is_corresponding'])
                                            <button type="button" wire:click="setCorresponding({{ $index }})"
                                                    class="text-sm text-blue-800 hover:text-blue-900">
                                                Jadikan Korespondensi
                                            </button>
                                          @endif
                                          <button type="button" wire:click="removeAuthor({{ $index }})"
                                                  class="text-red-600 hover:text-red-800">
                                              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                  <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                              </svg>
                                          </button>
                                      </div>
                                  </div>
                              </div>
                            @endforeach
                        </div>
                      @endif

                      {{-- Add New Author Form --}}
                      <div class="border border-gray-300 rounded-lg p-4 bg-white">
                          <h4 class="text-sm font-medium text-gray-900 mb-4">Tambah Kontributor</h4>
                          <div class="space-y-4">
                              <div>
                                  <label for="newAuthorRoleCategory" class="block text-sm font-medium text-gray-700 mb-1">
                                      Kategori Peran <span class="text-red-500">*</span>
                                  </label>
                                  <select id="newAuthorRoleCategory" wire:model="newAuthorRoleCategory" 
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent">
                                      <option value="">Pilih kategori</option>
                                      <option value="PENULIS">Penulis</option>
                                      <option value="KOMIKUS">Komikus</option>
                                      <option value="PENERJEMAH">Penerjemah</option>
                                      <option value="ILUSTRATOR">Ilustrator</option>
                                      <option value="EDITOR">Editor</option>
                                      <option value="MURAJAAH">Muraja'ah</option>
                                      <option value="REVIEWER">Reviewer</option>
                                      <option value="FOTOGRAFER">Fotografer</option>
                                  </select>
                              </div>

                              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                  <div>
                                      <label for="newAuthorName" class="block text-sm font-medium text-gray-700 mb-1">
                                          Nama Lengkap <span class="text-red-500">*</span>
                                      </label>
                                      <input type="text" id="newAuthorName" wire:model="newAuthorName" 
                                             class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent"
                                             placeholder="Nama lengkap">
                                      @error('newAuthorName') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                  </div>

                                  <div>
                                      <label for="newAuthorEmail" class="block text-sm font-medium text-gray-700 mb-1">
                                          Email <span class="text-red-500">*</span>
                                      </label>
                                      <input type="email" id="newAuthorEmail" wire:model="newAuthorEmail" 
                                             class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent"
                                             placeholder="email@example.com">
                                      @error('newAuthorEmail') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                  </div>
                              </div>

                              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                  <div>
                                      <label for="newAuthorAffiliation" class="block text-sm font-medium text-gray-700 mb-1">
                                          Afiliasi <span class="text-red-500">*</span>
                                      </label>
                                      <input type="text" id="newAuthorAffiliation" wire:model="newAuthorAffiliation" 
                                             class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent"
                                             placeholder="Nama institusi">
                                      @error('newAuthorAffiliation') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                  </div>

                                  <div>
                                      <label for="newAuthorNidnNip" class="block text-sm font-medium text-gray-700 mb-1">
                                          NIDN/NIP
                                      </label>
                                      <input type="text" id="newAuthorNidnNip" wire:model="newAuthorNidnNip" 
                                             class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent"
                                             placeholder="NIDN atau NIP">
                                      @error('newAuthorNidnNip') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                  </div>
                              </div>

                              <div class="flex items-center justify-between">
                                  <label class="flex items-center">
                                      <input type="checkbox" wire:model="newAuthorIsCorresponding" 
                                             class="w-4 h-4 text-blue-800 border-gray-300 rounded focus:ring-blue-800">
                                      <span class="ml-2 text-sm text-gray-700">Penulis Korespondensi</span>
                                  </label>
                                  <button type="button" wire:click="addAuthor"
                                          class="px-4 py-2 bg-blue-800 text-white text-sm font-medium rounded-lg hover:bg-blue-900">
                                      Tambah Kontributor
                                  </button>
                              </div>
                          </div>
                      </div>
                  </div>

                  {{-- 4. Media Terbitan ISBN --}}
                  <div class="border-t border-gray-200 pt-6">
                      <label for="publication_media" class="block text-sm font-medium text-gray-700 mb-1">
                          Media Terbitan ISBN <span class="text-red-500">*</span>
                      </label>
                      <select id="publication_media" wire:model="publication_media" 
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent">
                          <option value="">Pilih media terbitan</option>
                          <option value="CETAK">Cetak</option>
                          <option value="DIGITAL_PDF">Digital (PDF)</option>
                          <option value="DIGITAL_EPUB">Digital (EPUB)</option>
                          <option value="AUDIO_BOOK">Audio Book</option>
                          <option value="AUDIO_VISUAL">Audio Visual</option>
                      </select>
                      @error('publication_media') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                  </div>

                  {{-- 5. Kelompok Pembaca --}}
                  <div>
                      <label for="reader_group" class="block text-sm font-medium text-gray-700 mb-1">
                          Kelompok Pembaca <span class="text-red-500">*</span>
                      </label>
                      <select id="reader_group" wire:model="reader_group" 
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent">
                          <option value="">Pilih kelompok pembaca</option>
                          <option value="ANAK">Anak</option>
                          <option value="DEWASA">Dewasa</option>
                          <option value="SEMUA_UMUR">Semua Umur</option>
                      </select>
                      @error('reader_group') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                  </div>

                  {{-- 6. Jenis Pustaka --}}
                  <div>
                      <label for="library_type" class="block text-sm font-medium text-gray-700 mb-1">
                          Jenis Pustaka <span class="text-red-500">*</span>
                      </label>
                      <select id="library_type" wire:model="library_type" 
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent">
                          <option value="">Pilih jenis pustaka</option>
                          <option value="FIKSI">Fiksi</option>
                          <option value="NON_FIKSI">Non Fiksi</option>
                      </select>
                      @error('library_type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                  </div>

                  {{-- 7. Kategori Jenis Pustaka --}}
                  <div>
                      <label for="library_category" class="block text-sm font-medium text-gray-700 mb-1">
                          Kategori Jenis Pustaka <span class="text-red-500">*</span>
                      </label>
                      <select id="library_category" wire:model="library_category" 
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent">
                          <option value="">Pilih kategori</option>
                          <option value="TERJEMAHAN">Terjemahan</option>
                          <option value="NON_TERJEMAHAN">Non Terjemahan</option>
                      </select>
                      @error('library_category') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                  </div>

                  {{-- 8. Katalog Dalam Terbitan (KDT) --}}
                  <div>
                      <label class="flex items-center">
                          <input type="checkbox" wire:model="has_kdt" 
                                 class="w-4 h-4 text-blue-800 border-gray-300 rounded focus:ring-blue-800">
                          <span class="ml-2 text-sm text-gray-700">Apakah Anda memerlukan katalog dalam terbitan (KDT)?</span>
                      </label>
                  </div>
              </div>
            @endif

            {{-- Step 2: Detail Publikasi & Spesifikasi --}}
            @if($currentStep === 2)
              <div class="space-y-6">
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                      <div>
                          <label for="estimated_publish_month" class="block text-sm font-medium text-gray-700 mb-1">
                              Bulan Terbit <span class="text-red-500">*</span>
                          </label>
                          <select id="estimated_publish_month" wire:model="estimated_publish_month" 
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent">
                              <option value="">Pilih Bulan</option>
                              <option value="Januari">Januari</option>
                              <option value="Februari">Februari</option>
                              <option value="Maret">Maret</option>
                              <option value="April">April</option>
                              <option value="Mei">Mei</option>
                              <option value="Juni">Juni</option>
                              <option value="Juli">Juli</option>
                              <option value="Agustus">Agustus</option>
                              <option value="September">September</option>
                              <option value="Oktober">Oktober</option>
                              <option value="November">November</option>
                              <option value="Desember">Desember</option>
                          </select>
                          @error('estimated_publish_month') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                      </div>

                      <div>
                          <label for="estimated_publish_year" class="block text-sm font-medium text-gray-700 mb-1">
                              Tahun Terbit <span class="text-red-500">*</span>
                          </label>
                          <input type="number" id="estimated_publish_year" wire:model="estimated_publish_year" 
                                 class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent"
                                 placeholder="2025" min="{{ date('Y') }}">
                          @error('estimated_publish_year') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                      </div>
                  </div>

                  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                      <div>
                          <label for="province" class="block text-sm font-medium text-gray-700 mb-1">
                              Provinsi Penerbit <span class="text-red-500">*</span>
                          </label>
                          <input type="text" id="province" wire:model="province" 
                                 class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent"
                                 placeholder="Contoh: Jawa Timur">
                          @error('province') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                      </div>

                      <div>
                          <label for="city" class="block text-sm font-medium text-gray-700 mb-1">
                              Kota Penerbit <span class="text-red-500">*</span>
                          </label>
                          <input type="text" id="city" wire:model="city" 
                                 class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent"
                                 placeholder="Contoh: Surabaya">
                          @error('city') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                      </div>
                  </div>

                  <div>
                      <label for="distributor" class="block text-sm font-medium text-gray-700 mb-1">
                          Nama Distributor
                      </label>
                      <input type="text" id="distributor" wire:model="distributor" 
                             class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent"
                             placeholder="Nama distributor/penerbit">
                      @error('distributor') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                  </div>

                  <div>
                      <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                          Deskripsi Terbitan <span class="text-red-500">*</span>
                      </label>
                      <textarea id="description" wire:model="description" rows="5"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent"
                                placeholder="Jelaskan ringkasan isi terbitan"></textarea>
                      @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                  </div>

                  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                      <div>
                          <label for="total_pages" class="block text-sm font-medium text-gray-700 mb-1">
                              Jumlah Halaman
                          </label>
                          <input type="number" id="total_pages" wire:model="total_pages" 
                                 class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent"
                                 placeholder="200" min="1">
                          @error('total_pages') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                      </div>

                      <div>
                          <label for="book_height_cm" class="block text-sm font-medium text-gray-700 mb-1">
                              Tinggi Buku (cm)
                          </label>
                          <input type="number" step="0.1" id="book_height_cm" wire:model="book_height_cm" 
                                 class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent"
                                 placeholder="21.0" min="1">
                          @error('book_height_cm') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                      </div>

                      <div>
                          <label for="edition" class="block text-sm font-medium text-gray-700 mb-1">
                              Edisi/Cetakan
                          </label>
                          <input type="text" id="edition" wire:model="edition" 
                                 class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent"
                                 placeholder="Cetakan 1">
                          @error('edition') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                      </div>
                  </div>

                  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                      <div>
                          <label for="series" class="block text-sm font-medium text-gray-700 mb-1">
                              Seri (jika ada)
                          </label>
                          <input type="text" id="series" wire:model="series" 
                                 class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent"
                                 placeholder="Nama seri buku">
                          @error('series') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                      </div>

                      <div>
                          <label for="publication_url" class="block text-sm font-medium text-gray-700 mb-1">
                              URL Publikasi (untuk digital)
                          </label>
                          <input type="url" id="publication_url" wire:model="publication_url" 
                                 class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent"
                                 placeholder="https://example.com">
                          @error('publication_url') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                      </div>
                  </div>

                  <div>
                      <label class="flex items-center">
                          <input type="checkbox" wire:model="has_illustration" 
                                 class="w-4 h-4 text-blue-800 border-gray-300 rounded focus:ring-blue-800">
                          <span class="ml-2 text-sm text-gray-700">Terbitan memiliki ilustrasi</span>
                      </label>
                  </div>
              </div>
            @endif

            {{-- Step 3: Kepengarangan --}}
            @if($currentStep === 3)
              <div class="space-y-6">
                  {{-- Existing Authors List --}}
                  @if(count($authors) > 0)
                    <div class="space-y-3">
                        <h3 class="text-sm font-medium text-gray-900">Daftar Kontributor</h3>
                        @foreach($authors as $index => $author)
                          <div class="p-4 border border-gray-200 rounded-lg">
                              <div class="flex items-start justify-between">
                                  <div class="flex-1">
                                      <div class="flex items-center gap-2">
                                          <h4 class="text-sm font-medium text-gray-900">{{ $author['name'] }}</h4>
                                          <span class="px-2 py-0.5 text-xs font-medium bg-gray-100 text-gray-800 rounded">
                                              {{ ucfirst(strtolower(str_replace('_', ' ', $author['role_category']))) }}
                                          </span>
                                          @if($author['is_corresponding'])
                                            <span class="px-2 py-0.5 text-xs font-medium bg-blue-100 text-blue-800 rounded">
                                                Korespondensi
                                            </span>
                                          @endif
                                      </div>
                                      <p class="text-sm text-gray-600 mt-1">{{ $author['email'] }}</p>
                                      <p class="text-sm text-gray-600">{{ $author['affiliation'] }}</p>
                                      @if(!empty($author['nidn_nip']))
                                        <p class="text-sm text-gray-600">NIDN/NIP: {{ $author['nidn_nip'] }}</p>
                                      @endif
                                  </div>
                                  <div class="flex items-center gap-2">
                                      @if(!$author['is_corresponding'])
                                        <button type="button" wire:click="setCorresponding({{ $index }})"
                                                class="text-sm text-blue-800 hover:text-blue-900">
                                            Jadikan Korespondensi
                                        </button>
                                      @endif
                                      <button type="button" wire:click="removeAuthor({{ $index }})"
                                              class="text-red-600 hover:text-red-800">
                                          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                              <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                          </svg>
                                      </button>
                                  </div>
                              </div>
                          </div>
                        @endforeach
                    </div>
                  @endif

                  {{-- Add New Author Form --}}
                  <div class="border-t border-gray-200 pt-6">
                      <h3 class="text-sm font-medium text-gray-900 mb-4">Tambah Kontributor</h3>
                      <div class="space-y-4">
                          <div>
                              <label for="newAuthorRoleCategory" class="block text-sm font-medium text-gray-700 mb-1">
                                  Peran <span class="text-red-500">*</span>
                              </label>
                              <select id="newAuthorRoleCategory" wire:model="newAuthorRoleCategory" 
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent">
                                  <option value="PENULIS">Penulis</option>
                                  <option value="KOMIKUS">Komikus</option>
                                  <option value="PENERJEMAH">Penerjemah</option>
                                  <option value="ILUSTRATOR">Ilustrator</option>
                                  <option value="EDITOR">Editor</option>
                                  <option value="MURAJAAH">Murajaah</option>
                                  <option value="REVIEWER">Reviewer</option>
                                  <option value="FOTOGRAFER">Fotografer</option>
                              </select>
                          </div>

                          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                              <div>
                                  <label for="newAuthorName" class="block text-sm font-medium text-gray-700 mb-1">
                                      Nama Lengkap <span class="text-red-500">*</span>
                                  </label>
                                  <input type="text" id="newAuthorName" wire:model="newAuthorName" 
                                         class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent"
                                         placeholder="Nama lengkap">
                                  @error('newAuthorName') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                              </div>

                              <div>
                                  <label for="newAuthorEmail" class="block text-sm font-medium text-gray-700 mb-1">
                                      Email <span class="text-red-500">*</span>
                                  </label>
                                  <input type="email" id="newAuthorEmail" wire:model="newAuthorEmail" 
                                         class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent"
                                         placeholder="email@example.com">
                                  @error('newAuthorEmail') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                              </div>
                          </div>

                          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                              <div>
                                  <label for="newAuthorAffiliation" class="block text-sm font-medium text-gray-700 mb-1">
                                      Afiliasi <span class="text-red-500">*</span>
                                  </label>
                                  <input type="text" id="newAuthorAffiliation" wire:model="newAuthorAffiliation" 
                                         class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent"
                                  @error('newAuthorAffiliation') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                              </div>

                              <div>
                                  <label for="newAuthorNidn" class="block text-sm font-medium text-gray-700 mb-1">
                                      NIDN/NIP (Opsional)
                                  </label>
                                  <input type="text" id="newAuthorNidn" wire:model="newAuthorNidn" 
                                         class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent"
                                         placeholder="NIDN atau NIP">
                              </div>
                          </div>

                          <button type="button" wire:click="addAuthor"
                                  class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200">
                              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                              </svg>
                              Tambah Kontributor
                          </button>
                      </div>
                  </div>

                  @error('authors') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
              </div>
            @endif

            {{-- Step 4: Upload Files --}}
            @if($currentStep === 4)
              <div class="space-y-6">
                  <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                      <p class="text-sm text-blue-800">
                          <strong>Catatan:</strong> Upload file dummy buku dalam format yang sesuai dengan media publikasi yang dipilih.
                      </p>
                  </div>

                  <div>
                      <label for="dummyFile" class="block text-sm font-medium text-gray-700 mb-1">
                          File Dummy Buku <span class="text-red-500">*</span>
                      </label>
                      <input type="file" id="dummyFile" wire:model="dummyFile" 
                             accept=".pdf,.epub,.mp3,.mp4,.wav"
                             class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent">
                      <p class="mt-1 text-sm text-gray-500">Format: PDF, EPUB, MP3, MP4, WAV - Maksimal 50MB</p>
                      @error('dummyFile') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror

                      @if ($dummyFile)
                        <div class="mt-2 p-3 bg-green-50 border border-green-200 rounded-lg">
                            <p class="text-sm text-green-800">✓ File dipilih: {{ $dummyFile->getClientOriginalName() }}</p>
                        </div>
                      @endif
                  </div>

                  <div>
                      <label for="coverFile" class="block text-sm font-medium text-gray-700 mb-1">
                          File Cover Buku (Opsional)
                      </label>
                      <input type="file" id="coverFile" wire:model="coverFile" 
                             accept="image/*"
                             class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent">
                      <p class="mt-1 text-sm text-gray-500">Format: JPG, PNG - Maksimal 2MB</p>
                      @error('coverFile') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror

                      @if ($coverFile)
                        <div class="mt-2 p-3 bg-green-50 border border-green-200 rounded-lg">
                            <p class="text-sm text-green-800">✓ File dipilih: {{ $coverFile->getClientOriginalName() }}</p>
                        </div>
                      @endif
                  </div>

                  <div>
                      <label for="attachmentFile" class="block text-sm font-medium text-gray-700 mb-1">
                          File Lampiran (PDF)
                      </label>
                      <p class="text-xs text-gray-600 mb-2">Berisi: Surat Permohonan ISBN, Surat Keaslian Karya, Halaman Judul, Kata Pengantar, Daftar Isi</p>
                      <input type="file" id="attachmentFile" wire:model="attachmentFile" 
                             accept=".pdf"
                             class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent">
                      <p class="mt-1 text-sm text-gray-500">Format: PDF - Maksimal 10MB</p>
                      @error('attachmentFile') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror

                      @if ($attachmentFile)
                        <div class="mt-2 p-3 bg-green-50 border border-green-200 rounded-lg">
                            <p class="text-sm text-green-800">✓ File dipilih: {{ $attachmentFile->getClientOriginalName() }}</p>
                        </div>
                      @endif
                  </div>
              </div>
            @endif

            {{-- Navigation Buttons --}}
            <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-200">
                <div>
                    @if($currentStep > 1)
                      <button type="button" wire:click="previousStep"
                              class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50">
                          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                          </svg>
                          Sebelumnya
                      </button>
                    @endif
                </div>

                <div>
                    @if($currentStep < 3)
                      <button type="button" wire:click="nextStep"
                              class="inline-flex items-center px-4 py-2 bg-blue-800 text-white text-sm font-medium rounded-lg hover:bg-blue-900">
                          Selanjutnya
                          <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                          </svg>
                      </button>
                    @else
                      <button type="submit"
                              class="inline-flex items-center px-6 py-2 bg-blue-800 text-white text-sm font-medium rounded-lg hover:bg-blue-900">
                          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                          </svg>
                          Ajukan Permohonan ISBN
                      </button>
                    @endif
                </div>
            </div>
        </form>
    </div>

    @if (session()->has('error'))
      <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-lg">
          <p class="text-sm text-red-800">{{ session('error') }}</p>
      </div>
    @endif
</div>
