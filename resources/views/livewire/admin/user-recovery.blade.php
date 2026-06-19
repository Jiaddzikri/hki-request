<div class="max-w-2xl mx-auto py-8">
    <flux:breadcrumbs class="mb-6">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('admin.users') }}">Manajemen Pengguna</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Pemulihan SSS: {{ $targetUser->name }}</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <flux:heading size="xl" class="mb-2">Pemulihan Akun Terpandu (Guided SSS Recovery)</flux:heading>
    <flux:text class="mb-6">Sistem ini memfasilitasi Super Admin untuk melakukan <strong>Hard Reset</strong> pada kredensial WebAuthn milik pengguna. Sesuai prosedur keamanan, Anda diwajibkan untuk memasukkan <strong>Kunci Backup Fisik</strong> (Physical Share) yang tersimpan di brankas institusi.</flux:text>

    @if(!$hasActiveSecret)
        <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-4 rounded-lg flex items-start gap-3">
            <flux:icon.exclamation-triangle class="mt-0.5" />
            <div>
                <strong class="block font-semibold">Tidak Ada Kredensial Aktif</strong>
                <p class="text-sm mt-1">Pengguna <strong>{{ $targetUser->name }}</strong> tidak memiliki Kunci Institusi aktif di database. Ini berarti pengguna tersebut belum mendaftarkan keamanan biometrik, atau akunya sudah di-reset sebelumnya.</p>
                <div class="mt-4">
                    <flux:button href="{{ route('admin.users') }}">Kembali ke Manajemen Pengguna</flux:button>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 shadow-sm p-6 relative overflow-hidden">
            <!-- Decorative Icon -->
            <div class="absolute -right-6 -top-6 text-zinc-100 dark:text-zinc-800/50">
                <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C9.243 2 7 4.243 7 7v3H6a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2v-8a2 2 0 00-2-2h-1V7c0-2.757-2.243-5-5-5zM9 7c0-1.654 1.346-3 3-3s3 1.346 3 3v3H9V7zm4 10.723V20h-2v-2.277a1.993 1.993 0 01.5-3.608 2 2 0 011.5 3.608z"/></svg>
            </div>

            <div class="relative z-10">
                <div class="mb-6">
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                        Target Pemulihan: <span class="text-red-600">{{ $targetUser->name }}</span>
                    </h3>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Status Kunci Institusi (DB): <span class="text-green-600 font-semibold">Tersedia (Pecahan 2)</span></p>
                </div>

                @error('recovery')
                    <div class="mb-6 p-3 bg-red-50 text-red-700 rounded-lg text-sm border border-red-200 flex items-start gap-2">
                        <flux:icon.x-circle class="w-5 h-5 shrink-0" />
                        <span>{{ $message }}</span>
                    </div>
                @enderror

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">
                            Masukkan Kunci Backup Fisik (Share 3 / Physical Share)
                        </label>
                        <p class="text-xs text-zinc-500 mb-2">Kunci ini seharusnya berbentuk teks heksadesimal panjang yang diambil dari brankas Dekan/Rektor.</p>
                        <textarea id="physical-share-input" rows="4" class="w-full rounded-md border-zinc-300 shadow-sm focus:border-red-500 focus:ring-red-500 dark:bg-zinc-900 dark:border-zinc-700 dark:text-white sm:text-sm font-mono text-xs p-3" placeholder="Masukkan hex string..."></textarea>
                    </div>
                    
                    <!-- Hidden Institutional Share -->
                    <input type="hidden" id="institutional-share" value="{{ $institutionalShare }}">

                    <div class="pt-4 border-t border-zinc-100 dark:border-zinc-700">
                        <button type="button" id="btn-reconstruct" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                            <flux:icon.lock-open class="w-4 h-4 mr-2" />
                            Kalkulasi Matematika SSS & Reset Akun
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnReconstruct = document.getElementById('btn-reconstruct');
            
            if(btnReconstruct) {
                btnReconstruct.addEventListener('click', async function() {
                    const physicalShare = document.getElementById('physical-share-input').value.trim();
                    const institutionalShare = document.getElementById('institutional-share').value.trim();
                    
                    if (!physicalShare) {
                        alert('Harap masukkan Kunci Backup Fisik terlebih dahulu.');
                        return;
                    }
                    
                    try {
                        btnReconstruct.innerHTML = '<span class="animate-pulse">Menghitung Interpolasi Lagrange...</span>';
                        btnReconstruct.disabled = true;

                        // Wait for secrets library to load from bundle
                        const getSecrets = () => {
                            return new Promise((resolve, reject) => {
                                if (typeof secrets !== 'undefined') return resolve(secrets);
                                let attempts = 0;
                                const interval = setInterval(() => {
                                    attempts++;
                                    if (typeof secrets !== 'undefined') {
                                        clearInterval(interval);
                                        resolve(secrets);
                                    }
                                    if (attempts > 50) {
                                        clearInterval(interval);
                                        reject('Library keamanan (secrets.js) tidak ditemukan.');
                                    }
                                }, 100);
                            });
                        };

                        const secretsLib = await getSecrets();
                        
                        // RECONSTRUCTION: Combine the Physical Share + Institutional Share
                        // The user's HP (Share 1) is lost, so we rely on Share 2 + Share 3.
                        // Since threshold t=2, providing 2 shares will successfully rebuild the Master Secret.
                        const reconstructedHex = secretsLib.combine([physicalShare, institutionalShare]);
                        
                        // Hash the reconstructed secret to send to the server (Zero-Knowledge)
                        const hashBuffer = await crypto.subtle.digest('SHA-256', new TextEncoder().encode(reconstructedHex));
                        const hashArray = Array.from(new Uint8Array(hashBuffer));
                        const secretHash = hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
                        
                        // Send to Livewire component
                        @this.verifyAndReset(secretHash);
                        
                    } catch (error) {
                        btnReconstruct.innerHTML = 'Kalkulasi Matematika SSS & Reset Akun';
                        btnReconstruct.disabled = false;
                        
                        // If it throws an error (e.g. invalid share length), catch it gracefully
                        alert('Gagal merekonstruksi kunci: ' + error);
                        console.error(error);
                    }
                });
            }
        });
    </script>
</div>
