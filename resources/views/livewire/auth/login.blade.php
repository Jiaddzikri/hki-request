<x-layouts.auth>
    <div class="flex flex-col gap-6">
        <x-auth-header 
            :title="__('Permohonan Pengajuan HKI')" 
            :description="__('Silakan masuk menggunakan akun Google Workspace institusi (@unsap.ac.id).')" 
        />

        <x-auth-session-status class="text-center" :status="session('status')" />
        
        @if (session('error'))
            <div class="p-4 text-sm text-center text-red-600 bg-red-50 rounded-lg border border-red-200 dark:bg-red-900/20 dark:border-red-800 dark:text-red-400">
                {{ session('error') }}
            </div>
        @endif

        <div class="flex flex-col gap-4">
            <a href="{{ route('auth.google') }}" class="group relative flex w-full justify-center rounded-lg border border-zinc-200 bg-white py-3 text-sm font-medium text-zinc-900 shadow-sm hover:bg-zinc-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-100 dark:hover:bg-zinc-700 transition-all duration-200">
                <span class="flex items-center gap-3">
                    <svg class="h-5 w-5" aria-hidden="true" viewBox="0 0 24 24">
                        <path d="M12.48 10.92v3.28h7.84c-.24 1.84-.853 3.187-1.787 4.133-1.147 1.147-2.933 2.4-6.053 2.4-4.827 0-8.6-3.893-8.6-8.72s3.773-8.72 8.6-8.72c2.6 0 4.507 1.027 5.907 2.347l2.307-2.307C18.747 1.44 16.133 0 12.48 0 5.867 0 .533 5.333.533 12S5.867 24 12.48 24c3.44 0 6.013-1.133 8.053-3.24 2.08-2.12 2.707-5.453 2.707-8.293 0-.587-.067-1.147-.187-1.547h-10.56z" fill="currentColor" />
                    </svg>
                    <span >Masuk dengan Google Workspace</span>
                </span>
            </a>
        </div>

        <div class="text-xs text-center text-zinc-500 dark:text-zinc-400 mt-4">
            <p>Akses terbatas hanya untuk Dosen & Staff terdaftar.</p>
            <p>Jika mengalami kendala akses, hubungi Sentra HKI.</p>
        </div>
    </div>
</x-layouts.auth>