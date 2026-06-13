<div class="flex flex-col items-center justify-center min-h-screen bg-zinc-50 dark:bg-zinc-900 p-6">
    <div class="w-full max-w-md">

        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">
                Setup Keamanan Biometrik
            </h1>
            <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">
                Demi standar <strong>Non-Repudiation</strong>, Anda wajib mendaftarkan identitas biometrik (sidik jari/wajah) untuk mengamankan Tanda Tangan Digital Anda.
            </p>
            <p class="mt-1 text-xs text-zinc-500">
                Jika perangkat ini tidak memiliki sensor, Anda dapat menggunakan <strong>Smartphone (QR Code)</strong> saat diminta oleh browser.
            </p>
        </div>

        <!-- Load Secrets.js for Shamir's Secret Sharing -->


        <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-xl border border-zinc-200 dark:border-zinc-700 p-6">
            @if(!$registered)
                <div class="space-y-6">
                    <div class="p-4 bg-blue-50 dark:bg-blue-900/30 rounded-lg border border-blue-200 dark:border-blue-800">
                        <div class="flex gap-3">
                            <flux:icon.shield-check class="text-blue-600 dark:text-blue-400" />
                            <div class="text-sm text-blue-800 dark:text-blue-200">
                                <strong>Keamanan Tinggi:</strong> Kunci biometrik Anda akan disimpan secara aman di hardware perangkat Anda dan tidak pernah dikirim ke server.
                            </div>
                        </div>
                    </div>

                    <div class="pt-2 grid grid-cols-1 md:grid-cols-2 gap-3">
                        <flux:button variant="primary" class="w-full" wire:click="registerOptions('platform')" wire:loading.attr="disabled">
                            <span wire:loading.remove>Perangkat Ini &rarr;</span>
                            <span wire:loading>Menyiapkan...</span>
                        </flux:button>
                        
                        <flux:button variant="outline" class="w-full" wire:click="registerOptions('cross-platform')" wire:loading.attr="disabled">
                            <span wire:loading.remove>Gunakan HP (QR Code) &rarr;</span>
                            <span wire:loading>Menyiapkan...</span>
                        </flux:button>
                    </div>

                    @error('registration')
                        <div class="text-red-500 text-sm text-center font-medium">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            @else
                <div class="space-y-6 text-center">
                    <div class="flex flex-col items-center gap-4 py-4">
                        <div class="w-16 h-16 bg-green-100 dark:bg-green-900/50 rounded-full flex items-center justify-center text-green-600 dark:text-green-400">
                            <flux:icon.check-circle class="w-10 h-10" />
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-zinc-900 dark:text-zinc-100">Berhasil Terdaftar!</h2>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400">Identitas biometrik Anda sekarang aktif.</p>
                        </div>
                    </div>

                    <div class="p-4 bg-red-50 dark:bg-red-900/30 rounded-lg border border-red-200 dark:border-red-800 text-left">
                        <p class="text-xs font-bold text-red-800 dark:text-red-200 uppercase mb-2">SIMPAN KUNCI PEMULIHAN INI (SANGAT RAHASIA):</p>
                        <p class="text-[10px] text-red-700 dark:text-red-300 mb-2">
                            Sistem ini menggunakan <strong>Shamir's Secret Sharing</strong>. Anda wajib menyimpan KUNCI PRIBADI Anda, dan mencetak KUNCI FAKULTAS untuk diserahkan ke Fakultas/Pusat TI secara fisik.
                        </p>
                        
                        <div class="mb-3">
                            <span class="text-[10px] font-bold text-red-800">1. KUNCI PRIBADI ANDA (Simpan di tempat aman/password manager):</span>
                            <div class="mt-1 p-2 bg-white dark:bg-zinc-900 border border-red-300 rounded">
                                <code id="user-share-display" class="text-xs font-mono break-all text-red-600">Memproses...</code>
                            </div>
                        </div>

                        <div>
                            <span class="text-[10px] font-bold text-red-800">2. KUNCI FAKULTAS/TI (Cetak dan berikan ke Admin TI secara fisik):</span>
                            <div class="mt-1 p-2 bg-white dark:bg-zinc-900 border border-red-300 rounded">
                                <code id="physical-share-display" class="text-xs font-mono break-all text-red-600">Memproses...</code>
                            </div>
                        </div>
                        
                        <p class="mt-3 text-[10px] text-red-700 font-semibold bg-red-100 p-2 rounded">
                            PERINGATAN: Server tidak pernah menyimpan Kunci Rahasia Anda! Jika Anda kehilangan Kunci Pribadi ini, akun biometrik Anda tidak bisa dipulihkan.
                        </p>
                    </div>

                    <flux:button variant="primary" class="w-full" wire:click="finish">
                        Masuk ke Dashboard &rarr;
                    </flux:button>
                </div>
            @endif
        </div>

        <div class="mt-6 text-center text-xs text-zinc-400">
            <p>FIDO2/WebAuthn Protocol • Hardware-backed Security</p>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:init', () => {
            const base64ToBuffer = (base64) => {
                const binary_string = window.atob(base64.replace(/-/g, '+').replace(/_/g, '/').padEnd(base64.length + (4 - base64.length % 4) % 4, '='));
                const len = binary_string.length;
                const bytes = new Uint8Array(len);
                for (let i = 0; i < len; i++) { bytes[i] = binary_string.charCodeAt(i); }
                return bytes.buffer;
            };

            const bufferToBase64 = (buffer) => {
                const bytes = new Uint8Array(buffer);
                let binary = '';
                for (let i = 0; i < bytes.byteLength; i++) { binary += String.fromCharCode(bytes[i]); }
                return window.btoa(binary).replace(/\+/g, '-').replace(/\//g, '_').replace(/=/g, '');
            };

            Livewire.on('webauthn-register', ({ options, attachment }) => {
                // Parse options if stringified
                let opts = options;
                if (typeof opts === 'string') opts = JSON.parse(opts);
                
                // Handle Laragear wrapping
                if (opts.publicKey) opts = opts.publicKey;

                // Prepare options for navigator.credentials.create
                const publicKey = {
                    ...opts,
                    challenge: base64ToBuffer(opts.challenge),
                    user: {
                        ...opts.user,
                        id: base64ToBuffer(opts.user.id)
                    },
                    excludeCredentials: (opts.excludeCredentials || []).map(cred => ({
                        ...cred,
                        id: base64ToBuffer(cred.id)
                    }))
                };
                
                // Explicitly set the authenticator attachment based on user selection
                if (attachment) {
                    publicKey.authenticatorSelection = publicKey.authenticatorSelection || {};
                    publicKey.authenticatorSelection.authenticatorAttachment = attachment;
                }

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

                getSecrets().then(secretsLib => {
                    navigator.credentials.create({ publicKey })
                        .then(credential => {
                            const attestation = {
                                id: credential.id,
                                rawId: bufferToBase64(credential.rawId),
                                type: credential.type,
                                response: {
                                    attestationObject: bufferToBase64(credential.response.attestationObject),
                                    clientDataJSON: bufferToBase64(credential.response.clientDataJSON),
                                }
                            };
                            
                            // Generate SSS Shares
                            const masterSecret = secretsLib.random(256); // 256-bit random hex string
                            // Split into 3 shares, requires 2 to reconstruct
                            const shares = secretsLib.share(masterSecret, 3, 2); 
                            
                            const userShare = shares[0];
                            const institutionalShare = shares[1];
                            const physicalShare = shares[2];

                            // Simple SHA-256 hash of the master secret for the server to verify later
                            crypto.subtle.digest('SHA-256', new TextEncoder().encode(masterSecret)).then(hashBuffer => {
                                const hashArray = Array.from(new Uint8Array(hashBuffer));
                                const secretHash = hashArray.map(b => b.toString(16).padStart(2, '0')).join('');

                                @this.completeRegistration(attestation, institutionalShare, secretHash);

                                // Update UI to show the user's shares
                                setTimeout(() => {
                                    const userShareEl = document.getElementById('user-share-display');
                                    const physicalShareEl = document.getElementById('physical-share-display');
                                    if(userShareEl) userShareEl.innerText = userShare;
                                    if(physicalShareEl) physicalShareEl.innerText = physicalShare;
                                }, 500);
                            });
                        })
                        .catch(error => {
                            console.error('Registration failed:', error);
                            alert('Gagal mendaftarkan biometrik: ' + error.message);
                        });
                }).catch(err => {
                    alert(err);
                });
            });
        });
    </script>
</div>