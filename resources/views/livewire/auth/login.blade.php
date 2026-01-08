<x-layouts.auth>
  <div class="flex flex-col gap-8">
    {{-- Header dengan Icon ISBN --}}


    <x-auth-session-status class="text-center" :status="session('status')" />

    @if (session('error'))
      <div
        class="p-4 text-sm text-center text-red-600 bg-red-50 rounded-xl border-l-4 border-red-500 dark:bg-red-900/20 dark:border-red-600 dark:text-red-300">
        <div class="flex items-center justify-center gap-2">
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
              d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
              clip-rule="evenodd" />
          </svg>
          <span class="font-medium">{{ session('error') }}</span>
        </div>
      </div>
    @endif

    {{-- Login Card --}}
    <div
      class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
      {{-- Info Badge --}}
      <div
        class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-start gap-3">
          <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 flex-shrink-0" fill="currentColor"
            viewBox="0 0 20 20">
            <path fill-rule="evenodd"
              d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
              clip-rule="evenodd" />
          </svg>
          <div class="text-sm">
            <p class="font-semibold text-gray-900 dark:text-white">Akses Terbatas</p>
            <p class="text-gray-600 dark:text-gray-300 mt-1">Gunakan email institusi <span
                class="font-mono text-blue-600 dark:text-blue-400">@unsap.ac.id</span></p>
          </div>
        </div>
      </div>

      {{-- Login Button --}}
      <div class="p-8">
        <a href="{{ route('auth.google') }}"
          class="group relative flex w-full justify-center items-center gap-3 rounded-xl bg-white dark:bg-gray-900 border-2 border-gray-300 dark:border-gray-600 px-6 py-4 text-base font-semibold text-gray-900 dark:text-white shadow-lg hover:shadow-xl hover:border-blue-500 dark:hover:border-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-500/50 transition-all duration-300 hover:-translate-y-0.5">
          {{-- Google Icon --}}
          <svg class="w-6 h-6 transition-transform group-hover:scale-110" viewBox="0 0 24 24">
            <path
              d="M12.48 10.92v3.28h7.84c-.24 1.84-.853 3.187-1.787 4.133-1.147 1.147-2.933 2.4-6.053 2.4-4.827 0-8.6-3.893-8.6-8.72s3.773-8.72 8.6-8.72c2.6 0 4.507 1.027 5.907 2.347l2.307-2.307C18.747 1.44 16.133 0 12.48 0 5.867 0 .533 5.333.533 12S5.867 24 12.48 24c3.44 0 6.013-1.133 8.053-3.24 2.08-2.12 2.707-5.453 2.707-8.293 0-.587-.067-1.147-.187-1.547h-10.56z"
              fill="#4285F4" />
          </svg>
          <span
            class="bg-gradient-to-r from-gray-900 to-gray-700 dark:from-white dark:to-gray-200 bg-clip-text text-transparent">
            Masuk dengan Google Workspace
          </span>
          <svg
            class="w-5 h-5 text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-all group-hover:translate-x-1"
            fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
          </svg>
        </a>

        {{-- Security Info --}}
        <div class="mt-6 flex items-center justify-center gap-2 text-sm text-gray-500 dark:text-gray-400">
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
              d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
              clip-rule="evenodd" />
          </svg>
          <span>Autentikasi Aman dengan OAuth 2.0 + PIN</span>
        </div>
      </div>
    </div>

    {{-- Footer Info --}}
    <div class="text-center space-y-3">
      <div class="flex items-center justify-center gap-6 text-sm text-gray-600 dark:text-gray-400">
        <div class="flex items-center gap-2">
          <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
              d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
              clip-rule="evenodd" />
          </svg>
          <span>Dosen</span>
        </div>
        <div class="flex items-center gap-2">
          <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
              d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
              clip-rule="evenodd" />
          </svg>
          <span>Staff Akademik</span>
        </div>
        <div class="flex items-center gap-2">
          <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
              d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
              clip-rule="evenodd" />
          </svg>
          <span>Reviewer</span>
        </div>
      </div>

      <p class="text-xs text-gray-500 dark:text-gray-400">
        Mengalami kendala? Hubungi <a href="mailto:hki@unsap.ac.id"
          class="text-blue-600 dark:text-blue-400 hover:underline font-medium">Sentra HKI</a>
      </p>
    </div>
  </div>
</x-layouts.auth>