<x-slot name="sidebar">
    <x-layouts.app.sidebar-pengajuan-surat />
</x-slot>
<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

    {{-- 1. HEADER PAGE --}}
    <div class="flex items-start justify-between mb-8">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="px-2 py-1 text-xs font-bold rounded bg-indigo-100 text-indigo-700">
                    {{ $submission->scheme->code }}
                </span>
                <span class="text-sm text-gray-500">{{ $submission->period->name }}</span>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 leading-tight max-w-3xl">
                {{ $submission->title }}
            </h1>
            <div class="flex items-center gap-4 mt-2 text-sm text-gray-600">
                <div class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span>{{ $submission->user->name }} (Ketua)</span>
                </div>
                <div class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Diajukan: {{ $submission->created_at->format('d M Y') }}</span>
                </div>
            </div>
        </div>

        {{-- Status Badge Besar --}}
        <div class="text-right">
            @php
                $colors = [
                    'DRAFT' => 'bg-gray-100 text-gray-800',
                    'SUBMITTED' => 'bg-blue-100 text-blue-800',
                    'APPROVED' => 'bg-green-100 text-green-800',
                    'REJECTED' => 'bg-red-100 text-red-800',
                ];
                $color = $colors[$submission->status] ?? 'bg-gray-100';
            @endphp
            <span class="px-4 py-2 rounded-lg text-sm font-bold {{ $color }}">
                {{ $submission->status }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- KOLOM KIRI: DATA UTAMA (2/3 layar) --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Abstrak --}}
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Abstrak Proposal</h3>
                <p class="text-gray-700 leading-relaxed whitespace-pre-line">
                    {{ $submission->abstract }}
                </p>
            </div>

            {{-- Tim Peneliti --}}
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Anggota Tim</h3>
                <div class="space-y-3">
                    @foreach($submission->members as $member)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <div class="font-bold text-gray-900">{{ $member->name }}</div>
                                <div class="text-xs text-gray-500">{{ $member->identifier_number ?? '-' }}</div>
                            </div>
                            <span class="px-2 py-1 text-xs font-medium bg-white border border-gray-200 rounded">
                                {{ $member->role }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Dokumen --}}
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Dokumen Lampiran</h3>
                @foreach($submission->documents as $doc)
                    <div class="flex items-center justify-between p-3 border border-indigo-100 bg-indigo-50 rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="bg-indigo-200 p-2 rounded text-indigo-700">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <div class="font-medium text-gray-900 text-sm">Proposal Lengkap.pdf</div>
                                <div class="text-xs text-gray-500">{{ number_format($doc->file_size / 1024, 0) }} KB •
                                    Uploaded {{ $doc->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        <a href="{{ Storage::url($doc->file_path) }}" target="_blank"
                            class="text-indigo-600 hover:text-indigo-800 text-sm font-bold underline">
                            Download
                        </a>
                    </div>
                @endforeach
            </div>

            {{-- RAB Detail --}}
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                <div class="flex justify-between items-center mb-4 border-b pb-2">
                    <h3 class="text-lg font-bold text-gray-900">Rincian Anggaran (RAB)</h3>
                    <span class="text-lg font-bold text-indigo-600">Total: Rp
                        {{ number_format($submission->total_budget_proposed) }}</span>
                </div>
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-left">Item</th>
                            <th class="px-3 py-2 text-center">Vol</th>
                            <th class="px-3 py-2 text-right">Harga</th>
                            <th class="px-3 py-2 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($submission->budgetDetails as $budget)
                            <tr>
                                <td class="px-3 py-2">{{ $budget->item_description }}</td>
                                <td class="px-3 py-2 text-center">{{ $budget->volume }} {{ $budget->unit }}</td>
                                <td class="px-3 py-2 text-right">{{ number_format($budget->unit_cost) }}</td>
                                <td class="px-3 py-2 text-right font-medium">{{ number_format($budget->total_cost) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

        {{-- KOLOM KANAN: ACTION PANEL (1/3 layar) --}}
        <div class="space-y-6">

            {{-- TOMBOL BACK --}}
            <a href="{{ route('grants.list') }}"
                class="block w-full text-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                &larr; Kembali ke Daftar
            </a>

            {{-- PANEL REVIEWER (Hanya muncul jika user adalah Reviewer/Admin) --}}
            @role('reviewer|super-admin')
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 shadow-sm">
                <h3 class="text-lg font-bold text-yellow-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Panel Penilaian
                </h3>

                @if($submission->status === 'SUBMITTED')
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Skor Penilaian (0-100)</label>
                            <input type="number" wire:model="score"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm">
                            @error('score') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Catatan Reviewer</label>
                            <textarea wire:model="comment" rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm"
                                placeholder="Berikan masukan atau alasan penolakan..."></textarea>
                            @error('comment') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-3 pt-2">
                            <button wire:click="submitReview('REJECT')" wire:confirm="Yakin tolak proposal ini?"
                                class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none">
                                Tolak 🚫
                            </button>
                            <button wire:click="submitReview('ACCEPT')" wire:confirm="Yakin setujui proposal ini?"
                                class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none">
                                Setujui ✅
                            </button>
                        </div>
                    </div>
                @else
                    <div class="text-center p-4 bg-white rounded border border-yellow-100">
                        <p class="text-sm text-gray-500">Proposal ini sudah direview.</p>
                        <p class="font-bold mt-1 text-gray-800">Status: {{ $submission->status }}</p>
                    </div>
                @endif
                @if($submission->status === 'APPROVED')
                    <div class="mt-4 bg-green-50 border border-green-200 rounded-xl p-4 shadow-sm animate-pulse-once">
                        <h4 class="text-green-800 font-bold flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Pendanaan Disetujui!
                        </h4>
                        <p class="text-sm text-green-700 mt-1 mb-3">
                            Selamat! Proposal Anda telah disetujui untuk didanai. Silakan unduh kontrak penelitian di bawah
                            ini.
                        </p>

                        <a href="{{ route('grants.contract', $submission->id) }}" target="_blank"
                            class="flex items-center justify-center w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            Download Kontrak Penelitian (PDF)
                        </a>
                    </div>
                @endif
            </div>
            @endrole

        </div>

    </div>
</div>