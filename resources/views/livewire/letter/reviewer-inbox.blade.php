<x-slot name="sidebar">
  <x-layouts.app.sidebar-pengajuan-surat />
</x-slot>

<div class="max-w-7xl mx-auto py-8 px-4">
  {{-- Header --}}
  <div class="mb-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
      <div class="bg-blue-800 px-8 py-6 border-b-2 border-blue-900">
        <div class="flex items-center space-x-4">
          <div class="w-12 h-12 bg-white rounded-md flex items-center justify-center">
            <svg class="w-7 h-7 text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
              </path>
            </svg>
          </div>
          <div>
            <h1 class="text-2xl font-bold text-white">Reviewer Inbox</h1>
            <p class="text-blue-100 text-sm font-medium">Review & Kelola Letter Submissions</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Alert Messages --}}
  @if (session()->has('success'))
    <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
      <div class="flex items-center">
        <svg class="w-5 h-5 text-green-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd"
            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
            clip-rule="evenodd"></path>
        </svg>
        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
      </div>
    </div>
  @endif

  @if (session()->has('error'))
    <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
      <div class="flex items-center">
        <svg class="w-5 h-5 text-red-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd"
            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
            clip-rule="evenodd"></path>
        </svg>
        <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
      </div>
    </div>
  @endif

  {{-- Filters --}}
  <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      {{-- Search --}}
      <div>
        <label class="block text-sm font-bold text-gray-700 mb-2">Cari</label>
        <input type="text" wire:model.live="search"
          class="block w-full rounded-md border-gray-300 focus:border-blue-800 focus:ring-2 focus:ring-blue-200 text-sm"
          placeholder="Cari deskripsi, pembuat...">
      </div>

      {{-- Filter Status --}}
      <div>
        <label class="block text-sm font-bold text-gray-700 mb-2">Status</label>
        <select wire:model.live="filterStatus"
          class="block w-full rounded-md border-gray-300 focus:border-blue-800 focus:ring-2 focus:ring-blue-200 text-sm">
          <option value="">Semua Status</option>
          <option value="pending">Pending</option>
          <option value="approved">Approved</option>
          <option value="rejected">Rejected</option>
        </select>
      </div>
    </div>
  </div>

  {{-- List --}}
  <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    @if($submissions->count() > 0)
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                Pengaju / Kategori
              </th>
              <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                Deskripsi
              </th>
              <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                Anggaran
              </th>
              <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                Status
              </th>
              <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                Aksi
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @foreach($submissions as $submission)
              <tr class="hover:bg-gray-50 transition-colors duration-150">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex flex-col">
                    <span class="text-sm font-bold text-gray-900">
                      {{ $submission->user->name ?? 'Unknown' }}
                    </span>
                    <span class="text-xs text-blue-800 font-medium">
                      {{ $submission->category->category ?? 'No Category' }}
                    </span>
                    <span class="text-xs text-gray-500">
                      {{ $submission->created_at->format('d/m/Y H:i') }}
                    </span>
                  </div>
                </td>
                <td class="px-6 py-4">
                  <p class="text-sm text-gray-900 line-clamp-2">{{ Str::limit($submission->description ?? '-', 100) }}
                  </p>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="text-sm font-semibold text-gray-900">
                    @if($submission->budget)
                      Rp {{ number_format($submission->budget, 0, ',', '.') }}
                    @else
                      -
                    @endif
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  @if($submission->status === 'pending')
                    <span
                      class="inline-flex items-center px-3 py-1 rounded-md text-xs font-bold bg-yellow-100 text-yellow-800 border border-yellow-200">
                      Pending
                    </span>
                  @elseif($submission->status === 'approved')
                    <span
                      class="inline-flex items-center px-3 py-1 rounded-md text-xs font-bold bg-green-100 text-green-800 border border-green-200">
                      Approved
                    </span>
                  @else
                    <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-bold bg-red-100 text-red-800 border border-red-200">
                      Rejected
                    </span>
                  @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                  <div class="flex items-center space-x-2">
                    <button wire:click="viewDetail({{ $submission->id }})"
                      class="inline-flex items-center px-3 py-1.5 bg-blue-800 text-white rounded-md text-xs font-bold hover:bg-blue-900 transition-colors">
                      <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                        </path>
                      </svg>
                      Detail
                    </button>
                    @if($submission->status === 'pending')
                      <button wire:click="openReviewModal({{ $submission->id }}, 'approve')"
                        class="inline-flex items-center px-3 py-1.5 bg-green-700 text-white rounded-md text-xs font-bold hover:bg-green-800 transition-colors">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                          </path>
                        </svg>
                        Setuju
                      </button>
                      <button wire:click="openReviewModal({{ $submission->id }}, 'reject')"
                        class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white rounded-md text-xs font-bold hover:bg-red-700 transition-colors">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                          </path>
                        </svg>
                        Tolak
                      </button>
                    @endif
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      {{-- Pagination --}}
      <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
        {{ $submissions->links() }}
      </div>
    @else
      {{-- Empty State --}}
      <div class="text-center py-12">
        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
          </path>
        </svg>
        <h3 class="mt-4 text-lg font-bold text-gray-900">Belum Ada Submission</h3>
        <p class="mt-2 text-sm text-gray-600">Tidak ada submission yang perlu direview.</p>
      </div>
    @endif
  </div>

  {{-- Review Modal (untuk approve/reject) --}}
  @if($showReviewModal && $selectedSubmission && $reviewAction !== 'view')
    <div class="fixed inset-0 z-50 overflow-y-auto">
      <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" wire:click="closeReviewModal"
          style="backdrop-filter: blur(2px);"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

        <div
          class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full z-50">
          <div class="bg-gradient-to-r from-purple-700 to-indigo-800 px-6 py-4">
            <div class="flex items-center justify-between">
              <h3 class="text-xl font-bold text-white">
                @if($reviewAction === 'approve')
                  Setujui Submission
                @else
                  Tolak Submission
                @endif
              </h3>
              <button wire:click="closeReviewModal" class="text-white hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                  </path>
                </svg>
              </button>
            </div>
          </div>

          <div class="bg-white px-6 py-6 max-h-[70vh] overflow-y-auto">
            <div class="space-y-4">
              <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <label class="block text-xs font-bold text-gray-700 mb-2">Pengaju</label>
                <p class="text-sm font-semibold text-gray-900">{{ $selectedSubmission->user->name ?? 'Unknown' }}</p>
                <p class="text-xs text-gray-500">{{ $selectedSubmission->created_at->format('d F Y, H:i') }}</p>
              </div>

              <div class="grid grid-cols-2 gap-4">
                <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                  <label class="block text-xs font-bold text-blue-900 mb-2">Kategori</label>
                  <p class="text-sm font-semibold">{{ $selectedSubmission->category->category ?? '-' }}</p>
                </div>
                <div class="bg-purple-50 rounded-lg p-4 border border-purple-200">
                  <label class="block text-xs font-bold text-purple-900 mb-2">Unit</label>
                  <p class="text-sm font-semibold">{{ $selectedSubmission->unit->unit ?? '-' }}</p>
                </div>
              </div>

              <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <label class="block text-xs font-bold text-gray-700 mb-2">Deskripsi</label>
                <p class="text-sm text-gray-900 whitespace-pre-wrap">{{ $selectedSubmission->description ?? '-' }}</p>
              </div>

              <div>
                <label for="reviewNotes" class="block text-sm font-bold text-gray-700 mb-2">
                  Catatan Review <span class="text-red-600">*</span>
                </label>
                <textarea wire:model="reviewNotes" id="reviewNotes" rows="4"
                  class="block w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 text-sm"
                  placeholder="Tulis catatan review..."></textarea>
                @error('reviewNotes')
                  <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
              </div>
            </div>
          </div>

          <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            <div class="flex items-center justify-end space-x-3">
              <button wire:click="closeReviewModal"
                class="px-6 py-2.5 bg-gray-600 text-white rounded-lg font-semibold text-sm hover:bg-gray-700">
                Batal
              </button>
              <button wire:click="submitReview" wire:loading.attr="disabled"
                class="px-6 py-2.5 {{ $reviewAction === 'approve' ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700' }} text-white rounded-lg font-semibold text-sm">
                <span wire:loading.remove>{{ $reviewAction === 'approve' ? 'Setujui' : 'Tolak' }}</span>
                <span wire:loading>Memproses...</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endif

  {{-- Detail Modal (untuk view detail lengkap) --}}
  @if($showReviewModal && $selectedSubmission && $reviewAction === 'view')
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
      <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        {{-- Background overlay with transparency --}}
        <div class="fixed inset-0 bg-black opacity-50 transition-opacity" wire:click="closeReviewModal"
          style="backdrop-filter: blur(2px);"></div>

        {{-- Center helper --}}
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        {{-- Modal panel --}}
        <div
          class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full z-50">
          {{-- Header --}}
          <div class="bg-gradient-to-r from-purple-700 to-indigo-800 px-6 py-4 border-b-4 border-purple-600">
            <div class="flex items-center justify-between">
              <div class="flex items-center space-x-3">
                <div
                  class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm border border-white/30">
                  <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                  </svg>
                </div>
                <h3 class="text-xl font-bold text-white">Detail Submission</h3>
              </div>
              <button wire:click="closeReviewModal" class="text-white hover:text-gray-200 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                  </path>
                </svg>
              </button>
            </div>
          </div>

          {{-- Content --}}
          <div class="bg-white px-6 py-6 max-h-[70vh] overflow-y-auto">
            <div class="space-y-6">
              {{-- Kategori & Unit --}}
              <div class="grid grid-cols-2 gap-6">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 border border-blue-200">
                  <label class="block text-xs font-bold text-blue-900 mb-2 uppercase tracking-wide">Kategori</label>
                  <p class="text-sm font-semibold text-gray-900">
                    {{ $selectedSubmission->category->category ?? 'Tidak ada kategori' }}
                  </p>
                </div>
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4 border border-purple-200">
                  <label class="block text-xs font-bold text-purple-900 mb-2 uppercase tracking-wide">Unit Kerja</label>
                  <p class="text-sm font-semibold text-gray-900">
                    {{ $selectedSubmission->unit->unit ?? 'Tidak ada unit' }}
                  </p>
                </div>
              </div>

              {{-- Deskripsi --}}
              <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wide">Deskripsi</label>
                <p class="text-sm text-gray-900 leading-relaxed whitespace-pre-wrap">{{ $selectedSubmission->description ?? '-' }}</p>
              </div>

              {{-- Indikator --}}
              <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4 border border-green-200">
                <label class="block text-xs font-bold text-green-900 mb-3 uppercase tracking-wide">Indikator</label>
                <div class="flex flex-wrap gap-2">
                  @php
                    $indicators = $selectedSubmission->indicators ? array_filter(array_map('trim', explode(',', $selectedSubmission->indicators))) : [];
                  @endphp
                  @if(count($indicators) > 0)
                    @foreach($indicators as $indicator)
                      <span
                        class="inline-flex items-center px-3 py-1.5 rounded-lg bg-white text-green-800 text-sm font-medium border border-green-300 shadow-sm">
                        <svg class="w-4 h-4 mr-1.5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                          <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                        </svg>
                        {{ $indicator }}
                      </span>
                    @endforeach
                  @else
                    <p class="text-sm text-gray-500">Tidak ada indikator</p>
                  @endif
                </div>
              </div>

              {{-- Anggaran --}}
              <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-lg p-4 border border-yellow-200">
                <label class="block text-xs font-bold text-yellow-900 mb-2 uppercase tracking-wide">Anggaran</label>
                <p class="text-lg font-bold text-gray-900">
                  @if($selectedSubmission->budget)
                    Rp {{ number_format($selectedSubmission->budget, 0, ',', '.') }}
                  @else
                    <span class="text-gray-500">Tidak ada anggaran</span>
                  @endif
                </p>
              </div>

              {{-- Periode --}}
              <div class="grid grid-cols-2 gap-6">
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4 border border-green-200">
                  <label class="block text-xs font-bold text-green-900 mb-2 uppercase tracking-wide">Tanggal Mulai</label>
                  <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd"
                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                        clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-sm font-semibold text-gray-900">
                      {{ $selectedSubmission->planned_start_date ? $selectedSubmission->planned_start_date->format('d F Y') : '-' }}
                    </p>
                  </div>
                </div>
                <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-lg p-4 border border-red-200">
                  <label class="block text-xs font-bold text-red-900 mb-2 uppercase tracking-wide">Tanggal Selesai</label>
                  <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd"
                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                        clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-sm font-semibold text-gray-900">
                      {{ $selectedSubmission->planned_end_date ? $selectedSubmission->planned_end_date->format('d F Y') : '-' }}
                    </p>
                  </div>
                </div>
              </div>

              {{-- URL Dokumentasi --}}
              @if($selectedSubmission->url_documentation)
                <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-lg p-4 border border-indigo-200">
                  <label class="block text-xs font-bold text-indigo-900 mb-2 uppercase tracking-wide">URL
                    Dokumentasi</label>
                  <a href="{{ $selectedSubmission->url_documentation }}" target="_blank"
                    class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                    {{ $selectedSubmission->url_documentation }}
                  </a>
                </div>
              @endif

              {{-- User Info --}}
              <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wide">Dibuat Oleh</label>
                <div class="flex items-center">
                  <div
                    class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center text-white font-bold mr-3">
                    {{ strtoupper(substr($selectedSubmission->user->name ?? 'U', 0, 1)) }}
                  </div>
                  <div>
                    <p class="text-sm font-semibold text-gray-900">{{ $selectedSubmission->user->name ?? 'Unknown' }}</p>
                    <p class="text-xs text-gray-500">{{ $selectedSubmission->created_at->format('d F Y, H:i') }}</p>
                  </div>
                </div>
              </div>

              {{-- Review Status & Info --}}
              @if($selectedSubmission->status !== 'pending')
                <div
                  class="rounded-lg p-4 border {{ $selectedSubmission->status === 'approved' ? 'bg-gradient-to-br from-green-50 to-green-100 border-green-200' : 'bg-gradient-to-br from-red-50 to-red-100 border-red-200' }}">
                  <div class="flex items-center mb-3">
                    @if($selectedSubmission->status === 'approved')
                      <svg class="w-6 h-6 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                          d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                          clip-rule="evenodd"></path>
                      </svg>
                      <span class="text-lg font-bold text-green-900">Submission Disetujui</span>
                    @else
                      <svg class="w-6 h-6 text-red-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                          clip-rule="evenodd"></path>
                      </svg>
                      <span class="text-lg font-bold text-red-900">Submission Ditolak</span>
                    @endif
                  </div>

                  @if($selectedSubmission->reviewer)
                    <div class="mb-3">
                      <label
                        class="block text-xs font-bold mb-1 uppercase tracking-wide {{ $selectedSubmission->status === 'approved' ? 'text-green-900' : 'text-red-900' }}">Direview
                        oleh</label>
                      <p class="text-sm font-semibold text-gray-900">{{ $selectedSubmission->reviewer->name }}</p>
                      <p class="text-xs text-gray-600">
                        {{ $selectedSubmission->reviewed_at ? $selectedSubmission->reviewed_at->format('d F Y, H:i') : '-' }}
                      </p>
                    </div>
                  @endif

                  @if($selectedSubmission->review_notes)
                    <div>
                      <label
                        class="block text-xs font-bold mb-1 uppercase tracking-wide {{ $selectedSubmission->status === 'approved' ? 'text-green-900' : 'text-red-900' }}">Catatan
                        Review</label>
                      <p
                        class="text-sm text-gray-900 whitespace-pre-wrap bg-white p-3 rounded border {{ $selectedSubmission->status === 'approved' ? 'border-green-200' : 'border-red-200' }}">
                        {{ $selectedSubmission->review_notes }}
                      </p>
                    </div>
                  @endif
                </div>
              @endif

              {{-- Action Buttons for Pending Submissions in Detail View --}}
              @if($selectedSubmission->status === 'pending')
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-lg p-4 border-2 border-dashed border-gray-300">
                  <label class="block text-xs font-bold text-gray-700 mb-3 uppercase tracking-wide">Aksi Review</label>
                  <div class="flex items-center space-x-3">
                    <button wire:click="openReviewModal({{ $selectedSubmission->id }}, 'approve')"
                      class="flex-1 inline-flex items-center justify-center px-4 py-2.5 bg-green-600 text-white rounded-lg font-semibold text-sm hover:bg-green-700 transition-colors duration-200 shadow-md">
                      <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                        </path>
                      </svg>
                      Setujui Submission
                    </button>
                    <button wire:click="openReviewModal({{ $selectedSubmission->id }}, 'reject')"
                      class="flex-1 inline-flex items-center justify-center px-4 py-2.5 bg-red-600 text-white rounded-lg font-semibold text-sm hover:bg-red-700 transition-colors duration-200 shadow-md">
                      <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                      </svg>
                      Tolak Submission
                    </button>
                  </div>
                </div>
              @endif
            </div>
          </div>

          {{-- Footer --}}
          <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            <div class="flex items-center justify-end">
              <button wire:click="closeReviewModal"
                class="inline-flex items-center px-6 py-2.5 bg-gray-600 text-white rounded-lg font-semibold text-sm hover:bg-gray-700 transition-colors duration-200 shadow-md">
                Tutup
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endif
</div>