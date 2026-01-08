<x-slot name="sidebar">
  <x-layouts.app.sidebar-pengajuan-surat />
</x-slot>

<div class="p-6">
  {{-- Header --}}
  <div class="mb-6">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Pengajuan Surat Tugas</h1>
        <p class="mt-1 text-sm text-gray-600">Kelola pengajuan surat tugas Anda</p>
      </div>
      <a href="{{ route('letter.create') }}" wire:navigate
        class="inline-flex items-center px-4 py-2 bg-blue-800 text-white text-sm font-medium rounded-lg hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-800 transition-colors">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Buat Pengajuan Baru
      </a>
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
  <div class="bg-white rounded-lg border border-gray-200 p-4 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
      {{-- Search --}}
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
        <input type="text" wire:model.live="search"
          class="block w-full rounded-lg border-gray-300 focus:border-blue-800 focus:ring-2 focus:ring-blue-800 text-sm"
          placeholder="Cari deskripsi, indikator, URL...">
      </div>

      {{-- Filter Category --}}
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
        <select wire:model.live="filterCategory"
          class="block w-full rounded-lg border-gray-300 focus:border-blue-800 focus:ring-2 focus:ring-blue-800 text-sm">
          <option value="">Semua Kategori</option>
          @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->category }}</option>
          @endforeach
        </select>
      </div>

      {{-- Filter Unit --}}
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Unit</label>
        <select wire:model.live="filterUnit"
          class="block w-full rounded-lg border-gray-300 focus:border-blue-800 focus:ring-2 focus:ring-blue-800 text-sm">
          <option value="">Semua Unit</option>
          @foreach($units as $unit)
            <option value="{{ $unit->id }}">{{ $unit->unit }}</option>
          @endforeach
        </select>
      </div>

      {{-- Items Per Page --}}
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Tampilkan</label>
        <select wire:model.live="perPage"
          class="block w-full rounded-lg border-gray-300 focus:border-blue-800 focus:ring-2 focus:ring-blue-800 text-sm">
          <option value="5">5 per halaman</option>
          <option value="10">10 per halaman</option>
          <option value="25">25 per halaman</option>
          <option value="50">50 per halaman</option>
          <option value="100">100 per halaman</option>
        </select>
      </div>
    </div>
  </div>

  {{-- List --}}
  <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
    @if($submissions->count() > 0)
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Kategori / Unit
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Deskripsi
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Indikator
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Anggaran
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Status
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Aksi
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @foreach($submissions as $submission)
                      <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                          <div class="flex flex-col">
                            <span class="text-sm font-medium text-gray-900">
                              {{ $submission->category->category ?? 'Tidak ada kategori' }}
                            </span>
                            <span class="text-xs text-gray-500">
                              {{ $submission->unit->unit ?? 'Tidak ada unit' }}
                            </span>
                          </div>
                        </td>
                        <td class="px-6 py-4">
                          <div class="text-sm text-gray-900">
                            <p class="font-medium line-clamp-2">{{ Str::limit($submission->description ?? '-', 100) }}</p>
                            @if($submission->url_documentation)
                              <a href="{{ $submission->url_documentation }}" target="_blank"
                                class="text-xs text-blue-800 hover:text-blue-900 flex items-center mt-1">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                  </path>
                                </svg>
                                Dokumentasi
                              </a>
                            @endif
                          </div>
                        </td>
                        <td class="px-6 py-4">
                          <div class="flex flex-wrap gap-1">
                            @php
                              $indicators = $submission->indicators ? array_filter(array_map('trim', explode(',', $submission->indicators))) : [];
                              $displayIndicators = array_slice($indicators, 0, 3);
                            @endphp
                            @foreach($displayIndicators as $indicator)
                              <span
                                class="inline-flex items-center px-2 py-1 rounded-md bg-blue-100 text-blue-800 text-xs font-medium">
                                {{ $indicator }}
                              </span>
                            @endforeach
                            @if(count($indicators) > 3)
                              <span
                                class="inline-flex items-center px-2 py-1 rounded-md bg-gray-100 text-gray-600 text-xs font-medium">
                                +{{ count($indicators) - 3 }}
                              </span>
                            @endif
                          </div>
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
                              class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800">
                              <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                  clip-rule="evenodd"></path>
                              </svg>
                              Pending
                            </span>
                          @elseif($submission->status === 'approved')
                            <span
                              class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                              <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                  clip-rule="evenodd"></path>
                              </svg>
                              Approved
                            </span>
                          @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800">
                              <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                  d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                  clip-rule="evenodd"></path>
                              </svg>
                              Rejected
                            </span>
                          @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">

                </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                  <div class="flex items-center space-x-2">
                    <button wire:click="viewDetail({{ $submission->id }})"
                      class="inline-flex items-center px-3 py-1.5 bg-blue-800 text-white rounded-lg text-xs font-bold hover:bg-blue-900 transition-colors duration-200">
                      <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                        </path>
                      </svg>
                      Detail
                    </button>
                    @if($submission->status === 'pending')
                      <button wire:click="delete({{ $submission->id }})"
                        wire:confirm="Apakah Anda yakin ingin menghapus submission ini?"
                        class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white rounded-lg text-xs font-bold hover:bg-red-700 transition-colors duration-200">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                          </path>
                        </svg>
                        Hapus
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
        <div class="flex flex-col sm:flex-row items-center justify-between space-y-3 sm:space-y-0">
          {{-- Pagination Info --}}
          <div class="text-sm text-gray-700">
            Menampilkan
            <span class="font-semibold text-gray-900">{{ $submissions->firstItem() ?? 0 }}</span>
            sampai
            <span class="font-semibold text-gray-900">{{ $submissions->lastItem() ?? 0 }}</span>
            dari
            <span class="font-semibold text-gray-900">{{ $submissions->total() }}</span>
            hasil
          </div>

          {{-- Pagination Links --}}
          <div>
            {{ $submissions->links() }}
          </div>
        </div>
      </div>
    @else
    {{-- Empty State --}}
    <div class="text-center py-12">
      <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
        </path>
      </svg>
      <h3 class="mt-4 text-lg font-bold text-gray-900">Belum Ada Submission</h3>
      <p class="mt-2 text-sm text-gray-600">Mulai dengan membuat submission baru.</p>
      <div class="mt-6">
        <a href="{{ route('letter.create') }}"
          class="inline-flex items-center px-6 py-3 bg-blue-800 text-white rounded-lg font-semibold text-sm shadow-md hover:bg-blue-900 transition-all duration-200">
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
          </svg>
          Buat Submission Baru
        </a>
      </div>
    </div>
  @endif
</div>

{{-- Modal Detail --}}
@if($showModal && $selectedSubmission)
  <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
      {{-- Background overlay with transparency --}}
      <div class="fixed inset-0 bg-black opacity-50 transition-opacity" wire:click="closeModal"
        style="backdrop-filter: blur(2px);"></div>

      {{-- Center helper --}}
      <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

      {{-- Modal panel --}}
      <div
        class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full z-50">
        {{-- Header --}}
        <div class="bg-gradient-to-r from-slate-700 to-slate-800 px-6 py-4 border-b-4 border-blue-600">
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
            <button wire:click="closeModal" class="text-white hover:text-gray-200 transition-colors">
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
                <label class="block text-xs font-bold text-blue-800 mb-2 uppercase tracking-wide">Kategori</label>
                <p class="text-sm font-semibold text-gray-900">
                  {{ $selectedSubmission->category->category ?? 'Tidak ada kategori' }}
                </p>
              </div>
              <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 border border-blue-200">
                <label class="block text-xs font-bold text-blue-800 mb-2 uppercase tracking-wide">Unit Kerja</label>
                <p class="text-sm font-semibold text-gray-900">
                  {{ $selectedSubmission->unit->unit ?? 'Tidak ada unit' }}
                </p>
              </div>
            </div>

            {{-- Deskripsi --}}
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
              <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wide">Deskripsi</label>
              <p class="text-sm text-gray-900 leading-relaxed whitespace-pre-wrap">
                {{ $selectedSubmission->description ?? '-' }}</p>
            </div>

            {{-- Indikator --}}
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 border border-blue-200">
              <label class="block text-xs font-bold text-blue-800 mb-3 uppercase tracking-wide">Indikator</label>
              <div class="flex flex-wrap gap-2">
                @php
                  $indicators = $selectedSubmission->indicators ? array_filter(array_map('trim', explode(',', $selectedSubmission->indicators))) : [];
                @endphp
                @if(count($indicators) > 0)
                  @foreach($indicators as $indicator)
                    <span
                      class="inline-flex items-center px-3 py-1.5 rounded-lg bg-white text-blue-800 text-sm font-medium border border-blue-300 shadow-sm">
                      <svg class="w-4 h-4 mr-1.5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
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
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 border border-blue -200">
              <label class="block text-xs font-bold text-blue-800 mb-2 uppercase tracking-wide">Anggaran</label>
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
              <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 border border-blue-200">
                <label class="block text-xs font-bold text-blue-800 mb-2 uppercase tracking-wide">Tanggal Mulai</label>
                <div class="flex items-center">
                  <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
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
              <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 border border-blue-200">
                <label class="block text-xs font-bold text-blue-800 mb-2 uppercase tracking-wide">URL
                  Dokumentasi</label>
                <a href="{{ $selectedSubmission->url_documentation }}" target="_blank"
                  class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 font-medium">
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
                  class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold mr-3">
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
          </div>
        </div>

        {{-- Footer --}}
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
          <div class="flex items-center justify-end">
            <button wire:click="closeModal"
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