<x-slot name="sidebar">
    <x-layouts.app.sidebar-hki />
</x-slot>
<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

    <div class="md:flex md:items-center md:justify-between mb-8">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                {{ $proposal->title }}
            </h2>
            <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                <div class="mt-2 flex items-center text-sm text-gray-500">
                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    {{ $proposal->type->name ?? '-' }}
                </div>
                <div class="mt-2 flex items-center text-sm text-gray-500">
                    <span
                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                        {{ $proposal->status }}
                    </span>
                </div>
            </div>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4">
            <a href="{{ route('hki.dashboard') }}"
                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 space-y-6">

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Tim Pengusul</h3>
                </div>
                <ul role="list" class="divide-y divide-gray-200">
                    @foreach($proposal->members as $member)
                        <li class="px-4 py-4 sm:px-6">
                            <div class="flex items-center justify-between">
                                <div class="text-sm font-medium text-indigo-600 truncate">{{ $member->name }}</div>
                                <div class="ml-2 flex-shrink-0 flex">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $member->role == 'KETUA' ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $member->role }}
                                    </span>
                                </div>
                            </div>
                            <div class="mt-2 sm:flex sm:justify-between">
                                <div class="sm:flex">
                                    <p class="flex items-center text-sm text-gray-500">
                                        NIK: {{ $member->nik }}
                                    </p>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg leading-6 font-bold text-gray-900 flex items-center">
                        <svg class="h-5 w-5 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Repositori Dokumen & Integritas File
                    </h3>
                    <p class="mt-1 max-w-2xl text-xs text-gray-500">
                        Hash SHA-256 dihitung dari konten fisik file. Jika file di server berubah 1 byte saja, hash ini
                        tidak akan cocok.
                    </p>
                </div>
                <ul role="list" class="divide-y divide-gray-200">
                    @foreach($proposal->documents as $doc)
                        <li class="px-4 py-4 sm:px-6 hover:bg-gray-50 transition">
                            <div class="flex items-center justify-between">
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-gray-900">{{ $doc->name }}</span>
                                    <span class="text-xs text-gray-500">{{ number_format($doc->file_size / 1024, 2) }} KB |
                                        {{ $doc->mime_type }}</span>
                                </div>
                                <a href="{{ Storage::url($doc->file_path) }}" target="_blank"
                                    class="text-indigo-600 hover:text-indigo-900 text-sm font-bold">Download</a>
                            </div>

                            <div
                                class="mt-3 bg-gray-100 p-2 rounded text-xs font-mono text-gray-600 break-all border border-gray-300">
                                <span class="font-bold text-gray-500 select-none">SHA-256:</span> {{ $doc->file_hash }}
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>

        <div class="lg:col-span-1">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg sticky top-6">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200 bg-yellow-50">
                    <h3 class="text-lg leading-6 font-bold text-yellow-800">
                        Audit Trail
                    </h3>
                    <p class="mt-1 text-xs text-yellow-600">
                        Catatan aktivitas immutable (Anti-Repudiation).
                    </p>
                </div>

                <div class="flow-root p-6">
                    <ul role="list" class="-mb-8">
                        @foreach($proposal->auditLogs as $log)
                            <li>
                                <div class="relative pb-8">
                                    @if(!$loop->last)
                                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200"
                                            aria-hidden="true"></span>
                                    @endif
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span
                                                class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white">
                                                <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-500">
                                                    <span class="font-medium text-gray-900">{{ $log->action }}</span>
                                                    oleh <span
                                                        class="font-medium text-gray-900">{{ $log->user->name }}</span>
                                                </p>

                                                <div class="text-right">
                                                    <div class="text-sm text-gray-500 mb-1">
                                                        <time
                                                            datetime="{{ $log->created_at }}">{{ $log->created_at->diffForHumans() }}</time>
                                                    </div>

                                                    @livewire('hki.forensic.verifier', ['logId' => $log->id], key($log->id))

                                                </div>
                                                <div class="mt-2">
                                                    <div class="text-[10px] text-gray-400 font-mono">Current Hash:</div>
                                                    <div class="text-[10px] text-green-700 font-mono bg-green-50 px-1 truncate w-40 sm:w-52"
                                                        title="{{ $log->current_hash }}">
                                                        {{ Str::limit($log->current_hash, 20) }}...
                                                    </div>

                                                    <div class="text-[10px] text-gray-400 font-mono mt-1">Prev Hash:</div>
                                                    <div class="text-[10px] text-gray-500 font-mono bg-gray-50 px-1 truncate w-40 sm:w-52"
                                                        title="{{ $log->previous_hash }}">
                                                        {{ Str::limit($log->previous_hash, 20) }}...
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                <time
                                                    datetime="{{ $log->created_at }}">{{ $log->created_at->diffForHumans() }}</time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>