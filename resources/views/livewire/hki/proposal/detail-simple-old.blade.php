<div>
<div class="p-6">
  <x-slot name="sidebar">
    <x-layouts.app.sidebar-hki />
  </x-slot>

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

  {{-- Header --}}
  <div class="mb-6">
    <div class="flex items-center justify-between">
      <div>
        <div class="flex items-center gap-3 mb-2">
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
              'REVISION' => 'Perlu Revisi',
              'APPROVED' => 'Disetujui',
              'REJECTED' => 'Ditolak',
            ];
          @endphp
          <h1 class="text-2xl font-bold text-gray-900">Detail Proposal HKI</h1>
          <span
            class="px-3 py-1 inline-flex text-sm font-semibold rounded-full {{ $statusColors[$proposal->status] ?? 'bg-gray-100 text-gray-800' }}">
            {{ $statusLabels[$proposal->status] ?? $proposal->status }}
          </span>
        </div>
        <p class="text-sm text-gray-600">{{ $proposal->title }}</p>
      </div>
      <div class="flex items-center gap-3">
        <a href="{{ route('hki.list') }}" class="text-sm text-gray-600 hover:text-gray-900">
          ← Kembali
        </a>
      </div>
    </div>
  </div>

  {{-- Alert untuk Status Revisi --}}
  @if($proposal->status === 'REVISION')
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
          <h3 class="text-sm font-medium text-orange-800">Proposal Memerlukan Revisi</h3>
          <div class="mt-2 text-sm text-orange-700">
            <p>Proposal HKI Anda memerlukan perbaikan. Silakan periksa catatan reviewer di bagian bawah halaman ini dan lakukan revisi yang diperlukan.</p>
          </div>
        </div>
      </div>
    </div>
  @endif

  {{-- Alert untuk Status Disetujui --}}
  @if($proposal->status === 'APPROVED')
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
          <h3 class="text-sm font-medium text-green-800">Proposal HKI Disetujui</h3>
          <div class="mt-2 text-sm text-green-700">
            <p>Selamat! Proposal HKI Anda telah disetujui oleh reviewer.</p>
            @php
              $approvalNote = $proposal->auditLogs()
                ->where('action', 'APPROVE_PROPOSAL')
                ->latest()
                ->first();
            @endphp
            @if($approvalNote && isset($approvalNote->payload['note']))
              <p class="mt-2">{{ $approvalNote->payload['note'] }}</p>
            @endif
          </div>
        </div>
      </div>
    </div>
  @endif

  {{-- Alert untuk Status Ditolak --}}
  @if($proposal->status === 'REJECTED')
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
          <h3 class="text-sm font-medium text-red-800">Proposal HKI Ditolak</h3>
          <div class="mt-2 text-sm text-red-700">
            <p>Proposal HKI Anda ditolak. Silakan periksa alasan penolakan di bawah.</p>
            @php
              $rejectionNote = $proposal->auditLogs()
                ->where('action', 'REJECT_PROPOSAL')
                ->latest()
                ->first();
            @endphp
            @if($rejectionNote && isset($rejectionNote->payload['note']))
              <p class="mt-2">{{ $rejectionNote->payload['note'] }}</p>
            @endif
          </div>
        </div>
      </div>
    </div>
  @endif

  {{-- Informasi Dasar --}}
  <div class="mb-6 bg-white rounded-lg border border-gray-200 overflow-hidden">
    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
      <h2 class="text-lg font-semibold text-gray-900">Informasi Dasar</h2>
    </div>
    <div class="p-6">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Judul Proposal</dt>
          <dd class="text-sm font-semibold text-gray-900">{{ $proposal->title }}</dd>
        </div>
        <div>
          <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Kategori HKI</dt>
          <dd class="text-sm font-semibold text-blue-800">{{ $proposal->type->name ?? 'Tidak Diketahui' }}</dd>
        </div>
        <div>
          <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Negara Pertama kali diumumkan</dt>
          <dd class="text-sm font-semibold text-gray-900">
            {{ $proposal->publication_country ? \App\Helpers\Countries::getCountryName($proposal->publication_country) : 'Tidak Diketahui' }}
          </dd>
        </div>
        <div>
          <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Kota Pertama kali diumumkan</dt>
          <dd class="text-sm font-semibold text-gray-900">{{ $proposal->publication_city ?? 'Tidak Diketahui' }}</dd>
        </div>
        <div>
          <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Tanggal Pertama kali diumumkan</dt>
          <dd class="text-sm font-semibold text-gray-900">
            {{ $proposal->publication_date ? \Carbon\Carbon::parse($proposal->publication_date)->format('d F Y') : 'Tidak Diketahui' }}
          </dd>
        </div>
        <div>
          <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Pengusul Utama</dt>
          <dd class="text-sm font-semibold text-gray-900">{{ $proposal->user->name ?? 'Tidak Diketahui' }}</dd>
        </div>
      </div>

      @if($proposal->description)
        <div class="mt-4 pt-4 border-t border-gray-200">
          <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-2">Deskripsi Proposal</dt>
          <dd class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">{{ $proposal->description }}</dd>
        </div>
      @endif
    </div>
  </div>

  {{-- Main Content Grid --}}
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Left Column --}}
    <div class="lg:col-span-2 space-y-6">

      {{-- Team Members Card --}}
      <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
          <h2 class="text-lg font-semibold text-gray-900">Daftar Tim Pengusul ({{ $proposal->members->count() }} Anggota)</h2>
        </div>
        <div class="p-6">
          {{-- View Mode Only - Members tidak bisa diedit --}}
          <div class="space-y-4">
            @foreach($proposal->members as $index => $member)
              <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                <div class="flex items-start justify-between mb-3">
                  <div class="flex-1">
                    <div class="flex items-center gap-2 flex-wrap mb-2">
                      <h4 class="text-sm font-semibold text-gray-900">{{ $member->name }}</h4>
                      <span class="px-2 py-0.5 inline-flex items-center text-xs leading-5 font-semibold rounded-full {{ $member->role == 'KETUA' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $member->role }}
                      </span>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm text-gray-600">
                      <div class="flex items-center gap-1">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span>{{ $member->email ?? 'Email tidak tersedia' }}</span>
                      </div>
                      <div class="flex items-center gap-1">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                        </svg>
                        <span>NIK: {{ $member->nik ?? 'Tidak tersedia' }}</span>
                      </div>
                      <div class="flex items-center gap-1">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>NIDN: {{ $member->nidn ?? ($member->user->nidn ?? 'Tidak tersedia') }}</span>
                      </div>
                      <div class="flex items-center gap-1">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>NPWP: {{ $member->npwp ?? 'Tidak tersedia' }}</span>
                      </div>
                    </div>

                    @if($member->detail)
                      <div class="mt-3 p-3 bg-white rounded border border-gray-200">
                        <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Detail Tambahan:</p>
                        <p class="text-sm text-gray-700 whitespace-pre-line">{{ $member->detail }}</p>
                      </div>
                    @endif
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>

      {{-- Documents Repository Card --}}
      <div class="bg-white rounded-lg border border-gray-200 overflow-hidden mt-8">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
          <h2 class="text-lg font-semibold text-gray-900">Repositori Dokumen</h2>
        </div>
        <ul role="list" class="divide-y divide-gray-100">
          @foreach($proposal->documents as $doc)
            <li class="px-6 py-5 hover:bg-gray-50">
              <div class="flex items-start justify-between mb-3">
                <div class="flex items-start space-x-3 flex-1 min-w-0">
                  <div class="flex-shrink-0">
                    <div class="h-10 w-10 rounded bg-blue-100 flex items-center justify-center">
                      <svg class="w-6 h-6 text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                        </path>
                      </svg>
                    </div>
                  </div>
                  <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">{{ $doc->name }}</p>
                    <div class="mt-1 flex items-center gap-2 text-xs text-gray-500">
                      <span>{{ number_format($doc->file_size / 1024, 2) }} KB</span>
                      <span>•</span>
                      <span>{{ $doc->mime_type }}</span>
                    </div>
                  </div>
                </div>
                <a href="{{ Storage::url($doc->file_path) }}" target="_blank"
                  class="ml-3 flex-shrink-0 inline-flex items-center px-4 py-2 bg-blue-800 text-white rounded-lg text-xs font-medium hover:bg-blue-900">
                  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                  </svg>
                  Lihat
                </a>
              </div>
              <div class="bg-gray-50 p-3 rounded border border-gray-200">
                <div class="flex items-start space-x-2">
                  <svg class="w-4 h-4 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <div class="flex-1 min-w-0">
                    <p class="text-xs font-medium text-gray-700 mb-1">Hash SHA-256:</p>
                    <p class="text-xs font-mono text-gray-600 break-all">
                      {{ $doc->file_hash }}
                    </p>
                  </div>
                </div>
              </div>
            </li>
          @endforeach
        </ul>
      </div>

      {{-- Reviews & Catatan Revisi --}}
      @if($proposal->reviews && $proposal->reviews->count() > 0)
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden mt-6">
          <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Riwayat Review & Catatan</h2>
          </div>
          <div class="p-6">
            <div class="space-y-4">
              @foreach ($proposal->reviews as $review)
                <div
                  class="border-l-4 pl-4 {{ $review->decision === 'approved' ? 'border-green-400 bg-green-50' : ($review->decision === 'rejected' ? 'border-red-400 bg-red-50' : 'border-orange-400 bg-orange-50') }} rounded-r-lg p-4">
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
                          <p class="text-sm font-medium text-orange-900">Proposal memerlukan revisi</p>
                          <p class="text-xs text-orange-700 mt-1">Silakan perbaiki sesuai catatan reviewer di atas.</p>
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

    {{-- Right Column - Audit Trail --}}
    <div class="lg:col-span-1">
      <div class="bg-white rounded-lg border border-gray-200 overflow-hidden lg:sticky lg:top-6">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
          <h3 class="text-lg font-semibold text-gray-900">Audit Trail</h3>
          <p class="text-xs text-gray-500 mt-1">Riwayat aktivitas</p>
        </div>
        <div class="p-6">
          <div class="flow-root">
            <ul role="list" class="-mb-8">
              @foreach($proposal->auditLogs as $log)
                <li>
                  <div class="relative pb-8">
                    @if(!$loop->last)
                      <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                    @endif
                    <div class="relative flex items-start space-x-3">
                      <div>
                        <span class="h-10 w-10 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white">
                          <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                          </svg>
                        </span>
                      </div>
                      <div class="min-w-0 flex-1">
                        <div class="text-sm">
                          <span class="font-medium text-gray-900">{{ $log->action }}</span>
                          <p class="text-gray-500 mt-0.5">oleh {{ $log->user->name }}</p>
                          <p class="text-xs text-gray-400 mt-0.5">{{ $log->created_at->format('d M Y, H:i') }}</p>
                        </div>

                        <div class="mt-3 bg-gray-50 p-2 rounded border border-gray-200">
                          <p class="text-[10px] text-gray-600 font-medium mb-1">Hash:</p>
                          <p class="text-[10px] text-gray-700 font-mono break-all" title="{{ $log->current_hash }}">
                            {{ $log->current_hash }}
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
