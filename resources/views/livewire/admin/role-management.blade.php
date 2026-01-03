<x-slot name="sidebar">
  <flux:navlist.group heading="Admin Panel">
    <flux:navlist.item icon="users" href="{{ route('admin.users') }}" :current="request()->routeIs('admin.users')">
      Manajemen User
    </flux:navlist.item>

    <flux:navlist.item icon="shield-check" href="{{ route('admin.roles') }}"
      :current="request()->routeIs('admin.roles')">
      Manajemen Role
    </flux:navlist.item>
  </flux:navlist.group>

  <flux:separator class="my-4" />

  <flux:navlist.item icon="arrow-left" href="{{ route('portal') }}">
    Kembali ke Portal
  </flux:navlist.item>
</x-slot>

<div class="max-w-7xl mx-auto py-8 px-4">
  {{-- Header --}}
  <div class="mb-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
      <div class="bg-blue-800 px-8 py-6 border-b-2 border-blue-900">
        <div class="flex items-center space-x-4">
          <div class="w-12 h-12 bg-white rounded-md flex items-center justify-center">
            <svg class="w-7 h-7 text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
              </path>
            </svg>
          </div>
          <div>
            <h1 class="text-2xl font-bold text-white">Manajemen Role User</h1>
            <p class="text-blue-100 text-sm font-medium">Kelola role dan permission untuk setiap user</p>
          </div>
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

  {{-- Filters --}}
  <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      {{-- Search --}}
      <div>
        <label class="block text-sm font-bold text-gray-700 mb-2">Cari User</label>
        <input type="text" wire:model.live="search"
          class="block w-full rounded-md border-gray-300 focus:border-blue-800 focus:ring-2 focus:ring-blue-200 text-sm"
          placeholder="Nama, email, atau NIDN...">
      </div>

      {{-- Filter Role --}}
      <div>
        <label class="block text-sm font-bold text-gray-700 mb-2">Filter Role</label>
        <select wire:model.live="filterRole"
          class="block w-full rounded-md border-gray-300 focus:border-blue-800 focus:ring-2 focus:ring-blue-200 text-sm">
          <option value="">Semua Role</option>
          @foreach($allRoles as $role)
            <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
          @endforeach
        </select>
      </div>

      {{-- Per Page --}}
      <div>
        <label class="block text-sm font-bold text-gray-700 mb-2">Items per page</label>
        <select wire:model.live="perPage"
          class="block w-full rounded-md border-gray-300 focus:border-blue-800 focus:ring-2 focus:ring-blue-200 text-sm">
          <option value="5">5</option>
          <option value="10">10</option>
          <option value="25">25</option>
          <option value="50">50</option>
          <option value="100">100</option>
        </select>
      </div>
    </div>
  </div>

  {{-- Users Table --}}
  <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    @if($users->count() > 0)
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                User
              </th>
              <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                Email
              </th>
              <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                NIDN
              </th>
              <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                Roles
              </th>
              <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                Aksi
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @foreach($users as $user)
              <tr class="hover:bg-gray-50 transition-colors duration-150">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div
                      class="w-10 h-10 bg-blue-800 rounded-full flex items-center justify-center text-white font-bold mr-3">
                      {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                      <p class="text-sm font-bold text-gray-900">{{ $user->name }}</p>
                      <p class="text-xs text-gray-500">
                        Bergabung {{ $user->created_at->diffForHumans() }}
                      </p>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <p class="text-sm text-gray-900">{{ $user->email }}</p>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <p class="text-sm text-gray-900">{{ $user->nidn ?? '-' }}</p>
                </td>
                <td class="px-6 py-4">
                  <div class="flex flex-wrap gap-1">
                    @forelse($user->roles as $role)
                      @if($role->name === 'super-admin')
                        <span
                          class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800">
                          <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                              d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                              clip-rule="evenodd"></path>
                          </svg>
                          Super Admin
                        </span>
                      @elseif($role->name === 'reviewer')
                        <span
                          class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-800">
                          <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                              d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                              clip-rule="evenodd"></path>
                          </svg>
                          Reviewer
                        </span>
                      @else
                        <span
                          class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                          {{ ucfirst($role->name) }}
                        </span>
                      @endif
                    @empty
                      <span class="text-xs text-gray-500 italic">Belum ada role</span>
                    @endforelse
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                  <button wire:click="openRoleModal({{ $user->id }})"
                    class="inline-flex items-center px-3 py-1.5 bg-indigo-600 text-white rounded-lg text-xs font-bold hover:bg-indigo-700 transition-colors duration-200">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                      </path>
                    </svg>
                    Kelola Role
                  </button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      {{-- Pagination --}}
      <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
        <div class="flex flex-col sm:flex-row items-center justify-between space-y-3 sm:space-y-0">
          {{-- Pagination Info --}}
          <div class="text-sm text-gray-700">
            Menampilkan
            <span class="font-semibold text-gray-900">{{ $users->firstItem() ?? 0 }}</span>
            sampai
            <span class="font-semibold text-gray-900">{{ $users->lastItem() ?? 0 }}</span>
            dari
            <span class="font-semibold text-gray-900">{{ $users->total() }}</span>
            user
          </div>

          {{-- Pagination Links --}}
          <div>
            {{ $users->links() }}
          </div>
        </div>
      </div>
    @else
      {{-- Empty State --}}
      <div class="text-center py-12">
        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
          </path>
        </svg>
        <h3 class="mt-4 text-lg font-bold text-gray-900">Tidak Ada User</h3>
        <p class="mt-2 text-sm text-gray-600">Tidak ada user yang sesuai dengan filter.</p>
      </div>
    @endif
  </div>

  {{-- Role Management Modal (continues in next part due to character limit) --}}
  @if($showModal && $selectedUser)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
      <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        {{-- Background overlay --}}
        <div class="fixed inset-0 bg-black opacity-50 transition-opacity" wire:click="closeModal"
          style="backdrop-filter: blur(2px);"></div>

        {{-- Center helper --}}
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        {{-- Modal panel --}}
        <div
          class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full z-50">
          {{-- Header --}}
          <div class="bg-gradient-to-r from-indigo-700 to-purple-800 px-6 py-4 border-b-4 border-indigo-600">
            <div class="flex items-center justify-between">
              <div class="flex items-center space-x-3">
                <div
                  class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm border border-white/30">
                  <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                    </path>
                  </svg>
                </div>
                <h3 class="text-xl font-bold text-white">Kelola Role User</h3>
              </div>
              <button wire:click="closeModal" class="text-white hover:text-gray-200 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                  </path>
                </svg>
              </button>
            </div>
          </div>

          {{-- Content --}}
          <div class="bg-white px-6 py-6">
            {{-- User Info --}}
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 mb-6">
              <div class="flex items-center">
                <div
                  class="w-12 h-12 bg-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-lg mr-4">
                  {{ strtoupper(substr($selectedUser->name, 0, 1)) }}
                </div>
                <div>
                  <p class="text-lg font-bold text-gray-900">{{ $selectedUser->name }}</p>
                  <p class="text-sm text-gray-600">{{ $selectedUser->email }}</p>
                  @if($selectedUser->nidn)
                    <p class="text-xs text-gray-500">NIDN: {{ $selectedUser->nidn }}</p>
                  @endif
                </div>
              </div>
            </div>

            {{-- Role Selection --}}
            <div>
              <label class="block text-sm font-bold text-gray-700 mb-3">Pilih Role</label>
              <div class="space-y-3">
                @foreach($allRoles as $role)
                  <label
                    class="flex items-center p-4 rounded-lg border-2 cursor-pointer transition-all duration-200 {{ in_array($role->name, $selectedRoles) ? 'border-indigo-600 bg-indigo-50' : 'border-gray-200 hover:border-indigo-300 bg-white' }}">
                    <input type="checkbox" wire:model="selectedRoles" value="{{ $role->name }}"
                      class="w-5 h-5 text-indigo-600 rounded focus:ring-2 focus:ring-indigo-500">
                    <div class="ml-4 flex-1">
                      <div class="flex items-center justify-between">
                        <span class="text-sm font-bold text-gray-900">{{ ucfirst($role->name) }}</span>
                        @if($role->name === 'super-admin')
                          <span
                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                              <path fill-rule="evenodd"
                                d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"></path>
                            </svg>
                            Full Access
                          </span>
                        @elseif($role->name === 'reviewer')
                          <span
                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-800">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                              <path fill-rule="evenodd"
                                d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"></path>
                            </svg>
                            Review Access
                          </span>
                        @endif
                      </div>
                      <p class="text-xs text-gray-500 mt-1">
                        @if($role->name === 'super-admin')
                          Akses penuh ke semua fitur sistem
                        @elseif($role->name === 'reviewer')
                          Dapat melakukan review dan approve/reject submission
                        @else
                          {{ $role->permissions->count() }} permissions
                        @endif
                      </p>
                    </div>
                  </label>
                @endforeach
              </div>
            </div>

            {{-- Current Permissions Info --}}
            @if(count($selectedRoles) > 0)
              <div class="mt-6 bg-blue-50 rounded-lg p-4 border border-blue-200">
                <div class="flex items-start">
                  <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <div class="flex-1">
                    <p class="text-sm font-bold text-blue-900">Role yang dipilih:</p>
                    <div class="flex flex-wrap gap-2 mt-2">
                      @foreach($selectedRoles as $roleName)
                        <span
                          class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                          {{ ucfirst($roleName) }}
                        </span>
                      @endforeach
                    </div>
                  </div>
                </div>
              </div>
            @endif
          </div>

          {{-- Footer --}}
          <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            <div class="flex items-center justify-end space-x-3">
              <button wire:click="closeModal"
                class="px-6 py-2.5 bg-gray-600 text-white rounded-lg font-semibold text-sm hover:bg-gray-700 transition-colors duration-200 shadow-md">
                Batal
              </button>
              <button wire:click="updateRoles" wire:loading.attr="disabled"
                class="px-6 py-2.5 bg-indigo-600 text-white rounded-lg font-semibold text-sm hover:bg-indigo-700 transition-colors duration-200 shadow-md">
                <span wire:loading.remove>Simpan Perubahan</span>
                <span wire:loading>Menyimpan...</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endif
</div>