<div class="flex flex-col items-center justify-center min-h-screen bg-zinc-50 dark:bg-zinc-900 p-6">
    <div class="w-full max-w-md">

        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">
                Setup Keamanan Forensik
            </h1>
            <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">
                Demi standar <strong>Non-Repudiation</strong>, Anda wajib membuat 6-digit PIN untuk mengamankan Tanda
                Tangan Digital Anda.
            </p>
        </div>

        <div class="bg-whie dark:bg-zinc-800 rounded-xl shadow-xl border border-zinc-200 dark:border-zinc-700 p-6">
            <form wire:submit="save" class="relative w-full space-y-6">
                <flux:field>
                    <flux:input wire:model="pin" type="password" label="Buat 6-Digit PIN" placeholder="123456"
                        mask="999999" description="PIN ini hanya diketahui oleh Anda. Admin tidak bisa meresetnya."
                        required />

                </flux:field>

                <flux:input wire:model="pin_confirmation" type="password" label="Konfirmasi PIN"
                    placeholder="Ulangi PIN" required />

                <div class="pt-2">
                    <flux:button variant="primary" type="submit" class="w-full" wire:loading.attr="disabled">
                        <span wire:loading.remove>Generate Secure Identity &rarr;</span>
                        <span wire:loading>Sedang Mengenkripsi Kunci...</span>
                    </flux:button>
                </div>

                @error('pin')
                    <div class="text-red-500 text-sm text-center font-medium">
                        {{ $message }}
                    </div>
                @enderror
            </form>
        </div>

        <div class="mt-6 text-center text-xs text-zinc-400">
            <p>RSA-2048 Encryption • AES-256-CBC Protection</p>
        </div>
    </div>
</div>