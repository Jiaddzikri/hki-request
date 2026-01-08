<div>
  <x-slot name="sidebar">
    <x-layouts.app.sidebar-hki />
  </x-slot>

  <div class="p-6 max-w-7xl mx-auto">
    {{-- Success/Error Messages --}}
    @if(session('success'))
      <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
        {{ session('success') }}
      </div>
    @endif

    @if(session('error'))
      <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
        {{ session('error') }}
      </div>
    @endif

    {{-- Header --}}
    <div class="mb-6">
      <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold text-gray-900">Detail Proposal HKI</h1>
        <div class="flex items-center gap-3">
          {{-- Tombol Review untuk Reviewer --}}
          @can('review-hki')
            @if(in_array($proposal->status, ['SUBMITTED', 'REVISION']))
              <button wire:click="$set('showReviewModal', true)"
                class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-600">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Berikan Review
              </button>
            @endif
          @endcan

          {{-- Tombol Edit untuk Pemilik Proposal --}}
          @if($proposal->status === 'REVISION' && !$isEditMode)
            <button wire:click="enableEditMode"
              class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
              </svg>
              Mulai Revisi
            </button>
          @endif

          @if($isEditMode)
            <button wire:click="saveRevision"
              class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
              Simpan & Ajukan Ulang
            </button>
            <button wire:click="cancelEdit"
              class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
              Batal
            </button>
          @endif

          <a href="{{ route('hki.list') }}" class="text-sm text-blue-600 hover:text-blue-800">
            ← Kembali ke Daftar
          </a>
        </div>
      </div>

      {{-- Alert untuk Status Revisi --}}
      @if($proposal->status === 'REVISION' && !$isEditMode)
        <div class="mb-4 bg-orange-50 border-l-4 border-orange-400 p-4">
          <div class="flex">
            <div class="flex-shrink-0">
              <svg class="h-5 w-5 text-orange-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                  d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                  clip-rule="evenodd" />
              </svg>
            </div>
            <div class="ml-3">
              <p class="text-sm text-orange-700">
                <strong>Proposal memerlukan revisi.</strong> Silakan klik tombol "Mulai Revisi" untuk melakukan perbaikan.
              </p>
            </div>
          </div>
        </div>
      @endif

      {{-- Status Badge --}}
      <div class="mb-4">
        @php
          $statusColors = [
            'DRAFT' => 'bg-gray-100 text-gray-800',
            'SUBMITTED' => 'bg-blue-100 text-blue-800',
            'REVISION' => 'bg-orange-100 text-orange-800',
            'APPROVED' => 'bg-green-100 text-green-800',
            'REJECTED' => 'bg-red-100 text-red-800',
          ];
        @endphp
        <span
          class="px-3 py-1 inline-flex text-sm font-semibold rounded-full {{ $statusColors[$proposal->status] ?? 'bg-gray-100 text-gray-800' }}">
          {{ $proposal->status }}
        </span>
      </div>
    </div>

    {{-- Main Content --}}
    <div class="bg-white shadow rounded-lg p-6 mb-6">
      <h2 class="text-lg font-semibold mb-4">Informasi Proposal</h2>

      <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <dt class="text-sm font-medium text-gray-500">Judul</dt>
          @if($isEditMode)
            <input type="text" wire:model="title"
              class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
              placeholder="Masukkan judul proposal">
            @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          @else
            <dd class="mt-1 text-sm text-gray-900">{{ $proposal->title }}</dd>
          @endif
        </div>

        <div>
          <dt class="text-sm font-medium text-gray-500">Kategori HKI</dt>
          @if($isEditMode)
            <select wire:model="hki_type_id"
              class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
              <option value="">Pilih Kategori</option>
              @foreach($hkiTypes as $type)
                <option value="{{ $type->id }}">{{ $type->name }}</option>
              @endforeach
            </select>
            @error('hki_type_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          @else
            <dd class="mt-1 text-sm text-gray-900">{{ $proposal->type->name ?? '-' }}</dd>
          @endif
        </div>

        <div>
          <dt class="text-sm font-medium text-gray-500">Negara Publikasi</dt>
          @if($isEditMode)
            <select wire:model="publication_country"
              class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
              <option value="">Pilih Negara</option>
              @foreach(\App\Helpers\Countries::countries() as $code => $name)
                <option value="{{ $code }}">{{ $name }}</option>
              @endforeach
            </select>
            @error('publication_country') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          @else
            <dd class="mt-1 text-sm text-gray-900">
              {{ $proposal->publication_country ? \App\Helpers\Countries::getCountryName($proposal->publication_country) : '-' }}
            </dd>
          @endif
        </div>

        <div>
          <dt class="text-sm font-medium text-gray-500">Kota Publikasi</dt>
          @if($isEditMode)
            <input type="text" wire:model="publication_city"
              class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
              placeholder="Masukkan kota">
            @error('publication_city') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          @else
            <dd class="mt-1 text-sm text-gray-900">{{ $proposal->publication_city ?? '-' }}</dd>
          @endif
        </div>

        <div>
          <dt class="text-sm font-medium text-gray-500">Tanggal Publikasi</dt>
          @if($isEditMode)
            <input type="date" wire:model="publication_date"
              class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
            @error('publication_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          @else
            <dd class="mt-1 text-sm text-gray-900">
              {{ $proposal->publication_date ? \Carbon\Carbon::parse($proposal->publication_date)->format('d F Y') : '-' }}
            </dd>
          @endif
        </div>

        <div>
          <dt class="text-sm font-medium text-gray-500">Pengusul</dt>
          <dd class="mt-1 text-sm text-gray-900">{{ $proposal->user->name ?? 'N/A' }}</dd>
        </div>
      </dl>

      @if($proposal->description || $isEditMode)
        <div class="mt-4 pt-4 border-t">
          <dt class="text-sm font-medium text-gray-500 mb-2">Deskripsi</dt>
          @if($isEditMode)
            <textarea wire:model="description" rows="4"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
              placeholder="Masukkan deskripsi proposal"></textarea>
            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          @else
            <dd class="text-sm text-gray-700">{{ $proposal->description }}</dd>
          @endif
        </div>
      @endif
    </div>

    {{-- Anggota Tim --}}
    <div class="bg-white shadow rounded-lg p-6 mb-6">
      <h2 class="text-lg font-semibold mb-4">Anggota Tim ({{ $proposal->members->count() }} orang)</h2>
      @if($proposal->members->count() > 0)
        <ul class="divide-y divide-gray-200">
          @foreach($proposal->members as $member)
            <li class="py-3">
              @if($editingMemberId === $member->id)
                {{-- Edit Form --}}
                <div class="space-y-3">
                  <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Nama</label>
                    <input type="text" wire:model="editMemberName"
                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm">
                    @error('editMemberName') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                  </div>
                  <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Role</label>
                    <input type="text" wire:model="editMemberRole"
                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm">
                    @error('editMemberRole') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                  </div>
                  <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">NIDN (Opsional)</label>
                    <input type="text" wire:model="editMemberNidn"
                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm">
                    @error('editMemberNidn') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                  </div>
                  <div class="flex gap-2">
                    <button wire:click="saveMember"
                      class="px-3 py-1.5 bg-blue-600 text-white text-xs font-medium rounded hover:bg-blue-700">
                      Simpan
                    </button>
                    <button wire:click="cancelEditMember"
                      class="px-3 py-1.5 border border-gray-300 text-gray-700 text-xs font-medium rounded hover:bg-gray-50">
                      Batal
                    </button>
                  </div>
                </div>
              @else
                {{-- Display Mode --}}
                <div class="flex justify-between items-start">
                  <div>
                    <p class="text-sm font-medium text-gray-900">{{ $member->name ?? 'N/A' }}</p>
                    <p class="text-sm text-gray-500">{{ $member->role ?? 'N/A' }}</p>
                    @if($member->nidn)
                      <p class="text-xs text-gray-400">NIDN: {{ $member->nidn }}</p>
                    @endif
                  </div>
                  @if($proposal->status === 'REVISION' && $proposal->user_id === auth()->id())
                    <button wire:click="editMember({{ $member->id }})"
                      class="px-2 py-1 text-xs text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded">
                      Edit
                    </button>
                  @endif
                </div>
              @endif
            </li>
          @endforeach
        </ul>
      @else
        <p class="text-sm text-gray-500">Tidak ada anggota tim</p>
      @endif
    </div>

    {{-- Dokumen --}}
    <div class="bg-white shadow rounded-lg p-6 mb-6">
      <h2 class="text-lg font-semibold mb-4">Dokumen Pendukung ({{ $proposal->documents->count() }} file)</h2>
      @if($proposal->documents->count() > 0)
        <ul class="divide-y divide-gray-200">
          @foreach($proposal->documents as $doc)
            <li class="py-3">
              @if($replacingDocumentId === $doc->id)
                {{-- Replace Form --}}
                <div class="space-y-3">
                  <div>
                    <p class="text-sm font-medium text-gray-900 mb-2">Mengganti: {{ $doc->name ?? 'Dokumen' }}</p>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Pilih File Baru</label>
                    <input type="file" wire:model="newDocumentFile"
                      accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                      class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    @error('newDocumentFile') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    <p class="text-xs text-gray-400 mt-1">Format: PDF, DOC, DOCX, JPG, JPEG, PNG (Maks. 10MB)</p>
                  </div>
                  <div class="flex gap-2">
                    <button wire:click="replaceDocument"
                      class="px-3 py-1.5 bg-blue-600 text-white text-xs font-medium rounded hover:bg-blue-700"
                      wire:loading.attr="disabled">
                      <span wire:loading.remove wire:target="replaceDocument">Simpan</span>
                      <span wire:loading wire:target="replaceDocument">Mengunggah...</span>
                    </button>
                    <button wire:click="cancelReplaceDocument"
                      class="px-3 py-1.5 border border-gray-300 text-gray-700 text-xs font-medium rounded hover:bg-gray-50">
                      Batal
                    </button>
                  </div>
                </div>
              @else
                {{-- Display Mode --}}
                <div class="flex justify-between items-center">
                  <div>
                    <p class="text-sm font-medium text-gray-900">{{ $doc->name ?? 'Dokumen' }}</p>
                    <p class="text-xs text-gray-500">
                      {{ $doc->mime_type ?? '-' }} • {{ $doc->file_size ? number_format($doc->file_size / 1024, 2) . ' KB' : '-' }}
                    </p>
                  </div>
                  <div class="flex gap-2">
                    @if($doc->file_path)
                      <a href="{{ Storage::url($doc->file_path) }}" target="_blank"
                        class="text-sm text-blue-600 hover:text-blue-800">
                        Lihat
                      </a>
                    @endif
                    @if($proposal->status === 'REVISION' && $proposal->user_id === auth()->id())
                      <button wire:click="startReplaceDocument({{ $doc->id }})"
                        class="px-2 py-1 text-xs text-orange-600 hover:text-orange-800 hover:bg-orange-50 rounded">
                        Ganti
                      </button>
                    @endif
                  </div>
                </div>
              @endif
            </li>
          @endforeach
        </ul>
      @else
        <p class="text-sm text-gray-500">Tidak ada dokumen pendukung</p>
      @endif
    </div>

    {{-- Review History --}}
    @if($proposal->reviews->count() > 0)
      <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-lg font-semibold mb-4">Riwayat Review</h2>
        <ul class="divide-y divide-gray-200">
          @foreach($proposal->reviews as $review)
              <li class="py-3">
                <div class="mb-2">
                  <span
                    class="px-2 py-1 text-xs font-semibold rounded 
                        {{ $review->decision === 'approved' ? 'bg-green-100 text-green-800' :
            ($review->decision === 'revision' ? 'bg-orange-100 text-orange-800' : 'bg-red-100 text-red-800') }}">
                    {{ strtoupper($review->decision) }}
                  </span>
                </div>
                <p class="text-sm text-gray-600">{{ $review->review_notes ?? '-' }}</p>
                <p class="text-xs text-gray-400 mt-1">
                  oleh {{ $review->reviewer->name ?? 'Unknown' }} • {{ $review->reviewed_at ? $review->reviewed_at->format('d M Y, H:i') : ($review->created_at ? $review->created_at->format('d M Y, H:i') : '-') }}
                </p>
              </li>
          @endforeach
        </ul>
      </div>
    @endif

    {{-- Audit Trail --}}
    @if($proposal->auditLogs->count() > 0)
      <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-semibold mb-4">Audit Trail</h2>
        <ul class="divide-y divide-gray-200">
          @foreach($proposal->auditLogs->take(10) as $log)
            <li class="py-3">
              <p class="text-sm font-medium text-gray-900">{{ $log->action ?? 'Action' }}</p>
              <p class="text-xs text-gray-500">
                oleh {{ $log->user->name ?? 'System' }} • {{ $log->created_at->format('d M Y, H:i') }}
              </p>
            </li>
          @endforeach
        </ul>
      </div>
    @endif

    {{-- Review Modal --}}
    @if($showReviewModal)
      <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
          <div class="fixed inset-0 bg-gray-900/50" wire:click="$set('showReviewModal', false)"></div>
          
          <div class="relative bg-white rounded-lg max-w-lg w-full shadow-xl">
            <div class="bg-blue-800 px-6 py-4">
              <h3 class="text-lg font-semibold text-white">Review Proposal HKI</h3>
            </div>

            <div class="px-6 py-4 space-y-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Keputusan Review <span class="text-red-600">*</span>
                </label>
                <div class="grid grid-cols-3 gap-2">
                  <button type="button" wire:click="$set('reviewDecision', 'approved')"
                    class="px-4 py-2 text-sm font-medium rounded-lg border-2 {{ $reviewDecision === 'approved' ? 'bg-green-100 border-green-600 text-green-800' : 'border-gray-300 hover:bg-gray-50' }}">
                    Setujui
                  </button>
                  <button type="button" wire:click="$set('reviewDecision', 'revision')"
                    class="px-4 py-2 text-sm font-medium rounded-lg border-2 {{ $reviewDecision === 'revision' ? 'bg-orange-100 border-orange-600 text-orange-800' : 'border-gray-300 hover:bg-gray-50' }}">
                    Revisi
                  </button>
                  <button type="button" wire:click="$set('reviewDecision', 'rejected')"
                    class="px-4 py-2 text-sm font-medium rounded-lg border-2 {{ $reviewDecision === 'rejected' ? 'bg-red-100 border-red-600 text-red-800' : 'border-gray-300 hover:bg-gray-50' }}">
                    Tolak
                  </button>
                </div>
                @error('reviewDecision') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Catatan Reviewer
                  @if(in_array($reviewDecision, ['revision', 'rejected']))
                    <span class="text-red-600">*</span>
                  @endif
                </label>
                <textarea wire:model="reviewNotes" rows="4"
                  class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm"
                  placeholder="Masukkan catatan review..."></textarea>
                @error('reviewNotes') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
              </div>
            </div>

            <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3">
              <button type="button" wire:click="$set('showReviewModal', false)"
                class="px-4 py-2 border rounded-lg text-sm font-medium hover:bg-gray-50">
                Batal
              </button>
              <button type="button" wire:click="submitReview"
                class="px-4 py-2 bg-blue-800 text-white rounded-lg text-sm font-medium hover:bg-blue-900">
                Simpan Review
              </button>
            </div>
          </div>
        </div>
      </div>
    @endif
  </div>
</div>
</div>