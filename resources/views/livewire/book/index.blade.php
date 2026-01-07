<x-slot name="sidebar">
  <x-layouts.app.sidebar-book />
</x-slot>

<div class="p-6">
  {{-- Header --}}
  <div class="mb-6">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Permohonan ISBN</h1>
        <p class="mt-1 text-sm text-gray-600">Kelola permohonan ISBN terbitan Anda</p>
      </div>
      <a href="{{ route('book.create') }}" wire:navigate
        class="inline-flex items-center px-4 py-2 bg-blue-800 text-white text-sm font-medium rounded-lg hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-800 transition-colors">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Ajukan ISBN Baru
      </a>
    </div>
  </div>

  {{-- Search and Filter --}}
  <div class="mb-6 bg-white rounded-lg border border-gray-200 p-4">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div class="md:col-span-2">
        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
        <div class="relative">
          <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
          </div>
          <input type="text" id="search" wire:model.live.debounce.300ms="search"
            placeholder="Cari berdasarkan judul, jenis ISBN, atau media publikasi..."
            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent">
        </div>
        @if($search)
          <p class="mt-1 text-sm text-gray-600">Mencari: "{{ $search }}"</p>
        @endif
      </div>
      <div>
        <label for="filterStatus" class="block text-sm font-medium text-gray-700 mb-1">Filter Status</label>
        <select id="filterStatus" wire:model.live="filterStatus"
          class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent">
          <option value="">Semua Status</option>
          <option value="draft">Draft</option>
          <option value="submitted">Diajukan</option>
          <option value="review">Review</option>
          <option value="revision">Revisi</option>
          <option value="approved">Disetujui</option>
          <option value="rejected">Ditolak</option>
          <option value="published">Diterbitkan</option>
        </select>
        @if($filterStatus)
          <p class="mt-1 text-sm text-gray-600">Filter: {{ ucfirst($filterStatus) }}</p>
        @endif
      </div>
    </div>

    {{-- Stats --}}
    @if($search || $filterStatus)
      <div class="mt-4 pt-4 border-t border-gray-200">
        <div class="flex items-center justify-between">
          <p class="text-sm text-gray-600">
            Menampilkan {{ $submissions->total() }} hasil
          </p>
          <button wire:click="$set('search', ''); $set('filterStatus', '')" 
                  class="text-sm text-blue-800 hover:text-blue-900 font-medium">
            Reset Filter
          </button>
        </div>
      </div>
    @endif
  </div>

  {{-- Table --}}
  <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Judul & Jenis ISBN
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Media & Kelompok
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Kontributor
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Status
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Tanggal
            </th>
            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
              Aksi
            </th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @forelse($submissions as $submission)
            <tr class="hover:bg-gray-50 transition-colors">
              <td class="px-6 py-4">
                <div class="text-sm font-medium text-gray-900">{{ $submission->title }}</div>
                <div class="flex items-center gap-2 mt-1">
                  <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800">
                    {{ $submission->isbn_request_type === 'LEPAS' ? 'ISBN Lepas' : 'ISBN Jilid' }}
                  </span>
                  <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                    {{ ucfirst($submission->library_type === 'FIKSI' ? 'Fiksi' : 'Non Fiksi') }}
                  </span>
                </div>
              </td>

              <td class="px-6 py-4">
                @php
                  $mediaLabels = [
                    'CETAK' => 'Cetak',
                    'DIGITAL_PDF' => 'Digital (PDF)',
                    'DIGITAL_EPUB' => 'Digital (EPUB)',
                    'AUDIO_BOOK' => 'Audio Book',
                    'AUDIO_VISUAL' => 'Audio Visual'
                  ];
                  $readerLabels = [
                    'ANAK' => 'Anak-anak',
                    'DEWASA' => 'Dewasa',
                    'SEMUA_UMUR' => 'Semua Umur'
                  ];
                @endphp
                <div class="text-sm text-gray-900">{{ $mediaLabels[$submission->publication_media] ?? $submission->publication_media }}</div>
                <div class="text-sm text-gray-500">
                  {{ $readerLabels[$submission->reader_group] ?? $submission->reader_group }}
                </div>
              </td>

              <td class="px-6 py-4">
                @php
                  $correspondingAuthor = $submission->correspondingAuthor();
                @endphp
                <div class="text-sm text-gray-900">{{ $correspondingAuthor ? $correspondingAuthor->name : '-' }}</div>
                @if($submission->authors->count() > 1)
                  <div class="text-sm text-gray-500">+{{ $submission->authors->count() - 1 }} lainnya</div>
                @endif
                @if($correspondingAuthor)
                  <div class="text-xs text-gray-500">
                    {{ ucfirst(strtolower(str_replace('_', ' ', $correspondingAuthor->role_category))) }}
                  </div>
                @endif
              </td>

              <td class="px-6 py-4">
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
                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$submission->status] ?? 'bg-gray-100 text-gray-800' }}">
                  {{ $statusLabels[$submission->status] ?? $submission->status }}
                </span>
              </td>

              <td class="px-6 py-4 text-sm text-gray-500">
                {{ $submission->submitted_at ? $submission->submitted_at->format('d M Y') : '-' }}
              </td>

              <td class="px-6 py-4 text-right">
                <button wire:click="viewDetail({{ $submission->id }})"
                  class="text-blue-800 hover:text-blue-900 font-medium text-sm">
                  Detail
                </button>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="px-6 py-12">
                <div class="flex flex-col items-center justify-center">
                  <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                  </svg>
                  <p class="mt-4 text-sm text-gray-600">Belum ada permohonan ISBN</p>
                  <p class="mt-1 text-sm text-gray-500">Klik tombol "Ajukan ISBN Baru" untuk memulai</p>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Pagination --}}
    @if($submissions->hasPages())
      <div class="px-6 py-4 border-t border-gray-200">
        {{ $submissions->links() }}
      </div>
    @endif
  </div>
</div>