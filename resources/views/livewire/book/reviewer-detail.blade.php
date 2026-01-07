<x-slot name="sidebar">
  <x-layouts.app.sidebar-book />
</x-slot>

<div class="p-6">
  {{-- Success Message --}}
  @if(session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
      {{ session('success') }}
    </div>
  @endif

  {{-- Header --}}
  <div class="mb-6">
    <div class="flex items-center justify-between">
      <div>
        <div class="flex items-center gap-3 mb-2">
          <h1 class="text-2xl font-bold text-gray-900">Review Permohonan ISBN</h1>
          @php
            $statusColors = [
              'submitted' => 'bg-blue-100 text-blue-800',
              'review' => 'bg-yellow-100 text-yellow-800',
              'revision' => 'bg-orange-100 text-orange-800',
              'approved' => 'bg-green-100 text-green-800',
              'rejected' => 'bg-red-100 text-red-800',
            ];
            $statusLabels = [
              'submitted' => 'Diajukan',
              'review' => 'Review',
              'revision' => 'Revisi',
              'approved' => 'Disetujui',
              'rejected' => 'Ditolak',
            ];
          @endphp
          <span
            class="px-3 py-1 inline-flex text-sm font-semibold rounded-full {{ $statusColors[$submission->status] ?? 'bg-gray-100 text-gray-800' }}">
            {{ $statusLabels[$submission->status] ?? $submission->status }}
          </span>
        </div>
      </div>

      <div class="flex items-center gap-3">
        @if(!in_array($submission->status, ['approved', 'rejected', 'published']))
          <button type="button" wire:click="toggleReviewForm"
            class="inline-flex items-center px-4 py-2 bg-blue-800 text-white text-sm font-medium rounded-md hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-800">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Buat Review
          </button>
        @endif
        <a href="{{ route('book.reviewer.index') }}"
          class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-800">
          Kembali
        </a>
      </div>
    </div>
  </div>

  {{-- Review Form --}}
  @if($showReviewForm)
    <div class="mb-6 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
      <h2 class="text-lg font-semibold text-gray-900 mb-4">Formulir Review</h2>

      <form wire:submit.prevent="submitReview">
        <div class="space-y-4">
          {{-- Review Status --}}
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Keputusan Review *</label>
            <div class="space-y-2">
              <label class="flex items-center">
                <input type="radio" wire:model="reviewStatus" value="approved"
                  class="w-4 h-4 text-blue-800 border-gray-300 focus:ring-blue-800">
                <span class="ml-2 text-sm text-gray-700">
                  <span class="font-medium text-green-700">Disetujui</span> - Permohonan memenuhi syarat
                </span>
              </label>
              <label class="flex items-center">
                <input type="radio" wire:model="reviewStatus" value="revision"
                  class="w-4 h-4 text-blue-800 border-gray-300 focus:ring-blue-800">
                <span class="ml-2 text-sm text-gray-700">
                  <span class="font-medium text-orange-700">Perlu Revisi</span> - Ada yang perlu diperbaiki
                </span>
              </label>
              <label class="flex items-center">
                <input type="radio" wire:model="reviewStatus" value="rejected"
                  class="w-4 h-4 text-blue-800 border-gray-300 focus:ring-blue-800">
                <span class="ml-2 text-sm text-gray-700">
                  <span class="font-medium text-red-700">Ditolak</span> - Permohonan tidak memenuhi syarat
                </span>
              </label>
            </div>
            @error('reviewStatus')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          {{-- Review Notes --}}
          <div>
            <label for="reviewNotes" class="block text-sm font-medium text-gray-700 mb-1">
              Catatan Review *
            </label>
            <textarea id="reviewNotes" wire:model="reviewNotes" rows="5"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-transparent"
              placeholder="Berikan catatan detail untuk pemohon..."></textarea>
            <p class="mt-1 text-sm text-gray-500">Minimal 10 karakter</p>
            @error('reviewNotes')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          {{-- Actions --}}
          <div class="flex items-center gap-3 pt-4">
            <button type="submit"
              class="inline-flex items-center px-4 py-2 bg-blue-800 text-white text-sm font-medium rounded-md hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-800">
              Simpan Review
            </button>
            <button type="button" wire:click="toggleReviewForm"
              class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50">
              Batal
            </button>
          </div>
        </div>
      </form>
    </div>
  @endif

  {{-- Main Content Grid --}}
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Left Column --}}
    <div class="lg:col-span-2 space-y-6">

      {{-- Jenis Permohonan ISBN --}}
      <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
          <h2 class="text-lg font-semibold text-gray-900">Jenis Permohonan ISBN</h2>
        </div>
        <div class="p-6">
          <div class="flex items-start gap-3">
            <span
              class="inline-flex items-center px-3 py-1.5 rounded text-sm font-medium bg-purple-100 text-purple-800">
              {{ $submission->isbn_request_type === 'LEPAS' ? 'ISBN Lepas' : 'ISBN Jilid' }}
            </span>
            <div class="flex-1">
              <p class="text-sm text-gray-600">
                @if($submission->isbn_request_type === 'LEPAS')
                  Penerbit akan mendapatkan 1 nomor ISBN untuk setiap judul yang diminta
                @else
                  Untuk permohonan jilid baru, penerbit akan menerima 2 ISBN yaitu ISBN jilid lengkap, serta 1 ISBN yang
                  spesifik untuk jilidnya
                @endif
              </p>
            </div>
          </div>
        </div>
      </div>

      {{-- Judul Buku --}}
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-3">Judul Buku</h2>
        <p class="text-xl font-semibold text-gray-900">{{ $submission->title }}</p>
      </div>

      

      {{-- Kepengarangan --}}
      <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
          <h2 class="text-lg font-semibold text-gray-900">Kepengarangan</h2>
        </div>
        <div class="p-6">
          @if($submission->authors && $submission->authors->count() > 0)
            <div class="space-y-4">
              @foreach($submission->authors as $author)
                <div class="flex items-start gap-4 pb-4 border-b border-gray-100 last:border-0 last:pb-0">
                  <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                    <span class="text-sm font-medium text-blue-800">
                      {{ substr($author->name, 0, 1) }}
                    </span>
                  </div>
                  <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900">{{ $author->name }}</p>
                    <div class="mt-1 flex items-center gap-2 text-xs text-gray-500">
                      <span
                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                        {{ $author->role_category }}
                      </span>
                      @if($author->is_corresponding)
                        <span
                          class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                          Koresponden
                        </span>
                      @endif
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          @else
            <p class="text-sm text-gray-500 text-center py-4">Belum ada data kepengarangan</p>
          @endif
        </div>
      </div>

      {{-- Media & Kategori --}}
      <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
          <h2 class="text-lg font-semibold text-gray-900">Media Terbitan & Kategori</h2>
        </div>
        <div class="p-6">
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
              <p class="mt-1 text-sm text-gray-900">{{ $submission->reader_group }}</p>
            </div>
            @if($submission->library_type)
              <div>
                <p class="text-sm font-medium text-gray-500">Jenis Pustaka</p>
                <p class="mt-1 text-sm text-gray-900">{{ $submission->library_type }}</p>
              </div>
            @endif
            @if($submission->library_category)
              <div>
                <p class="text-sm font-medium text-gray-500">Kategori Pustaka</p>
                <p class="mt-1 text-sm text-gray-900">{{ $submission->library_category }}</p>
              </div>
            @endif
            <div class="md:col-span-2">
              <p class="text-sm font-medium text-gray-500">Katalog Dalam Terbitan (KDT)</p>
              <p class="mt-1 text-sm text-gray-900">
                {{ $submission->has_kdt ? 'Ya, memerlukan KDT' : 'Tidak memerlukan KDT' }}
              </p>
            </div>
          </div>
        </div>
      </div>

      {{-- Detail Publikasi --}}
      <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
          <h2 class="text-lg font-semibold text-gray-900">Detail Publikasi</h2>
        </div>
        <div class="p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @if($submission->estimated_publish_month && $submission->estimated_publish_year)
              <div>
                <p class="text-sm font-medium text-gray-500">Estimasi Terbit</p>
                <p class="mt-1 text-sm text-gray-900">
                  {{ $submission->estimated_publish_month }} {{ $submission->estimated_publish_year }}
                </p>
              </div>
            @endif
            @if($submission->province)
              <div>
                <p class="text-sm font-medium text-gray-500">Provinsi</p>
                <p class="mt-1 text-sm text-gray-900">{{ $submission->province }}</p>
              </div>
            @endif
            @if($submission->city)
              <div>
                <p class="text-sm font-medium text-gray-500">Kota/Kabupaten</p>
                <p class="mt-1 text-sm text-gray-900">{{ $submission->city }}</p>
              </div>
            @endif
            @if($submission->distributor)
              <div class="md:col-span-2">
                <p class="text-sm font-medium text-gray-500">Distributor</p>
                <p class="mt-1 text-sm text-gray-900">{{ $submission->distributor }}</p>
              </div>
            @endif
          </div>
        </div>
      </div>

      {{-- Deskripsi --}}
      @if($submission->description)
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
          <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Deskripsi atau Abstrak Buku</h2>
          </div>
          <div class="p-6">
            <p class="text-sm text-gray-700 whitespace-pre-line">{{ $submission->description }}</p>
          </div>
        </div>
      @endif

      {{-- Spesifikasi Buku --}}
      <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
          <h2 class="text-lg font-semibold text-gray-900">Spesifikasi Buku</h2>
        </div>
        <div class="p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @if($submission->total_pages)
              <div>
                <p class="text-sm font-medium text-gray-500">Jumlah Halaman</p>
                <p class="mt-1 text-sm text-gray-900">{{ $submission->total_pages }} halaman</p>
              </div>
            @endif
            @if($submission->book_height_cm)
              <div>
                <p class="text-sm font-medium text-gray-500">Tinggi Buku</p>
                <p class="mt-1 text-sm text-gray-900">{{ $submission->book_height_cm }} cm</p>
              </div>
            @endif
            @if($submission->edition)
              <div>
                <p class="text-sm font-medium text-gray-500">Edisi</p>
                <p class="mt-1 text-sm text-gray-900">{{ $submission->edition }}</p>
              </div>
            @endif
            @if($submission->series)
              <div>
                <p class="text-sm font-medium text-gray-500">Seri</p>
                <p class="mt-1 text-sm text-gray-900">{{ $submission->series }}</p>
              </div>
            @endif
            <div class="md:col-span-2">
              <p class="text-sm font-medium text-gray-500">Ilustrasi</p>
              <p class="mt-1 text-sm text-gray-900">
                {{ $submission->has_illustration ? 'Ya, terdapat ilustrasi' : 'Tidak ada ilustrasi' }}
              </p>
            </div>
          </div>
        </div>
      </div>

      {{-- File Terlampir --}}
      <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
          <h2 class="text-lg font-semibold text-gray-900">File Terlampir</h2>
        </div>
        <div class="p-6">
          @if($submission->files && $submission->files->count() > 0)
            <div class="space-y-3">
              @foreach($submission->files as $file)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100">
                  <div class="flex items-center gap-3 flex-1 min-w-0">
                    <div class="flex-shrink-0">
                      @php
                        $extension = strtolower(pathinfo($file->file_path, PATHINFO_EXTENSION));
                        $iconColor = match ($extension) {
                          'pdf' => 'text-red-500',
                          'jpg', 'jpeg', 'png' => 'text-blue-500',
                          'epub' => 'text-green-500',
                          'mp3', 'wav' => 'text-purple-500',
                          'mp4' => 'text-orange-500',
                          default => 'text-gray-500'
                        };
                      @endphp
                      <svg class="w-8 h-8 {{ $iconColor }}" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                          d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                          clip-rule="evenodd" />
                      </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                      <p class="text-sm font-medium text-gray-900 truncate">{{ $file->file_name }}</p>
                      <p class="text-xs text-gray-500">
                        {{ ucfirst($file->file_type) }}
                        @if($file->file_size)
                          • {{ number_format($file->file_size / 1024 / 1024, 2) }} MB
                        @endif
                      </p>
                    </div>
                  </div>
                  <a href="{{ Storage::url($file->file_path) }}" target="_blank"
                    class="ml-3 inline-flex items-center px-3 py-1.5 bg-blue-800 text-white text-xs font-medium rounded hover:bg-blue-900">
                    Lihat
                  </a>
                </div>
              @endforeach
            </div>
          @else
            <p class="text-sm text-gray-500 text-center py-8">Belum ada file yang diupload</p>
          @endif
        </div>
      </div>

      {{-- URL Link Publikasi --}}
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
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
              </svg>
            </a>
          </div>
        </div>
      @endif

      {{-- Previous Reviews --}}
      @if($submission->reviews->count() > 0)
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
          <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Riwayat Review</h2>
          </div>
          <div class="p-6">
            <div class="space-y-4">
              @foreach($submission->reviews as $review)
                <div
                  class="border-l-4 pl-4 {{ $review->status === 'approved' ? 'border-green-400' : ($review->status === 'revision' ? 'border-orange-400' : 'border-red-400') }}">
                  <div class="flex items-start justify-between mb-2">
                    <div>
                      <p class="text-sm font-medium text-gray-900">{{ $review->reviewer->name }}</p>
                      <p class="text-xs text-gray-500">{{ $review->reviewed_at->format('d M Y, H:i') }}</p>
                    </div>
                    @php
                      $reviewStatusColors = [
                        'approved' => 'bg-green-100 text-green-800',
                        'revision' => 'bg-orange-100 text-orange-800',
                        'rejected' => 'bg-red-100 text-red-800',
                      ];
                      $reviewStatusLabels = [
                        'approved' => 'Disetujui',
                        'revision' => 'Perlu Revisi',
                        'rejected' => 'Ditolak',
                      ];
                    @endphp
                    <span
                      class="px-2 py-1 text-xs font-semibold rounded {{ $reviewStatusColors[$review->status] ?? 'bg-gray-100 text-gray-800' }}">
                      {{ $reviewStatusLabels[$review->status] ?? $review->status }}
                    </span>
                  </div>
                  <p class="text-sm text-gray-700">{{ $review->notes }}</p>
                </div>
              @endforeach
            </div>
          </div>
        </div>
      @endif
    </div>

    {{-- Right Sidebar --}}
    <div class="lg:col-span-1 space-y-6">
      {{-- Info Pemohon --}}
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pemohon</h3>
        <div class="space-y-3">
          <div>
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Nama</p>
            <p class="mt-1 text-sm text-gray-900">{{ $submission->user->name }}</p>
          </div>
          <div>
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Email</p>
            <p class="mt-1 text-sm text-gray-900">{{ $submission->user->email }}</p>
          </div>
          <div>
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Tanggal Pengajuan</p>
            <p class="mt-1 text-sm text-gray-900">{{ $submission->created_at->format('d M Y, H:i') }}</p>
            <p class="text-xs text-gray-500">{{ $submission->created_at->diffForHumans() }}</p>
          </div>
          @if($submission->updated_at->ne($submission->created_at))
            <div>
              <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Terakhir Diubah</p>
              <p class="mt-1 text-sm text-gray-900">{{ $submission->updated_at->format('d M Y, H:i') }}</p>
              <p class="text-xs text-gray-500">{{ $submission->updated_at->diffForHumans() }}</p>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>