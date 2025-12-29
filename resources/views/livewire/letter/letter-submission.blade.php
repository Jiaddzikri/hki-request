<x-slot name="sidebar">
    <x-layouts.app.sidebar-pengajuan-surat />
</x-slot>

<div class="max-w-5xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    {{-- HEADER & STEPPER --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Pengajuan Hibah Baru</h1>
            <p class="text-sm text-gray-500 mt-1">
                Periode Aktif: <span class="font-bold text-indigo-600">{{ $period->name }}</span>
            </p>
        </div>
        
        {{-- Stepper Visual --}}
        <div class="flex items-center gap-2">
            @foreach(range(1, 4) as $step)
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold border transition-colors
                        {{ $currentStep >= $step ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-gray-100 text-gray-500 border-gray-200' }}">
                        {{ $step }}
                    </div>
                    @if($step < 4)
                        <div class="w-8 h-1 {{ $currentStep > $step ? 'bg-indigo-600' : 'bg-gray-200' }}"></div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <hr class="border-gray-200 mb-8">

    {{-- MAIN CARD --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="p-6 md:p-8 space-y-8">

            {{-- ==================================================== --}}
            {{-- LANGKAH 1: PILIH SKEMA & JUDUL                       --}}
            {{-- ==================================================== --}}
            @if($currentStep === 1)
                <div class="space-y-6">
                    <h2 class="text-lg font-semibold text-gray-900 border-b pb-2">Langkah 1: Informasi Dasar</h2>

                    {{-- Pilihan Skema --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Skema Penelitian</label>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($schemes as $scheme)
                                <div wire:click="$set('scheme_id', {{ $scheme->id }})" 
                                     class="cursor-pointer border rounded-xl p-4 transition-all relative group
                                     {{ $scheme_id == $scheme->id 
                                        ? 'border-indigo-600 bg-indigo-50 ring-1 ring-indigo-600' 
                                        : 'border-gray-200 hover:border-gray-300 hover:bg-gray-50' }}">
                                    
                                    <div class="font-bold text-gray-900">{{ $scheme->name }}</div>
                                    <div class="text-sm text-gray-500 mt-1">Plafon: <span class="font-mono font-bold text-gray-700">Rp {{ number_format($scheme->max_budget) }}</span></div>
                                    
                                    <div class="flex flex-wrap gap-2 mt-3">
                                        @if($scheme->requires_student_member)
                                            <span class="inline-flex items-center px-2 py-1 rounded text-[10px] font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                                Wajib Mhs
                                            </span>
                                        @endif
                                        @if($scheme->requires_external_partner)
                                            <span class="inline-flex items-center px-2 py-1 rounded text-[10px] font-medium bg-purple-100 text-purple-800 border border-purple-200">
                                                Wajib Mitra
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Check Icon --}}
                                    @if($scheme_id == $scheme->id)
                                        <div class="absolute top-3 right-3 text-indigo-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        @error('scheme_id') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    {{-- Input Judul --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Judul Proposal</label>
                        <input type="text" wire:model="title" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Ketik judul lengkap penelitian...">
                        @error('title') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    {{-- Input Abstrak --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Abstrak / Ringkasan</label>
                        <textarea wire:model="abstract" rows="5" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Jelaskan latar belakang, tujuan..."></textarea>
                        @error('abstract') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            @endif


            {{-- ==================================================== --}}
            {{-- LANGKAH 2: TIM PENELITI                              --}}
            {{-- ==================================================== --}}
            @if($currentStep === 2)
                <div class="space-y-6">
                    <div class="flex justify-between items-center border-b pb-2">
                        <h2 class="text-lg font-semibold text-gray-900">Langkah 2: Susunan Tim</h2>
                        <button wire:click="addMember" type="button" class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            + Tambah Anggota
                        </button>
                    </div>

                    <div class="overflow-x-auto border border-gray-200 rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Lengkap</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peran</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID (NIDN/NIM)</th>
                                    <th class="px-4 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($members as $index => $mem)
                                    <tr>
                                        <td class="px-4 py-3">
                                            <input type="text" wire:model="members.{{ $index }}.name" {{ $mem['is_locked'] ? 'disabled' : '' }} 
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm {{ $mem['is_locked'] ? 'bg-gray-100 text-gray-500' : '' }}" placeholder="Nama Lengkap">
                                            @error('members.'.$index.'.name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </td>
                                        <td class="px-4 py-3 w-48">
                                            @if($mem['is_locked'])
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    KETUA
                                                </span>
                                            @else
                                                <select wire:model="members.{{ $index }}.role" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                    <option value="ANGGOTA">Dosen Anggota</option>
                                                    <option value="MAHASISWA">Mahasiswa</option>
                                                    <option value="MITRA">Mitra Eksternal</option>
                                                </select>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 w-48">
                                            <input type="text" wire:model="members.{{ $index }}.identifier" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Nomor ID">
                                        </td>
                                        <td class="px-4 py-3 text-center w-10">
                                            @if(!$mem['is_locked'])
                                                <button wire:click="removeMember({{ $index }})" type="button" class="text-red-600 hover:text-red-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                    </svg>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    @error('members') <span class="text-red-500 text-sm block">{{ $message }}</span> @enderror
                    
                    @if($selectedSchemeConfig && $selectedSchemeConfig->requires_student_member)
                        <div class="rounded-md bg-yellow-50 p-3 flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                            </div>
                            <div class="ml-3 text-sm text-yellow-700">
                                <p>Skema ini mewajibkan minimal 1 anggota berstatus Mahasiswa.</p>
                            </div>
                        </div>
                    @endif
                </div>
            @endif


            {{-- ==================================================== --}}
            {{-- LANGKAH 3: RAB (THE MONEY TABLE)                     --}}
            {{-- ==================================================== --}}
            @if($currentStep === 3)
                <div class="space-y-6">
                    <div class="flex justify-between items-center border-b pb-2">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Langkah 3: Rencana Anggaran Biaya</h2>
                            <p class="text-xs text-gray-500">Detailkan kebutuhan dana.</p>
                        </div>
                        <button wire:click="addBudgetItem" type="button" class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50">
                            + Tambah Item
                        </button>
                    </div>

                    {{-- Budget Status Bar --}}
                    @if($selectedSchemeConfig)
                        @php
                            $percentage = $selectedSchemeConfig->max_budget > 0 ? ($totalBudget / $selectedSchemeConfig->max_budget) * 100 : 0;
                            $isOverBudget = $totalBudget > $selectedSchemeConfig->max_budget;
                        @endphp
                        
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <div class="flex justify-between text-sm font-medium mb-2">
                                <span class="text-gray-500">Plafon: Rp {{ number_format($selectedSchemeConfig->max_budget) }}</span>
                                <span class="{{ $isOverBudget ? 'text-red-600' : 'text-gray-900' }}">
                                    Terpakai: Rp {{ number_format($totalBudget) }} ({{ round($percentage, 1) }}%)
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="h-2.5 rounded-full {{ $isOverBudget ? 'bg-red-600' : 'bg-indigo-600' }}" style="width: {{ min($percentage, 100) }}%"></div>
                            </div>
                            @if($isOverBudget)
                                <p class="text-xs text-red-600 font-bold mt-1">Total melebihi batas maksimal skema!</p>
                            @endif
                        </div>
                        @error('totalBudget') <span class="text-red-500 text-sm block">{{ $message }}</span> @enderror
                    @endif

                    {{-- Tabel RAB --}}
                    <div class="overflow-x-auto border border-gray-200 rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">Uraian / Item</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase w-20">Vol</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase w-24">Satuan</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase w-40">Harga (Rp)</th>
                                    <th class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase w-40">Total (Rp)</th>
                                    <th class="px-3 py-3 w-10"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($budgetItems as $index => $item)
                                    <tr>
                                        <td class="px-3 py-2">
                                            <input type="text" wire:model="budgetItems.{{ $index }}.description" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Contoh: Kertas A4">
                                            @error('budgetItems.'.$index.'.description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </td>
                                        <td class="px-3 py-2">
                                            <input type="number" wire:model.live.debounce.500ms="budgetItems.{{ $index }}.volume" min="1" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-center">
                                        </td>
                                        <td class="px-3 py-2">
                                            <input type="text" wire:model="budgetItems.{{ $index }}.unit" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-center" placeholder="Pcs">
                                        </td>
                                        <td class="px-3 py-2">
                                            <input type="number" wire:model.live.debounce.500ms="budgetItems.{{ $index }}.unit_cost" min="0" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        </td>
                                        <td class="px-3 py-2 text-right font-mono font-bold text-gray-700">
                                            {{ number_format($item['total']) }}
                                        </td>
                                        <td class="px-3 py-2 text-center">
                                            <button wire:click="removeBudgetItem({{ $index }})" type="button" class="text-gray-400 hover:text-red-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50 border-t border-gray-200">
                                <tr>
                                    <td colspan="4" class="px-4 py-3 text-right text-sm font-bold text-gray-500">TOTAL ESTIMASI BIAYA:</td>
                                    <td class="px-4 py-3 text-right text-lg font-bold text-indigo-600">Rp {{ number_format($totalBudget) }}</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            @endif


            {{-- ==================================================== --}}
            {{-- LANGKAH 4: UPLOAD & KONFIRMASI                       --}}
            {{-- ==================================================== --}}
            @if($currentStep === 4)
                <div class="space-y-8 text-center max-w-lg mx-auto py-4">
                    
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Langkah Terakhir</h2>
                        <p class="text-gray-500 text-sm">Silakan upload dokumen proposal lengkap Anda.</p>
                    </div>

                    {{-- Upload Area with AlpineJS Logic --}}
                    <div 
                        x-data="{ isUploading: false, progress: 0 }"
                        x-on:livewire-upload-start="isUploading = true"
                        x-on:livewire-upload-finish="isUploading = false"
                        x-on:livewire-upload-error="isUploading = false"
                        x-on:livewire-upload-progress="progress = $event.detail.progress"
                        class="relative border-2 border-dashed border-gray-300 rounded-xl p-10 bg-gray-50 hover:bg-gray-100 transition-colors">
                        
                        <input type="file" wire:model="proposalFile" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept=".pdf">
                        
                        <div class="space-y-2">
                            <div class="mx-auto w-12 h-12 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                                </svg>
                            </div>
                            <div class="text-sm font-medium text-gray-700">
                                <span class="text-indigo-600">Klik untuk upload</span> atau drag and drop
                            </div>
                            <p class="text-xs text-gray-500">PDF maksimal 5MB</p>
                        </div>

                        {{-- Progress Bar --}}
                        <div x-show="isUploading" class="mt-4 w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-indigo-600 h-2 rounded-full transition-all duration-300" :style="`width: ${progress}%`"></div>
                        </div>
                    </div>

                    @if($proposalFile)
                        <div class="flex items-center justify-center gap-2 text-sm text-green-700 bg-green-50 p-2 rounded-md border border-green-200">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                            </svg>
                            File siap: {{ $proposalFile->getClientOriginalName() }}
                        </div>
                    @endif
                    @error('proposalFile') <span class="text-red-500 text-sm block">{{ $message }}</span> @enderror

                    {{-- Summary Card --}}
                    <div class="bg-white border border-gray-200 rounded-lg p-5 text-left shadow-sm">
                        <h4 class="font-bold text-gray-900 border-b pb-2 mb-3">Ringkasan Pengajuan</h4>
                        <dl class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Skema:</dt>
                                <dd class="font-medium text-gray-900">{{ $selectedSchemeConfig->name ?? '-' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Anggota Tim:</dt>
                                <dd class="font-medium text-gray-900">{{ count($members) }} Orang</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Total RAB:</dt>
                                <dd class="font-bold text-indigo-600">Rp {{ number_format($totalBudget) }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div class="flex items-start gap-2 text-left text-xs text-gray-500">
                        <input type="checkbox" class="mt-0.5 rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <span>Saya menyatakan bahwa data yang saya isikan adalah benar dan saya bertanggung jawab atas keaslian dokumen yang diunggah.</span>
                    </div>
                </div>
            @endif

        </div>
    </div>

    {{-- NAVIGASI BUTTONS --}}
    <div class="mt-8 flex justify-between items-center">
        <div>
            @if($currentStep > 1)
                <button wire:click="prevStep" type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none ring-1 ring-gray-300 shadow-sm">
                    &larr; Kembali
                </button>
            @endif
        </div>

        <div>
            @if($currentStep < $totalSteps)
                <button wire:click="nextStep" type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-sm">
                    Lanjut &rarr;
                </button>
            @else
                <button wire:click="submit" type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                    </svg>
                    Kirim Proposal
                </button>
            @endif
        </div>
    </div>

</div>