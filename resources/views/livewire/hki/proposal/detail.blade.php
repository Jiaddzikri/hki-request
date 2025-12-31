<x-slot name="sidebar">
    <x-layouts.app.sidebar-hki />
</x-slot>

<div class="max-w-7xl mx-auto py-8 px-4">

    {{-- Official Header Section --}}
    <div class="mb-8">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-200">
            <div class="bg-gradient-to-r from-slate-700 to-slate-800 px-8 py-8 border-b-4 border-blue-600">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-16 h-16 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/30">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="mb-2">
                                    <p class="text-sm text-blue-100 font-medium uppercase tracking-wide">DOKUMEN RESMI</p>
                                </div>
                                <h1 class="text-2xl font-bold text-white mb-3">
                                    {{ $proposal->title }}
                                </h1>
                                <div class="flex flex-wrap items-center gap-4">
                                    <div class="flex items-center text-sm text-blue-100">
                                        <svg class="flex-shrink-0 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                        <span class="font-medium">Kategori: {{ $proposal->type->name ?? '-' }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="px-4 py-1.5 inline-flex items-center text-xs leading-5 font-bold rounded-lg bg-white text-slate-700 border border-gray-200 shadow-sm">
                                            <svg class="w-3 h-3 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            STATUS: {{ $proposal->status }}
                                        </span>
                                        <button wire:click="$set('showDetailModal', true)" type="button" class="ml-3 p-2 bg-white/10 hover:bg-white/20 rounded-lg transition-colors duration-200" title="Lihat Detail Lengkap">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="flex space-x-3">
                            <button wire:click="$set('showDetailModal', true)" type="button"
                                class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold text-sm shadow-md hover:bg-blue-700 border border-blue-700 transition-all duration-200"
                                wire:loading.attr="disabled"
                                wire:target="showDetailModal">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m-6 8h6m-3-6v6m-9-10V4a2 2 0 012-2h14a2 2 0 012 2v6M4 14h16a2 2 0 002-2V4a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                                <span wire:loading.remove wire:target="showDetailModal">LIHAT DETAIL LENGKAP</span>
                                <span wire:loading wire:target="showDetailModal">Loading...</span>
                            </button>
                            <a href="{{ route('hki.dashboard') }}"
                                class="inline-flex items-center px-6 py-3 bg-white text-slate-700 rounded-lg font-semibold text-sm shadow-md hover:bg-gray-50 border border-gray-200 transition-all duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Kembali ke Beranda
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Certificate Download Area (Only for APPROVED) --}}
    @if($proposal->status === 'APPROVED')
        <div class="mb-6 bg-white rounded-lg shadow-lg border border-green-200 overflow-hidden">
            <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-8 py-6 border-b border-green-700">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0 w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">SERTIFIKAT HAKI TELAH DISETUJUI</h3>
                        <p class="text-sm text-green-50 font-medium">Dokumen resmi tersedia untuk diunduh</p>
                    </div>
                </div>
            </div>
            <div class="px-8 py-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                    <div class="flex-1">
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                            <div class="flex items-start space-x-3">
                                <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <div class="flex-1">
                                    <h4 class="text-sm font-bold text-green-800">Selamat! Permohonan HKI Anda telah disetujui</h4>
                                    <div class="mt-2">
                                        @php
                                            $approvalNote = $proposal->auditLogs()
                                                ->where('action', 'APPROVE_PROPOSAL')
                                                ->latest()
                                                ->first();
                                        @endphp
                                        @if($approvalNote && isset($approvalNote->payload['note']))
                                            <p class="text-sm text-green-700 leading-relaxed mb-2">{{ $approvalNote->payload['note'] }}</p>
                                        @endif
                                        <p class="text-xs text-green-600 font-medium">
                                            @if($approvalNote)
                                                Disetujui oleh: {{ $approvalNote->payload['reviewer_name'] ?? 'Reviewer' }} 
                                                pada {{ \Carbon\Carbon::parse($approvalNote->payload['timestamp'])->format('d F Y, H:i') }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="text-sm text-gray-700 leading-relaxed font-medium">
                            <svg class="w-4 h-4 inline mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Sertifikat pencatatan ciptaan telah terbit secara digital dan ditandatangani elektronik.
                            Dokumen ini memiliki kekuatan hukum yang sah sesuai peraturan perundang-undangan yang berlaku.
                        </p>
                    </div>
                    <div class="flex-shrink-0">
                        <a href="{{ route('hki.certificate.download', $proposal->id) }}" target="_blank"
                            class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg font-bold text-sm shadow-lg hover:from-green-700 hover:to-emerald-700 transition-all duration-200 border border-green-700">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            UNDUH SERTIFIKAT PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Rejection Message Area (Only for REJECTED) --}}
    @if($proposal->status === 'REJECTED')
        <div class="mb-6 bg-white rounded-lg shadow-lg border border-red-200 overflow-hidden">
            <div class="bg-gradient-to-r from-red-600 to-rose-600 px-8 py-6 border-b border-red-700">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0 w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">PERMOHONAN HKI DITOLAK</h3>
                        <p class="text-sm text-red-50 font-medium">Proposal tidak memenuhi persyaratan yang ditetapkan</p>
                    </div>
                </div>
            </div>
            <div class="px-8 py-6">
                <div class="space-y-4">
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-red-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <div class="flex-1">
                                <h4 class="text-sm font-bold text-red-800">Alasan Penolakan:</h4>
                                <div class="mt-2">
                                    @php
                                        $rejectionNote = $proposal->auditLogs()
                                            ->where('action', 'REJECT_PROPOSAL')
                                            ->latest()
                                            ->first();
                                    @endphp
                                    @if($rejectionNote && isset($rejectionNote->payload['note']))
                                        <p class="text-sm text-red-700 leading-relaxed">{{ $rejectionNote->payload['note'] }}</p>
                                        <div class="mt-3 pt-3 border-t border-red-200">
                                            <p class="text-xs text-red-600 font-medium">
                                                Ditolak oleh: {{ $rejectionNote->payload['reviewer_name'] ?? 'Reviewer' }} 
                                                pada {{ \Carbon\Carbon::parse($rejectionNote->payload['timestamp'])->format('d F Y, H:i') }}
                                            </p>
                                        </div>
                                    @else
                                        <p class="text-sm text-red-700">Tidak ada catatan khusus dari reviewer.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="flex-1">
                                <h4 class="text-sm font-bold text-blue-800">Langkah Selanjutnya:</h4>
                                <ul class="mt-2 text-sm text-blue-700 space-y-1">
                                    <li>• Perbaiki dokumen sesuai dengan catatan reviewer</li>
                                    <li>• Lengkapi persyaratan yang masih kurang</li>
                                    <li>• Ajukan permohonan baru dengan dokumen yang telah diperbaiki</li>
                                    <li>• Hubungi admin jika memerlukan klarifikasi lebih lanjut</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Submitted Status Message (For non-reviewers) --}}
    @if($proposal->status === 'SUBMITTED')
        @cannot('review-hki')
            <div class="mb-6 bg-white rounded-lg shadow-lg border border-yellow-200 overflow-hidden">
                <div class="bg-gradient-to-r from-yellow-500 to-amber-500 px-8 py-6 border-b border-yellow-600">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">PERMOHONAN SEDANG DIPROSES</h3>
                            <p class="text-sm text-yellow-50 font-medium">Dokumen sedang dalam tahap review oleh tim ahli</p>
                        </div>
                    </div>
                </div>
                <div class="px-8 py-6">
                    <div class="space-y-4">
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <div class="flex items-start space-x-3">
                                <svg class="w-5 h-5 text-yellow-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div class="flex-1">
                                    <h4 class="text-sm font-bold text-yellow-800">Status Terkini:</h4>
                                    <p class="text-sm text-yellow-700 mt-1">
                                        Permohonan HKI Anda telah berhasil diajukan dan saat ini sedang dalam proses evaluasi oleh tim reviewer. 
                                        Proses ini biasanya membutuhkan waktu 3-7 hari kerja.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-start space-x-3">
                                <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div class="flex-1">
                                    <h4 class="text-sm font-bold text-blue-800">Yang Perlu Anda Ketahui:</h4>
                                    <ul class="mt-2 text-sm text-blue-700 space-y-1">
                                        <li>• Anda akan mendapat notifikasi melalui email setelah review selesai</li>
                                        <li>• Jangan mengajukan permohonan duplikat untuk karya yang sama</li>
                                        <li>• Pastikan dokumen yang diajukan sudah final dan benar</li>
                                        <li>• Hubungi admin jika ada pertanyaan mendesak</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endcannot
    @endif

    {{-- Reviewer Panel --}}
    @can('review-hki')
        @if($proposal->status === 'SUBMITTED')
            <div class="mb-6 bg-white rounded-lg shadow-lg border border-yellow-200 overflow-hidden">
                <div class="bg-gradient-to-r from-yellow-500 to-amber-500 px-8 py-5 border-b border-yellow-600">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm border border-white/30">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white">PANEL REVIEWER RESMI</h3>
                            <p class="text-sm text-yellow-50 font-medium">Validasi dan Evaluasi Dokumen Pengajuan HKI</p>
                        </div>
                    </div>
                </div>
                <div class="px-8 py-6">
                    <p class="text-sm text-gray-700 mb-6 font-medium">Silakan melakukan review terhadap kelengkapan dokumen dan berikan keputusan resmi:</p>
                    <div class="flex flex-wrap gap-4">
                        <button wire:click="confirmReview('APPROVE')"
                            class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg font-bold text-sm shadow-lg hover:from-green-700 hover:to-emerald-700 transition-all duration-200 border border-green-700">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            SETUJUI PROPOSAL
                        </button>
                        <button wire:click="confirmReview('REJECT')"
                            class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-red-600 to-rose-600 text-white rounded-lg font-bold text-sm shadow-lg hover:from-red-700 hover:to-rose-700 transition-all duration-200 border border-red-700">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            TOLAK PROPOSAL
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
            <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-200">
                <div class="bg-gradient-to-r from-gray-100 to-blue-50 px-8 py-5 border-b border-gray-200">
                    <div class="flex items-center space-x-3">
                        <svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        <h3 class="text-lg font-bold text-gray-800">DAFTAR TIM PENGUSUL</h3>
                    </div>
                </div>
                <ul role="list" class="divide-y divide-gray-100">
                    @foreach($proposal->members as $member)
                        <li class="px-6 py-4 hover:bg-gray-50 transition-colors duration-150">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="h-12 w-12 rounded-full bg-gradient-to-br from-blue-600 to-slate-700 flex items-center justify-center text-white font-bold text-lg shadow-md border-2 border-white">
                                        {{ strtoupper(substr($member->name, 0, 1)) }}
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <p class="text-sm font-bold text-gray-900 truncate">{{ $member->name }}</p>
                                        <span class="ml-2 px-3 py-1 inline-flex items-center text-xs leading-5 font-bold rounded-lg {{ $member->role == 'KETUA' ? 'bg-blue-100 text-blue-800 border border-blue-200' : 'bg-gray-100 text-gray-800 border border-gray-200' }}">
                                            @if($member->role == 'KETUA')
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                </svg>
                                            @endif
                                            {{ $member->role }}
                                        </span>
                                    </div>
                                    <p class="mt-1 flex items-center text-sm text-gray-600 font-medium">
                                        <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
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
            <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-200">
                <div class="bg-gradient-to-r from-gray-100 to-blue-50 px-8 py-5 border-b border-gray-200">
                    <div class="flex items-center space-x-3">
                        <svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">REPOSITORI DOKUMEN RESMI</h3>
                            <p class="text-xs text-gray-600 mt-0.5 font-medium">Integritas file dijamin dengan Hash SHA-256</p>
                        </div>
                    </div>
                </div>
                <ul role="list" class="divide-y divide-gray-100">
                    @foreach($proposal->documents as $doc)
                        <li class="px-6 py-5 hover:bg-gray-50 transition-colors duration-150">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-start space-x-3 flex-1 min-w-0">
                                    <div class="flex-shrink-0">
                                        <div class="h-12 w-12 rounded-lg bg-gradient-to-br from-blue-600 to-slate-700 flex items-center justify-center shadow-md border-2 border-white">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-bold text-gray-900 truncate">{{ $doc->name }}</p>
                                        <div class="mt-1 flex flex-wrap items-center gap-2 text-xs text-gray-600 font-medium">
                                            <span class="inline-flex items-center">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                    class="ml-3 flex-shrink-0 inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-slate-700 text-white rounded-lg font-bold text-xs shadow-lg hover:from-blue-700 hover:to-slate-800 transition-all duration-200 border border-gray-300">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                    UNDUH
                                </a>
                            </div>
                            <div class="bg-gradient-to-r from-gray-50 to-blue-50 p-3 rounded-lg border border-gray-200">
                                <div class="flex items-start space-x-2">
                                    <svg class="w-4 h-4 text-blue-700 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-bold text-gray-700 mb-1">Sidik Jari Digital (SHA-256):</p>
                                        <p class="text-xs font-mono text-gray-700 break-all bg-white px-2 py-1 rounded border border-gray-300 font-medium">
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
            <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-200 lg:sticky lg:top-6">
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
                                            <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gradient-to-b from-gray-300 to-transparent"
                                                aria-hidden="true"></span>
                                        @endif
                                        <div class="relative flex items-start space-x-3">
                                            <div>
                                                <span class="h-10 w-10 rounded-full bg-gradient-to-br from-green-600 to-emerald-600 flex items-center justify-center ring-4 ring-white shadow-lg border-2 border-white">
                                                    <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <div class="text-sm">
                                                    <span class="font-bold text-gray-900">{{ $log->action }}</span>
                                                    <p class="text-gray-600 mt-0.5 font-medium">oleh <span class="font-bold text-blue-700">{{ $log->user->name }}</span></p>
                                                </div>

                                                <div class="mt-2">
                                                    @livewire('hki.forensic.verifier', ['logId' => $log->id], key($log->id))
                                                </div>

                                                <div class="mt-3 bg-gradient-to-r from-green-50 to-emerald-50 p-2 rounded-lg border border-green-200">
                                                    <p class="text-[10px] text-gray-700 font-bold mb-1">Hash Verifikasi:</p>
                                                    <p class="text-[10px] text-green-800 font-mono break-all font-medium"
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
            {{-- Review Modal --}}
@if($showReviewModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity backdrop-blur-sm" 
                 wire:click="$set('showReviewModal', false)" aria-hidden="true"></div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal panel -->
            <div class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full border-2 border-gray-300">
                    <div class="bg-gradient-to-r {{ $reviewAction === 'APPROVE' ? 'from-green-600 to-emerald-600' : 'from-red-600 to-rose-600' }} px-8 py-6 border-b-2 {{ $reviewAction === 'APPROVE' ? 'border-green-700' : 'border-red-700' }}">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm border border-white/30">
                                @if($reviewAction === 'APPROVE')
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @else
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @endif
                            </div>
                            <h3 class="text-xl font-bold text-white">
                                @if($reviewAction === 'APPROVE')
                                    KONFIRMASI PERSETUJUAN RESMI
                                @else
                                    KONFIRMASI PENOLAKAN RESMI
                                @endif
                            </h3>
                        </div>
                    </div>

                    <div class="bg-white px-8 py-6">
                        <div class="space-y-6">
                            <div class="bg-gradient-to-r {{ $reviewAction === 'APPROVE' ? 'from-green-50 to-emerald-50 border-green-200' : 'from-red-50 to-rose-50 border-red-200' }} p-4 rounded-lg border-2">
                                <p class="text-sm text-gray-700 font-medium">
                                    Anda akan melakukan tindakan resmi <strong class="{{ $reviewAction === 'APPROVE' ? 'text-green-700' : 'text-red-700' }} font-bold">{{ $reviewAction === 'APPROVE' ? 'MENYETUJUI' : 'MENOLAK' }}</strong>
                                    proposal ini. Tindakan ini akan tercatat permanen dalam audit trail sistem.
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">
                                    Catatan Reviewer Resmi <span class="text-red-600">*</span>
                                </label>
                                <textarea wire:model="reviewNote" rows="4"
                                    class="block w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-sm font-medium"
                                    placeholder="Berikan catatan atau alasan keputusan resmi Anda..."></textarea>
                                @error('reviewNote')
                                    <p class="mt-1 text-xs text-red-600 flex items-center font-medium">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="bg-gradient-to-r from-blue-50 to-slate-50 p-4 rounded-lg border-2 border-blue-200">
                                <label class="text-sm font-bold text-gray-800 mb-2 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                        </path>
                                    </svg>
                                    PIN Keamanan Reviewer
                                </label>
                                <input type="password" wire:model="pin" maxlength="6"
                                    class="block w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-center text-lg tracking-widest font-bold"
                                    placeholder="• • • • • •">
                                @error('pin')
                                    <p class="mt-2 text-xs text-red-600 font-bold flex items-center">
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
                            class="w-full inline-flex justify-center items-center rounded-lg px-8 py-3 text-sm font-bold text-white sm:w-auto bg-gradient-to-r {{ $reviewAction === 'APPROVE' ? 'from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700' : 'from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700' }} shadow-lg transition-all duration-200 border-2 {{ $reviewAction === 'APPROVE' ? 'border-green-700' : 'border-red-700' }}">
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
                            <span wire:loading.remove>TANDA TANGAN DIGITAL & SIMPAN</span>
                            <span wire:loading>MEMPROSES...</span>
                        </button>
                        <button type="button" wire:click="$set('showReviewModal', false)"
                            class="mt-3 w-full inline-flex justify-center rounded-lg border-2 border-gray-300 px-6 py-3 bg-white text-sm font-bold text-gray-700 hover:bg-gray-50 sm:mt-0 sm:w-auto transition-colors duration-200 shadow-md">
                            BATAL
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

{{-- Detail Modal --}}
{{-- Debug: showDetailModal = {{ $showDetailModal ? 'true' : 'false' }} --}}
@if($showDetailModal)
    <div class="fixed inset-0 z-[60] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" wire:ignore.self>
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity backdrop-blur-sm" 
                 wire:click="$set('showDetailModal', false)" aria-hidden="true"></div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal panel -->
            <div class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl w-full border-2 border-gray-300">
                <!-- Header -->
                <div class="bg-gradient-to-r from-slate-700 to-slate-800 px-8 py-6 border-b-2 border-blue-600">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm border border-white/30">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-white">DETAIL LENGKAP PERMOHONAN HKI</h3>
                                <p class="text-blue-100 text-sm font-medium">Informasi Komprehensif Pengajuan</p>
                            </div>
                        </div>
                        <button wire:click="$set('showDetailModal', false)" class="text-white hover:text-gray-200 transition-colors duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Content -->
                <div class="bg-white max-h-96 overflow-y-auto">
                    <div class="p-8 space-y-8">
                        <!-- Basic Information -->
                        <div class="bg-gradient-to-r from-gray-50 to-blue-50 p-6 rounded-lg border border-gray-200">
                            <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                INFORMASI DASAR
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-white p-4 rounded-lg border border-gray-200">
                                    <dt class="text-xs font-bold text-gray-500 uppercase tracking-wide">Judul Proposal</dt>
                                    <dd class="mt-1 text-sm font-bold text-gray-900">{{ $proposal->title }}</dd>
                                </div>
                                <div class="bg-white p-4 rounded-lg border border-gray-200">
                                    <dt class="text-xs font-bold text-gray-500 uppercase tracking-wide">Kategori HKI</dt>
                                    <dd class="mt-1 text-sm font-bold text-blue-700">{{ $proposal->type->name ?? 'Tidak Diketahui' }}</dd>
                                </div>
                                <div class="bg-white p-4 rounded-lg border border-gray-200">
                                    <dt class="text-xs font-bold text-gray-500 uppercase tracking-wide">Status Terkini</dt>
                                    <dd class="mt-1">
                                        @php
                                            $statusClass = match($proposal->status) {
                                                'APPROVED' => 'bg-green-100 text-green-800 border-green-200',
                                                'REJECTED' => 'bg-red-100 text-red-800 border-red-200', 
                                                'SUBMITTED' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                                default => 'bg-gray-100 text-gray-800 border-gray-200'
                                            };
                                        @endphp
                                        <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-bold rounded-lg border {{ $statusClass }}">
                                            {{ $proposal->status }}
                                        </span>
                                    </dd>
                                </div>
                                <div class="bg-white p-4 rounded-lg border border-gray-200">
                                    <dt class="text-xs font-bold text-gray-500 uppercase tracking-wide">Tanggal Pengajuan</dt>
                                    <dd class="mt-1 text-sm font-bold text-gray-900">{{ $proposal->created_at->format('d F Y, H:i') }}</dd>
                                </div>
                                <div class="bg-white p-4 rounded-lg border border-gray-200">
                                    <dt class="text-xs font-bold text-gray-500 uppercase tracking-wide">Pengusul Utama</dt>
                                    <dd class="mt-1 text-sm font-bold text-gray-900">{{ $proposal->user->name ?? 'Tidak Diketahui' }}</dd>
                                </div>
                                <div class="bg-white p-4 rounded-lg border border-gray-200">
                                    <dt class="text-xs font-bold text-gray-500 uppercase tracking-wide">Negara Pertama kali diumumkan</dt>
                                    <dd class="mt-1 text-sm font-bold text-gray-900">{{ $proposal->publication_country ? \App\Helpers\Countries::getCountryName($proposal->publication_country) : 'Tidak Diketahui' }}</dd>
                                </div>
                                <div class="bg-white p-4 rounded-lg border border-gray-200">
                                    <dt class="text-xs font-bold text-gray-500 uppercase tracking-wide">Kota Pertama kali diumumkan</dt>
                                    <dd class="mt-1 text-sm font-bold text-gray-900">{{ $proposal->publication_city ? $proposal->publication_city : 'Tidak Diketahui' }}</dd>
                                </div>
                            </div>
                        </div>

                        <!-- Description Section -->
                        <div class="bg-gradient-to-r from-gray-50 to-blue-50 p-6 rounded-lg border border-gray-200">
                            <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16m-7 6h7">
                                    </path>
                                </svg>
                                DESKRIPSI AJUAN HKI
                            </h4>
                            <div class="bg-white p-6 rounded-lg border border-gray-200">
                                @if($proposal->description)
                                    <div class="prose prose-sm max-w-none text-gray-700">
                                        <p class="text-sm leading-relaxed font-medium whitespace-pre-line">{{ $proposal->description }}</p>
                                    </div>
                                @else
                                    <div class="text-center py-8">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                        <p class="mt-2 text-sm text-gray-500 font-medium">Tidak ada deskripsi tersedia untuk ajuan HKI ini</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Team Members Detail -->
                        <div class="bg-gradient-to-r from-gray-50 to-blue-50 p-6 rounded-lg border border-gray-200">
                            <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                                DETAIL TIM PENGUSUL ({{ $proposal->members->count() }} Orang)
                            </h4>
                            <div class="space-y-4">
                                @foreach($proposal->members as $member)
                                    <div class="bg-white p-4 rounded-lg border border-gray-200 hover:shadow-md transition-shadow duration-200">
                                        <div class="flex items-start space-x-4">
                                            <div class="flex-shrink-0">
                                                <div class="h-12 w-12 rounded-full bg-gradient-to-br from-blue-600 to-slate-700 flex items-center justify-center text-white font-bold text-lg shadow-md border-2 border-white">
                                                    {{ strtoupper(substr($member->name, 0, 1)) }}
                                                </div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center justify-between mb-2">
                                                    <h5 class="text-sm font-bold text-gray-900">{{ $member->name }}</h5>
                                                    <span class="px-2 py-1 text-xs font-bold rounded-lg {{ $member->role == 'KETUA' ? 'bg-blue-100 text-blue-800 border border-blue-200' : 'bg-gray-100 text-gray-800 border border-gray-200' }}">
                                                        {{ $member->role }}
                                                    </span>
                                                </div>
                                                <dl class="grid grid-cols-2 gap-4 text-xs">
                                                    <div>
                                                        <dt class="font-bold text-gray-500">NIK</dt>
                                                        <dd class="font-medium text-gray-900">{{ $member->nik ?? 'Tidak Tersedia' }}</dd>
                                                    </div>
                                                    <div>
                                                        <dt class="font-bold text-gray-500">NIDN</dt>
                                                        <dd class="font-medium text-gray-900">{{ $member->nidn ?? ($member->user->nik ?? 'Tidak Tersedia') }}</dd>
                                                    </div>
                                                    <div>
                                                        <dt class="font-bold text-gray-500">NIDN</dt>
                                                        <dd class="font-medium text-gray-900">{{ $member->nidn ?? ($member->user->nidn ?? 'Tidak Tersedia') }}</dd>
                                                    </div>
                                                    <div>
                                                        <dt class="font-bold text-gray-500">NPWP</dt>
                                                        <dd class="font-medium text-gray-900">{{ $member->npwp ?? 'Tidak Tersedia' }}</dd>
                                                    </div>
                                                    <div>
                                                        <dt class="font-bold text-gray-500">Email</dt>
                                                        <dd class="font-medium text-gray-900">{{ $member->user->email ?? 'Tidak Tersedia' }}</dd>
                                                    </div>
                                                    <div>
                                                        <dt class="font-bold text-gray-500">Bergabung</dt>
                                                        <dd class="font-medium text-gray-900">{{ $member->created_at->format('d/m/Y') }}</dd>
                                                    </div>
                                                </dl>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Documents Detail -->
                        <div class="bg-gradient-to-r from-gray-50 to-blue-50 p-6 rounded-lg border border-gray-200">
                            <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                DOKUMEN PENDUKUNG ({{ $proposal->documents->count() }} File)
                            </h4>
                            <div class="space-y-4">
                                @foreach($proposal->documents as $doc)
                                    <div class="bg-white p-4 rounded-lg border border-gray-200 hover:shadow-md transition-shadow duration-200">
                                        <div class="flex items-start justify-between">
                                            <div class="flex items-start space-x-3 flex-1">
                                                <div class="flex-shrink-0">
                                                    <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-blue-600 to-slate-700 flex items-center justify-center shadow-md border-2 border-white">
                                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                                            </path>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="flex-1">
                                                    <h5 class="text-sm font-bold text-gray-900 mb-1">{{ $doc->name }}</h5>
                                                    <dl class="grid grid-cols-3 gap-4 text-xs">
                                                        <div>
                                                            <dt class="font-bold text-gray-500">Ukuran</dt>
                                                            <dd class="font-medium text-gray-900">{{ number_format($doc->file_size / 1024, 2) }} KB</dd>
                                                        </div>
                                                        <div>
                                                            <dt class="font-bold text-gray-500">Tipe</dt>
                                                            <dd class="font-medium text-gray-900">{{ $doc->mime_type }}</dd>
                                                        </div>
                                                        <div>
                                                            <dt class="font-bold text-gray-500">Upload</dt>
                                                            <dd class="font-medium text-gray-900">{{ $doc->created_at->format('d/m/Y') }}</dd>
                                                        </div>
                                                    </dl>
                                                    <div class="mt-2 p-2 bg-gray-50 rounded border">
                                                        <dt class="text-xs font-bold text-gray-500 mb-1">Hash SHA-256:</dt>
                                                        <dd class="text-xs font-mono text-gray-700 break-all">{{ $doc->file_hash }}</dd>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-shrink-0 ml-4">
                                                <a href="{{ Storage::url($doc->file_path) }}" target="_blank"
                                                    class="inline-flex items-center px-3 py-2 bg-blue-600 text-white rounded-lg font-bold text-xs shadow-md hover:bg-blue-700 transition-all duration-200">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                                    </svg>
                                                    UNDUH
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Audit Trail Summary -->
                        <div class="bg-gradient-to-r from-yellow-50 to-amber-50 p-6 rounded-lg border border-yellow-200">
                            <h4 class="text-lg font-bold text-yellow-800 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                RIWAYAT AKTIVITAS ({{ $proposal->auditLogs->count() }} Aktivitas)
                            </h4>
                            <div class="space-y-3">
                                @foreach($proposal->auditLogs->take(5) as $log)
                                    <div class="bg-white p-4 rounded-lg border border-yellow-200">
                                        <div class="flex items-start justify-between mb-2">
                                            <div class="flex items-center space-x-3">
                                                <div class="h-8 w-8 rounded-full bg-gradient-to-br from-green-600 to-emerald-600 flex items-center justify-center">
                                                    <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-bold text-gray-900">{{ $log->action }}</p>
                                                    <p class="text-xs text-gray-600">oleh {{ $log->user->name ?? 'System' }}</p>
                                                </div>
                                            </div>
                                            <span class="text-xs font-medium text-gray-500">{{ $log->created_at->format('d/m/Y H:i') }}</span>
                                        </div>
                                        @if($log->payload && is_array($log->payload))
                                            <div class="mt-2 p-2 bg-gray-50 rounded text-xs">
                                                <strong class="text-gray-700">Detail:</strong>
                                                @foreach($log->payload as $key => $value)
                                                    @if(!in_array($key, ['pin', 'password']))
                                                        <div class="text-gray-600"><span class="font-medium">{{ ucfirst(str_replace('_', ' ', $key)) }}:</span> {{ is_string($value) ? $value : json_encode($value) }}</div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                                @if($proposal->auditLogs->count() > 5)
                                    <div class="text-center">
                                        <p class="text-sm font-medium text-yellow-700">Dan {{ $proposal->auditLogs->count() - 5 }} aktivitas lainnya...</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="bg-gray-50 px-8 py-4 border-t border-gray-200">
                    <div class="flex justify-end">
                        <button type="button" wire:click="$set('showDetailModal', false)"
                            class="inline-flex justify-center items-center rounded-lg border-2 border-gray-300 px-6 py-3 bg-white text-sm font-bold text-gray-700 hover:bg-gray-50 transition-colors duration-200 shadow-md">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            TUTUP
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<script>
document.addEventListener('livewire:init', () => {
    console.log('Livewire initialized');
    
    Livewire.on('modal-opened', () => {
        console.log('Detail modal opened');
    });
    
    Livewire.on('modal-closed', () => {
        console.log('Detail modal closed');
    });
});

// Debug: Add click event listener
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded');
});
</script>

