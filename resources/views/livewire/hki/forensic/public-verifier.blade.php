<div class="min-h-screen flex flex-col items-center justify-center bg-gray-50 px-4 py-12 sm:px-6 lg:px-8">

    {{-- Container Kartu --}}
    <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-xl shadow-2xl border border-gray-100">

        @if($isValid)
            {{-- KONDISI 1: DOKUMEN ASLI (VALID) --}}
            <div class="text-center">
                {{-- Icon Centang Hijau (Animasi Pulse) --}}
                <div
                    class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-green-100 mb-6 animate-pulse">
                    <svg class="h-14 w-14 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>

                <h2 class="mt-2 text-3xl font-extrabold text-gray-900 tracking-tight">
                    DOKUMEN VALID
                </h2>
                <p class="mt-2 text-sm text-green-600 font-medium">
                    Sertifikat ini Terdaftar & Terverifikasi.
                </p>
            </div>

            {{-- Detail Informasi --}}
            <div class="mt-8 bg-gray-50 rounded-lg p-6 border border-gray-200 text-left shadow-inner">
                <dl class="space-y-4">

                    <div>
                        <dt class="text-xs font-bold text-gray-400 uppercase tracking-wide">Judul Ciptaan</dt>
                        <dd class="mt-1 text-lg font-semibold text-gray-900 leading-tight">
                            {{ $proposal->title }}
                        </dd>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <dt class="text-xs font-bold text-gray-400 uppercase tracking-wide">Pencipta</dt>
                            <dd class="mt-1 text-sm font-medium text-gray-900">{{ $proposal->user->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-bold text-gray-400 uppercase tracking-wide">Jenis</dt>
                            <dd class="mt-1 text-sm font-medium text-gray-900">{{ $proposal->type->name ?? 'Umum' }}</dd>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-200">
                        <dt class="text-xs font-bold text-gray-400 uppercase tracking-wide">Tanggal Pengesahan</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $proposal->updated_at->isoFormat('D MMMM Y') }}
                        </dd>
                        <dd class="text-xs text-gray-500">
                            Pukul {{ $proposal->updated_at->format('H:i') }} WIB
                        </dd>
                    </div>

                    {{-- Bukti Forensik (Hash) --}}
                    <div class="pt-4 border-t border-gray-200">
                        <dt class="text-xs font-bold text-gray-400 uppercase tracking-wide">Jejak Digital (SHA-256)</dt>
                        <dd class="mt-2">
                            <code
                                class="block bg-indigo-50 text-indigo-700 text-xs p-2 rounded border border-indigo-100 break-all font-mono">
                                    {{-- Mengambil Hash terakhir dari log --}}
                                    {{ $proposal->auditLogs->last()->current_hash ?? 'HASH_INTEGRITY_CHECK' }}
                                </code>
                        </dd>
                    </div>

                </dl>
            </div>

            <div class="text-center">
                <p class="text-xs text-gray-400">
                    Sistem Verifikasi HKI Terdesentralisasi<br>
                    Universitas Dummy © {{ date('Y') }}
                </p>
            </div>

        @else
            {{-- KONDISI 2: DOKUMEN PALSU / TIDAK DITEMUKAN --}}
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-red-100 mb-6">
                    <svg class="h-14 w-14 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>

                <h2 class="mt-2 text-2xl font-extrabold text-gray-900">
                    TIDAK VALID
                </h2>
                <p class="mt-2 text-sm text-red-600">
                    Dokumen tidak ditemukan atau belum disahkan oleh pejabat berwenang.
                </p>

                <div class="mt-8">
                    <a href="{{ url('/') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                        &larr; Kembali ke Beranda Utama
                    </a>
                </div>
            </div>
        @endif

    </div>
</div>