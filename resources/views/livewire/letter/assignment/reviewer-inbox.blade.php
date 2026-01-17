<x-slot name="sidebar">
  <x-layouts.app.sidebar-pengajuan-surat />
</x-slot>

<div class="py-12">
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

    <div class="mb-6">
      <h2 class="text-2xl font-bold">Inbox Reviewer - Surat Ajuan Tugas</h2>
      <p class="text-gray-600 mt-1">Review dan kelola surat ajuan tugas yang masuk</p>
    </div>

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
            <option value="SUBMITTED">Submitted (Perlu Review)</option>
            <option value="APPROVED">Approved</option>
            <option value="REJECTED">Rejected</option>
            <option value="REVISION">Revision</option>
          </select>
        </div>
      </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
      <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="text-blue-800 text-sm font-medium">Perlu Review</div>
        <div class="text-2xl font-bold text-blue-900">
          {{ \App\Models\LtrAssignmentRequest::where('status', 'SUBMITTED')->count() }}
        </div>
      </div>
      <div class="bg-green-50 border border-green-200 rounded-lg p-4">
        <div class="text-green-800 text-sm font-medium">Approved</div>
        <div class="text-2xl font-bold text-green-900">
          {{ \App\Models\LtrAssignmentRequest::where('status', 'APPROVED')->count() }}
        </div>
      </div>
      <div class="bg-red-50 border border-red-200 rounded-lg p-4">
        <div class="text-red-800 text-sm font-medium">Rejected</div>
        <div class="text-2xl font-bold text-red-900">
          {{ \App\Models\LtrAssignmentRequest::where('status', 'REJECTED')->count() }}
        </div>
      </div>
      <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
        <div class="text-orange-800 text-sm font-medium">Revision</div>
        <div class="text-2xl font-bold text-orange-900">
          {{ \App\Models\LtrAssignmentRequest::where('status', 'REVISION')->count() }}
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
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Submit</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pengaju</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenis</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul/Tema</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Instansi</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @foreach ($assignments as $assignment)
                <tr class="{{ $assignment->status === 'SUBMITTED' ? 'bg-blue-50' : '' }}">
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    {{ $assignment->created_at->format('d M Y') }}
                  </td>
                  <td class="px-6 py-4">
                    <div class="text-sm font-medium text-gray-900">{{ $assignment->full_name }}</div>
                    <div class="text-xs text-gray-500">{{ $assignment->faculty }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span
                      class="px-2 py-1 text-xs font-medium rounded 
                                {{ $assignment->assignment_type === 'penelitian' ? 'bg-purple-100 text-purple-800' : '' }}
                                {{ $assignment->assignment_type === 'pkm' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $assignment->assignment_type === 'penunjang' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $assignment->assignment_type === 'seminar_workshop' ? 'bg-blue-100 text-blue-800' : '' }}">
                      {{ ucwords(str_replace('_', ' ', $assignment->assignment_type)) }}
                    </span>
                  </td>
                  <td class="px-6 py-4">
                    <div class="text-sm text-gray-900">{{ Str::limit($assignment->research_title, 50) }}</div>
                  </td>
                  <td class="px-6 py-4">
                    <div class="text-sm text-gray-900">{{ Str::limit($assignment->institution_name, 30) }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 py-1 text-xs font-semibold rounded 
                                {{ $assignment->status === 'SUBMITTED' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $assignment->status === 'APPROVED' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $assignment->status === 'REJECTED' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $assignment->status === 'REVISION' ? 'bg-orange-100 text-orange-800' : '' }}">
                      {{ $assignment->status }}
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm">
                    <a href="{{ route('letter.assignment.review', $assignment->id) }}"
                      class="text-blue-600 hover:text-blue-800 font-medium">
                      Review
                    </a>
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
          <p class="text-gray-500">Tidak ada surat ajuan yang perlu direview</p>
        </div>
      @endif
    </div>

  </div>
</div>