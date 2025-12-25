<x-slot name="sidebar">
    <x-layouts.app.sidebar-hki />
</x-slot>


<div class="max-w-7xl mx-auto py-2 px-2">

    {{-- Header Section --}}
    <div class="mb-8">
        <div class="bg-white rounded-2xl  overflow-hidden border border-indigo-100">
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-6">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h2 class="text-2xl font-bold text-white truncate">
                                    {{ $proposal->title }}
                                </h2>
                                <div class="mt-2 flex flex-wrap items-center gap-3">
                                    <div class="flex items-center text-sm text-indigo-100">
                                        <svg class="flex-shrink-0 mr-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                        <span class="font-medium">{{ $proposal->type->name ?? '-' }}</span>
                                    </div>
                                    <span
                                        class="px-3 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-white/90 text-indigo-700">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $proposal->status }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex-shrink-0">
                        <a href="{{ route('hki.dashboard') }}"
                            class="inline-flex items-center px-5 py-2.5 bg-white text-indigo-600 rounded-lg font-semibold text-sm hover: transform hover:-translate-y-0.5 transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Certificate Download Area (Only for APPROVED) --}}
    @if($proposal->status === 'APPROVED')
        <div class="mb-6 bg-white rounded-2xl  border border-green-200 overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-emerald-500 px-6 py-4">
                <div class="flex items-center space-x-3">
                    <div
                        class="flex-shrink-0 w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-white">Selamat! Pengajuan HKI Diterima</h3>
                        <p class="text-sm text-green-50">Sertifikat resmi telah tersedia untuk diunduh</p>
                    </div>
                </div>
            </div>
            <div class="px-6 py-5">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                    <div class="flex-1">
                        <p class="text-sm text-gray-700 leading-relaxed">
                            <svg class="w-4 h-4 inline mr-1 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Sertifikat pencatatan ciptaan telah terbit secara digital dan ditandatangani elektronik.
                            Dokumen ini valid dan memiliki kekuatan hukum.
                        </p>
                    </div>
                    <div class="flex-shrink-0">
                        <a href="{{ route('hki.certificate.download', $proposal->id) }}" target="_blank"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg font-semibold text-sm hover: transform hover:-translate-y-0.5 transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            Download Sertifikat PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Reviewer Panel --}}
    @can('review-hki')
        @if($proposal->status === 'SUBMITTED')
            <div class="mb-6 bg-white rounded-2xl  border border-yellow-200 overflow-hidden">
                <div class="bg-gradient-to-r from-yellow-500 to-amber-500 px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <div
                            class="flex-shrink-0 w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white">Panel Reviewer</h3>
                            <p class="text-sm text-yellow-50">Validasi kelengkapan dokumen pengajuan</p>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-5">
                    <p class="text-sm text-gray-700 mb-4">Silakan review dokumen dan berikan keputusan Anda:</p>
                    <div class="flex flex-wrap gap-3">
                        <button wire:click="confirmReview('APPROVE')"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg font-semibold text-sm hover: transform hover:-translate-y-0.5 transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Setujui (Approve)
                        </button>
                        <button wire:click="confirmReview('REJECT')"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-600 to-rose-600 text-white rounded-lg font-semibold text-sm hover: transform hover:-translate-y-0.5 transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Tolak (Reject)
                        </button>
                    </div>
                </div>
            </div>
        @endif
    @endcan

    {{-- Main Content Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left Column --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Team Members Card --}}
            <div class="bg-white rounded-2xl  overflow-hidden border border-indigo-100">
                <div class="bg-gradient-to-r from-gray-50 to-indigo-50 px-6 py-4 border-b border-indigo-100">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-800">Tim Pengusul</h3>
                    </div>
                </div>
                <ul role="list" class="divide-y divide-gray-100">
                    @foreach($proposal->members as $member)
                        <li class="px-6 py-4 hover:bg-indigo-50/30 transition-colors duration-150">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <div
                                        class="h-12 w-12 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white font-bold text-lg shadow-md">
                                        {{ strtoupper(substr($member->name, 0, 1)) }}
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $member->name }}</p>
                                        <span
                                            class="ml-2 px-3 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full {{ $member->role == 'KETUA' ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-800' }}">
                                            @if($member->role == 'KETUA')
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                    </path>
                                                </svg>
                                            @endif
                                            {{ $member->role }}
                                        </span>
                                    </div>
                                    <p class="mt-1 flex items-center text-sm text-gray-500">
                                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2">
                                            </path>
                                        </svg>
                                        NIK: {{ $member->nik }}
                                    </p>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Documents Repository Card --}}
            <div class="bg-white rounded-2xl  overflow-hidden border border-indigo-100">
                <div class="bg-gradient-to-r from-gray-50 to-indigo-50 px-6 py-4 border-b border-indigo-100">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Repositori Dokumen & Integritas File
                            </h3>
                            <p class="text-xs text-gray-600 mt-0.5">Hash SHA-256 dihitung dari konten fisik file</p>
                        </div>
                    </div>
                </div>
                <ul role="list" class="divide-y divide-gray-100">
                    @foreach($proposal->documents as $doc)
                        <li class="px-6 py-5 hover:bg-indigo-50/30 transition-colors duration-150">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-start space-x-3 flex-1 min-w-0">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="h-10 w-10 rounded-lg bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center shadow-md">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $doc->name }}</p>
                                        <div class="mt-1 flex flex-wrap items-center gap-2 text-xs text-gray-500">
                                            <span class="inline-flex items-center">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4">
                                                    </path>
                                                </svg>
                                                {{ number_format($doc->file_size / 1024, 2) }} KB
                                            </span>
                                            <span>•</span>
                                            <span>{{ $doc->mime_type }}</span>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ Storage::url($doc->file_path) }}" target="_blank"
                                    class="ml-3 flex-shrink-0 inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg font-semibold text-xs shadow-md hover transform hover:-translate-y-0.5 transition-all duration-200">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                    Download
                                </a>
                            </div>
                            <div class="bg-gradient-to-r from-gray-50 to-indigo-50 p-3 rounded-lg border border-indigo-100">
                                <div class="flex items-start space-x-2">
                                    <svg class="w-4 h-4 text-indigo-600 flex-shrink-0 mt-0.5" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-semibold text-gray-700 mb-1">SHA-256 Hash:</p>
                                        <p
                                            class="text-xs font-mono text-gray-600 break-all bg-white px-2 py-1 rounded border border-gray-200">
                                            {{ $doc->file_hash }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Right Column - Audit Trail --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl  overflow-hidden border border-indigo-100 lg:sticky lg:top-6">
                <div class="bg-gradient-to-r from-yellow-50 to-amber-50 px-6 py-4 border-b border-yellow-100">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-yellow-800">Audit Trail</h3>
                    </div>
                    <p class="text-xs text-yellow-700 mt-1">Riwayat aktivitas terverifikasi</p>
                </div>
                <div class="p-6">
                    <div class="flow-root">
                        <ul role="list" class="-mb-8">
                            @foreach($proposal->auditLogs as $log)
                                <li>
                                    <div class="relative pb-8">
                                        @if(!$loop->last)
                                            <span
                                                class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gradient-to-b from-indigo-200 to-transparent"
                                                aria-hidden="true"></span>
                                        @endif
                                        <div class="relative flex items-start space-x-3">
                                            <div>
                                                <span
                                                    class="h-10 w-10 rounded-full bg-gradient-to-br from-green-400 to-emerald-500 flex items-center justify-center ring-4 ring-white shadow-md">
                                                    <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <div class="text-sm">
                                                    <span class="font-semibold text-gray-900">{{ $log->action }}</span>
                                                    <p class="text-gray-600 mt-0.5">oleh <span
                                                            class="font-medium text-indigo-600">{{ $log->user->name }}</span>
                                                    </p>
                                                </div>

                                                <div class="mt-2">
                                                    @livewire('hki.forensic.verifier', ['logId' => $log->id], key($log->id))
                                                </div>

                                                <div
                                                    class="mt-3 bg-gradient-to-r from-green-50 to-emerald-50 p-2 rounded-lg border border-green-100">
                                                    <p class="text-[10px] text-gray-500 font-medium mb-1">Current Hash:
                                                    </p>
                                                    <p class="text-[10px] text-green-700 font-mono break-all"
                                                        title="{{ $log->current_hash }}">
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

{{-- Review Modal --}}
@if($showReviewModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity backdrop-blur-sm"
                wire:click="$set('showReviewModal', false)">

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div
                    class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                    <div
                        class="bg-gradient-to-r {{ $reviewAction === 'APPROVE' ? 'from-green-600 to-emerald-600' : 'from-red-600 to-rose-600' }} px-6 py-5">
                        <div class="flex items-center space-x-3">
                            <div
                                class="flex-shrink-0 w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                                @if($reviewAction === 'APPROVE')
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @else
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @endif
                            </div>
                            <h3 class="text-lg font-bold text-white">
                                @if($reviewAction === 'APPROVE')
                                    Konfirmasi Persetujuan
                                @else
                                    Konfirmasi Penolakan
                                @endif
                            </h3>
                        </div>
                    </div>

                    <div class="bg-white px-6 py-6">
                        <div class="space-y-5">
                            <div
                                class="bg-gradient-to-r {{ $reviewAction === 'APPROVE' ? 'from-green-50 to-emerald-50 border-green-200' : 'from-red-50 to-rose-50 border-red-200' }} p-4 rounded-lg border">
                                <p class="text-sm text-gray-700">
                                    Anda akan melakukan tindakan <strong
                                        class="{{ $reviewAction === 'APPROVE' ? 'text-green-700' : 'text-red-700' }}">{{ $reviewAction === 'APPROVE' ? 'MENYETUJUI' : 'MENOLAK' }}</strong>
                                    proposal ini. Tindakan ini akan tercatat dalam audit trail.
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Catatan Reviewer <span class="text-red-500">*</span>
                                </label>
                                <textarea wire:model="reviewNote" rows="4"
                                    class="block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-sm"
                                    placeholder="Berikan catatan atau alasan keputusan Anda..."></textarea>
                                @error('reviewNote')
                                    <p class="mt-1 text-xs text-red-600 flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div
                                class="bg-gradient-to-r from-indigo-50 to-purple-50 p-4 rounded-lg border border-indigo-200">
                                <label class="text-sm font-bold text-gray-800 mb-2 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                        </path>
                                    </svg>
                                    PIN Keamanan
                                </label>
                                <input type="password" wire:model="pin" maxlength="6"
                                    class="block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-center text-lg tracking-widest font-semibold"
                                    placeholder="• • • • • •">
                                @error('pin')
                                    <p class="mt-2 text-xs text-red-600 font-semibold flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse gap-3">
                        <button type="button" wire:click="submitReview" wire:loading.attr="disabled"
                            class="w-full inline-flex justify-center items-center rounded-lg px-5 py-3 text-sm font-semibold text-white sm:w-auto bg-gradient-to-r {{ $reviewAction === 'APPROVE' ? 'from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700' : 'from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700' }} transform hover:-translate-y-0.5 transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" wire:loading.remove fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                                </path>
                            </svg>
                            <svg class="animate-spin h-4 w-4 mr-2" wire:loading xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span wire:loading.remove>Tanda Tangan & Simpan</span>
                            <span wire:loading>Memproses...</span>
                        </button>
                        <button type="button" wire:click="$set('showReviewModal', false)"
                            class="mt-3 w-full inline-flex justify-center rounded-lg border-2 border-gray-300 px-5 py-3 bg-white text-sm font-semibold text-gray-700 hover:bg-gray-50 sm:mt-0 sm:w-auto transition-colors duration-200">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif