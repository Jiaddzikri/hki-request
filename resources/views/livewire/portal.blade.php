<div class="min-h-screen bg-gray-50">
  {{-- Header Section --}}
  <div class="bg-white border-b-2 border-blue-800 shadow-sm">
    <header class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
      <div class="flex items-center space-x-4">
        <div class="flex-shrink-0 w-16 h-16 bg-blue-800 rounded-lg flex items-center justify-center">
          <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
            </path>
          </svg>
        </div>
        <div>
          <h1 class="text-2xl font-bold text-gray-900">
            Portal Layanan LPPM
          </h1>
          <p class="mt-1 text-gray-600 text-sm">
            Sistem Terintegrasi Penelitian & Pengabdian Masyarakat
          </p>
        </div>
      </div>
    </header>
  </div>

  <main class="page-container py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

      {{-- Welcome Card --}}
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-8">
        <div class="px-6 py-5 border-b border-gray-200">
          <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div class="flex items-center space-x-4">
              <div
                class="flex-shrink-0 w-12 h-12 bg-blue-800 rounded-full flex items-center justify-center text-white font-bold text-lg">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
              </div>
              <div>
                <h2 class="text-lg font-bold text-gray-900">
                  Halo, {{ auth()->user()->name }}
                </h2>
                <p class="text-gray-600 text-sm mt-1">
                  NIDN/NIP: <span class="font-semibold">{{ auth()->user()->nidn ?? '-' }}</span>
                </p>
              </div>
            </div>
            <div class="flex-shrink-0">
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                  class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md font-medium text-sm hover:bg-red-700 transition-colors">
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
          <div class="flex-shrink-0 w-10 h-10 bg-blue-800 rounded-md flex items-center justify-center">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
              </path>
            </svg>
          </div>
          <h3 class="text-xl font-bold text-gray-900">
            Sentra Kekayaan Intelektual & Publikasi
          </h3>
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">

          {{-- HKI Card --}}
          <a href="{{ route('hki.dashboard') }}"
            class="group bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow border border-gray-200 overflow-hidden">
            <div class="p-6">
              <div class="flex items-start justify-between mb-4">
                <div
                  class="flex-shrink-0 w-12 h-12 bg-blue-800 rounded-md flex items-center justify-center group-hover:bg-blue-900 transition-colors">
                  <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                  </svg>
                </div>
                <span
                  class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800 border border-green-200">
                  Aktif
                </span>
              </div>

              <h3 class="text-lg font-bold text-gray-900 mb-2">
                Pengajuan HKI
              </h3>
              <p class="text-sm text-gray-600 leading-relaxed mb-4">
                Pendaftaran Hak Cipta & Paten dengan tanda tangan digital berbasis Forensik.
              </p>

              <div class="flex items-center text-sm font-semibold text-blue-800 group-hover:text-blue-900">
                <span>Akses Layanan</span>
                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none"
                  stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6">
                  </path>
                </svg>
              </div>
            </div>
            <div class="h-1 bg-blue-800 transform scale-x-0 group-hover:scale-x-100 transition-transform"></div>
          </a>

          {{-- Buku Ajar Card --}}
          <a href="{{ route('book.index') }}"
            class="group bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow border border-gray-200 overflow-hidden">
            <div class="p-6">
              <div class="flex items-start justify-between mb-4">
                <div
                  class="flex-shrink-0 w-12 h-12 bg-blue-800 rounded-md flex items-center justify-center group-hover:bg-blue-900 transition-colors">
                  <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                  </svg>
                </div>
                <span
                  class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800 border border-green-200">
                  Aktif
                </span>
              </div>

              <h3 class="text-lg font-bold text-gray-900 mb-2">
                Permohonan ISBN
              </h3>
              <p class="text-sm text-gray-600 leading-relaxed mb-4">
                Fasilitasi permohonan ISBN untuk terbitan buku ajar, monograf, dan karya ilmiah lainnya.
              </p>

              <div class="flex items-center text-sm font-semibold text-blue-800 group-hover:text-blue-900">
                <span>Akses Layanan</span>
                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none"
                  stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6">
                  </path>
                </svg>
              </div>
            </div>
            <div class="h-1 bg-blue-800 transform scale-x-0 group-hover:scale-x-100 transition-transform"></div>
          </a>

        </div>
      </div>

      {{-- Layanan Administrasi Section --}}
      <div class="mb-8">
        <div class="flex items-center space-x-3 mb-6">
          <div class="flex-shrink-0 w-10 h-10 bg-blue-800 rounded-md flex items-center justify-center">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
              </path>
            </svg>
          </div>
          <h3 class="text-xl font-bold text-gray-900">
            Layanan Administrasi
          </h3>
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">

          {{-- Surat Tugas Card --}}
          <a href="{{ route('letter.index') }}"
            class="group bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow border border-gray-200 overflow-hidden">
            <div class="p-6">
              <div
                class="flex-shrink-0 w-12 h-12 bg-blue-800 rounded-md flex items-center justify-center group-hover:bg-blue-900 transition-colors mb-4">
                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
              </div>

              <h3 class="text-lg font-bold text-gray-900 mb-2">
                Pengajuan Surat Tugas
              </h3>
              <p class="text-sm text-gray-600 leading-relaxed mb-4">
                Administrasi surat tugas penelitian dan pengabdian masyarakat.
              </p>

              <div class="flex items-center text-sm font-semibold text-blue-800 group-hover:text-blue-900">
                <span>Akses Layanan</span>
                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none"
                  stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6">
                  </path>
                </svg>
              </div>
            </div>
            <div class="h-1 bg-blue-800 transform scale-x-0 group-hover:scale-x-100 transition-transform"></div>
          </a>

          {{-- Identitas Digital Card --}}
          <a href="{{ route('setup.security') }}"
            class="group bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow border border-gray-200 overflow-hidden">
            <div class="p-6">
              <div
                class="flex-shrink-0 w-12 h-12 bg-blue-800 rounded-md flex items-center justify-center group-hover:bg-blue-900 transition-colors mb-4">
                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
              </div>

              <h3 class="text-lg font-bold text-gray-900 mb-2">
                Identitas Digital
              </h3>
              <p class="text-sm text-gray-600 leading-relaxed mb-4">
                Kelola PIN dan Tanda Tangan Digital Anda.
              </p>

              <div class="flex items-center text-sm font-semibold text-blue-800 group-hover:text-blue-900">
                <span>Akses Layanan</span>
                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none"
                  stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6">
                  </path>
                </svg>
              </div>
            </div>
            <div class="h-1 bg-blue-800 transform scale-x-0 group-hover:scale-x-100 transition-transform"></div>
          </a>

        </div>
      </div>

      {{-- Area Petugas LPPM --}}
      @can('review-hki')
        <div class="mt-10 pt-8 border-t-2 border-gray-200">
          <div class="flex items-center space-x-3 mb-6">
            <div class="flex-shrink-0 w-10 h-10 bg-green-700 rounded-md flex items-center justify-center">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4">
                </path>
              </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900">
              Area Petugas LPPM
            </h3>
          </div>

          <a href="{{ route('hki.reviewer.inbox') }}"
            class="group bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow border-l-4 border-green-700 overflow-hidden">
            <div class="p-6 flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
              <div class="flex items-center space-x-4">
                <div
                  class="flex-shrink-0 w-14 h-14 bg-green-700 rounded-md flex items-center justify-center group-hover:bg-green-800 transition-colors">
                  <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                    </path>
                  </svg>
                </div>
                <div>
                  <h4 class="text-lg font-bold text-gray-900 mb-1">Reviewer Inbox</h4>
                  <p class="text-gray-600 text-sm">
                    Validasi dan review pengajuan masuk
                  </p>
                </div>
              </div>
              <div class="flex items-center space-x-3">
                <span
                  class="inline-flex items-center px-3 py-1 rounded-md text-xs font-semibold bg-green-100 text-green-800 border border-green-200">
                  Akses Khusus
                </span>
                <div class="flex items-center text-green-700 group-hover:text-green-800 font-semibold">
                  <span>Buka Inbox</span>
                  <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6">
                    </path>
                  </svg>
                </div>
              </div>
            </div>
          </a>
        </div>
      @endcan

      {{-- Admin Panel Section - Super Admin Only --}}
      @role('super-admin')
      <div class="mt-10 pt-8 border-t-2 border-gray-200">
        <div class="flex items-center space-x-3 mb-6">
          <div class="flex-shrink-0 w-10 h-10 bg-red-600 rounded-md flex items-center justify-center">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
              </path>
            </svg>
          </div>
          <h3 class="text-xl font-bold text-gray-900">
            Admin Panel
          </h3>
          <span
            class="inline-flex items-center px-3 py-1 rounded-md text-xs font-bold bg-red-100 text-red-800 border border-red-200">
            Super Admin Only
          </span>
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
          {{-- User Management --}}
          <a href="{{ route('admin.users') }}"
            class="group bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow border-l-4 border-red-600 overflow-hidden">
            <div class="p-6">
              <div
                class="flex-shrink-0 w-12 h-12 bg-red-600 rounded-md flex items-center justify-center group-hover:bg-red-700 transition-colors mb-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                  </path>
                </svg>
              </div>

              <h4 class="text-lg font-bold text-gray-900 mb-2">Manajemen User</h4>
              <p class="text-gray-600 text-sm leading-relaxed mb-4">
                Kelola akun pengguna sistem LPPM
              </p>

              <div class="flex items-center text-red-600 group-hover:text-red-700 font-semibold">
                <span>Kelola User</span>
                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none"
                  stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6">
                  </path>
                </svg>
              </div>
            </div>
          </a>

          {{-- Role Management --}}
          <a href="{{ route('admin.roles') }}"
            class="group bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow border-l-4 border-blue-800 overflow-hidden">
            <div class="p-6">
              <div
                class="flex-shrink-0 w-12 h-12 bg-blue-800 rounded-md flex items-center justify-center group-hover:bg-blue-900 transition-colors mb-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                  </path>
                </svg>
              </div>

              <h4 class="text-lg font-bold text-gray-900 mb-2">Manajemen Role</h4>
              <p class="text-gray-600 text-sm leading-relaxed mb-4">
                Atur role dan permission user
              </p>

              <div class="flex items-center text-blue-800 group-hover:text-blue-900 font-semibold">
                <span>Kelola Role</span>
                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none"
                  stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6">
                  </path>
                </svg>
              </div>
            </div>
          </a>
        </div>
      </div>
      @endrole

    </div>
  </main>
</div>