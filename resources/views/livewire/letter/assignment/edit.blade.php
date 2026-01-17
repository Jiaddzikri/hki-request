<x-slot name="sidebar"></x-slot><x-slot name="sidebar"><div class="py-12"><div class="py-12">

  <x-layouts.app.sidebar-pengajuan-surat />

</x-slot>  <x-layouts.app.sidebar-pengajuan-surat />



<div class="p-6"></x-slot>  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

  {{-- Header Section --}}

  <div class="mb-6">

    <div class="flex items-center justify-between">

      <div><div class="py-12">    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

        <h1 class="text-2xl font-bold text-gray-900">Edit Surat Ajuan Tugas</h1>

        <p class="mt-1 text-sm text-gray-600">Perbarui informasi pengajuan surat tugas Anda</p>  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

      </div>

    </div>

  </div>

    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

  {{-- Flash Messages --}}

  @if (session()->has('success'))      <h2 class="text-2xl font-bold mb-6">Edit Surat Ajuan Tugas</h2>      <h2 class="text-2xl font-bold mb-6">Edit Surat Ajuan Tugas</h2>

    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">

      {{ session('success') }}      <h2 class="text-2xl font-bold mb-6">Edit Surat Ajuan Tugas</h2>

    </div>

  @endif



  @if (session()->has('error'))      @if (session()->has('success'))

    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">

      {{ session('error') }}        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">      @if (session()->has('success'))      @if (session()->has('success'))

    </div>

  @endif          {{ session('success') }}



  <form wire:submit="update">        </div>        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">



    {{-- 1. Jenis Ajuan --}}      @endif

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">

      <h3 class="text-lg font-semibold text-gray-900 mb-4">1. Jenis Ajuan</h3>          {{ session('success') }}          {{ session('success') }}



      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">      @if (session()->has('error'))

        <div>

          <label class="block text-sm font-medium text-gray-700 mb-2">        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">        </div>        </div>

            Ajuan Untuk <span class="text-red-500">*</span>

          </label>          {{ session('error') }}

          <select wire:model="assignment_type"

            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">        </div>      @endif      @endif

            <option value="">Pilih Jenis Ajuan</option>

            <option value="penelitian">Penelitian</option>      @endif

            <option value="pkm">PKM</option>

            <option value="penunjang">Penunjang</option>

            <option value="seminar_workshop">Seminar/Workshop</option>

          </select>      <form wire:submit="update">

          @error('assignment_type')

            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>      @if (session()->has('error'))      @if (session()->has('error'))

          @enderror

        </div>        {{-- 1. Jenis Ajuan --}}

      </div>

    </div>        <div class="mb-6 p-4 bg-gray-50 rounded-lg">        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">



    {{-- 2. Data Pengaju --}}          <h3 class="text-lg font-semibold mb-4">1. Jenis Ajuan</h3>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">

      <h3 class="text-lg font-semibold text-gray-900 mb-4">2. Data Pengaju</h3>          {{ session('error') }}          {{ session('error') }}



      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <div>

          <label class="block text-sm font-medium text-gray-700 mb-2">            <div>        </div>        </div>

            Nama Lengkap dengan Gelar <span class="text-red-500">*</span>

          </label>              <label class="block text-sm font-medium text-gray-700 mb-2">Ajuan Untuk <span

          <input type="text" wire:model="full_name"

            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">                  class="text-red-500">*</span></label>      @endif      @endif

          @error('full_name')

            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>              <select wire:model="assignment_type"

          @enderror

        </div>                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">



        <div>                <option value="">Pilih Jenis Ajuan</option>

          <label class="block text-sm font-medium text-gray-700 mb-2">

            NIDN <span class="text-red-500">*</span>                <option value="penelitian">Penelitian</option>      <form wire:submit="update">      <form wire:submit="update">

          </label>

          <input type="text" wire:model="nidn"                <option value="pkm">PKM</option>

            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

          @error('nidn')                <option value="penunjang">Penunjang</option>

            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>

          @enderror                <option value="seminar_workshop">Seminar/Workshop</option>

        </div>

              </select>        {{-- Jenis Ajuan --}}        {{-- Jenis Ajuan --}}

        <div>

          <label class="block text-sm font-medium text-gray-700 mb-2">              @error('assignment_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

            Fakultas <span class="text-red-500">*</span>

          </label>            </div>        <div class="mb-6 p-4 bg-gray-50 rounded-lg">        <div class="mb-6 p-4 bg-gray-50 rounded-lg">

          <select wire:model="faculty"

            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">          </div>

            <option value="">Pilih Fakultas</option>

            <option value="FKIP">Fakultas Keguruan dan Ilmu Pendidikan (FKIP)</option>        </div>          <h3 class="text-lg font-semibold mb-4">Jenis Ajuan</h3>          <h3 class="text-lg font-semibold mb-4">Jenis Ajuan</h3>

            <option value="FIB">Fakultas Ilmu Budaya (FIB)</option>

            <option value="FEB">Fakultas Ekonomi dan Bisnis (FEB)</option>

            <option value="FISIP">Fakultas Ilmu Sosial dan Ilmu Pemerintahan (FISIP)</option>

            <option value="FTI">Fakultas Teknologi Informasi (FTI)</option>        {{-- 2. Data Pengaju --}}

            <option value="FIKES">Fakultas Ilmu Kesehatan (FIKES)</option>

          </select>        <div class="mb-6 p-4 bg-gray-50 rounded-lg">

          @error('faculty')

            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>          <h3 class="text-lg font-semibold mb-4">2. Data Pengaju</h3>          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

          @enderror

        </div>



        <div>          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">            <div>            <div>

          <label class="block text-sm font-medium text-gray-700 mb-2">

            Jabatan Akademik <span class="text-red-500">*</span>            <div>

            <span class="text-xs text-gray-500">(Bisa pilih lebih dari satu)</span>

          </label>              <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap dengan Gelar <span              <label class="block text-sm font-medium text-gray-700 mb-2">Ajuan Untuk <span              <label class="block text-sm font-medium text-gray-700 mb-2">Ajuan Untuk <span

          <div class="space-y-2 mt-2">

            <label class="flex items-center">                  class="text-red-500">*</span></label>

              <input type="checkbox" wire:model="academic_positions" value="asisten_ahli"

                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">              <input type="text" wire:model="full_name"                  class="text-red-500">*</span></label>                  class="text-red-500">*</span></label>

              <span class="ml-2 text-sm text-gray-700">Asisten Ahli</span>

            </label>                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

            <label class="flex items-center">

              <input type="checkbox" wire:model="academic_positions" value="lektor"              @error('full_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror              <select wire:model="assignment_type"              <select wire:model="assignment_type"

                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">

              <span class="ml-2 text-sm text-gray-700">Lektor</span>            </div>

            </label>

            <label class="flex items-center">                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

              <input type="checkbox" wire:model="academic_positions" value="lektor_kepala"

                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">            <div>

              <span class="ml-2 text-sm text-gray-700">Lektor Kepala</span>

            </label>              <label class="block text-sm font-medium text-gray-700 mb-2">NIDN <span                <option value="">Pilih Jenis Ajuan</option>                <option value="">Pilih Jenis Ajuan</option>

            <label class="flex items-center">

              <input type="checkbox" wire:model="academic_positions" value="guru_besar"                  class="text-red-500">*</span></label>

                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">

              <span class="ml-2 text-sm text-gray-700">Guru Besar</span>              <input type="text" wire:model="nidn"                <option value="penelitian">Penelitian</option>                <option value="penelitian">Penelitian</option>

            </label>

          </div>                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

          @error('academic_positions')

            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>              @error('nidn') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror                <option value="pkm">PKM</option>                <option value="pkm">PKM</option>

          @enderror

        </div>            </div>

      </div>

    </div>                <option value="penunjang">Penunjang</option>                <option value="penunjang">Penunjang</option>



    {{-- 3. Periode Kegiatan --}}            <div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">

      <h3 class="text-lg font-semibold text-gray-900 mb-4">3. Periode Kegiatan</h3>              <label class="block text-sm font-medium text-gray-700 mb-2">Fakultas <span                <option value="seminar_workshop">Seminar/Workshop</option>                <option value="seminar_workshop">Seminar/Workshop</option>



      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">                  class="text-red-500">*</span></label>

        <div>

          <label class="block text-sm font-medium text-gray-700 mb-2">              <select wire:model="faculty"              </select>              </select>

            Tanggal Mulai <span class="text-red-500">*</span>

          </label>                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

          <input type="date" wire:model="start_date"

            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">                <option value="">Pilih Fakultas</option>              @error('assignment_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror              @error('assignment_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

          @error('start_date')

            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>                <option value="FKIP">Fakultas Keguruan dan Ilmu Pendidikan (FKIP)</option>

          @enderror

        </div>                <option value="FIB">Fakultas Ilmu Budaya (FIB)</option>            </div>            </div>



        <div>                <option value="FEB">Fakultas Ekonomi dan Bisnis (FEB)</option>

          <label class="block text-sm font-medium text-gray-700 mb-2">

            Tanggal Berakhir <span class="text-red-500">*</span>                <option value="FISIP">Fakultas Ilmu Sosial dan Ilmu Pemerintahan (FISIP)</option>          </div>          </div>

          </label>

          <input type="date" wire:model="end_date"                <option value="FTI">Fakultas Teknologi Informasi (FTI)</option>

            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

          @error('end_date')                <option value="FIKES">Fakultas Ilmu Kesehatan (FIKES)</option>        </div>        </div>

            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>

          @enderror              </select>

        </div>

              @error('faculty') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

        <div>

          <label class="block text-sm font-medium text-gray-700 mb-2">            </div>

            Tahun Akademik <span class="text-red-500">*</span>

          </label>        {{-- Data Pengaju --}}        {{-- Data Pengaju --}}

          <input type="text" wire:model="academic_year" placeholder="2025/2026"

            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">            <div>

          @error('academic_year')

            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>              <label class="block text-sm font-medium text-gray-700 mb-2">Jabatan Akademik <span        <div class="mb-6 p-4 bg-gray-50 rounded-lg">        <div class="mb-6 p-4 bg-gray-50 rounded-lg">

          @enderror

        </div>                  class="text-red-500">*</span> <span class="text-xs text-gray-500">(Bisa pilih lebih dari

      </div>

    </div>                  satu)</span></label>          <h3 class="text-lg font-semibold mb-4">Data Pengaju</h3>          <h3 class="text-lg font-semibold mb-4">Data Pengaju</h3>



    {{-- 4. Detail Kegiatan --}}              <div class="space-y-2">

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">

      <h3 class="text-lg font-semibold text-gray-900 mb-4">4. Detail Kegiatan</h3>                <label class="flex items-center">



      <div class="space-y-4">                  <input type="checkbox" wire:model="academic_positions" value="asisten_ahli"

        <div>

          <label class="block text-sm font-medium text-gray-700 mb-2">                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            Nama Instansi/Lembaga Tujuan <span class="text-red-500">*</span>

          </label>                  <span class="ml-2 text-sm">Asisten Ahli</span>

          <input type="text" wire:model="institution_name"

            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">                </label>            <div>            <div>

          @error('institution_name')

            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>                <label class="flex items-center">

          @enderror

        </div>                  <input type="checkbox" wire:model="academic_positions" value="lektor"              <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap dengan Gelar <span              <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap dengan Gelar <span



        <div>                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">

          <label class="block text-sm font-medium text-gray-700 mb-2">

            Alamat Instansi/Lembaga <span class="text-red-500">*</span>                  <span class="ml-2 text-sm">Lektor</span>                  class="text-red-500">*</span></label>                  class="text-red-500">*</span></label>

          </label>

          <textarea wire:model="institution_address" rows="2"                </label>

            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>

          @error('institution_address')                <label class="flex items-center">              <input type="text" wire:model="full_name"              <input type="text" wire:model="full_name"

            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>

          @enderror                  <input type="checkbox" wire:model="academic_positions" value="lektor_kepala"

        </div>

                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

        <div>

          <label class="block text-sm font-medium text-gray-700 mb-2">                  <span class="ml-2 text-sm">Lektor Kepala</span>

            Judul Penelitian/Tema Kegiatan/Topik <span class="text-red-500">*</span>

          </label>                </label>              @error('full_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror              @error('full_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

          <input type="text" wire:model="research_title"

            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">                <label class="flex items-center">

          @error('research_title')

            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>                  <input type="checkbox" wire:model="academic_positions" value="guru_besar"            </div>            </div>

          @enderror

        </div>                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">



        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">                  <span class="ml-2 text-sm">Guru Besar</span>

          <div>

            <label class="block text-sm font-medium text-gray-700 mb-2">Estimasi Biaya (Rp)</label>                </label>

            <input type="number" wire:model="estimated_budget" placeholder="0"

              class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">              </div>            <div>            <div>

            @error('estimated_budget')

              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>              @error('academic_positions') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

            @enderror

          </div>            </div>              <label class="block text-sm font-medium text-gray-700 mb-2">NIDN <span              <label class="block text-sm font-medium text-gray-700 mb-2">NIDN <span

        </div>

          </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

          <div>        </div>                  class="text-red-500">*</span></label>                  class="text-red-500">*</span></label>

            <label class="block text-sm font-medium text-gray-700 mb-2">

              Nama Pimpinan Instansi <span class="text-red-500">*</span>

            </label>

            <input type="text" wire:model="leader_name"        {{-- 3. Periode Kegiatan --}}              <input type="text" wire:model="nidn"              <input type="text" wire:model="nidn"

              class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

            @error('leader_name')        <div class="mb-6 p-4 bg-gray-50 rounded-lg">

              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>

            @enderror          <h3 class="text-lg font-semibold mb-4">3. Periode Kegiatan</h3>                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

          </div>



          <div>

            <label class="block text-sm font-medium text-gray-700 mb-2">          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">              @error('nidn') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror              @error('nidn') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

              Nama PIC/Penanggung Jawab <span class="text-red-500">*</span>

            </label>            <div>

            <input type="text" wire:model="pic_name"

              class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">              <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai <span            </div>            </div>

            @error('pic_name')

              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>                  class="text-red-500">*</span></label>

            @enderror

          </div>              <input type="date" wire:model="start_date"

        </div>

      </div>                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

    </div>

              @error('start_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror            <div>            <div>

    {{-- 5. Anggota Tim --}}

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">            </div>

      <h3 class="text-lg font-semibold text-gray-900 mb-4">5. Anggota Tim</h3>

              <label class="block text-sm font-medium text-gray-700 mb-2">Fakultas <span              <label class="block text-sm font-medium text-gray-700 mb-2">Fakultas <span

      @if (session()->has('member_success'))

        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded text-sm">            <div>

          {{ session('member_success') }}

        </div>              <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Berakhir <span                  class="text-red-500">*</span></label>                  class="text-red-500">*</span></label>

      @endif

                  class="text-red-500">*</span></label>

      @if (count($members) > 0)

        <div class="mb-4 overflow-x-auto">              <input type="date" wire:model="end_date"              <select wire:model="faculty"              <select wire:model="faculty"

          <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-lg">

            <thead class="bg-gray-50">                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

              <tr>

                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>              @error('end_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>

                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIDN/NIP/NIM</th>            </div>

                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>

              </tr>                <option value="">Pilih Fakultas</option>                <option value="">Pilih Fakultas</option>

            </thead>

            <tbody class="bg-white divide-y divide-gray-200">            <div>

              @foreach ($members as $index => $member)

                <tr>              <label class="block text-sm font-medium text-gray-700 mb-2">Tahun Akademik <span                <option value="FKIP">Fakultas Keguruan dan Ilmu Pendidikan (FKIP)</option>                <option value="FKIP">Fakultas Keguruan dan Ilmu Pendidikan (FKIP)</option>

                  <td class="px-4 py-3 text-sm text-gray-900">{{ $member['name'] }}</td>

                  <td class="px-4 py-3 text-sm text-gray-600">{{ $member['email'] }}</td>                  class="text-red-500">*</span></label>

                  <td class="px-4 py-3 text-sm text-gray-600">{{ $member['nidn_nip_nim'] ?? '-' }}</td>

                  <td class="px-4 py-3 text-sm">              <input type="text" wire:model="academic_year" placeholder="2025/2026"                <option value="FIB">Fakultas Ilmu Budaya (FIB)</option>                <option value="FIB">Fakultas Ilmu Budaya (FIB)</option>

                    <button type="button" wire:click="removeMember({{ $index }})"

                      class="text-red-600 hover:text-red-800 font-medium">                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

                      Hapus

                    </button>              @error('academic_year') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror                <option value="FEB">Fakultas Ekonomi dan Bisnis (FEB)</option>                <option value="FEB">Fakultas Ekonomi dan Bisnis (FEB)</option>

                  </td>

                </tr>            </div>

              @endforeach

            </tbody>          </div>                <option value="FISIP">Fakultas Ilmu Sosial dan Ilmu Pemerintahan (FISIP)</option>                <option value="FISIP">Fakultas Ilmu Sosial dan Ilmu Pemerintahan (FISIP)</option>

          </table>

        </div>        </div>

      @endif

                <option value="FTI">Fakultas Teknologi Informasi (FTI)</option>                <option value="FTI">Fakultas Teknologi Informasi (FTI)</option>

      <button type="button" wire:click="toggleAddMemberForm"

        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">        {{-- 4. Detail Kegiatan --}}

        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">

          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>        <div class="mb-6 p-4 bg-gray-50 rounded-lg">                <option value="FIKES">Fakultas Ilmu Kesehatan (FIKES)</option>                <option value="FIKES">Fakultas Ilmu Kesehatan (FIKES)</option>

        </svg>

        {{ $showAddMemberForm ? 'Tutup Form' : 'Tambah Anggota' }}          <h3 class="text-lg font-semibold mb-4">4. Detail Kegiatan</h3>

      </button>

              </select>              </select>

      @if ($showAddMemberForm)

        <div class="mt-4 p-4 bg-gray-50 border border-gray-200 rounded-lg">          <div class="grid grid-cols-1 gap-4">

          <h4 class="font-semibold text-gray-900 mb-4">Form Tambah Anggota</h4>

            <div>              @error('faculty') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror              @error('faculty') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>              <label class="block text-sm font-medium text-gray-700 mb-2">Nama Instansi/Lembaga Tujuan <span

              <label class="block text-sm font-medium text-gray-700 mb-2">

                Email <span class="text-red-500">*</span>                  class="text-red-500">*</span></label>            </div>            </div>

              </label>

              <input type="email" wire:model="member_email"              <input type="text" wire:model="institution_name"

                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

              @error('member_email')                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>

              @enderror              @error('institution_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

            </div>

            </div>            <div>            <div>

            <div>

              <label class="block text-sm font-medium text-gray-700 mb-2">

                Nama Lengkap <span class="text-red-500">*</span>

              </label>            <div>              <label class="block text-sm font-medium text-gray-700 mb-2">Jabatan Akademik <span              <label class="block text-sm font-medium text-gray-700 mb-2">Jabatan Akademik <span

              <input type="text" wire:model="member_name"

                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">              <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Instansi/Lembaga <span

              @error('member_name')

                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>                  class="text-red-500">*</span></label>                  class="text-red-500">*</span> <span class="text-xs text-gray-500">(Bisa pilih lebih dari                  class="text-red-500">*</span> <span class="text-xs text-gray-500">(Bisa pilih lebih dari

              @enderror

            </div>              <textarea wire:model="institution_address" rows="2"



            <div>                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>                  satu)</span></label>                  satu)</span></label>

              <label class="block text-sm font-medium text-gray-700 mb-2">NIDN/NIP/NIM</label>

              <input type="text" wire:model="member_nidn_nip_nim"              @error('institution_address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

            </div>            </div>              <div class="space-y-2">              <div class="space-y-2">



            <div>

              <label class="block text-sm font-medium text-gray-700 mb-2">Fakultas</label>

              <select wire:model="member_faculty"            <div>                <label class="flex items-center">                <label class="flex items-center">

                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

                <option value="">Pilih Fakultas</option>              <label class="block text-sm font-medium text-gray-700 mb-2">Judul Penelitian/Tema Kegiatan/Topik <span

                <option value="FKIP">FKIP</option>

                <option value="FIB">FIB</option>                  class="text-red-500">*</span></label>                  <input type="checkbox" wire:model="academic_positions" value="asisten_ahli"                  <input type="checkbox" wire:model="academic_positions" value="asisten_ahli"

                <option value="FEB">FEB</option>

                <option value="FISIP">FISIP</option>              <input type="text" wire:model="research_title"

                <option value="FTI">FTI</option>

                <option value="FIKES">FIKES</option>                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">

              </select>

            </div>              @error('research_title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror



            <div>            </div>                  <span class="ml-2 text-sm">Asisten Ahli</span>                  <span class="ml-2 text-sm">Asisten Ahli</span>

              <label class="block text-sm font-medium text-gray-700 mb-2">Jabatan Akademik</label>

              <input type="text" wire:model="member_academic_position"

                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

            </div>            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">                </label>                </label>



            <div class="md:col-span-2">              <div>

              <label class="block text-sm font-medium text-gray-700 mb-2">

                Asal Instansi <span class="text-red-500">*</span>                <label class="block text-sm font-medium text-gray-700 mb-2">Estimasi Biaya (Rp)</label>                <label class="flex items-center">                <label class="flex items-center">

              </label>

              <div class="space-y-2">                <input type="number" wire:model="estimated_budget" placeholder="0"

                <label class="flex items-center">

                  <input type="checkbox" wire:model="member_institutions" value="dosen_unsap"                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">                  <input type="checkbox" wire:model="academic_positions" value="lektor"                  <input type="checkbox" wire:model="academic_positions" value="lektor"

                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">

                  <span class="ml-2 text-sm text-gray-700">Dosen UNSAP</span>                @error('estimated_budget') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                </label>

                <label class="flex items-center">              </div>                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">

                  <input type="checkbox" wire:model="member_institutions" value="mahasiswa_unsap"

                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">            </div>

                  <span class="ml-2 text-sm text-gray-700">Mahasiswa UNSAP</span>

                </label>                  <span class="ml-2 text-sm">Lektor</span>                  <span class="ml-2 text-sm">Lektor</span>

                <div>

                  <input type="text" wire:model="member_custom_institution" placeholder="Atau tulis instansi lain..."            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

                </div>              <div>                </label>                </label>

              </div>

              @error('member_institutions')                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Pimpinan Instansi <span

                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>

              @enderror                    class="text-red-500">*</span></label>                <label class="flex items-center">                <label class="flex items-center">

            </div>

          </div>                <input type="text" wire:model="leader_name"



          <div class="mt-4">                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">                  <input type="checkbox" wire:model="academic_positions" value="lektor_kepala"                  <input type="checkbox" wire:model="academic_positions" value="lektor_kepala"

            <button type="button" wire:click="addMember"

              class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">                @error('leader_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

              Simpan Anggota

            </button>              </div>                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">

          </div>

        </div>

      @endif

    </div>              <div>                  <span class="ml-2 text-sm">Lektor Kepala</span>                  <span class="ml-2 text-sm">Lektor Kepala</span>



    {{-- 6. Dokumen & Publikasi --}}                <label class="block text-sm font-medium text-gray-700 mb-2">Nama PIC/Penanggung Jawab <span

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">

      <h3 class="text-lg font-semibold text-gray-900 mb-4">6. Dokumen & Publikasi</h3>                    class="text-red-500">*</span></label>                </label>                </label>



      <div class="space-y-4">                <input type="text" wire:model="pic_name"

        {{-- Display existing file if available --}}

        @if ($existingFile)                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">                <label class="flex items-center">                <label class="flex items-center">

          <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">

            <div class="flex items-center justify-between">                @error('pic_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

              <div class="flex items-center">

                <svg class="w-8 h-8 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">              </div>                  <input type="checkbox" wire:model="academic_positions" value="guru_besar"                  <input type="checkbox" wire:model="academic_positions" value="guru_besar"

                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"

                    d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">            </div>

                  </path>

                </svg>          </div>                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">

                <div>

                  <p class="text-sm font-medium text-gray-900">File Saat Ini:</p>        </div>

                  <p class="text-sm text-gray-600">{{ basename($existingFile) }}</p>

                </div>                  <span class="ml-2 text-sm">Guru Besar</span>                  <span class="ml-2 text-sm">Guru Besar</span>

              </div>

              <a href="{{ Storage::url($existingFile) }}" target="_blank"        {{-- 5. Anggota Tim --}}

                class="text-blue-600 hover:text-blue-800 text-sm font-medium">

                Download        <div class="mb-6 p-4 bg-gray-50 rounded-lg">                </label>                </label>

              </a>

            </div>          <h3 class="text-lg font-semibold mb-4">5. Anggota Tim</h3>

          </div>

        @endif              </div>              </div>



        <div>          @if (session()->has('member_success'))

          <label class="block text-sm font-medium text-gray-700 mb-2">

            Upload File Laporan Baru            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded text-sm">              @error('academic_positions') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror              @error('academic_positions') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

            <span class="text-xs text-gray-500">(PDF/DOC/DOCX, Max 10MB)</span>

          </label>              {{ session('member_success') }}

          <input type="file" wire:model="report_file" accept=".pdf,.doc,.docx"

            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">            </div>            </div>            </div>

          @error('report_file')

            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>          @endif

          @enderror

          </div>          </div>

          <div wire:loading wire:target="report_file" class="mt-2">

            <div class="flex items-center text-sm text-blue-600">          @if (count($members) > 0)

              <svg class="animate-spin h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24">

                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>            <div class="mb-4">        </div>        </div>

                <path class="opacity-75" fill="currentColor"

                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">              <table class="min-w-full divide-y divide-gray-200">

                </path>

              </svg>                <thead class="bg-gray-100">

              Uploading...

            </div>                  <tr>

          </div>

        </div>                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Nama</th>        {{-- Periode --}}        {{-- Continue with remaining sections... This is getting too long, will split into part 2 --}}



        <div>                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Email</th>

          <label class="block text-sm font-medium text-gray-700 mb-2">

            Link Publikasi/Dokumen Online                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">NIDN/NIP/NIM</th>        <div class="mb-6 p-4 bg-gray-50 rounded-lg">

          </label>

          <input type="url" wire:model="publication_link" placeholder="https://example.com/document"                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Aksi</th>

            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

          @error('publication_link')                  </tr>          <h3 class="text-lg font-semibold mb-4">Periode Kegiatan</h3>      </form>

            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>

          @enderror                </thead>

        </div>

      </div>                <tbody class="bg-white divide-y divide-gray-200">    </div>

    </div>

                  @foreach ($members as $index => $member)

    {{-- Submit Buttons --}}

    <div class="flex items-center gap-3">                    <tr>          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">  </div>

      <button type="submit"

        class="inline-flex items-center px-6 py-3 bg-blue-800 text-white text-sm font-medium rounded-lg hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-800 transition-colors">                      <td class="px-4 py-2 text-sm">{{ $member['name'] }}</td>

        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">

          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"                      <td class="px-4 py-2 text-sm">{{ $member['email'] }}</td>            <div></div>

            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>

        </svg>                      <td class="px-4 py-2 text-sm">{{ $member['nidn_nip_nim'] ?? '-' }}</td>              <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai <span

        Update Draft

      </button>                      <td class="px-4 py-2 text-sm">                  class="text-red-500">*</span></label>

      <a href="{{ route('letter.assignment.detail', $assignmentId) }}"

        class="inline-flex items-center px-6 py-3 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">                        <button type="button" wire:click="removeMember({{ $index }})"              <input type="date" wire:model="start_date"

        Batal

      </a>                          class="text-red-600 hover:text-red-800 text-xs">                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

    </div>

                          Hapus              @error('start_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

  </form>

                        </button>            </div>

</div>

                      </td>

                    </tr>            <div>

                  @endforeach              <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Berakhir <span

                </tbody>                  class="text-red-500">*</span></label>

              </table>              <input type="date" wire:model="end_date"

            </div>                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

          @endif              @error('end_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

            </div>

          <button type="button" wire:click="toggleAddMemberForm"

            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">            <div>

            {{ $showAddMemberForm ? 'Tutup Form' : '+ Tambah Anggota' }}              <label class="block text-sm font-medium text-gray-700 mb-2">Tahun Akademik <span

          </button>                  class="text-red-500">*</span></label>

              <input type="text" wire:model="academic_year" placeholder="2025/2026"

          @if ($showAddMemberForm)                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

            <div class="mt-4 p-4 bg-white border border-gray-200 rounded-lg">              @error('academic_year') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

              <h4 class="font-semibold mb-3 text-sm">Form Tambah Anggota</h4>            </div>

          </div>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">        </div>

                <div>

                  <label class="block text-sm font-medium text-gray-700 mb-1">Email <span        {{-- Detail Kegiatan --}}

                      class="text-red-500">*</span></label>        <div class="mb-6 p-4 bg-gray-50 rounded-lg">

                  <input type="email" wire:model="member_email"          <h3 class="text-lg font-semibold mb-4">Detail Kegiatan</h3>

                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

                  @error('member_email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror          <div class="space-y-4">

                </div>            <div>

              <label class="block text-sm font-medium text-gray-700 mb-2">Nama Objek/Instansi/Lembaga Penelitian dan

                <div>                Pengabdian <span class="text-red-500">*</span></label>

                  <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span              <input type="text" wire:model="institution_name"

                      class="text-red-500">*</span></label>                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

                  <input type="text" wire:model="member_name"              @error('institution_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">            </div>

                  @error('member_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                </div>            <div>

              <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Objek/Instansi/Lembaga Penelitian

                <div>                <span class="text-red-500">*</span></label>

                  <label class="block text-sm font-medium text-gray-700 mb-1">NIDN/NIP/NIM</label>              <textarea wire:model="institution_address" rows="3"

                  <input type="text" wire:model="member_nidn_nip_nim"                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>

                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">              @error('institution_address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                </div>            </div>



                <div>            <div>

                  <label class="block text-sm font-medium text-gray-700 mb-1">Fakultas</label>              <label class="block text-sm font-medium text-gray-700 mb-2">Judul/Tema/Topik Penelitian dan Pengabdian

                  <select wire:model="member_faculty"                <span class="text-red-500">*</span></label>

                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">              <textarea wire:model="research_title" rows="2"

                    <option value="">Pilih Fakultas</option>                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>

                    <option value="FKIP">FKIP</option>              @error('research_title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                    <option value="FIB">FIB</option>            </div>

                    <option value="FEB">FEB</option>

                    <option value="FISIP">FISIP</option>            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <option value="FTI">FTI</option>              <div>

                    <option value="FIKES">FIKES</option>                <label class="block text-sm font-medium text-gray-700 mb-2">Estimasi Biaya Kegiatan (Rp)</label>

                  </select>                <input type="number" wire:model="estimated_budget" placeholder="0"

                </div>                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

                @error('estimated_budget') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                <div>              </div>

                  <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan Akademik</label>            </div>

                  <input type="text" wire:model="member_academic_position"

                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                </div>              <div>

                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Pimpinan <span

                <div class="md:col-span-2">                    class="text-red-500">*</span></label>

                  <label class="block text-sm font-medium text-gray-700 mb-2">Asal Instansi <span                <input type="text" wire:model="leader_name"

                      class="text-red-500">*</span></label>                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

                  <div class="space-y-2">                @error('leader_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                    <label class="flex items-center">              </div>

                      <input type="checkbox" wire:model="member_institutions" value="dosen_unsap"

                        class="rounded border-gray-300">              <div>

                      <span class="ml-2 text-sm">Dosen UNSAP</span>                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Penanggung Jawab <span

                    </label>                    class="text-red-500">*</span></label>

                    <label class="flex items-center">                <input type="text" wire:model="pic_name"

                      <input type="checkbox" wire:model="member_institutions" value="mahasiswa_unsap"                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

                        class="rounded border-gray-300">                @error('pic_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                      <span class="ml-2 text-sm">Mahasiswa UNSAP</span>              </div>

                    </label>            </div>

                    <div>          </div>

                      <input type="text" wire:model="member_custom_institution" placeholder="Atau tulis instansi lain"        </div>

                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

                    </div>        {{-- Anggota Tim --}}

                  </div>        <div class="mb-6 p-4 bg-gray-50 rounded-lg">

                  @error('member_institutions') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror          <div class="flex justify-between items-center mb-4">

                </div>            <h3 class="text-lg font-semibold">Anggota Tim ({{ count($members) }} orang)</h3>

              </div>            <button type="button" wire:click="toggleAddMemberForm"

              class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">

              <div class="mt-4">              {{ $showAddMemberForm ? 'Tutup Form' : '+ Tambah Anggota' }}

                <button type="button" wire:click="addMember"            </button>

                  class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 text-sm">          </div>

                  Simpan Anggota

                </button>          @if (session()->has('member_success'))

              </div>            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded text-sm">

            </div>              {{ session('member_success') }}

          @endif            </div>

        </div>          @endif



        {{-- 6. Dokumen & Publikasi --}}          @if ($showAddMemberForm)

        <div class="mb-6 p-4 bg-gray-50 rounded-lg">            <div class="bg-white p-4 rounded-lg border-2 border-blue-200 mb-4">

          <h3 class="text-lg font-semibold mb-4">6. Dokumen & Publikasi</h3>              <h4 class="font-semibold mb-3 text-blue-800">Form Tambah Anggota</h4>



          <div class="grid grid-cols-1 gap-4">              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>                <div>

              <label class="block text-sm font-medium text-gray-700 mb-2">Upload File Laporan (PDF/DOC/DOCX, Max                  <label class="block text-sm font-medium text-gray-700 mb-1">Email <span

                10MB)</label>                      class="text-red-500">*</span></label>

              <input type="file" wire:model="report_file" accept=".pdf,.doc,.docx"                  <input type="email" wire:model="member_email"

                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

              @error('report_file') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror                  @error('member_email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                </div>

              <div wire:loading wire:target="report_file" class="text-sm text-blue-600 mt-2">

                Uploading...                <div>

              </div>                  <label class="block text-sm font-medium text-gray-700 mb-1">Nama <span

            </div>                      class="text-red-500">*</span></label>

                  <input type="text" wire:model="member_name"

            <div>                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

              <label class="block text-sm font-medium text-gray-700 mb-2">Link Publikasi/Dokumen Online</label>                  @error('member_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

              <input type="url" wire:model="publication_link" placeholder="https://"                </div>

                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

              @error('publication_link') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror                <div>

            </div>                  <label class="block text-sm font-medium text-gray-700 mb-1">NIDN/NIP/NIM</label>

          </div>                  <input type="text" wire:model="member_nidn_nip_nim"

        </div>                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

                  @error('member_nidn_nip_nim') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

        {{-- Submit Buttons --}}                </div>

        <div class="flex gap-2">

          <button type="submit"                <div>

            class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 font-medium">                  <label class="block text-sm font-medium text-gray-700 mb-1">Fakultas</label>

            Update Draft                  <select wire:model="member_faculty"

          </button>                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

          <a href="{{ route('letter.assignment.index') }}"                    <option value="">Pilih Fakultas</option>

            class="px-6 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 font-medium">                    <option value="FKIP">FKIP</option>

            Batal                    <option value="FIB">FIB</option>

          </a>                    <option value="FEB">FEB</option>

        </div>                    <option value="FISIP">FISIP</option>

                    <option value="FTI">FTI</option>

      </form>                    <option value="FIKES">FIKES</option>

                  </select>

    </div>                  @error('member_faculty') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                </div>

  </div>

</div>                <div>

                  <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan Akademik (atau isi yang
                    lain)</label>
                  <input type="text" wire:model="member_academic_position" placeholder="e.g., Lektor, Mahasiswa, dll"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                  @error('member_academic_position') <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                  @enderror
                </div>

                <div class="md:col-span-2">
                  <label class="block text-sm font-medium text-gray-700 mb-2">Lembaga/Instansi <span
                      class="text-red-500">*</span> <span class="text-xs text-gray-500">(Bisa pilih lebih dari
                      satu)</span></label>
                  <div class="space-y-2">
                    <label class="flex items-center">
                      <input type="checkbox" wire:model="member_institutions" value="dosen_unsap"
                        class="rounded border-gray-300 text-blue-600">
                      <span class="ml-2 text-sm">Dosen UNSAP</span>
                    </label>
                    <label class="flex items-center">
                      <input type="checkbox" wire:model="member_institutions" value="mahasiswa_unsap"
                        class="rounded border-gray-300 text-blue-600">
                      <span class="ml-2 text-sm">Mahasiswa UNSAP</span>
                    </label>
                    <div>
                      <input type="text" wire:model="member_custom_institution"
                        placeholder="Atau isi lembaga lain..."
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                    </div>
                  </div>
                  @error('member_institutions') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
              </div>

              <div class="mt-4 flex gap-2">
                <button type="button" wire:click="addMember"
                  class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 text-sm">
                  Simpan Anggota
                </button>
                <button type="button" wire:click="toggleAddMemberForm"
                  class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 text-sm">
                  Batal
                </button>
              </div>
            </div>
          @endif

          {{-- List Members --}}
          @if (count($members) > 0)
            <div class="space-y-2">
              @foreach ($members as $index => $member)
                <div class="bg-white p-3 rounded-lg border flex justify-between items-start">
                  <div>
                    <p class="font-medium">{{ $member['name'] }}</p>
                    <p class="text-sm text-gray-600">{{ $member['email'] }}</p>
                    @if (isset($member['nidn_nip_nim']) && $member['nidn_nip_nim'])
                      <p class="text-xs text-gray-500">{{ $member['nidn_nip_nim'] }}</p>
                    @endif
                    @if (isset($member['academic_position']) && $member['academic_position'])
                      <p class="text-xs text-gray-500">{{ $member['academic_position'] }}</p>
                    @endif
                    <div class="flex gap-1 mt-1 flex-wrap">
                      @foreach ($member['institutions'] as $inst)
                        <span class="px-2 py-0.5 bg-blue-100 text-blue-800 text-xs rounded">{{ $inst }}</span>
                      @endforeach
                    </div>
                  </div>
                  <button type="button" wire:click="removeMember({{ $index }})"
                    class="text-red-600 hover:text-red-800 text-sm">
                    Hapus
                  </button>
                </div>
              @endforeach
            </div>
          @else
            <p class="text-sm text-gray-500">Belum ada anggota ditambahkan</p>
          @endif
        </div>

        {{-- Dokumen & Publikasi --}}
        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
          <h3 class="text-lg font-semibold mb-4">Dokumen & Publikasi</h3>

          <div class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Upload File Laporan/Artikel (PDF/DOC/DOCX,
                max 10MB)</label>
              <input type="file" wire:model="report_file" accept=".pdf,.doc,.docx"
                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
              @error('report_file') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
              <div wire:loading wire:target="report_file" class="text-sm text-blue-600 mt-1">Uploading...</div>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Link Publikasi</label>
              <input type="url" wire:model="publication_link" placeholder="https://..."
                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
              @error('publication_link') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
          </div>
        </div>

        {{-- Submit Buttons --}}
        <div class="flex gap-3">
          <button type="submit"
            class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 font-medium">
            Update Draft
          </button>
          <a href="{{ route('letter.assignment.index') }}"
            class="px-6 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 font-medium">
            Batal
          </a>
        </div>

      </form>
    </div>
  </div>
</div>
