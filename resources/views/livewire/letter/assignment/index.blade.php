<x-slot name="sidebar">
  <x-layouts.app.sidebar-pengajuan-surat />
</x-slot>

<div class="py-12">
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

    <div class="mb-6 flex justify-between items-center">
      <h2 class="text-2xl font-bold">Daftar Surat Ajuan Tugas</h2>
      <a href="{{ route('letter.assignment.create') }}"
        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
        + Buat Ajuan Baru
      </a>
    </div>

    @if (session()->has('success'))
      <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
        {{ session('success') }}
      </div>
    @endif

    {{-- Search & Filter --}}
    <div class="bg-white shadow rounded-lg p-4 mb-6">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="md:col-span-2">
          <input type="text" wire:model.live="search" placeholder="Cari berdasarkan nama, judul, atau instansi..."
            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
        <div>
          <select wire:model.live="statusFilter"
            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            <option value="">Semua Status</option>
            <option value="DRAFT">Draft</option>
            <option value="SUBMITTED">Submitted</option>
            <option value="APPROVED">Approved</option>
            <option value="REJECTED">Rejected</option>
            <option value="REVISION">Revision</option>
          </select>
        </div>
      </div>
    </div>

    {{-- List --}}
    <div class="bg-white shadow rounded-lg overflow-hidden">
      @if ($assignments->count() > 0)
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenis</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul/Tema</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Instansi</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Periode</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Anggota</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @foreach ($assignments as $assignment)
                <tr>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 py-1 text-xs font-medium rounded 
                            {{ $assignment->assignment_type === 'penelitian' ? 'bg-purple-100 text-purple-800' : '' }}
                            {{ $assignment->assignment_type === 'pkm' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $assignment->assignment_type === 'penunjang' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $assignment->assignment_type === 'seminar_workshop' ? 'bg-blue-100 text-blue-800' : '' }}">
                      {{ ucwords(str_replace('_', ' ', $assignment->assignment_type)) }}
                    </span>
                  </td>
                  <td class="px-6 py-4">
                    <div class="text-sm font-medium text-gray-900">{{ Str::limit($assignment->research_title, 50) }}
                    </div>
                    <div class="text-xs text-gray-500">{{ $assignment->full_name }}</div>
                  </td>
                  <td class="px-6 py-4">
                    <div class="text-sm text-gray-900">{{ Str::limit($assignment->institution_name, 40) }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">{{ $assignment->start_date->format('d M Y') }}</div>
                    <div class="text-xs text-gray-500">s/d {{ $assignment->end_date->format('d M Y') }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span class="text-sm text-gray-900">{{ $assignment->members->count() }} orang</span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 py-1 text-xs font-semibold rounded 
                            {{ $assignment->status === 'DRAFT' ? 'bg-gray-100 text-gray-800' : '' }}
                            {{ $assignment->status === 'SUBMITTED' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $assignment->status === 'APPROVED' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $assignment->status === 'REJECTED' ? 'bg-red-100 text-red-800' : '' }}
                            {{ $assignment->status === 'REVISION' ? 'bg-orange-100 text-orange-800' : '' }}">
                      {{ $assignment->status }}
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm">
                    <div class="flex gap-2">
                      <a href="{{ route('letter.assignment.detail', $assignment->id) }}" class="text-blue-600 hover:text-blue-800">Detail</a>
                      @if ($assignment->status === 'DRAFT')
                        <button wire:click="deleteAssignment('{{ $assignment->id }}')" wire:confirm="Yakin ingin menghapus?"
                          class="text-red-600 hover:text-red-800">
                          Hapus
                        </button>
                      @endif
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <div class="px-6 py-4">
          {{ $assignments->links() }}
        </div>
      @else
        <div class="text-center py-12">
          <p class="text-gray-500">Belum ada surat ajuan tugas</p>
          <a href="{{ route('letter.assignment.create') }}"
            class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
            Buat Ajuan Pertama
          </a>
        </div>
      @endif
    </div>

  </div>
</div>