<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
    {{-- Header Section --}}
    <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-700 pb-32 relative overflow-hidden">
        {{-- Decorative Background --}}
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-72 h-72 bg-white rounded-full -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full translate-x-1/3 translate-y-1/3">
            </div>
        </div>

        <header class="relative py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center space-x-4 mb-4">
                    <div
                        class="flex-shrink-0 w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-extrabold text-white tracking-tight">
                            Portal Layanan LPPM
                        </h1>
                        <p class="mt-1 text-indigo-100 text-lg">
                            Sistem Terintegrasi Penelitian & Pengabdian Masyarakat
                        </p>
                    </div>
                </div>
            </div>
        </header>
    </div>

    <main class="-mt-32 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">

            {{-- Welcome Card --}}
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8 border border-indigo-100">
                <div class="bg-gradient-to-r from-gray-50 to-indigo-50 px-8 py-6 border-b border-indigo-100">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                        <div class="flex items-center space-x-4">
                            <div
                                class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-full flex items-center justify-center text-white font-bold text-xl shadow-lg">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-gray-800 flex items-center">
                                    Halo, {{ auth()->user()->name }}!
                                    <span class="ml-2 text-2xl">👋</span>
                                </h2>
                                <p class="text-gray-600 text-sm mt-1 flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2">
                                        </path>
                                    </svg>
                                    NIDN/NIP: <span class="font-semibold ml-1">{{ auth()->user()->nidn ?? '-' }}</span>
                                    | Kelola semua aktivitas akademik Anda di sini
                                </p>
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-red-500 to-rose-600 text-white rounded-lg font-semibold text-sm shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sentra Kekayaan Intelektual Section --}}
            <div class="mb-8">
                <div class="flex items-center space-x-3 mb-6">
                    <div
                        class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center shadow-md">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">
                        Sentra Kekayaan Intelektual & Publikasi
                    </h3>
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">

                    {{-- HKI Card --}}
                    <a href="{{ route('hki.dashboard') }}"
                        class="group relative bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 border border-indigo-100 overflow-hidden transform hover:-translate-y-1">
                        <div
                            class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-indigo-400/20 to-purple-500/20 rounded-full -translate-y-16 translate-x-16 group-hover:scale-150 transition-transform duration-500">
                        </div>

                        <div class="relative p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div
                                    class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                    <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <span
                                    class="flex-shrink-0 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Aktif
                                </span>
                            </div>

                            <h3
                                class="text-xl font-bold text-gray-900 group-hover:text-indigo-600 transition-colors mb-2">
                                Pengajuan HKI
                            </h3>
                            <p class="text-sm text-gray-600 leading-relaxed mb-4">
                                Pendaftaran Hak Cipta & Paten dengan tanda tangan digital berbasis Forensik.
                            </p>

                            <div
                                class="flex items-center text-sm font-semibold text-indigo-600 group-hover:text-indigo-700">
                                <span>Akses Layanan</span>
                                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </div>
                        </div>

                        <div
                            class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-indigo-500 to-purple-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300">
                        </div>
                    </a>

                    {{-- Buku Ajar Card (Coming Soon) --}}
                    <div
                        class="group relative bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden opacity-75 hover:opacity-90 transition-opacity duration-300">
                        <div
                            class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-teal-400/10 to-cyan-500/10 rounded-full -translate-y-16 translate-x-16">
                        </div>

                        <div class="relative p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div
                                    class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-teal-400 to-cyan-500 rounded-xl flex items-center justify-center shadow-lg opacity-50">
                                    <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                                <span
                                    class="flex-shrink-0 inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Segera Hadir
                                </span>
                            </div>

                            <h3 class="text-xl font-bold text-gray-900 mb-2">
                                Pengajuan Buku Ajar
                            </h3>
                            <p class="text-sm text-gray-600 leading-relaxed mb-4">
                                Fasilitasi penerbitan buku ajar dan monograf ber-ISBN.
                            </p>

                            <div class="flex items-center text-sm font-semibold text-gray-400">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                                <span>Dalam Pengembangan</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Layanan Administrasi Section --}}
            <div class="mb-8">
                <div class="flex items-center space-x-3 mb-6">
                    <div
                        class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center shadow-md">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">
                        Layanan Administrasi
                    </h3>
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">

                    {{-- Surat Tugas Card --}}
                    <a href="{{ route('grants.list') }}"
                        class="group relative bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 border border-indigo-100 overflow-hidden transform hover:-translate-y-1">
                        <div
                            class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-400/20 to-indigo-500/20 rounded-full -translate-y-16 translate-x-16 group-hover:scale-150 transition-transform duration-500">
                        </div>

                        <div class="relative p-6">
                            <div
                                class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300 mb-4">
                                <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>

                            <h3
                                class="text-xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors mb-2">
                                Pengajuan Surat Tugas
                            </h3>
                            <p class="text-sm text-gray-600 leading-relaxed mb-4">
                                Administrasi surat tugas penelitian dan pengabdian masyarakat.
                            </p>

                            <div
                                class="flex items-center text-sm font-semibold text-blue-600 group-hover:text-blue-700">
                                <span>Akses Layanan</span>
                                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </div>
                        </div>

                        <div
                            class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 to-indigo-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300">
                        </div>
                    </a>

                    {{-- Identitas Digital Card --}}
                    <a href="{{ route('setup.security') }}"
                        class="group relative bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 border border-indigo-100 overflow-hidden transform hover:-translate-y-1">
                        <div
                            class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-purple-400/20 to-pink-500/20 rounded-full -translate-y-16 translate-x-16 group-hover:scale-150 transition-transform duration-500">
                        </div>

                        <div class="relative p-6">
                            <div
                                class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300 mb-4">
                                <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>

                            <h3
                                class="text-xl font-bold text-gray-900 group-hover:text-purple-600 transition-colors mb-2">
                                Identitas Digital
                            </h3>
                            <p class="text-sm text-gray-600 leading-relaxed mb-4">
                                Kelola PIN dan Tanda Tangan Digital Anda.
                            </p>

                            <div
                                class="flex items-center text-sm font-semibold text-purple-600 group-hover:text-purple-700">
                                <span>Akses Layanan</span>
                                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </div>
                        </div>

                        <div
                            class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-purple-500 to-pink-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300">
                        </div>
                    </a>

                </div>
            </div>

            {{-- Area Petugas LPPM --}}
            @can('review-hki')
                <div class="mt-10 pt-8 border-t-2 border-gray-200">
                    <div class="flex items-center space-x-3 mb-6">
                        <div
                            class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-gray-700 to-gray-900 rounded-lg flex items-center justify-center shadow-md">
                            <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">
                            Area Petugas LPPM
                        </h3>
                    </div>

                    <a href="{{ route('hki.reviewer.inbox') }}"
                        class="group relative bg-gradient-to-r from-gray-800 to-gray-900 rounded-2xl shadow-2xl hover:shadow-3xl transition-all duration-300 overflow-hidden transform hover:-translate-y-1">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-yellow-400/10 to-amber-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>

                        <div
                            class="relative p-8 flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                            <div class="flex items-center space-x-4">
                                <div
                                    class="flex-shrink-0 w-16 h-16 bg-gradient-to-br from-yellow-400 to-amber-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-8 h-8 text-gray-900" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-xl font-bold text-white mb-1">Reviewer Inbox</h4>
                                    <p class="text-gray-400 text-sm flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Validasi dan review pengajuan masuk
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-400/20 text-yellow-300 border border-yellow-400/30">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                        </path>
                                    </svg>
                                    Akses Khusus
                                </span>
                                <div
                                    class="flex items-center text-white group-hover:text-yellow-400 transition-colors font-semibold">
                                    <span>Buka Inbox</span>
                                    <svg class="w-6 h-6 ml-2 group-hover:translate-x-1 transition-transform" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div
                            class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-yellow-400 to-amber-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300">
                        </div>
                    </a>
                </div>
            @endcan

        </div>
    </main>
</div>