<x-slot name="sidebar">
  <x-layouts.app.sidebar-book />
</x-slot>

<div class="p-6">
  {{-- Header --}}
  <div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Review Permohonan ISBN</h1>
    <p class="mt-1 text-sm text-gray-600">Daftar permohonan ISBN yang perlu direview</p>
  </div>

  {{-- Search and Filters --}}
  <div class="mb-6 bg-white rounded-lg shadow-sm border border-gray-200 p-4">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
      {{-- Search --}}
      <div class="lg:col-span-2">
        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
        <input type="text" id="search" wire:model.live.debounce.300ms="search"
          placeholder="Cari judul, ISBN, atau pemohon..."
          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-transparent">
      </div>

      {{-- Status Filter --}}
      <div>
        <label for="statusFilter" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
        <select id="statusFilter" wire:model.live="statusFilter"
          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-transparent">
          <option value="">Semua Status</option>
          <option value="submitted">Diajukan</option>
          <option value="review">Review</option>
          <option value="revision">Revisi</option>
        </select>
      </div>

      {{-- ISBN Type Filter --}}
      <div>
        <label for="isbnTypeFilter" class="block text-sm font-medium text-gray-700 mb-1">Jenis ISBN</label>
        <select id="isbnTypeFilter" wire:model.live="isbnTypeFilter"
          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-transparent">
          <option value="">Semua Jenis</option>
          <option value="LEPAS">ISBN Lepas</option>
          <option value="JILID">ISBN Jilid</option>
        </select>
      </div>

      {{-- Media Filter --}}
      <div>
        <label for="mediaFilter" class="block text-sm font-medium text-gray-700 mb-1">Media</label>
        <select id="mediaFilter" wire:model.live="mediaFilter"
          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-transparent">
          <option value="">Semua Media</option>
          <option value="CETAK">Cetak</option>
          <option value="DIGITAL_PDF">Digital (PDF)</option>
          <option value="DIGITAL_EPUB">Digital (EPUB)</option>
          <option value="AUDIO_BOOK">Audio Book</option>
          <option value="AUDIO_VISUAL">Audio Visual</option>
        </select>
      </div>
    </div>

    {{-- Reset Filters Button --}}
    @if($search || $statusFilter || $isbnTypeFilter || $mediaFilter)
      <div class="mt-4">
        <button type="button" wire:click="resetFilters" class="text-sm text-blue-800 hover:text-blue-900 font-medium">
          Reset Filter
        </button>
      </div>
    @endif
  </div>

  {{-- Submissions Table --}}
  <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    @if($submissions->count() > 0)
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Judul Buku
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Pemohon
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Jenis ISBN
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Media
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Status
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Tanggal Ajuan
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Review
              </th>
              <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                Aksi
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @foreach($submissions as $submission)
              <tr class="hover:bg-gray-50">
                {{-- Title --}}
                <td class="px-6 py-4">
                  <div class="flex flex-col">
                    <div class="text-sm font-medium text-gray-900">
                      {{ Str::limit($submission->title, 50) }}
                    </div>
                    @if($submission->isbn)
                      <div class="text-xs text-gray-500 font-mono mt-1">
                        ISBN: {{ $submission->isbn }}
                      </div>
                    @endif
                  </div>
                </td>

                {{-- Submitter --}}
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">{{ $submission->user->name }}</div>
                  <div class="text-xs text-gray-500">{{ $submission->user->email }}</div>
                </td>

                {{-- ISBN Type --}}
                <td class="px-6 py-4 whitespace-nowrap">
                  <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                    {{ $submission->isbn_request_type === 'LEPAS' ? 'Lepas' : 'Jilid' }}
                  </span>
                </td>

                {{-- Media --}}
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">
                    @php
                      $mediaLabels = [
                        'CETAK' => 'Cetak',
                        'DIGITAL_PDF' => 'PDF',
                        'DIGITAL_EPUB' => 'EPUB',
                        'AUDIO_BOOK' => 'Audio',
                        'AUDIO_VISUAL' => 'Video',
                      ];
                    @endphp
                    {{ $mediaLabels[$submission->publication_media] ?? $submission->publication_media }}
                  </div>
                </td>

                {{-- Status --}}
                <td class="px-6 py-4 whitespace-nowrap">
                  @php
                    $statusColors = [
                      'submitted' => 'bg-blue-100 text-blue-800',
                      'review' => 'bg-yellow-100 text-yellow-800',
                      'revision' => 'bg-orange-100 text-orange-800',
                    ];
                    $statusLabels = [
                      'submitted' => 'Diajukan',
                      'review' => 'Review',
                      'revision' => 'Revisi',
                    ];
                  @endphp
                  <span
                    class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$submission->status] ?? 'bg-gray-100 text-gray-800' }}">
                    {{ $statusLabels[$submission->status] ?? $submission->status }}
                  </span>
                </td>

                {{-- Submission Date --}}
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ $submission->created_at->format('d M Y') }}
                  <div class="text-xs text-gray-400">{{ $submission->created_at->diffForHumans() }}</div>
                </td>

                {{-- Review Count --}}
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center gap-1">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                    </svg>
                    <span class="text-sm text-gray-600">{{ $submission->reviews->count() }}</span>
                  </div>
                </td>

                {{-- Actions --}}
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <a href="{{ route('book.reviewer.detail', $submission->id) }}"
                    class="inline-flex items-center px-3 py-1.5 bg-blue-800 text-white text-sm font-medium rounded-md hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-800">
                    Review
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      {{-- Pagination --}}
      <div class="bg-white px-4 py-3 border-t border-gray-200">
        {{ $submissions->links() }}
      </div>
    @else
      {{-- Empty State --}}
      <div class="text-center py-12">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada permohonan</h3>
        <p class="mt-1 text-sm text-gray-500">
          @if($search || $statusFilter || $isbnTypeFilter || $mediaFilter)
            Tidak ada permohonan yang sesuai dengan filter.
          @else
            Belum ada permohonan ISBN yang perlu direview.
          @endif
        </p>
      </div>
    @endif
  </div>
</div>