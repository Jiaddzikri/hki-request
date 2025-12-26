<div>
    <x-slot name="header">
        <div class="bg-white shadow-sm border-b border-indigo-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">
                            {{ __('Dashboard Overview') }}
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Ringkasan dan aktivitas sistem HKI</p>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    {{-- SIDEBAR --}}
    <x-slot name="sidebar">
        <x-layouts.app.sidebar-hki />
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 py-2">

        {{-- WELCOME MESSAGE --}}
        <div class="mb-8">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-indigo-100">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-6">
                    <div class="flex items-center space-x-4">
                        <div
                            class="flex-shrink-0 w-16 h-16 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                            <span class="text-3xl">👋</span>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-white">
                                Halo, {{ Auth::user()->name }}!
                            </h3>
                            <p class="text-indigo-100 mt-1">
                                @if($isOfficial)
                                    Berikut adalah ringkasan aktivitas sistem HKI hari ini.
                                @else
                                    Pantau status pengajuan HKI Anda di sini.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- STATISTIC CARDS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

            {{-- Card Total --}}
            <div
                class="bg-white rounded-2xl shadow-xl overflow-hidden border border-indigo-100 transform hover:scale-105 transition-transform duration-200">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div
                            class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Total Pengajuan</p>
                            <p class="text-4xl font-bold text-gray-900 mt-1">{{ $stats['total'] }}</p>
                        </div>
                    </div>
                    <div class="pt-4 border-t border-gray-100">
                        <div class="flex items-center text-sm text-blue-600 font-medium">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span>Semua status</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card Pending --}}
            <div
                class="bg-white rounded-2xl shadow-xl overflow-hidden border border-indigo-100 transform hover:scale-105 transition-transform duration-200">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div
                            class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-yellow-400 to-amber-500 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Menunggu Review</p>
                            <p class="text-4xl font-bold text-gray-900 mt-1">{{ $stats['pending'] }}</p>
                        </div>
                    </div>
                    <div class="pt-4 border-t border-gray-100">
                        <div class="flex items-center text-sm text-yellow-600 font-medium">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span>Perlu ditindaklanjuti</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card Approved --}}
            <div
                class="bg-white rounded-2xl shadow-xl overflow-hidden border border-indigo-100 transform hover:scale-105 transition-transform duration-200">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div
                            class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-green-400 to-emerald-500 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Disetujui</p>
                            <p class="text-4xl font-bold text-gray-900 mt-1">{{ $stats['approved'] }}</p>
                        </div>
                    </div>
                    <div class="pt-4 border-t border-gray-100">
                        <div class="flex items-center text-sm text-green-600 font-medium">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span>Berhasil disetujui</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card Rejected --}}
            <div
                class="bg-white rounded-2xl shadow-xl overflow-hidden border border-indigo-100 transform hover:scale-105 transition-transform duration-200">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div
                            class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-red-400 to-rose-500 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Ditolak</p>
                            <p class="text-4xl font-bold text-gray-900 mt-1">{{ $stats['rejected'] }}</p>
                        </div>
                    </div>
                    <div class="pt-4 border-t border-gray-100">
                        <div class="flex items-center text-sm text-red-600 font-medium">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span>Perlu perbaikan</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- ACTION AREA --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Quick Actions --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-indigo-100">
                    <div class="bg-gradient-to-r from-gray-50 to-indigo-50 px-6 py-4 border-b border-indigo-100">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            <h4 class="text-lg font-semibold text-gray-800">Aksi Cepat</h4>
                        </div>
                    </div>
                    <div class="p-6 space-y-3">
                        @if($isOfficial)
                            <a href="{{ route('hki.reviewer.inbox') }}"
                                class="block w-full text-center px-5 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg font-semibold text-sm text-white shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                                <div class="flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                        </path>
                                    </svg>
                                    <span>Buka Inbox Reviewer</span>
                                </div>
                            </a>
                            <a href="{{ route('admin.users') }}"
                                class="block w-full text-center px-5 py-3 bg-gradient-to-r from-gray-700 to-gray-900 rounded-lg font-semibold text-sm text-white shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                                <div class="flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                        </path>
                                    </svg>
                                    <span>Manajemen User</span>
                                </div>
                            </a>
                        @else
                            <a href="{{ route('hki.create') }}"
                                class="block w-full text-center px-5 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg font-semibold text-sm text-white shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                                <div class="flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    <span>Buat Pengajuan Baru</span>
                                </div>
                            </a>
                        @endif

                        <div class="pt-4 mt-4 border-t border-gray-200">
                            <div
                                class="bg-gradient-to-r from-indigo-50 to-purple-50 p-4 rounded-lg border border-indigo-100">
                                <div class="flex items-start space-x-3">
                                    <svg class="w-5 h-5 text-indigo-600 flex-shrink-0 mt-0.5" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <div class="text-xs text-gray-700">
                                        <p class="font-semibold mb-1">Tips:</p>
                                        <p>Pastikan semua dokumen lengkap sebelum mengajukan HKI untuk mempercepat
                                            proses review.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Recent Activity Table --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-indigo-100">
                    <div class="bg-gradient-to-r from-gray-50 to-indigo-50 px-6 py-4 border-b border-indigo-100">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <h4 class="text-lg font-semibold text-gray-800">
                                    {{ $isOfficial ? 'Antrean Terbaru Masuk' : 'Pengajuan Terakhir Saya' }}
                                </h4>
                            </div>
                            @if(!$isOfficial)
                                <a href="{{ route('hki.dashboard') }}"
                                    class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-800 font-semibold transition-colors">
                                    <span>Lihat Semua</span>
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>

                    @if($recentProposals->isEmpty())
                        <div class="p-12 text-center">
                            <div
                                class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-full mb-4">
                                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                    </path>
                                </svg>
                            </div>
                            <p class="text-gray-500 font-medium">Belum ada data pengajuan</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gradient-to-r from-gray-50 to-indigo-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            <div class="flex items-center space-x-1">
                                                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                    </path>
                                                </svg>
                                                <span>Judul Pengajuan</span>
                                            </div>
                                        </th>
                                        <th
                                            class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            <div class="flex items-center justify-center space-x-1">
                                                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <span>Status</span>
                                            </div>
                                        </th>
                                        <th
                                            class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            <div class="flex items-center justify-end space-x-1">
                                                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                                <span>Aksi</span>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @foreach($recentProposals as $p)
                                                                    <tr class="hover:bg-indigo-50/30 transition-colors duration-150">
                                                                        <td class="px-6 py-4">
                                                                            <div class="flex items-start space-x-3">
                                                                                <div class="flex-shrink-0 mt-1">
                                                                                    <div
                                                                                        class="h-10 w-10 rounded-lg bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center shadow-md">
                                                                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                                                                            viewBox="0 0 24 24">
                                                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                                                stroke-width="2"
                                                                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                                                            </path>
                                                                                        </svg>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="min-w-0 flex-1">
                                                                                    <p class="text-sm font-semibold text-gray-900 truncate max-w-xs hover:text-indigo-600 transition-colors"
                                                                                        title="{{ $p->title }}">
                                                                                        {{ Str::limit($p->title, 40) }}
                                                                                    </p>
                                                                                    @if($isOfficial)
                                                                                        <p class="text-xs text-gray-500 mt-1 flex items-center">
                                                                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                                                                viewBox="0 0 24 24">
                                                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                                                    stroke-width="2"
                                                                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                                                                </path>
                                                                                            </svg>
                                                                                            Oleh: {{ $p->user->name }}
                                                                                        </p>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td class="px-6 py-4 text-center">
                                                                            @php
                                                                                $statusConfig = [
                                                                                    'APPROVED' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                                                                                    'REJECTED' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'icon' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z'],
                                                                                    'SUBMITTED' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                                                                                ];
                                                                                $config = $statusConfig[$p->status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'];
                                                                            @endphp
                                         <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold shadow-sm {{ $config['bg'] }} {{ $config['text'] }}">
                                                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor"
                                                                                    viewBox="0 0 24 24">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                                        d="{{ $config['icon'] }}"></path>
                                                                                </svg>
                                                                                {{ $p->status }}
                                                                            </span>
                                                                        </td>
                                                                        <td class="px-6 py-4 text-right">
                                                                            <a href="{{ route('hki.show', $p->id) }}"
                                                                                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg font-semibold text-xs shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                                                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor"
                                                                                    viewBox="0 0 24 24">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                                                    </path>
                                                                                </svg>
                                                                                Lihat
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>