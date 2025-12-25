<x-slot name="sidebar">
    <x-layouts.app.sidebar-hki />
</x-slot>
<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Dashboard HKI Saya</h1>
        <a href="{{ route('hki.create') }}"
            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none transition ease-in-out duration-150">
            + Ajukan Baru
        </a>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">

        @if($proposals->isEmpty())
            <div class="p-10 text-center text-gray-500">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="mt-2 text-lg font-medium">Belum ada pengajuan.</p>
                <p class="text-sm">Silakan ajukan HKI pertama Anda sekarang.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul
                                / Jenis</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal Submit</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($proposals as $p)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="ml-0">
                                            <div class="text-sm font-medium text-gray-900 truncate max-w-xs"
                                                title="{{ $p->title }}">
                                                {{ Str::limit($p->title, 40) }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $p->type->name ?? 'Unknown Type' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $p->created_at->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $p->created_at->format('H:i') }} WIB</div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $colors = [
                                            'DRAFT' => 'bg-gray-100 text-gray-800',
                                            'SUBMITTED' => 'bg-blue-100 text-blue-800',
                                            'APPROVED' => 'bg-green-100 text-green-800',
                                            'REJECTED' => 'bg-red-100 text-red-800',
                                        ];
                                        $color = $colors[$p->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $color }}">
                                        {{ $p->status }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('hki.show', $p->id) }}"
                                        class="text-indigo-600 hover:text-indigo-900 font-bold">Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-gray-200">
                {{ $proposals->links() }}
            </div>
        @endif
    </div>
</div>