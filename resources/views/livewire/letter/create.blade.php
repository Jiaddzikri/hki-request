<x-slot name="sidebar">
  <x-layouts.app.sidebar-pengajuan-surat />
</x-slot>

<div class="max-w-7xl mx-auto py-8 px-4">
  {{-- Header --}}
  <div class="mb-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-200">
      <div class="bg-gradient-to-r from-slate-700 to-slate-800 px-8 py-6 border-b-4 border-blue-600">
        <div class="flex items-center justify-between">
          <div class="flex items-center space-x-4">
            <div
              class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm border border-white/30">
              <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                </path>
              </svg>
            </div>
            <div>
              <h1 class="text-2xl font-bold text-white">Buat Submission Baru</h1>
              <p class="text-blue-100 text-sm font-medium">Form Pengajuan Letter Submission</p>
            </div>
          </div>
          <a href="{{ route('letter.index') }}"
            class="inline-flex items-center px-6 py-3 bg-white text-slate-700 rounded-lg font-semibold text-sm shadow-md hover:bg-gray-50 border border-gray-200 transition-all duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
              </path>
            </svg>
            Kembali
          </a>
        </div>
      </div>
    </div>
  </div>

  {{-- Alert Messages --}}
  @if (session()->has('success'))
    <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
      <div class="flex items-center">
        <svg class="w-5 h-5 text-green-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd"
            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
            clip-rule="evenodd"></path>
        </svg>
        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
      </div>
    </div>
  @endif

  @if (session()->has('error'))
    <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
      <div class="flex items-center">
        <svg class="w-5 h-5 text-red-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd"
            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
            clip-rule="evenodd"></path>
        </svg>
        <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
      </div>
    </div>
  @endif

  {{-- Form --}}
  <div class="bg-white rounded-lg shadow-lg border border-gray-200">
    <form wire:submit.prevent="save">
      <div class="p-8 space-y-6">
        {{-- Category --}}
        <div>
          <label for="ltr_category_id" class="block text-sm font-bold text-gray-700 mb-2">
            Kategori Letter
          </label>
          <select wire:model="ltr_category_id" id="ltr_category_id"
            class="block w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-sm font-medium">
            <option value="">-- Pilih Kategori --</option>
            @foreach($categories as $category)
              <option value="{{ $category->id }}">{{ $category->category }}</option>
            @endforeach
          </select>
          @error('ltr_category_id')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Unit --}}
        <div>
          <label for="ltr_unit_id" class="block text-sm font-bold text-gray-700 mb-2">
            Unit Kerja
          </label>
          <select wire:model="ltr_unit_id" id="ltr_unit_id"
            class="block w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-sm font-medium">
            <option value="">-- Pilih Unit --</option>
            @foreach($units as $unit)
              <option value="{{ $unit->id }}">{{ $unit->unit }}</option>
            @endforeach
          </select>
          @error('ltr_unit_id')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Description --}}
        <div>
          <label for="description" class="block text-sm font-bold text-gray-700 mb-2">
            Deskripsi
          </label>
          <textarea wire:model="description" id="description" rows="4"
            class="block w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-sm font-medium"
            placeholder="Masukkan deskripsi submission..."></textarea>
          @error('description')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Indicators --}}
        <div>
          <label for="indicators" class="block text-sm font-bold text-gray-700 mb-2">
            Indikator
          </label>
          <textarea wire:model="indicators" id="indicators" rows="4"
            class="block w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-sm font-medium"
            placeholder="Contoh: Indikator 1, Indikator 2, Indikator 3"></textarea>
          <p class="mt-1 text-xs text-gray-500">Pisahkan setiap indikator dengan koma (,). Spasi setelah koma akan
            diabaikan.</p>
          @error('indicators')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Budget --}}
        <div x-data="{
          init() {
            if ({{ $budget ?? 0 }}) {
              let input = document.getElementById('budget');
              input.value = parseInt({{ $budget ?? 0 }}).toLocaleString('id-ID');
            }
          },
          formatNumber(input) {
            let value = input.value.replace(/\D/g, '');
            if (value) {
              input.value = parseInt(value).toLocaleString('id-ID');
              @this.set('budget', parseFloat(value));
            } else {
              input.value = '';
              @this.set('budget', null);
            }
          }
        }">
          <label for="budget" class="block text-sm font-bold text-gray-700 mb-2">
            Anggaran
          </label>
          <div class="relative">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 font-medium">Rp</span>
            <input type="text" id="budget" 
              x-on:input="formatNumber($event.target)"
              x-on:blur="formatNumber($event.target)"
              class="block w-full pl-12 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-sm font-medium"
              placeholder="0">
          </div>
          @error('budget')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Date Range --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="planned_start_date" class="block text-sm font-bold text-gray-700 mb-2">
              Tanggal Mulai Rencana
            </label>
            <div class="relative cursor-pointer" onclick="document.getElementById('planned_start_date').showPicker()">
              <input type="datetime-local" wire:model="planned_start_date" id="planned_start_date"
                class="block w-full pr-10 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-sm font-medium cursor-pointer"
                style="color-scheme: light;">

            </div>
            @error('planned_start_date')
              <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label for="planned_end_date" class="block text-sm font-bold text-gray-700 mb-2">
              Tanggal Selesai Rencana
            </label>
            <div class="relative cursor-pointer" onclick="document.getElementById('planned_end_date').showPicker()">
              <input type="datetime-local" wire:model="planned_end_date" id="planned_end_date"
                class="block w-full pr-10 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-sm font-medium cursor-pointer"
                style="color-scheme: light;">

            </div>
            @error('planned_end_date')
              <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
          </div>
        </div>

        {{-- URL Documentation --}}
        <div>
          <label for="url_documentation" class="block text-sm font-bold text-gray-700 mb-2">
            URL Dokumentasi
          </label>
          <input type="url" wire:model="url_documentation" id="url_documentation"
            class="block w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-sm font-medium"
            placeholder="https://example.com/documentation">
          @error('url_documentation')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
          @enderror
        </div>
      </div>

      {{-- Footer Actions --}}
      <div class="bg-gray-50 px-8 py-4 border-t border-gray-200 flex justify-end space-x-3">
        <a href="{{ route('letter.index') }}"
          class="inline-flex items-center px-6 py-3 bg-white text-gray-700 rounded-lg font-semibold text-sm shadow-md hover:bg-gray-50 border border-gray-300 transition-all duration-200">
          Batal
        </a>
        <button type="submit" wire:loading.attr="disabled"
          class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-slate-700 text-white rounded-lg font-semibold text-sm shadow-lg hover:from-blue-700 hover:to-slate-800 transition-all duration-200 border border-blue-700">
          <svg class="w-4 h-4 mr-2" wire:loading.remove fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
            </path>
          </svg>
          <svg class="animate-spin h-4 w-4 mr-2" wire:loading xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
            </circle>
            <path class="opacity-75" fill="currentColor"
              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
            </path>
          </svg>
          <span wire:loading.remove>Simpan Submission</span>
          <span wire:loading>Menyimpan...</span>
        </button>
      </div>
    </form>
  </div>
</div>