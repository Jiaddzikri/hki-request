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
        class="bg-gradient-to-r from-red-50 to-orange-50 dark:from-red-900/20 dark:to-orange-900/20 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-start gap-3">
          <svg class="w-5 h-5 text-red-600 dark:text-red-400 mt-0.5 flex-shrink-0" fill="currentColor"
            viewBox="0 0 20 20">
            <path fill-rule="evenodd"
              d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
              clip-rule="evenodd" />
          </svg>
          <div class="text-sm">
            <p class="font-semibold text-gray-900 dark:text-white">Akses Admin / Manual Login</p>
            <p class="text-gray-600 dark:text-gray-300 mt-1">Halaman ini digunakan khusus untuk Bypass Login oleh Administrator atau Penguji dengan kredensial manual.</p>
          </div>
        </div>
      </div>

      {{-- Admin Form --}}
      <div class="p-8">
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alamat Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-4 py-2.5 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition">
                @error('email')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password</label>
                <input type="password" id="password" name="password" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-4 py-2.5 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition">
                @error('password')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
            
            @if (config('services.turnstile.site_key'))
                <div class="flex justify-center pt-2">
                    <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.site_key') }}"></div>
                </div>
                @error('cf-turnstile-response')
                    <p class="text-sm text-red-600 dark:text-red-400 block text-center">{{ $message }}</p>
                @enderror
            @endif

            <button type="submit" class="w-full relative flex justify-center items-center gap-2 bg-gradient-to-r from-gray-800 to-gray-900 hover:from-gray-700 hover:to-gray-800 text-white font-medium py-3 px-4 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-gray-500/50">
                Masuk ke Sistem
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </form>

        {{-- Divider --}}
        <div class="mt-8 flex items-center justify-center">
            <a href="{{ route('login') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-500 hover:underline flex items-center gap-1 group transition">
                <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Login SSO
            </a>
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

  @if (config('services.turnstile.site_key'))
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
  @endif
</x-layouts.auth>