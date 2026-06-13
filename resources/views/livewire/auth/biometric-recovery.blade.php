<div class="max-w-md mx-auto py-12">
    <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-xl border border-zinc-200 dark:border-zinc-700 p-6">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-red-100 dark:bg-red-900/50 rounded-full flex items-center justify-center mx-auto mb-4 text-red-600 dark:text-red-400">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-zinc-900 dark:text-white">Pemulihan Biometrik (SSS)</h2>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-2">
                Masukkan <strong>Kunci Pribadi</strong> Anda untuk menggabungkannya dengan <strong>Kunci Institusi</strong> dan memulihkan akses akun.
            </p>
        </div>

        @if (session('error'))
            <div class="mb-4 p-3 bg-red-50 text-red-700 rounded-lg text-sm border border-red-200">
                {{ session('error') }}
            </div>
        @endif

        @error('recovery')
            <div class="mb-4 p-3 bg-red-50 text-red-700 rounded-lg text-sm border border-red-200">
                {{ $message }}
            </div>
        @enderror

        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Kunci Pribadi Anda (Share 1)</label>
                <textarea id="user-share-input" rows="4" class="w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-zinc-900 dark:border-zinc-700 dark:text-white sm:text-sm font-mono text-xs p-3" placeholder="Masukkan hex string rahasia Anda..."></textarea>
            </div>
            
            <input type="hidden" id="institutional-share" value="{{ $this->institutional_share }}">

            <div class="pt-4">
                <button type="button" id="btn-reconstruct" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Rekonstruksi & Reset Akses
                </button>
            </div>
            
            <div class="text-center mt-4">
                <a href="{{ route('dashboard') }}" class="text-sm text-blue-600 hover:text-blue-500">Kembali ke Dashboard</a>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnReconstruct = document.getElementById('btn-reconstruct');
            
            btnReconstruct.addEventListener('click', async function() {
                const userShare = document.getElementById('user-share-input').value.trim();
                const institutionalShare = document.getElementById('institutional-share').value.trim();
                
                if (!userShare) {
                    alert('Harap masukkan Kunci Pribadi Anda.');
                    return;
                }
                
                try {
                    btnReconstruct.innerText = 'Merekontruksi Kunci...';
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
                    
                    // Reconstruct the secret using the 2 shares
                    const reconstructedHex = secretsLib.combine([userShare, institutionalShare]);
                    
                    // Hash the reconstructed secret to send to the server (Server Blindness)
                    const hashBuffer = await crypto.subtle.digest('SHA-256', new TextEncoder().encode(reconstructedHex));
                    const hashArray = Array.from(new Uint8Array(hashBuffer));
                    const secretHash = hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
                    
                    // Send to Livewire component
                    @this.verifyReconstructedSecret(secretHash);
                    
                } catch (error) {
                    btnReconstruct.innerText = 'Rekonstruksi & Reset Akses';
                    btnReconstruct.disabled = false;
                    alert('Gagal: ' + error);
                    console.error(error);
                }
            });
        });
    </script>
</div>
