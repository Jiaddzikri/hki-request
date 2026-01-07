<x-slot name="sidebar">
  <x-layouts.app.sidebar-book />
</x-slot>

<div class="p-6">
  {{-- Success/Error Messages --}}
  @if(session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
      {{ session('success') }}
    </div>
  @endif

  @if(session('error'))
    <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
      {{ session('error') }}
    </div>
  @endif

  {{-- Alert untuk Status Revisi --}}
  @if($submission->status === 'revision')
    <div class="mb-6 bg-orange-50 border-l-4 border-orange-400 p-4">
      <div class="flex">
        <div class="flex-shrink-0">
          <svg class="h-5 w-5 text-orange-400" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
              d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
              clip-rule="evenodd" />
          </svg>
        </div>
        <div class="ml-3">
          <h3 class="text-sm font-medium text-orange-800">Permohonan Memerlukan Revisi</h3>
          <div class="mt-2 text-sm text-orange-700">
            <p>Permohonan ISBN Anda memerlukan perbaikan. Silakan periksa catatan reviewer di bagian bawah halaman ini
              dan lakukan revisi yang diperlukan.</p>
          </div>
        </div>
      </div>
    </div>
  @endif

  {{-- Alert untuk Status Ditolak --}}
  @if($submission->status === 'rejected')
    <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4">
      <div class="flex">
        <div class="flex-shrink-0">
          <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
              d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
              clip-rule="evenodd" />
          </svg>
        </div>
        <div class="ml-3">
          <h3 class="text-sm font-medium text-red-800">Permohonan Ditolak</h3>
          <div class="mt-2 text-sm text-red-700">
            <p>Permohonan ISBN Anda ditolak. Silakan periksa alasan penolakan di bagian review di bawah.</p>
          </div>
        </div>
      </div>
    </div>
  @endif

  {{-- Alert untuk Status Disetujui --}}
  @if($submission->status === 'approved')
    <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4">
      <div class="flex">
        <div class="flex-shrink-0">
          <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
              d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
              clip-rule="evenodd" />
          </svg>
        </div>
        <div class="ml-3">
          <h3 class="text-sm font-medium text-green-800">Permohonan Disetujui</h3>
          <div class="mt-2 text-sm text-green-700">
            <p>Selamat! Permohonan ISBN Anda telah disetujui oleh reviewer.</p>
          </div>
        </div>
      </div>
    </div>
  @endif

  {{-- Header --}}
  <div class="mb-6">
    <div class="flex items-center justify-between">
      <div>
        <div class="flex items-center gap-3 mb-2">
          @php
            $statusColors = [
              'draft' => 'bg-gray-100 text-gray-800',
              'submitted' => 'bg-blue-100 text-blue-800',
              'review' => 'bg-yellow-100 text-yellow-800',
              'revision' => 'bg-orange-100 text-orange-800',
              'approved' => 'bg-green-100 text-green-800',
              'rejected' => 'bg-red-100 text-red-800',
              'published' => 'bg-purple-100 text-purple-800',
            ];
            $statusLabels = [
              'draft' => 'Draft',
              'submitted' => 'Diajukan',
              'review' => 'Review',
              'revision' => 'Revisi',
              'approved' => 'Disetujui',
              'rejected' => 'Ditolak',
              'published' => 'Diterbitkan',
            ];
          @endphp
          <h1 class="text-2xl font-bold text-gray-900">Detail Permohonan ISBN</h1>
          <span
            class="px-3 py-1 inline-flex text-sm font-semibold rounded-full {{ $statusColors[$submission->status] ?? 'bg-gray-100 text-gray-800' }}">
            {{ $statusLabels[$submission->status] ?? $submission->status }}
          </span>
        </div>
      </div>
      <div class="flex items-center gap-3">
        {{-- Button Lihat Catatan Review (jika ada review) --}}
        @if($submission->reviews->count() > 0)
          <button type="button" onclick="document.getElementById('reviewModal').classList.remove('hidden')"
            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
            </svg>
            Lihat Catatan Review
            @if($submission->status === 'revision')
              <span class="ml-2 px-2 py-0.5 bg-white text-blue-800 text-xs rounded-full font-semibold">!</span>
            @endif
          </button>
        @endif

        @if($submission->status === 'revision' && !$isEditMode)
          <button wire:click="enableEditMode"
            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Mulai Revisi
          </button>
        @endif

        @if($isEditMode)
          <button wire:click="saveRevision"
            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M5 13l4 4L19 7" />
            </svg>
            Simpan & Ajukan Ulang
          </button>
          <button wire:click="cancelEdit"
            class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M6 18L18 6M6 6l12 12" />
            </svg>
            Batal
          </button>
        @endif

        @if($submission->status === 'draft')
          <button wire:click="submitForReview"
            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Ajukan untuk Review
          </button>
          <button wire:click="confirmDelete"
            class="inline-flex items-center px-4 py-2 border border-red-300 text-red-700 text-sm font-medium rounded-lg hover:bg-red-50">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
            Hapus
          </button>
        @endif
        <a href="{{ route('book.index') }}" wire:navigate class="text-sm text-gray-600 hover:text-gray-900">
          ← Kembali
        </a>
      </div>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Main Content --}}
    <div class="lg:col-span-2 space-y-6">

      {{-- 2. Nomor ISBN (Only if published) --}}
      @if($submission->isbn)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-8 h-8 rounded-full bg-blue-800 text-white flex items-center justify-center text-sm font-bold">
              2
            </div>
            <h2 class="text-lg font-semibold text-gray-900">Nomor ISBN</h2>
          </div>
          <div class="ml-11 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <p class="text-xs text-blue-600 font-medium uppercase tracking-wide mb-1">ISBN yang Diterbitkan</p>
            <p class="text-2xl font-mono font-bold text-blue-900">{{ $submission->isbn }}</p>
          </div>
        </div>
      @endif

        {{-- 3. Jenis Permohonan ISBN --}}
      <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
          <h2 class="text-lg font-semibold text-gray-900">Jenis Permohonan ISBN</h2>
        </div>
        <div class="p-6">
          <div class="flex items-start gap-3">
            <span class="inline-flex items-center px-3 py-1.5 rounded text-sm font-medium bg-purple-100 text-purple-800">
              {{ $submission->isbn_request_type === 'LEPAS' ? 'ISBN Lepas' : 'ISBN Jilid' }}
            </span>
            <div class="flex-1">
              <p class="text-sm text-gray-600">
                @if($submission->isbn_request_type === 'LEPAS')
                  Penerbit akan mendapatkan 1 nomor ISBN untuk setiap judul yang diminta
                @else
                  Untuk permohonan jilid baru, penerbit akan menerima 2 ISBN yaitu ISBN jilid lengkap, serta 1 ISBN yang spesifik untuk jilidnya
                @endif
              </p>
            </div>
          </div>
        </div>
      </div>

          {{-- 1. Judul Buku --}}
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center gap-3 mb-4">
          <div class="w-8 h-8 rounded-full bg-blue-800 text-white flex items-center justify-center text-sm font-bold">
            1
          </div>
          <h2 class="text-lg font-semibold text-gray-900">Judul Buku</h2>
        </div>
        <div class="ml-11">
          @if($isEditMode)
            <input type="text" wire:model="title" 
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              placeholder="Masukkan judul buku">
            @error('title') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
          @else
            <p class="text-xl font-semibold text-gray-900">{{ $submission->title }}</p>
          @endif
        </div>
      </div>

  

      {{-- 4. Kepengarangan --}}
      <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
          <h2 class="text-lg font-semibold text-gray-900">Kepengarangan</h2>
        </div>
        <div class="p-6">
          @if($isEditMode)
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Nama Penulis (pisahkan dengan koma untuk multiple penulis)
              </label>
              <input type="text" wire:model="authors_text" 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                placeholder="Contoh: John Doe, Jane Smith, Bob Johnson">
              <p class="text-xs text-gray-500 mt-1">Format: Nama Penulis 1, Nama Penulis 2, dst.</p>
              @error('authors_text') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>
          @else
            <div class="space-y-4">
              @foreach ($submission->authors as $author)
                <div class="flex items-start justify-between p-4 bg-gray-50 rounded-lg">
                  <div class="flex-1">
                    <div class="flex items-center gap-2 flex-wrap">
                      <h4 class="text-sm font-medium text-gray-900">{{ $author->name }}</h4>
                      @if($author->role_category)
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                          {{ ucfirst(strtolower(str_replace('_', ' ', $author->role_category))) }}
                        </span>
                      @endif
                      @if($author->is_corresponding)
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                          Korespondensi
                        </span>
                      @endif
                    </div>
                    <p class="mt-1 text-sm text-gray-600">{{ $author->email }}</p>
                    <p class="text-sm text-gray-600">{{ $author->affiliation }}</p>
                    @if($author->nidn_nip)
                      <p class="text-sm text-gray-500">NIDN/NIP: {{ $author->nidn_nip }}</p>
                    @endif
                  </div>
                </div>
            @endforeach
          </div>
          @endif
        </div>
      </div>

      {{-- 5. Informasi Media & Kategori --}}
      <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
          <h2 class="text-lg font-semibold text-gray-900">Media Terbitan & Kategori</h2>
        </div>
        <div class="p-6">
          @if($isEditMode)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              {{-- Media Terbitan ISBN --}}
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Media Terbitan ISBN</label>
                <select wire:model="publication_media"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                  <option value="">Pilih Media</option>
                  <option value="CETAK">Cetak</option>
                  <option value="DIGITAL_PDF">Digital (PDF)</option>
                  <option value="DIGITAL_EPUB">Digital (EPUB)</option>
                  <option value="AUDIO_BOOK">Audio Book</option>
                  <option value="AUDIO_VISUAL">Audio Visual</option>
                </select>
                @error('publication_media') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
              </div>

              {{-- Kelompok Pembaca --}}
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kelompok Pembaca</label>
                <select wire:model="reader_group"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                  <option value="">Pilih Kelompok</option>
                  <option value="ANAK">Anak</option>
                  <option value="DEWASA">Dewasa</option>
                  <option value="SEMUA_UMUR">Semua Umur</option>
                </select>
                @error('reader_group') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
              </div>

              {{-- Jenis Pustaka --}}
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Pustaka</label>
                <select wire:model="library_type"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                  <option value="">Pilih Jenis</option>
                  <option value="FIKSI">Fiksi</option>
                  <option value="NON_FIKSI">Non Fiksi</option>
                </select>
                @error('library_type') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
              </div>

              {{-- Kategori Jenis Pustaka --}}
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori Jenis Pustaka</label>
                <select wire:model="library_category"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                  <option value="">Pilih Kategori</option>
                  <option value="TERJEMAHAN">Terjemahan</option>
                  <option value="NON_TERJEMAHAN">Non Terjemahan</option>
                </select>
                @error('library_category') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
              </div>

              {{-- KDT --}}
              <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Katalog Dalam Terbitan (KDT)</label>
                <div class="flex gap-4">
                  <label class="flex items-center">
                    <input type="radio" wire:model="has_kdt" value="1" class="mr-2">
                    <span class="text-sm text-gray-700">Ya</span>
                  </label>
                  <label class="flex items-center">
                    <input type="radio" wire:model="has_kdt" value="0" class="mr-2">
                    <span class="text-sm text-gray-700">Tidak</span>
                  </label>
                </div>
                @error('has_kdt') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
              </div>
            </div>
          @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <p class="text-sm font-medium text-gray-500">Media Terbitan ISBN</p>
              <p class="mt-1 text-sm text-gray-900">
                @php
                  $mediaLabels = [
                    'CETAK' => 'Cetak',
                    'DIGITAL_PDF' => 'Digital (PDF)',
                    'DIGITAL_EPUB' => 'Digital (EPUB)',
                    'AUDIO_BOOK' => 'Audio Book',
                    'AUDIO_VISUAL' => 'Audio Visual',
                  ];
                @endphp
                {{ $mediaLabels[$submission->publication_media] ?? $submission->publication_media }}
              </p>
            </div>

            <div>
              <p class="text-sm font-medium text-gray-500">Kelompok Pembaca</p>
              <p class="mt-1 text-sm text-gray-900">
                @php
                  $readerLabels = [
                    'ANAK' => 'Anak',
                    'DEWASA' => 'Dewasa',
                    'SEMUA_UMUR' => 'Semua Umur',
                  ];
                @endphp
                {{ $readerLabels[$submission->reader_group] ?? $submission->reader_group }}
              </p>
            </div>

            <div>
              <p class="text-sm font-medium text-gray-500">Jenis Pustaka</p>
              <p class="mt-1">
                <span class="inline-flex items-center px-2.5 py-1 rounded text-xs font-medium bg-gray-100 text-gray-800">
                  {{ $submission->library_type === 'FIKSI' ? 'Fiksi' : 'Non Fiksi' }}
                </span>
              </p>
            </div>

            <div>
              <p class="text-sm font-medium text-gray-500">Kategori Jenis Pustaka</p>
              <p class="mt-1 text-sm text-gray-900">
                {{ $submission->library_category === 'TERJEMAHAN' ? 'Terjemahan' : 'Non Terjemahan' }}
              </p>
            </div>

            <div class="md:col-span-2">
              <p class="text-sm font-medium text-gray-500">Katalog Dalam Terbitan (KDT)</p>
              <p class="mt-1 text-sm text-gray-900">
                {{ $submission->has_kdt ? 'Ya' : 'Tidak' }}
              </p>
            </div>
          </div>
          @endif
        </div>
      </div>

      {{-- 6. Detail Publikasi --}}
      <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
          <h2 class="text-lg font-semibold text-gray-900">Detail Publikasi</h2>
        </div>
        <div class="p-6">
          @if($isEditMode)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              {{-- Bulan & Tahun Terbit --}}
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Perkiraan Bulan Terbit</label>
                <select wire:model="estimated_publish_month"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
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
                @error('estimated_publish_month') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Perkiraan Tahun Terbit</label>
                <input type="number" wire:model="estimated_publish_year" min="2020" max="2030"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                  placeholder="Contoh: 2026">
                @error('estimated_publish_year') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
              </div>

              {{-- Provinsi --}}
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Provinsi Tempat Terbit Buku</label>
                <input type="text" wire:model="province"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                  placeholder="Contoh: Jawa Timur">
                @error('province') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
              </div>

              {{-- Kota --}}
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kota/Kabupaten Tempat Terbit</label>
                <input type="text" wire:model="city"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                  placeholder="Contoh: Surabaya">
                @error('city') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
              </div>

              {{-- Distributor --}}
              <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Distributor Buku (Opsional)</label>
                <input type="text" wire:model="distributor"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                  placeholder="Nama distributor">
                @error('distributor') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
              </div>
            </div>
          @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @if($submission->estimated_publish_month && $submission->estimated_publish_year)
              <div>
                <p class="text-sm font-medium text-gray-500">Perkiraan Bulan dan Tahun Terbit</p>
                <p class="mt-1 text-sm text-gray-900">
                  {{ $submission->estimated_publish_month }} {{ $submission->estimated_publish_year }}
                </p>
              </div>
            @endif

            @if($submission->province)
              <div>
                <p class="text-sm font-medium text-gray-500">Provinsi Tempat Terbit Buku</p>
                <p class="mt-1 text-sm text-gray-900">{{ $submission->province }}</p>
              </div>
            @endif

            @if($submission->city)
              <div>
                <p class="text-sm font-medium text-gray-500">Kota/Kabupaten Tempat Terbit</p>
                <p class="mt-1 text-sm text-gray-900">{{ $submission->city }}</p>
              </div>
            @endif

            @if($submission->distributor)
              <div>
                <p class="text-sm font-medium text-gray-500">Distributor Buku</p>
                <p class="mt-1 text-sm text-gray-900">{{ $submission->distributor }}</p>
              </div>
            @endif
          </div>
          @endif
        </div>
      </div>

      {{-- 7. Deskripsi atau Abstrak Buku --}}
      @if($submission->description || $isEditMode)
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
          <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Deskripsi atau Abstrak Buku</h2>
          </div>
          <div class="p-6">
            @if($isEditMode)
              <textarea wire:model="summary" rows="6"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                placeholder="Masukkan deskripsi atau abstrak buku (minimal 50 karakter)"></textarea>
              <p class="text-xs text-gray-500 mt-1">Minimal 50 karakter</p>
              @error('summary') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            @else
              <p class="text-sm text-gray-900 whitespace-pre-wrap">{{ $submission->description }}</p>
            @endif
          </div>
        </div>
      @endif

      {{-- 8. Spesifikasi Buku --}}
      <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
          <h2 class="text-lg font-semibold text-gray-900">Spesifikasi Buku</h2>
        </div>
        <div class="p-6">
          @if($isEditMode)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              {{-- Jumlah Halaman --}}
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Halaman</label>
                <input type="number" wire:model="pages" min="1"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                  placeholder="Contoh: 250">
                @error('pages') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
              </div>

              {{-- Ukuran Buku --}}
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Ukuran Buku (cm)</label>
                <input type="text" wire:model="size"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                  placeholder="Contoh: 21 x 14.8">
                @error('size') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
              </div>

              {{-- Edisi --}}
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Edisi Buku (Opsional)</label>
                <input type="text" wire:model="edition"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                  placeholder="Contoh: Edisi 1, Edisi Revisi">
                @error('edition') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
              </div>

              {{-- Seri --}}
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Seri Buku (Opsional)</label>
                <input type="text" wire:model="series"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                  placeholder="Contoh: Seri Petualangan">
                @error('series') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
              </div>
            </div>
          @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @if($submission->total_pages)
              <div>
                <p class="text-sm font-medium text-gray-500">Jumlah Halaman</p>
                <p class="mt-1 text-sm text-gray-900">{{ $submission->total_pages }} halaman</p>
              </div>
            @endif

            @if($submission->book_height_cm)
              <div>
                <p class="text-sm font-medium text-gray-500">Tinggi Buku (cm)</p>
                <p class="mt-1 text-sm text-gray-900">{{ $submission->book_height_cm }} cm</p>
              </div>
            @endif

            @if($submission->edition)
              <div>
                <p class="text-sm font-medium text-gray-500">Edisi Buku</p>
                <p class="mt-1 text-sm text-gray-900">{{ $submission->edition }}</p>
              </div>
            @endif

            @if($submission->series)
              <div>
                <p class="text-sm font-medium text-gray-500">Seri Buku</p>
                <p class="mt-1 text-sm text-gray-900">{{ $submission->series }}</p>
              </div>
            @endif

            <div>
              <p class="text-sm font-medium text-gray-500">Ilustrasi</p>
              <p class="mt-1 text-sm text-gray-900">{{ $submission->has_illustration ? 'Ya' : 'Tidak' }}</p>
            </div>
          </div>
          @endif
        </div>
      </div>

      {{-- 9. File Upload --}}
      <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
          <h2 class="text-lg font-semibold text-gray-900">File Upload</h2>
        </div>
        <div class="p-6">
          @if($isEditMode)
            {{-- Form Edit Files --}}
            <div class="space-y-6">
              {{-- Cover File --}}
              <div class="border border-gray-200 rounded-lg p-4">
                <div class="flex items-center justify-between mb-3">
                  <div>
                    <h3 class="text-sm font-semibold text-gray-900">Cover Buku</h3>
                    @php $coverFile = $submission->files()->where('type', 'COVER')->first(); @endphp
                    @if($coverFile)
                      <p class="text-xs text-gray-500 mt-1">File saat ini: {{ $coverFile->file_name }}</p>
                    @endif
                  </div>
                  @if($coverFile)
                    <button wire:click="downloadFile({{ $coverFile->id }})" type="button"
                      class="text-xs text-blue-600 hover:text-blue-800">Lihat File</button>
                  @endif
                </div>
                <input type="file" wire:model="newCoverFile" accept=".jpg,.jpeg,.png,.pdf"
                  class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, PDF (Max 5MB)</p>
                @error('newCoverFile') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                @if($newCoverFile)
                  <p class="text-xs text-green-600 mt-2">✓ File baru dipilih: {{ $newCoverFile->getClientOriginalName() }}</p>
                @endif
              </div>

              {{-- Full Draft File --}}
              <div class="border border-gray-200 rounded-lg p-4">
                <div class="flex items-center justify-between mb-3">
                  <div>
                    <h3 class="text-sm font-semibold text-gray-900">File Dummy Buku (PDF)</h3>
                    @php $draftFile = $submission->files()->where('type', 'FULL_DRAFT')->first(); @endphp
                    @if($draftFile)
                      <p class="text-xs text-gray-500 mt-1">File saat ini: {{ $draftFile->file_name }}</p>
                    @endif
                  </div>
                  @if($draftFile)
                    <button wire:click="downloadFile({{ $draftFile->id }})" type="button"
                      class="text-xs text-blue-600 hover:text-blue-800">Lihat File</button>
                  @endif
                </div>
                <input type="file" wire:model="newFullDraftFile" accept=".pdf"
                  class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <p class="text-xs text-gray-500 mt-1">Format: PDF (Max 10MB)</p>
                @error('newFullDraftFile') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                @if($newFullDraftFile)
                  <p class="text-xs text-green-600 mt-2">✓ File baru dipilih: {{ $newFullDraftFile->getClientOriginalName() }}</p>
                @endif
              </div>

              {{-- Lampiran File --}}
              <div class="border border-gray-200 rounded-lg p-4">
                <div class="flex items-center justify-between mb-3">
                  <div>
                    <h3 class="text-sm font-semibold text-gray-900">File Lampiran (PDF)</h3>
                    <p class="text-xs text-gray-600 mt-1">Berisi: Surat Permohonan ISBN, Surat Keaslian Karya, Halaman Judul, Kata Pengantar, Daftar Isi</p>
                    @php $attachmentFile = $submission->files()->where('type', 'STATEMENT_LETTER')->first(); @endphp
                    @if($attachmentFile)
                      <p class="text-xs text-gray-500 mt-1">File saat ini: {{ $attachmentFile->file_name }}</p>
                    @endif
                  </div>
                  @if($attachmentFile)
                    <button wire:click="downloadFile({{ $attachmentFile->id }})" type="button"
                      class="text-xs text-blue-600 hover:text-blue-800">Lihat File</button>
                  @endif
                </div>
                <input type="file" wire:model="newAttachmentFile" accept=".pdf"
                  class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <p class="text-xs text-gray-500 mt-1">Format: PDF (Max 10MB)</p>
                @error('newAttachmentFile') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                @if($newAttachmentFile)
                  <p class="text-xs text-green-600 mt-2">✓ File baru dipilih: {{ $newAttachmentFile->getClientOriginalName() }}</p>
                @endif
              </div>

              <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex">
                  <svg class="w-5 h-5 text-blue-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                  </svg>
                  <div class="ml-3">
                    <p class="text-sm text-blue-700">
                      <strong>Catatan:</strong> File yang Anda upload akan menggantikan file lama. Jika tidak mengganti file tertentu, biarkan kosong.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          @else
            {{-- View Files --}}
            @if($submission->files->count() > 0)
            <div class="space-y-3">
              @foreach ($submission->files as $file)
                <div
                  class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                  <div class="flex items-center flex-1">
                    <div class="flex-shrink-0">
                      @php
                        $extension = pathinfo($file->file_name, PATHINFO_EXTENSION);
                        $iconColors = [
                          'pdf' => 'text-red-600',
                          'epub' => 'text-purple-600',
                          'mp3' => 'text-blue-600',
                          'mp4' => 'text-green-600',
                          'wav' => 'text-blue-600',
                          'jpg' => 'text-yellow-600',
                          'png' => 'text-yellow-600',
                          'default' => 'text-gray-600'
                        ];
                        $iconColor = $iconColors[$extension] ?? $iconColors['default'];
                      @endphp
                      <svg class="w-8 h-8 {{ $iconColor }}" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                          d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                          clip-rule="evenodd" />
                      </svg>
                    </div>
                    <div class="ml-4 flex-1">
                      <p class="text-sm font-medium text-gray-900">{{ $file->file_name }}</p>
                      <p class="text-sm text-gray-500">
                        @php
                          $typeLabels = [
                            'FULL_DRAFT' => 'File Dummy Buku',
                            'COVER' => 'Cover Buku',
                            'STATEMENT_LETTER' => 'File Lampiran',
                            'PROOFREAD_RESULT' => 'Hasil Proofread',
                          ];
                        @endphp
                        {{ $typeLabels[$file->type] ?? $file->type }} •
                        {{ number_format($file->file_size / 1024, 2) }} KB
                        @if($file->version > 1)
                          • Versi {{ $file->version }}
                        @endif
                      </p>
                    </div>
                  </div>
                  <button wire:click="downloadFile({{ $file->id }})"
                    class="ml-4 inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Download
                  </button>
                </div>
              @endforeach
            </div>
          @else
            <p class="text-sm text-gray-500 text-center py-8">Belum ada file yang diupload</p>
          @endif
          @endif
        </div>
      </div>

      {{-- 10. URL Link Publikasi --}}
      @if($submission->publication_url)
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
          <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">URL Link Publikasi</h2>
          </div>
          <div class="p-6">
            <a href="{{ $submission->publication_url }}" target="_blank"
              class="text-sm text-blue-800 hover:text-blue-900 break-all inline-flex items-center gap-2">
              {{ $submission->publication_url }}
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
              </svg>
            </a>
          </div>
        </div>
      @endif

      {{-- Reviews & Catatan Revisi --}}
      @if($submission->reviews->count() > 0)
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
          <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Riwayat Review & Catatan</h2>
          </div>
          <div class="p-6">
            <div class="space-y-4">
              @foreach ($submission->reviews as $review)
                <div
                  class="border-l-4 pl-4 {{ $review->decision === 'approved' ? 'border-green-400 bg-green-50' : ($review->decision === 'rejected' ? 'border-red-400 bg-red-50' : 'border-orange-400 bg-orange-50') }}">
                  <div class="flex items-start justify-between mb-3">
                    <div>
                      <p class="text-sm font-semibold text-gray-900">{{ $review->reviewer->name }}</p>
                      <p class="text-xs text-gray-500">{{ $review->reviewed_at->format('d M Y, H:i') }} WIB</p>
                      <p class="text-xs text-gray-500">{{ $review->reviewed_at->diffForHumans() }}</p>
                    </div>
                    @php
                      $decisionColors = [
                        'approved' => 'bg-green-100 text-green-800',
                        'rejected' => 'bg-red-100 text-red-800',
                        'revision' => 'bg-orange-100 text-orange-800',
                      ];
                      $decisionLabels = [
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        'revision' => 'Perlu Revisi',
                      ];
                    @endphp
                    <span
                      class="px-3 py-1 text-sm font-semibold rounded-full {{ $decisionColors[$review->decision] ?? 'bg-gray-100 text-gray-800' }}">
                      {{ $decisionLabels[$review->decision] ?? ucfirst($review->decision) }}
                    </span>
                  </div>

                  @if($review->review_notes)
                    <div class="mt-3 bg-white p-4 rounded-lg border border-gray-200">
                      <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-2">Catatan Reviewer:</p>
                      <p class="text-sm text-gray-900 whitespace-pre-line">{{ $review->review_notes }}</p>
                    </div>
                  @endif

                  @if($review->decision === 'revision')
                    <div class="mt-3 p-3 bg-orange-100 border border-orange-200 rounded-lg">
                      <div class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-orange-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                          viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <div class="flex-1">
                          <p class="text-sm font-medium text-orange-900">Permohonan memerlukan revisi</p>
                          <p class="text-xs text-orange-700 mt-1">Silakan perbaiki sesuai catatan reviewer di atas dan
                            ajukan kembali.</p>
                        </div>
                      </div>
                    </div>
                  @endif
                </div>
              @endforeach
            </div>
          </div>
        </div>
      @endif
    </div>

    {{-- Sidebar --}}
    <div class="space-y-6">
      {{-- Timeline --}}
      <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
          <h2 class="text-lg font-semibold text-gray-900">Riwayat</h2>
        </div>
        <div class="p-6">
          @if($submission->trackings->count() > 0)
            <div class="flow-root">
              <ul role="list" class="-mb-8">
                @foreach ($submission->trackings as $index => $tracking)
                  <li>
                    <div class="relative pb-8">
                      @if(!$loop->last)
                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                      @endif
                      <div class="relative flex space-x-3">
                        <div>
                          @php
                            $trackingStatusColors = [
                              'draft' => 'bg-gray-400',
                              'submitted' => 'bg-blue-800',
                              'review' => 'bg-yellow-500',
                              'revision' => 'bg-orange-500',
                              'approved' => 'bg-green-600',
                              'rejected' => 'bg-red-600',
                              'published' => 'bg-purple-600',
                            ];
                          @endphp
                          <span
                            class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white {{ $trackingStatusColors[$tracking->status] ?? 'bg-gray-400' }}">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                              <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                            </svg>
                          </span>
                        </div>
                        <div class="flex-1 min-w-0">
                          <div>
                            <p class="text-sm font-medium text-gray-900">
                              @php
                                $trackingLabels = [
                                  'draft' => 'Draft',
                                  'submitted' => 'Diajukan',
                                  'review' => 'Review',
                                  'revision' => 'Revisi',
                                  'approved' => 'Disetujui',
                                  'rejected' => 'Ditolak',
                                  'published' => 'Diterbitkan',
                                ];
                              @endphp
                              {{ $trackingLabels[$tracking->status] ?? $tracking->status }}
                            </p>
                            <p class="mt-0.5 text-xs text-gray-500">
                              {{ $tracking->created_at->format('d M Y, H:i') }}
                            </p>
                          </div>
                          @if($tracking->notes)
                            <div class="mt-2">
                              <p class="text-sm text-gray-600">{{ $tracking->notes }}</p>
                            </div>
                          @endif
                          @if($tracking->actor_id)
                            <p class="text-xs text-gray-500 mt-1">oleh {{ $tracking->getActorName() }}</p>
                          @endif
                        </div>
                      </div>
                    </div>
                  </li>
                @endforeach
              </ul>
            </div>
          @else
            <p class="text-sm text-gray-500 text-center py-8">Belum ada riwayat</p>
          @endif
        </div>
      </div>

      {{-- Info Submitter --}}
      <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
          <h2 class="text-lg font-semibold text-gray-900">Informasi Pengaju</h2>
        </div>
        <div class="p-6">
          <div class="space-y-3">
            <div>
              <p class="text-sm font-medium text-gray-500">Nama</p>
              <p class="mt-1 text-sm text-gray-900">{{ $submission->user->name }}</p>
            </div>
            <div>
              <p class="text-sm font-medium text-gray-500">Email</p>
              <p class="mt-1 text-sm text-gray-900">{{ $submission->user->email }}</p>
            </div>
            <div>
              <p class="text-sm font-medium text-gray-500">Tanggal Dibuat</p>
              <p class="mt-1 text-sm text-gray-900">{{ $submission->created_at->format('d M Y, H:i') }}</p>
            </div>
            @if($submission->submitted_at)
              <div>
                <p class="text-sm font-medium text-gray-500">Tanggal Diajukan</p>
                <p class="mt-1 text-sm text-gray-900">{{ $submission->submitted_at->format('d M Y, H:i') }}</p>
              </div>
            @endif
            @if($submission->published_at)
              <div>
                <p class="text-sm font-medium text-gray-500">Tanggal Diterbitkan</p>
                <p class="mt-1 text-sm text-gray-900">{{ $submission->published_at->format('d M Y, H:i') }}</p>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Delete Confirmation Modal --}}
  @if($showDeleteConfirm)
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
      <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Hapus Permohonan ISBN</h3>
        <p class="text-sm text-gray-600 mb-6">Apakah Anda yakin ingin menghapus permohonan ISBN ini? Tindakan ini tidak
          dapat dibatalkan.</p>
        <div class="flex items-center justify-end gap-3">
          <button wire:click="cancelDelete"
            class="px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50">
            Batal
          </button>
          <button wire:click="delete"
            class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
            Hapus
          </button>
        </div>
      </div>
    </div>
  @endif

  {{-- Review Modal --}}
  @if($submission->reviews->count() > 0)
    <div id="reviewModal" class="hidden fixed inset-0 bg-gray-900/50 z-50 p-4"
      onclick="document.getElementById('reviewModal').classList.add('hidden')">
      <div class="flex items-center justify-center min-h-full">
      <div class="bg-white rounded-lg max-w-3xl w-full max-h-[90vh] overflow-hidden flex flex-col"
        onclick="event.stopPropagation()">
        {{-- Modal Header --}}
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex items-center justify-between">
          <div class="flex items-center gap-3">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
            </svg>
            <h3 class="text-lg font-semibold text-white">Riwayat Review & Catatan</h3>
            <span class="px-2 py-1 bg-white bg-opacity-20 text-white text-xs rounded-full">
              {{ $submission->reviews->count() }} Review
            </span>
          </div>
          <button type="button" onclick="document.getElementById('reviewModal').classList.add('hidden')"
            class="text-white hover:text-gray-200 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

        {{-- Modal Body --}}
        <div class="flex-1 overflow-y-auto p-6">
          <div class="space-y-4">
            @foreach ($submission->reviews as $review)
              <div
                class="border-l-4 p-4 rounded-r-lg {{ $review->decision === 'approved' ? 'border-green-400 bg-green-50' : ($review->decision === 'rejected' ? 'border-red-400 bg-red-50' : 'border-orange-400 bg-orange-50') }}">
                <div class="flex items-start justify-between mb-3">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                      <span class="text-sm font-semibold text-gray-700">{{ substr($review->reviewer->name, 0, 2) }}</span>
                    </div>
                    <div>
                      <p class="text-sm font-semibold text-gray-900">{{ $review->reviewer->name }}</p>
                      <p class="text-xs text-gray-500">{{ $review->reviewed_at->format('d M Y, H:i') }} WIB</p>
                      <p class="text-xs text-gray-500">{{ $review->reviewed_at->diffForHumans() }}</p>
                    </div>
                  </div>
                  @php
                    $decisionColors = [
                      'approved' => 'bg-green-100 text-green-800',
                      'rejected' => 'bg-red-100 text-red-800',
                      'revision' => 'bg-orange-100 text-orange-800',
                    ];
                    $decisionLabels = [
                      'approved' => 'Disetujui',
                      'rejected' => 'Ditolak',
                      'revision' => 'Perlu Revisi',
                    ];
                  @endphp
                  <span
                    class="px-3 py-1.5 text-sm font-semibold rounded-full {{ $decisionColors[$review->decision] ?? 'bg-gray-100 text-gray-800' }}">
                    {{ $decisionLabels[$review->decision] ?? ucfirst($review->decision) }}
                  </span>
                </div>

                @if($review->review_notes)
                  <div class="mt-4 bg-white p-4 rounded-lg border-2 border-gray-200 shadow-sm">
                    <div class="flex items-center gap-2 mb-2">
                      <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                      </svg>
                      <p class="text-xs font-semibold text-gray-600 uppercase tracking-wide">Catatan Reviewer:</p>
                    </div>
                    <p class="text-sm text-gray-900 leading-relaxed whitespace-pre-line">{{ $review->review_notes }}</p>
                  </div>
                @endif

                @if($review->decision === 'revision')
                  <div class="mt-4 p-3 bg-orange-100 border-l-4 border-orange-500 rounded-r">
                    <div class="flex items-start gap-2">
                      <svg class="w-5 h-5 text-orange-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                      </svg>
                      <div class="flex-1">
                        <p class="text-sm font-semibold text-orange-900">Action Required: Revisi Diperlukan</p>
                        <p class="text-xs text-orange-700 mt-1">Silakan perbaiki sesuai catatan reviewer di atas dan
                          ajukan kembali permohonan Anda.</p>
                      </div>
                    </div>
                  </div>
                @endif

                @if($review->decision === 'rejected')
                  <div class="mt-4 p-3 bg-red-100 border-l-4 border-red-500 rounded-r">
                    <div class="flex items-start gap-2">
                      <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                      <div class="flex-1">
                        <p class="text-sm font-semibold text-red-900">Permohonan Ditolak</p>
                        <p class="text-xs text-red-700 mt-1">Permohonan tidak memenuhi syarat. Silakan buat permohonan
                          baru jika ingin mengajukan kembali.</p>
                      </div>
                    </div>
                  </div>
                @endif

                @if($review->decision === 'approved')
                  <div class="mt-4 p-3 bg-green-100 border-l-4 border-green-500 rounded-r">
                    <div class="flex items-start gap-2">
                      <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                      <div class="flex-1">
                        <p class="text-sm font-semibold text-green-900">Permohonan Disetujui</p>
                        <p class="text-xs text-green-700 mt-1">Selamat! Permohonan Anda telah disetujui oleh reviewer.
                        </p>
                      </div>
                    </div>
                  </div>
                @endif
              </div>
            @endforeach
          </div>
        </div>

        {{-- Modal Footer --}}
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
          <button type="button" onclick="document.getElementById('reviewModal').classList.add('hidden')"
            class="w-full px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
            Tutup
          </button>
        </div>
      </div>
      </div>
    </div>
  @endif

  @if (session()->has('error'))
    <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-lg">
      <p class="text-sm text-red-800">{{ session('error') }}</p>
    </div>
  @endif
</div>