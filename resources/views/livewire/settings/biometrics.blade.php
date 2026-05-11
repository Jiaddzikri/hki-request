<section class="w-full">
    @include('partials.settings-heading', [
        'title' => __('Biometrik Terdaftar'),
        'description' => __('Kelola perangkat biometrik yang Anda gunakan untuk tanda tangan digital.'),
    ])

    <div class="mt-6 space-y-4">
        @if (session('status'))
            <div class="p-3 bg-green-50 text-green-700 rounded-lg text-sm border border-green-200">
                {{ session('status') }}
            </div>
        @endif

        @forelse ($credentials as $credential)
            <div class="p-4 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-50 dark:bg-blue-900/30 rounded-full flex items-center justify-center text-blue-600">
                        <flux:icon.finger-print class="w-6 h-6" />
                    </div>
                    <div>
                        <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">
                            {{ $credential->alias ?: 'Perangkat Biometrik' }}
                        </p>
                        <p class="text-xs text-zinc-500">
                            Terdaftar pada {{ $credential->created_at->format('d M Y, H:i') }}
                        </p>
                    </div>
                </div>

                <flux:button variant="danger" size="sm" wire:click="delete('{{ $credential->id }}')" wire:confirm="Apakah Anda yakin ingin menghapus perangkat ini? Tanda tangan digital Anda pada perangkat ini tidak akan bisa digunakan lagi.">
                    Hapus
                </flux:button>
            </div>
        @empty
            <div class="p-8 text-center bg-zinc-50 dark:bg-zinc-900/50 border border-dashed border-zinc-200 dark:border-zinc-800 rounded-xl">
                <p class="text-sm text-zinc-500">Belum ada perangkat biometrik yang terdaftar.</p>
                <flux:button :href="route('setup.security')" variant="primary" class="mt-4">Daftarkan Sekarang</flux:button>
            </div>
        @endforelse

        @if($credentials->count() > 0)
            <div class="mt-8 p-4 bg-orange-50 dark:bg-orange-900/20 border border-orange-100 dark:border-orange-800 rounded-lg">
                <div class="flex gap-3">
                    <flux:icon.information-circle class="w-5 h-5 text-orange-600" />
                    <div>
                        <p class="text-xs font-bold text-orange-800 dark:text-orange-200 uppercase mb-1">Catatan Penting:</p>
                        <p class="text-xs text-orange-700 dark:text-orange-300">
                            Menghapus semua perangkat biometrik akan meriset sistem keamanan Anda. Anda perlu mendaftar ulang untuk dapat melakukan tanda tangan digital kembali.
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
