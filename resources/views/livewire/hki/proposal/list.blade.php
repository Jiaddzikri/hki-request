<x-slot name="sidebar">
  <x-layouts.app.sidebar-hki />
</x-slot>

<div class="p-6">
  {{-- Header Section --}}
  <div class="mb-6">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Pengajuan HKI Saya</h1>
        <p class="mt-1 text-sm text-gray-600">Kelola pengajuan Hak Kekayaan Intelektual Anda</p>
      </div>
      <a href="{{ route('hki.create') }}" wire:navigate
        class="inline-flex items-center px-4 py-2 bg-blue-800 text-white text-sm font-medium rounded-lg hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-800 transition-colors">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Ajukan HKI Baru
      </a>
    </div>
  </div>

  {{-- Main Content --}}
  <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">

    @if($proposals->isEmpty())
      <div class="p-16 text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-lg mb-6">
          <svg class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
          </svg>
        </div>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Pengajuan</h3>
        <p class="text-gray-600 mb-6">Mulai lindungi karya intelektual Anda dengan mengajukan HKI</p>
        <a href="{{ route('hki.create') }}"
          class="inline-flex items-center px-6 py-3 bg-blue-800 text-white rounded-lg font-semibold text-sm hover:bg-blue-900 transition-colors">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
          Ajukan HKI Pertama
        </a>
      </div>
    @else
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                <div class="flex items-center space-x-1">
                  <svg class="w-4 h-4 text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                    </path>
                  </svg>
                  <span>Judul & Jenis</span>
                </div>
              </th>
              <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                <div class="flex items-center space-x-1">
                  <svg class="w-4 h-4 text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                  </svg>
                  <span>Tanggal Submit</span>
                </div>
              </th>
              <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                <div class="flex items-center space-x-1">
                  <svg class="w-4 h-4 text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                  <span>Status</span>
                </div>
              </th>
              <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">
                <div class="flex items-center justify-end space-x-1">
                  <svg class="w-4 h-4 text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                    </path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                  </svg>
                  <span>Aksi</span>
                </div>
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-100">
            @foreach($proposals as $p)
              <tr class="hover:bg-indigo-50/30 transition-colors duration-150">
                <td class="px-6 py-4">
                  <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 mt-1">
                      <div
                        class="h-10 w-10 rounded-lg bg-blue-800 flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                          </path>
                        </svg>
                      </div>
                    </div>
                    <div class="min-w-0 flex-1">
                      <div
                        class="text-sm font-semibold text-gray-900 truncate max-w-xs hover:text-blue-800 transition-colors"
                        title="{{ $p->title }}">
                        {{ Str::limit($p->title, 40) }}
                      </div>
                      <div class="flex items-center mt-1 space-x-2">
                        <span
                          class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                          <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                              d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                              clip-rule="evenodd"></path>
                          </svg>
                          {{ $p->type->name ?? 'Unknown Type' }}
                        </span>
                      </div>
                    </div>
                  </div>
                </td>

                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center space-x-2 text-sm">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                      </path>
                    </svg>
                    <div>
                      <div class="font-medium text-gray-900">{{ $p->created_at->format('d M Y') }}</div>
                      <div class="text-xs text-gray-500">{{ $p->created_at->format('H:i') }} WIB</div>
                    </div>
                  </div>
                </td>

                <td class="px-6 py-4 whitespace-nowrap">
                  @php
                    $statusConfig = [
                      'DRAFT' => [
                        'bg' => 'bg-gray-100',
                        'text' => 'text-gray-800',
                        'icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'
                      ],
                      'SUBMITTED' => [
                        'bg' => 'bg-blue-100',
                        'text' => 'text-blue-800',
                        'icon' => 'M12 19l9 2-9-18-9 18 9-2zm0 0v-8'
                      ],
                      'APPROVED' => [
                        'bg' => 'bg-green-100',
                        'text' => 'text-green-800',
                        'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'
                      ],
                      'REJECTED' => [
                        'bg' => 'bg-red-100',
                        'text' => 'text-red-800',
                        'icon' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z'
                      ],
                    ];
                    $config = $statusConfig[$p->status] ?? $statusConfig['DRAFT'];
                  @endphp
                  <span
                    class="px-3 py-1.5 inline-flex items-center text-xs leading-5 font-semibold rounded-full {{ $config['bg'] }} {{ $config['text'] }}">
                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $config['icon'] }}">
                      </path>
                    </svg>
                    {{ $p->status }}
                  </span>
                </td>

                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <a href="{{ route('hki.show', $p->id) }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-800 text-white rounded-lg font-semibold text-xs hover transform hover:-translate-y-0.5 transition-all duration-200">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                      </path>
                    </svg>
                    Detail
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      {{-- Pagination --}}
      <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
        {{ $proposals->links() }}
      </div>
    @endif
  </div>

  {{-- Info Card --}}
  <div class="mt-6 bg-white rounded-lg border border-indigo-100 p-5">
    <div class="flex items-start space-x-3">
      <svg class="w-5 h-5 text-blue-800 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd"
          d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
          clip-rule="evenodd"></path>
      </svg>
      <div class="text-sm text-gray-600">
        <p class="font-medium text-gray-800 mb-2">Status Pengajuan HKI:</p>
        <div class="space-y-1.5">
          <div class="flex items-center space-x-2">
            <span class="px-2 py-0.5 rounded-full bg-gray-100 text-gray-800 text-xs font-medium">DRAFT</span>
            <span>- Dokumen masih dalam tahap penyusunan</span>
          </div>
          <div class="flex items-center space-x-2">
            <span class="px-2 py-0.5 rounded-full bg-blue-100 text-blue-800 text-xs font-medium">SUBMITTED</span>
            <span>- Dokumen telah diajukan dan menunggu review</span>
          </div>
          <div class="flex items-center space-x-2">
            <span class="px-2 py-0.5 rounded-full bg-green-100 text-green-800 text-xs font-medium">APPROVED</span>
            <span>- Pengajuan HKI telah disetujui</span>
          </div>
          <div class="flex items-center space-x-2">
            <span class="px-2 py-0.5 rounded-full bg-red-100 text-red-800 text-xs font-medium">REJECTED</span>
            <span>- Pengajuan HKI ditolak, perlu perbaikan</span>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>