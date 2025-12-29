<x-slot name="sidebar">
    <x-layouts.app.sidebar-pengajuan-surat />
</x-slot>
<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    {{-- Header Page --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Riwayat Hibah & Penelitian</h2>
            <p class="text-sm text-gray-500">Pantau status proposal dan laporan kegiatan Anda di sini.</p>
        </div>
        <div>
            <a href="{{ route('grants.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring focus:ring-indigo-300 disabled:opacity-25 transition">
                + Buat Proposal Baru
            </a>
        </div>
    </div>

    {{-- Tabel Proposal --}}
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
        
        @if($submissions->isEmpty())
            <div class="p-10 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900">Belum ada pengajuan</h3>
                <p class="mt-1 text-sm text-gray-500">Anda belum pernah mengajukan hibah penelitian atau pengabdian.</p>
                <div class="mt-6">
                    <a href="{{ route('grants.create') }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Mulai Pengajuan Sekarang &rarr;</a>
                </div>
            </div>
        @else
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul / Skema</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dana Diajukan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($submissions as $sub)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-gray-900 line-clamp-2" title="{{ $sub->title }}">
                                    {{ $sub->title }}
                                </span>
                                <span class="text-xs text-gray-500 mt-1 bg-gray-100 w-fit px-2 py-0.5 rounded">
                                    {{ $sub->scheme->name }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $sub->period->year }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-700">
                            Rp {{ number_format($sub->total_budget_proposed) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusClasses = [
                                    'DRAFT' => 'bg-gray-100 text-gray-800',
                                    'SUBMITTED' => 'bg-blue-100 text-blue-800',
                                    'REVIEW' => 'bg-yellow-100 text-yellow-800',
                                    'APPROVED' => 'bg-green-100 text-green-800',
                                    'REJECTED' => 'bg-red-100 text-red-800',
                                ];
                                $class = $statusClasses[$sub->status] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $class }}">
                                {{ $sub->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('grants.detail', $sub->id) }}">Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            {{-- Pagination --}}
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $submissions->links() }}
            </div>
        @endif
    </div>
</div>