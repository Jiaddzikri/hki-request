<x-slot name="sidebar">
  <x-layouts.app.sidebar-hki />
</x-slot>

<div class="p-6">
  {{-- Header --}}
  <div class="mb-6">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Pengajuan HKI Baru</h1>
        <p class="mt-1 text-sm text-gray-600">Lengkapi formulir berikut untuk mengajukan Hak Kekayaan Intelektual</p>
      </div>
      <a href="{{ route('hki.list') }}" wire:navigate 
         class="text-sm text-gray-600 hover:text-gray-900">
          ← Kembali
      </a>
    </div>
  </div>

  {{-- Progress Steps --}}
  <div class="mb-8">
    <div class="flex items-center justify-between">
      @foreach([
          1 => 'Informasi Dasar',
          2 => 'Anggota Tim',
          3 => 'Upload Dokumen',
          4 => 'Review & Kirim'
        ] as $stepNum => $label)
            <div class="flex items-center {{ $stepNum < 4 ? 'flex-1' : '' }}">
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full border-1 {{ $step >= $stepNum ? 'bg-blue-800 border-blue-800 text-white' : 'border-gray-300 text-gray-500' }}">
                        @if($step > $stepNum)
                          <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                              <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                          </svg>
                        @else
                          <span class="text-sm font-medium">{{ $stepNum }}</span>
                        @endif
                    </div>
                    <span class="ml-2 text-sm font-medium {{ $step >= $stepNum ? 'text-gray-900' : 'text-gray-500' }}">
                        {{ $label }}
                    </span>
                </div>
                @if($stepNum < 4)
                  <div class="flex-1 h-0.5 mx-4 {{ $step > $stepNum ? 'bg-blue-800' : 'bg-gray-300' }}"></div>
                @endif
            </div>
      @endforeach
    </div>
  </div>

  {{-- Form Container --}}
  <div class="bg-white rounded-lg border border-gray-200 p-6">
    <form wire:submit.prevent="submit">

        <!-- Step 1: Informasi -->
        @if($step === 1)
          <div class="space-y-6">
            <!-- Kategori HKI Card -->
            <div class=" rounded-xl p-6 border-1 border-gray-200 ">
              <label for="hki_type_parent" class="text-sm font-bold text-gray-800 mb-3 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                Kategori HKI <span class="text-red-500 ml-1">*</span>
              </label>
              <x-select.styled class='py-3 px-4 border-1 border-blue-300 focus:border-blue-800 focus:ring-4 focus:ring-blue-100 rounded-lg transition-all duration-200 bg-white' 
                id="hki_type_parent" wire:model.live="hki_type_parent_id"
                :options="$this->parentTypes" select="label:name|value:id" placeholder="Pilih Kategori HKI" />
              @error('hki_type_parent_id')
                <p class="mt-2 text-sm text-red-600 flex items-center">
                  <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                  </svg>
                  {{ $message }}
                </p>
              @enderror
            </div>

            <!-- Jenis Spesifik Card -->
            <div class="bg-white rounded-xl p-6 border-1 border-gray-200">
              <label for="hki_type" class="text-sm font-bold text-gray-800 mb-3 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
                Jenis Spesifik <span class="text-red-500 ml-1">*</span>
              </label>
              <x-select.styled class='py-3 px-4 border-1 border-gray-300  focus:ring-4 focus:ring-indigo-100 rounded-lg disabled:bg-gray-100 transition-all duration-200 bg-white' 
                id="hki_type" wire:model.live="hki_type_id"
                :options="$this->childTypes" :disabled="empty($hki_type_parent_id)" select="label:name|value:id"
                placeholder="Pilih Jenis Spesifik" />
              @error('hki_type_id')
                <p class="mt-2 text-sm text-red-600 flex items-center">
                  <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                  </svg>
                  {{ $message }}
                </p>
              @enderror
            </div>

            <!-- Judul Card -->
            <div class="bg-white rounded-xl p-6 border-1 border-gray-200">
              <label for="title" class="text-sm font-bold text-gray-800 mb-3 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Judul Ciptaan/Invensi <span class="text-red-500 ml-1">*</span>
              </label>
              <input type="text" id="title" wire:model="title"
                class="w-full px-4 py-3 border-1 border-gray-300  focus:ring-4 focus:ring-indigo-100 rounded-lg"
                placeholder="Masukkan judul ciptaan atau invensi">
              @error('title')
                <p class="mt-2 text-sm text-red-600 flex items-center">
                  <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                  </svg>
                  {{ $message }}
                </p>
              @enderror
            </div>

            <!-- Abstrak Card -->
            <div class="bg-white rounded-xl p-6 border-1 border-gray-200">
              <label for="abstract" class="text-sm font-bold text-gray-800 mb-3 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                </svg>
                Abstrak / Uraian Singkat <span class="text-red-500 ml-1">*</span>
              </label>
              <textarea id="abstract" wire:model="abstract" rows="6"
                class="w-full px-4 py-3 border-1 border-gray-300  focus:ring-4 focus:ring-indigo-100 rounded-lg resize-none"
                placeholder="Jelaskan secara singkat tentang ciptaan/invensi ini"></textarea>
              <div class="mt-2 flex items-center justify-between text-xs text-gray-500">
                <span class="flex items-center">
                  <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                  </svg>
                  Jelaskan secara detail dan jelas
                </span>
              </div>
              @error('abstract')
                <p class="mt-2 text-sm text-red-600 flex items-center">
                  <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                  </svg>
                  {{ $message }}
                </p>
              @enderror
            </div>

            <!-- Publication Date Card -->
            <div class="bg-white rounded-xl p-6 border-1 border-gray-200">
              <label for="publication_date" class="text-sm font-bold text-gray-800 mb-3 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Tanggal Pertama Kali Diumumkan <span class="text-red-500 ml-1">*</span>
              </label>
              <x-date wire:model="publication_date" />
              @error('publication_date')
                <p class="mt-2 text-sm text-red-600 flex items-center">
                  <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                  </svg>
                  {{ $message }}
                </p>
              @enderror
            </div>

            <!-- Publication Country Card -->
            <div class="bg-white rounded-xl p-6 border-1 border-gray-200">
              <label for="publication_country" class="text-sm font-bold text-gray-800 mb-3 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Negara Pertama Kali Diumumkan <span class="text-red-500 ml-1">*</span>
              </label>
              <select id="publication_country" wire:model.live="publication_country"
                class="w-full px-4 py-3 border-1 border-gray-300 focus:border-blue-800 focus:ring-4 focus:ring-blue-100 rounded-lg bg-white">
                <option value="">Pilih Negara</option>
                @foreach($this->getAllCountries() as $key => $value)
                  <option value="{{ $key}}">{{ $value }}</option>
                @endforeach
              </select>
              @error('publication_country')
                <p class="mt-2 text-sm text-red-600 flex items-center">
                  <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                  </svg>
                  {{ $message }}
                </p>
              @enderror
            </div>

            <!-- Publication City Card -->
            <div class="bg-white rounded-xl p-6 border-1 border-gray-200">
              <label for="publication_city" class="text-sm font-bold text-gray-800 mb-3 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Kota Pertama Kali Dipublikasikan <span class="text-red-500 ml-1">*</span>
              </label>
              <input type="text" id="publication_city" wire:model="publication_city"
                class="w-full px-4 py-3 border-1 border-gray-300  focus:ring-4 focus:ring-indigo-100 rounded-lg"
                placeholder="Contoh: Jakarta">

              @error('title')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>
          </div>
        @endif

        <!-- Step 2: Anggota -->
        @if($step === 2)
            <div class="space-y-6">
              <!-- Info Box with Modern Design -->
              <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-5 border-1 border-blue-200 shadow-sm">
                <div class="flex items-start">
                  <div class="flex-shrink-0">
                    <div class="w-10 h-10 rounded-lg bg-blue-800 flex items-center justify-center">
                      <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                      </svg>
                    </div>
                  </div>
                  <div class="ml-4 flex-1">
                    <h3 class="text-sm font-bold text-blue-800">Informasi Anggota Tim</h3>
                    <p class="text-sm text-blue-800 mt-1">
                      Masukkan data seluruh anggota yang terlibat dalam pengembangan HKI. Ketua pengusul otomatis adalah Anda.
                    </p>
                  </div>
                </div>
              </div>

              <!-- Members List -->
              <div class="space-y-5">
                @foreach($members as $index => $member)
                    <div class="bg-white rounded-xl p-6 border-1 border-gray-200 shadow-md hover:shadow-lg transition-all duration-300 relative overflow-hidden">
                      <!-- Member Number Badge -->
                      <div class="absolute top-0 right-0 w-16 h-16">
                        <div class="absolute transform rotate-45 bg-blue-800 text-white text-xs font-bold py-1 right-[-35px] top-[15px] w-[100px] text-center shadow-lg">
                          #{{ $index + 1 }}
                        </div>
                      </div>

                      <div class="grid grid-cols-1 gap-5 sm:grid-cols-12">
                        <!-- Nama Lengkap -->
                        <div class="sm:col-span-6">
                          <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            <svg class="w-4 h-4 inline mr-1 text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Nama Lengkap
                          </label>
                          <input type="text" wire:model="members.{{ $index }}.name"
                            class="px-4 py-3 block w-full border-1 border-gray-300  focus:ring-4 focus:ring-indigo-100 rounded-lg shadow-sm text-sm transition-all duration-200"
                            placeholder="Nama lengkap anggota">
                          @error("members.$index.name")
                            <p class="mt-1 text-xs text-red-600 flex items-center">
                              <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                              </svg>
                              {{ $message }}
                            </p>
                          @enderror
                        </div>

                        <!-- NIK -->
                        <div class="sm:col-span-6">
                          <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            <svg class="w-4 h-4 inline mr-1 text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                            </svg>
                            NIK
                          </label>
                          <input type="text" wire:model="members.{{ $index }}.nik"
                            class="px-4 py-3 block w-full border-1 border-gray-300 focus:border-blue-800 focus:ring-4 focus:ring-blue-100 rounded-lg shadow-sm text-sm transition-all duration-200"
                            placeholder="Nomor Induk Kependudukan">
                          @error("members.$index.nik")
                            <p class="mt-1 text-xs text-red-600 flex items-center">
                              <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                              </svg>
                              {{ $message }}
                            </p>
                          @enderror
                        </div>

                        <!-- NPWP -->
                        <div class="sm:col-span-6">
                          <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            <svg class="w-4 h-4 inline mr-1 text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            NPWP
                          </label>
                          <input type="text" wire:model="members.{{ $index }}.npwp"
                            class="px-4 py-3 block w-full border-1 border-gray-300 focus:border-blue-800 focus:ring-4 focus:ring-blue-100 rounded-lg shadow-sm text-sm transition-all duration-200"
                            placeholder="Nomor Pokok Wajib Pajak">
                          @error("members.$index.npwp")
                            <p class="mt-1 text-xs text-red-600 flex items-center">
                              <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                              </svg>
                              {{ $message }}
                            </p>
                          @enderror
                        </div>

                        <!-- Email -->
                        <div class="sm:col-span-6">
                          <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            <svg class="w-4 h-4 inline mr-1 text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Email
                          </label>
                          <input type="email" wire:model="members.{{ $index }}.email"
                            class="px-4 py-3 block w-full border-1 border-gray-300 focus:border-blue-800 focus:ring-4 focus:ring-blue-100 rounded-lg shadow-sm text-sm transition-all duration-200"
                            placeholder="alamat@email.com">
                          @error("members.$index.email")
                            <p class="mt-1 text-xs text-red-600 flex items-center">
                              <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                              </svg>
                              {{ $message }}
                            </p>
                          @enderror
                        </div>

                        <!-- NIDN -->
                        <div class="sm:col-span-6">
                          <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            <svg class="w-4 h-4 inline mr-1 text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            NIDN / Identitas
                          </label>
                          <input type="text" wire:model="members.{{ $index }}.nidn"
                            class="px-4 py-3 block w-full border-1 border-gray-300  focus:ring-4 focus:ring-blue-100 rounded-lg shadow-sm text-sm transition-all duration-200"
                            placeholder="Nomor Induk Dosen Nasional">
                          @error("members.$index.nidn")
                            <p class="mt-1 text-xs text-red-600 flex items-center">
                              <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                              </svg>
                              {{ $message }}
                            </p>
                          @enderror
                        </div>

                        <!-- Peran Badge -->
                        <div class="sm:col-span-6 flex items-end">
                          <div class="w-full">
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                              Peran
                            </label>
                            <div class="px-4 py-3 rounded-lg bg-blue-800 text-white text-center font-bold text-sm shadow-md">
                              {{ $member['role'] }}
                            </div>
                          </div>
                        </div>

                        <!-- Detail Pencipta -->
                        <div class="sm:col-span-12">
                          <label for="detail_{{ $index }}" class="text-sm font-bold text-gray-800 mb-2 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Detail Pencipta <span class="text-red-500">*</span>
                          </label>
                          <div class="text-xs text-gray-600 mb-2 bg-gray-50 p-2 rounded border border-gray-200">
                            <span class="font-medium">Isi dengan:</span> Nomor telepon, kewarganegaraan, alamat lengkap, negara, provinsi, kabupaten/kota, kecamatan, kelurahan/desa, kode pos
                          </div>
                          <textarea id="detail_{{ $index }}" wire:model="members.{{ $index }}.detail" rows="4"
                            class="w-full px-4 py-3 border-1 border-gray-300  focus:ring-4 focus:ring-indigo-100 rounded-lg shadow-sm resize-none transition-all duration-200"
                            placeholder="Contoh: 08123456789, Indonesia, Jl. Merdeka No. 123, Indonesia, Jawa Barat, Bandung, Coblong, Dago, 40135"></textarea>
                          @error("members.$index.detail")
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                              <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                              </svg>
                              {{ $message }}
                            </p>
                          @enderror
                        </div>
                      </div>

                      <!-- Delete Button -->
                      @if($index > 0)
                        <div class="mt-4 flex justify-end">
                          <button wire:click="removeMember({{ $index }})" type="button"
                            class="inline-flex items-center px-4 py-2 border-1 border-red-300 rounded-lg text-red-700 bg-red-50 hover:bg-red-100 hover:border-red-400 focus:outline-none focus:ring-4 focus:ring-red-100 transition-all duration-200 font-medium text-sm">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus Anggota
                          </button>
                        </div>
                      @endif
                    </div>
                @endforeach
            </div>

            <!-- Add Member Button - Modern Design -->
            <button wire:click="addMember" type="button"
              class="w-full inline-flex justify-center items-center px-6 py-4 border-1 border-dashed border-blue-300 rounded-xl text-blue-800 bg-blue-50 hover:bg-blue-100 hover:border-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-100 transition-all duration-300 font-semibold shadow-sm hover:shadow-md group">
              <div class="w-10 h-10 rounded-full bg-blue-800 flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300">
                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
              </div>
              <span class="text-lg">Tambah Anggota Lain</span>
            </button>
          </div>
        @endif

      <!-- Step 3: Dokumen -->
      @if($step === 3)
        <div class="space-y-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- KTP Upload Card -->
            <div class="bg-white rounded-xl p-6 border-1 border-gray-200 shadow-md hover:shadow-lg transition-all duration-300">
              <div class="flex items-center mb-4">
                <div class="w-10 h-10 rounded-lg bg-blue-800 flex items-center justify-center shadow-md">
                  <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                  </svg>
                </div>
                <div class="ml-3">
                  <label class="block text-sm font-bold text-gray-800">
                    1. Scan KTP Ketua Pengusul <span class="text-red-500">*</span>
                  </label>
                </div>
              </div>
              <div class="border-1 border-dashed border-blue-300 rounded-lg p-4 bg-blue-50/50 hover:bg-blue-50 transition-colors duration-200">
                <input type="file" wire:model="uploads.ktp"
                  class="block w-full text-sm text-gray-600
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-sm file:font-semibold
                    file:bg-blue-800 file:text-white
                    hover:file:bg-blue-800
                    file:cursor-pointer file:shadow-sm
                    file:transition-all file:duration-200" />
                <p class="text-xs text-gray-500 mt-2 flex items-center">
                  <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                  </svg>
                  Wajib format PDF, maksimal 10MB
                </p>
              </div>
              @error('uploads.ktp')
                <p class="mt-2 text-xs text-red-600 flex items-center">
                  <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                  </svg>
                  {{ $message }}
                </p>
              @enderror
            </div>

            <!-- Surat Pernyataan Card -->
            <div class="bg-white rounded-xl p-6 border-1 border-gray-200 shadow-md hover:shadow-lg transition-all duration-300">
              <div class="flex items-center mb-4">
                <div class="w-10 h-10 rounded-lg bg-blue-800 flex items-center justify-center shadow-md">
                  <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                  </svg>
                </div>
                <div class="ml-3">
                  <label class="block text-sm font-bold text-gray-800">
                    2. Surat Pernyataan Keaslian <span class="text-red-500">*</span>
                  </label>
                </div>
              </div>
              <div class="border-1 border-dashed border-blue-300 rounded-lg p-4 bg-blue-50/50 hover:bg-blue-50 transition-colors duration-200">
                <input type="file" wire:model="uploads.pernyataan"
                  class="block w-full text-sm text-gray-600
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-sm file:font-semibold
                    file:bg-blue-800 file:text-white
                    hover:file:bg-blue-800
                    file:cursor-pointer file:shadow-sm
                    file:transition-all file:duration-200" />
                <p class="text-xs text-gray-500 mt-2 flex items-center">
                  <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                  </svg>
                  Wajib format PDF, maksimal 10MB
                </p>
              </div>
              @error('uploads.pernyataan')
                <p class="mt-2 text-xs text-red-600 flex items-center">
                  <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                  </svg>
                  {{ $message }}
                </p>
              @enderror
            </div>

            <!-- Contoh Ciptaan Card (Full Width) -->
            <div class="md:col-span-2 bg-white rounded-xl p-6 border-1 border-gray-200 shadow-md hover:shadow-lg transition-all duration-300">
              <div class="flex items-center mb-4">
                <div class="w-10 h-10 rounded-lg bg-blue-800 flex items-center justify-center shadow-md">
                  <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                  </svg>
                </div>
                <div class="ml-3">
                  <label class="block text-sm font-bold text-gray-800">
                    3. Contoh Ciptaan / Manual Book / Source Code <span class="text-red-500">*</span>
                  </label>
                </div>
              </div>
              <div class="border-1 border-dashed border-blue-300 rounded-lg p-8 text-center bg-blue-50/50 hover:bg-blue-50 transition-all duration-200">
                <div class="flex flex-col items-center justify-center">
                  <svg class="w-12 h-12 text-blue-800 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                  </svg>
                  <input type="file" wire:model="uploads.contoh_ciptaan"
                    class="block w-full text-sm text-gray-600
                      file:mr-4 file:py-3 file:px-6
                      file:rounded-full file:border-0
                      file:text-sm file:font-bold
                      file:bg-blue-800 file:text-white
                      hover:file:bg-blue-800
                      file:cursor-pointer file:shadow-md
                      file:transition-all file:duration-200" />
                  <p class="text-xs text-gray-500 mt-3 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Format PDF, maksimal 10MB
                  </p>
                </div>
              </div>
              @error('uploads.contoh_ciptaan')
                <p class="mt-2 text-xs text-red-600 flex items-center">
                  <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                  </svg>
                  {{ $message }}
                </p>
              @enderror
            </div>

            <!-- Surat Pengalihan Card (Full Width) -->
            <div class="md:col-span-2 bg-white rounded-xl p-6 border-1 border-gray-200 shadow-md hover:shadow-lg transition-all duration-300">
              <div class="flex items-center mb-4">
                <div class="w-10 h-10 rounded-lg bg-blue-800 flex items-center justify-center shadow-md">
                  <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                  </svg>
                </div>
                <div class="ml-3">
                  <label class="block text-sm font-bold text-gray-800">
                    4. Surat Pengalihan Hak Cipta <span class="text-red-500">*</span>
                  </label>
                </div>
              </div>
              <div class="border-1 border-dashed border-blue-300 rounded-lg p-4 bg-blue-50/50 hover:bg-blue-50 transition-colors duration-200">
                <input type="file" wire:model="uploads.pengalihan"
                  class="block w-full text-sm text-gray-600
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-sm file:font-semibold
                    file:bg-blue-800 file:text-white
                    hover:file:bg-blue-800
                    file:cursor-pointer file:shadow-sm
                    file:transition-all file:duration-200" />
                <p class="text-xs text-gray-500 mt-2 flex items-center">
                  <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                  </svg>
                  Wajib format PDF, maksimal 10MB
                </p>
              </div>
              @error('uploads.pengalihan')
                <p class="mt-2 text-xs text-red-600 flex items-center">
                  <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                  </svg>
                  {{ $message }}
                </p>
              @enderror
            </div>

            <!-- Link Ciptaan Card (Full Width) -->
            <div class='md:col-span-2 bg-white rounded-xl p-6 border-1 border-gray-200 shadow-md hover:shadow-lg transition-all duration-300'>
              <div class="flex items-center mb-4">
                <div class="w-10 h-10 rounded-lg bg-blue-800 flex items-center justify-center shadow-md">
                  <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                  </svg>
                </div>
                <div class="ml-3">
                  <label class="block text-sm font-bold text-gray-800">
                    5. Link Ciptaan (Opsional)
                  </label>
                  <p class="text-xs text-gray-500">Link ke repository, website, atau lokasi online lainnya</p>
                </div>
              </div>
              <input type="text" wire:model="url_detail"
                class="w-full px-4 py-3 border-1 border-gray-300 focus:border-blue-800 focus:ring-4 focus:ring-blue-100 rounded-lg"
                placeholder="https://github.com/username/project atau URL lainnya">
              @error("url_detail")
                <p class="mt-2 text-xs text-red-600 flex items-center">
                  <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                  </svg>
                  {{ $message }}
                </p>
              @enderror
            </div>

          </div>
        </div>
      @endif

      <!-- Step 4: Review & Submit -->
      @if($step === 4)
        <div class="space-y-6">
          <!-- Header Section -->
          <div class="text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-800 to-blue-600 shadow-xl mb-4">
              <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
              </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900">Review Data Pengajuan</h3>
            <p class="mt-2 text-sm text-gray-600 max-w-2xl mx-auto">
              Pastikan semua informasi sudah benar dan lengkap sebelum mengirimkan proposal HKI Anda
            </p>
          </div>

         

          <!-- Review Details Card -->
          <div class="bg-white rounded-xl p-8 border-1 border-gray-200 shadow-lg">
            <!-- HKI Info Section -->
            <div class="mb-8">
              <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center border-b-2 border-blue-200 pb-2">
                <svg class="w-6 h-6 mr-2 text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Informasi Ciptaan/Invensi
              </h4>
              <dl class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg p-4 border border-blue-200">
                  <dt class="text-xs font-bold text-blue-700 uppercase tracking-wider mb-2">Judul Ciptaan/Invensi</dt>
                  <dd class="text-base text-gray-900 font-semibold">{{ $title }}</dd>
                </div>
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 border border-blue-200">
                  <dt class="text-xs font-bold text-blue-800 uppercase tracking-wider mb-2">Total Anggota Tim</dt>
                  <dd class="text-base text-gray-900 font-semibold">{{ count($members) }} Orang</dd>
                </div>
                <div class="sm:col-span-2 bg-gradient-to-br from-gray-50 to-slate-50 rounded-lg p-4 border border-gray-200">
                  <dt class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Abstrak / Uraian Singkat</dt>
                  <dd class="text-sm text-gray-900 leading-relaxed">{{ $abstract }}</dd>
                </div>
              </dl>
            </div>

            <!-- Team Members Section -->
            <div>
              <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center border-b-2 border-indigo-200 pb-2">
                <svg class="w-6 h-6 mr-2 text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                Daftar Anggota Tim
              </h4>
              <div class="space-y-3">
                @foreach($members as $index => $member)
                  <div class="bg-gradient-to-r from-indigo-50 to-blue-50 rounded-lg p-4 border-1 border-indigo-200 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center justify-between">
                      <div class="flex-1">
                        <div class="flex items-center">
                          <div class="w-10 h-10 rounded-full bg-blue-800 flex items-center justify-center text-white font-bold shadow-md mr-3">
                            {{ $index + 1 }}
                          </div>
                          <div>
                            <p class="font-bold text-gray-900">{{ $member['name'] }}</p>
                            <p class="text-sm text-gray-600">NIK: {{ $member['nik'] }}</p>
                          </div>
                        </div>
                      </div>
                      <span class="inline-flex items-center px-4 py-2 rounded-full text-xs font-bold bg-blue-800 text-white shadow-md">
                        {{ $member['role'] }}
                      </span>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>

          <!-- Security Info -->
          <div class="bg-gradient-to-r from-blue-50 to-blue-100 border-1 border-blue-200 rounded-xl p-5 shadow-sm">
            <div class="flex items-start">
              <div class="flex-shrink-0">
                <svg class="h-8 w-8 text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
              </div>
              <div class="ml-4">
                <h3 class="text-sm font-bold text-blue-900">Langkah Selanjutnya</h3>
                <p class="mt-1 text-sm text-blue-800">
                  Klik tombol <strong>"Kirim Proposal"</strong> di bawah untuk melanjutkan ke verifikasi PIN. 
                  Setelah PIN diverifikasi, proposal Anda akan dikirim dan tidak dapat diubah.
                </p>
              </div>
            </div>
          </div>
        </div>
      @endif

    </div>

    <!-- Navigation Buttons -->
    <div class="mt-6 flex justify-between items-center pt-6 border-t border-gray-200">
      @if($step > 1)
        <button wire:click="prevStep" type="button"
          class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-800">
          <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
          </svg>
          Kembali
        </button>
      @else
        <div></div>
      @endif

      @if($step < 4)
        <button wire:click="nextStep" type="button"
          class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-800 hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-800">
          Lanjutkan
          <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
          </svg>
        </button>
      @else
        <button x-on:click="$modalOpen('modal-id')" type="button"
          class="inline-flex items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-blue-800 hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-800">
          <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          Kirim Proposal
        </button>

        <x-modal id='modal-id' center>
          <div class="px-6 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-800 mb-4">
              <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
              </svg>
            </div>
            <h1 class='text-2xl text-gray-800 font-bold mb-2'>Masukkan PIN Anda</h1>
            <p class='text-sm text-gray-600 max-w-sm mx-auto'>
              PIN ini akan menjadi tanda tangan digital Anda untuk memastikan permohonan ini tidak bisa diubah setelah dikirim
            </p>
          </div>
          <div class="w-full flex justify-center mt-6 flex-col items-center">
            <x-pin length="6" wire:model="pin" x-on:filled="$wire.submitProposal()" />
            <p class="text-xs text-gray-500 mt-4">Masukkan 6 digit PIN keamanan Anda</p>
          </div>
        </x-modal>

      @endif
    </div>
  </div>
</div>