<div class="">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="mb-6">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Pengajuan HKI Baru
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                Lengkapi formulir berikut untuk mengajukan Hak Kekayaan Intelektual
            </p>
        </div>

        <!-- Progress Steps -->
        <div class="mb-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <nav aria-label="Progress">
                    <ol role="list" class="space-y-4 md:flex md:space-y-0 md:space-x-8">
                        <!-- Step 1 -->
                        <li class="md:flex-1">
                            <div
                                class="group pl-4 py-2 flex flex-col border-l-4 {{ $step >= 1 ? 'border-indigo-600' : 'border-gray-200' }} md:pl-0 md:pt-4 md:pb-0 md:border-l-0 md:border-t-4">
                                <span
                                    class="text-xs font-semibold tracking-wide uppercase {{ $step >= 1 ? 'text-indigo-600' : 'text-gray-500' }}">Step
                                    1</span>
                                <span class="text-sm font-medium">Informasi</span>
                            </div>
                        </li>

                        <!-- Step 2 -->
                        <li class="md:flex-1">
                            <div
                                class="group pl-4 py-2 flex flex-col border-l-4 {{ $step >= 2 ? 'border-indigo-600' : 'border-gray-200' }} md:pl-0 md:pt-4 md:pb-0 md:border-l-0 md:border-t-4">
                                <span
                                    class="text-xs font-semibold tracking-wide uppercase {{ $step >= 2 ? 'text-indigo-600' : 'text-gray-500' }}">Step
                                    2</span>
                                <span class="text-sm font-medium">Anggota</span>
                            </div>
                        </li>

                        <!-- Step 3 -->
                        <li class="md:flex-1">
                            <div
                                class="group pl-4 py-2 flex flex-col border-l-4 {{ $step >= 3 ? 'border-indigo-600' : 'border-gray-200' }} md:pl-0 md:pt-4 md:pb-0 md:border-l-0 md:border-t-4">
                                <span
                                    class="text-xs font-semibold tracking-wide uppercase {{ $step >= 3 ? 'text-indigo-600' : 'text-gray-500' }}">Step
                                    3</span>
                                <span class="text-sm font-medium">Dokumen</span>
                            </div>
                        </li>

                        <!-- Step 4 -->
                        <li class="md:flex-1">
                            <div
                                class="group pl-4 py-2 flex flex-col border-l-4 {{ $step >= 4 ? 'border-indigo-600' : 'border-gray-200' }} md:pl-0 md:pt-4 md:pb-0 md:border-l-0 md:border-t-4">
                                <span
                                    class="text-xs font-semibold tracking-wide uppercase {{ $step >= 4 ? 'text-indigo-600' : 'text-gray-500' }}">Step
                                    4</span>
                                <span class="text-sm font-medium">Finalisasi</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Form Content -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">

                <!-- Step 1: Informasi -->
                @if($step === 1)
                    <div class="space-y-6">
                        <!-- Kategori HKI -->
                        <div>
                            <label for="hki_type_parent" class="block font-medium text-sm text-gray-700">
                                Kategori HKI <span class="text-red-500">*</span>
                            </label>
                            <select id="hki_type_parent" wire:model.live="hki_type_parent_id"
                                class="mt-1 block w-full focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-4 py-2 border border-slate-300">
                                <option value="">Pilih Kategori</option>
                                @foreach($this->parentTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                            @error('hki_type_parent_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jenis Spesifik -->
                        <div>
                            <label for="hki_type" class="block font-medium text-sm text-gray-700">
                                Jenis Spesifik <span class="text-red-500">*</span>
                            </label>
                            <select id="hki_type" wire:model="hki_type_id"
                                class="mt-1 block w-full border border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-4 py-2"
                                {{ empty($hki_type_parent_id) ? 'disabled' : '' }}>
                                <option value="">Pilih Jenis</option>
                                @foreach($this->childTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                            @error('hki_type_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Judul -->
                        <div>
                            <label for="title" class="block font-medium text-sm text-gray-700">
                                Judul Ciptaan/Invensi <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="title" wire:model="title"
                                class="px-4 py-2 mt-1 block w-full border border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                placeholder="Contoh: Alat Pendeteksi Gempa Berbasis IoT">
                            @error('title')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Abstrak -->
                        <div>
                            <label for="abstract" class="block font-medium text-sm text-gray-700">
                                Abstrak / Uraian Singkat <span class="text-red-500">*</span>
                            </label>
                            <textarea id="abstract" wire:model="abstract" rows="5"
                                class="mt-1 block w-full border border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-4 py-2"
                                placeholder="Jelaskan secara singkat tentang karya Anda..."></textarea>
                            @error('abstract')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                @endif

                <!-- Step 2: Anggota -->
                @if($step === 2)
                        <div class="space-y-6">
                            <!-- Info Box -->
                            <div class="rounded-md p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3 flex-1">
                                        <p class="text-sm text-blue-700">
                                            Masukkan data seluruh anggota yang terlibat. Ketua pengusul otomatis adalah Anda.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Members List -->
                            <div class="space-y-4">
                                @foreach($members as $index => $member)
                                        <div class="rounded-lg p-4 border border-gray-200">
                                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-12 sm:items-end">
                                                <!-- Nama -->
                                                <div class="sm:col-span-6">
                                                    <label class="block text-xs font-medium text-gray-700 uppercase tracking-wider">
                                                        Nama Lengkap
                                                    </label>
                                                    <input type="text" wire:model="members.{{ $index }}.name"
                                                        class="mt-1 px-4 py-2 block w-full border border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                                    @error("members.$index.name")
                                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>

                                                <!-- NIK -->
                                                <div class="sm:col-span-6">
                                                    <label class="block text-xs font-medium text-gray-700 uppercase tracking-wider">
                                                        NIK
                                                    </label>
                                                    <input type="text" wire:model="members.{{ $index }}.nik"
                                                        class="mt-1 px-4 py-2 block w-full border border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                                    @error("members.$index.nik")
                                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>

                                                <!-- NPWP -->
                                                <div class="sm:col-span-6">
                                                    <label class="block text-xs font-medium text-gray-700 uppercase tracking-wider">
                                                        NPWP
                                                    </label>
                                                    <input type="text" wire:model="members.{{ $index }}.npwp"
                                                        class="mt-1 px-4 py-2 block w-full border border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                                    @error("members.$index.npwp")
                                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>

                                                <!-- Email -->
                                                <div class="sm:col-span-6">
                                                    <label class="block text-xs font-medium text-gray-700 uppercase tracking-wider">
                                                        Email
                                                    </label>
                                                    <input type="email" wire:model="members.{{ $index }}.email"
                                                        class="mt-1 px-4 py-2 block w-full border border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                                    @error("members.$index.email")
                                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>

                                                <!-- NIDN -->
                                                <div class="sm:col-span-6">
                                                    <label class="block text-xs font-medium text-gray-700 uppercase tracking-wider">
                                                        NIDN / Identitas
                                                    </label>
                                                    <input type="text" wire:model="members.{{ $index }}.nidn"
                                                        class="mt-1 block w-full px-4 py-2 border border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                                    @error("members.$index.identifier")
                                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <!-- Detail -->
                                                <div class="sm:col-span-12">
                                                    <label for="abstract" class="block font-medium text-sm text-gray-700">
                                                        Detail Pencipta (nomor telephone, kewarganegaraan, alamat lengkap, negara,
                                                        provinsi, kabupaten/kota, kecamatan, kelurahan/desa, kode pos) <span
                                                            class="text-red-500">*</span>
                                                    </label>
                                                    <textarea id="abstract" wire:model="members.{{ $index }}.detail" rows="5"
                                                        class="mt-1 block w-full border border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-4 py-2"
                                                        placeholder="Jelaskan secara singkat tentang karya Anda..."></textarea>
                                                    @error('abstract')
                                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <!-- Role -->
                                            <div class="sm:col-span-2 mt-3">
                                                <label class="block text-xs font-medium text-gray-700 uppercase tracking-wider">
                                                    Peran
                                                </label>
                                                <span
                                                    class="mt-1 inline-flex items-center px-3 py-2 rounded-md text-sm font-medium bg-indigo-100 text-indigo-800 w-full justify-center">
                                                    {{ $member['role'] }}
                                                </span>
                                            </div>

                                            <!-- Delete Button -->
                                            @if($index > 0)
                                                <div class="sm:col-span-1 flex justify-end">
                                                    <button wire:click="removeMember({{ $index }})" type="button"
                                                        class="inline-flex items-center p-2 border border-transparent rounded-md text-red-600 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor">
                                                            <path fill-rule="evenodd"
                                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                        </div>

                        <!-- Add Member Button -->
                        <button wire:click="addMember" type="button"
                            class="w-full inline-flex justify-center items-center px-4 py-2 border-1 border-slate-300 border-dashed rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            Tambah Anggota Lain
                        </button>
                    </div>
                @endif

            <!-- Step 3: Dokumen -->
            @if($step === 3)
                <div class="space-y-6">

                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                        <p class="text-sm text-yellow-700">
                            <strong>Perhatian:</strong> Sistem akan menghitung <em>Cryptographic Hash</em> (SHA-256) untuk
                            setiap file yang Anda upload guna menjamin keaslian dokumen digital.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                            <label class="block text-sm font-bold text-gray-700 mb-2">1. Scan KTP Ketua Pengusul <span
                                    class="text-red-500">*</span></label>
                            <input type="file" wire:model="uploads.ktp" class="block w-full text-sm text-gray-500
                                                                              file:mr-4 file:py-2 file:px-4
                                                                              file:rounded-full file:border-0
                                                                              file:text-sm file:font-semibold
                                                                              file:bg-indigo-50 file:text-indigo-700
                                                                              hover:file:bg-indigo-100
                                                                            " />
                            <p class="text-xs text-gray-400 mt-1">Wajib format PDF. Max 10MB.</p>
                            @error('uploads.ktp') <span class="text-red-500 text-xs block">{{ $message }}</span> @enderror
                        </div>

                        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                            <label class="block text-sm font-bold text-gray-700 mb-2">2. Surat Pernyataan Keaslian <span
                                    class="text-red-500">*</span></label>
                            <input type="file" wire:model="uploads.pernyataan" class="block w-full text-sm text-gray-500
                                                                              file:mr-4 file:py-2 file:px-4
                                                                              file:rounded-full file:border-0
                                                                              file:text-sm file:font-semibold
                                                                              file:bg-indigo-50 file:text-indigo-700
                                                                              hover:file:bg-indigo-100
                                                                            " />
                            <p class="text-xs text-gray-400 mt-1">Wajib format PDF. Max 10MB.</p>
                            @error('uploads.pernyataan') <span class="text-red-500 text-xs block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">3. Contoh Ciptaan / Manual Book /
                                Source Code <span class="text-red-500">*</span></label>
                            <div
                                class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:bg-gray-50 transition">
                                <input type="file" wire:model="uploads.contoh_ciptaan"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100" />
                                <p class="text-xs text-gray-400 mt-2">Format: PDF. Max 10MB.
                                </p>
                            </div>
                            @error('uploads.contoh_ciptaan') <span
                            class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm md:col-span-2 ">
                            <div class="flex justify-between items-center mb-2">
                                <label class="block text-sm font-bold text-gray-700">4. Surat Pengalihan Hak Cipta <span
                                        class="text-red-500">*</span></label>

                            </div>
                            <input type="file" wire:model="uploads.pengalihan" class="block w-full text-sm text-gray-500
                                                                              file:mr-4 file:py-2 file:px-4
                                                                              file:rounded-full file:border-0
                                                                              file:text-sm file:font-semibold
                                                                              file:bg-gray-200 file:text-gray-700
                                                                              hover:file:bg-gray-300
                                                                            " />
                            <p class="text-xs text-gray-500 mt-1">Wajib format PDF, max 10MB</p>
                            <p>
                                @error('uploads.pengalihan') <span class="text-red-500 text-xs block">{{ $message }}</span>
                                @enderror
                            <p>
                        </div>
                        <!-- Link Ciptaan -->
                        <div class='md:col-span-2'>
                            <label class="block text-sm font-bold text-gray-700">
                                5. Link Ciptaan
                            </label>
                            <input type="text" wire:model="uploads.link_ciptaan"
                                class="mt-1 px-4 py-2 block w-full border border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                            @error("uploads.link_ciptaan")
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>
            @endif

            <!-- Step 4: Review -->
            @if($step === 4)
                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Review Data Pengajuan</h3>
                        <p class="mt-1 text-sm text-gray-600">Pastikan semua informasi sudah benar sebelum melanjutkan.
                        </p>
                    </div>

                    <!-- Warning Alert -->
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Perhatian</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>Dokumen akan di-hash dan ditandatangani secara digital. Pastikan semua data sudah
                                        benar.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Review Details -->
                    <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Judul Ciptaan/Invensi</dt>
                                <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $title }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Total Anggota Tim</dt>
                                <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ count($members) }} Orang</dd>
                            </div>
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Abstrak</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $abstract }}</dd>
                            </div>
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Daftar Anggota</dt>
                                <dd class="mt-2">
                                    <ul class="border border-gray-200 rounded-md divide-y divide-gray-200">
                                        @foreach($members as $member)
                                            <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                                <div class="flex-1 flex items-center">
                                                    <span class="ml-2 flex-1 font-medium">{{ $member['name'] }}</span>
                                                    <span class="text-gray-500">{{ $member['nik'] }}</span>
                                                </div>
                                                <span
                                                    class="ml-4 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                    {{ $member['role'] }}
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            @endif

        </div>

        <!-- Footer Actions -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
            <div>
                @if($step > 1)
                    <button wire:click="prevStep" type="button"
                        class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                        <svg class="mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                                clip-rule="evenodd" />
                        </svg>
                        Kembali
                    </button>
                @endif
            </div>

            <div>
                @if($step < 4)
                    <button wire:click="nextStep" type="button"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Lanjutkan
                        <svg class="ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                @else
                    <button type="button"
                        class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-sm">Siap Tanda Tangan</span>
                    </button>
                @endif
            </div>
        </div>
    </div>

</div>
</div>