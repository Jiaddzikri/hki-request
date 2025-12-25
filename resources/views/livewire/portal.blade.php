<div class="min-h-screen bg-gray-50">
    <div class="bg-indigo-900 pb-32">
        <header class="py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-extrabold text-white tracking-tight">
                    Portal Layanan LPPM
                </h1>
                <p class="mt-1 text-indigo-200">
                    Sistem Terintegrasi Penelitian & Pengabdian Masyarakat
                </p>
            </div>
        </header>
    </div>

    <main class="-mt-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">

            <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8 p-6 flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Halo, {{ auth()->user()->name }}! 👋</h2>
                    <p class="text-gray-500 text-sm">NIDN/NIP: {{ auth()->user()->nidn ?? '-' }} | Kelola semua
                        aktivitas akademik Anda di sini.</p>
                </div>
                <div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800">
                            Logout
                        </button>
                    </form>
                </div>
            </div>

            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                    </path>
                </svg>
                Sentra Kekayaan Intelektual & Publikasi
            </h3>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3 mb-10">

                <a href="{{ route('hki.dashboard') }}"
                    class="relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500 rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 border border-indigo-100 cursor-pointer">
                    <div>
                        <span
                            class="rounded-lg inline-flex p-3 bg-indigo-50 text-indigo-700 ring-4 ring-white group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </span>
                    </div>
                    <div class="mt-4">
                        <h3 class="text-lg font-bold text-gray-900 group-hover:text-indigo-600">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            Pengajuan HKI
                        </h3>
                        <p class="mt-2 text-sm text-gray-500">
                            Pendaftaran Hak Cipta & Paten dengan tanda tangan digital berbasis Forensik.
                        </p>
                    </div>
                    <span class="absolute top-4 right-4 pointer-events-none text-gray-300 group-hover:text-indigo-400">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
                        </svg>
                    </span>
                </a>

                <div
                    class="relative group bg-white p-6 rounded-xl shadow-sm border border-gray-200 opacity-75 hover:opacity-100 transition-opacity">
                    <div>
                        <span class="rounded-lg inline-flex p-3 bg-teal-50 text-teal-700 ring-4 ring-white">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </span>
                    </div>
                    <div class="mt-4">
                        <h3 class="text-lg font-bold text-gray-900">
                            Pengajuan Buku Ajar
                        </h3>
                        <p class="mt-2 text-sm text-gray-500">
                            Fasilitasi penerbitan buku ajar dan monograf ber-ISBN.
                        </p>
                        <span
                            class="mt-3 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            Segera Hadir
                        </span>
                    </div>
                </div>

            </div>

            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                    </path>
                </svg>
                Layanan Administrasi
            </h3>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">

                <a href="#"
                    class="relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-200 cursor-pointer">
                    <div>
                        <span
                            class="rounded-lg inline-flex p-3 bg-blue-50 text-blue-700 ring-4 ring-white group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </span>
                    </div>
                    <div class="mt-4">
                        <h3 class="text-lg font-bold text-gray-900 group-hover:text-blue-600">
                            Pengajuan Surat Tugas
                        </h3>
                        <p class="mt-2 text-sm text-gray-500">
                            Administrasi surat tugas penelitian dan pengabdian masyarakat.
                        </p>
                    </div>
                </a>

                <a href="{{ route('setup.security') }}"
                    class="relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-200 cursor-pointer">
                    <div>
                        <span
                            class="rounded-lg inline-flex p-3 bg-purple-50 text-purple-700 ring-4 ring-white group-hover:bg-purple-600 group-hover:text-white transition-colors">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </span>
                    </div>
                    <div class="mt-4">
                        <h3 class="text-lg font-bold text-gray-900 group-hover:text-purple-600">
                            Identitas Digital
                        </h3>
                        <p class="mt-2 text-sm text-gray-500">
                            Kelola PIN dan Tanda Tangan Digital Anda.
                        </p>
                    </div>
                </a>

            </div>

            @can('review-hki')
                <div class="mt-10 border-t border-gray-200 pt-8">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4">
                            </path>
                        </svg>
                        Area Petugas LPPM
                    </h3>
                    <a href="{{ route('hki.reviewer.inbox') }}"
                        class=" bg-gray-900 rounded-lg shadow-lg hover:bg-gray-800 transition p-6 flex items-center justify-between group cursor-pointer">
                        <div class="flex items-center">
                            <div
                                class="h-12 w-12 bg-gray-700 rounded-lg flex items-center justify-center text-yellow-400 mr-4">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-white">Reviewer Inbox</h4>
                                <p class="text-gray-400 text-sm">Validasi pengajuan masuk.</p>
                            </div>
                        </div>
                        <div>
                            <span class="text-gray-400 group-hover:text-white transition">Akses &rarr;</span>
                        </div>
                    </a>
                </div>
            @endcan

        </div>
    </main>
</div>