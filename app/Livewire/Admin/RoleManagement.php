<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

#[Layout('components.layouts.app')]

class RoleManagement extends Component
{
  use WithPagination, AuthorizesRequests;

  public $search = '';
  public $filterRole = '';
  public $showModal = false;
  public $selectedUser = null;
  public $selectedRoles = [];
  public $perPage = 10;

  protected $queryString = [
    'search' => ['except' => ''],
    'filterRole' => ['except' => ''],
  ];

  public function mount()
  {
    // Check if user is super-admin
    $this->authorize('manage users');
  }

  public function updatingSearch()
  {
    $this->resetPage();
  }

  public function updatingFilterRole()
  {
    $this->resetPage();
  }

  public function openRoleModal($userId)
  {
    $this->selectedUser = User::with('roles')->findOrFail($userId);
    $this->selectedRoles = $this->selectedUser->roles->pluck('name')->toArray();
    $this->showModal = true;
  }

  public function closeModal()
  {
    $this->showModal = false;
    $this->selectedUser = null;
    $this->selectedRoles = [];
  }

  public function updateRoles()
  {
    $this->authorize('manage users');

    if (!$this->selectedUser) {
      session()->flash('error', 'User tidak ditemukan.');
      return;
    }

    // Sync roles
    $this->selectedUser->syncRoles($this->selectedRoles);

    session()->flash('success', 'Role user berhasil diupdate!');
    $this->closeModal();
  }

  public function render()
  {
    $query = User::with('roles');

    if ($this->search) {
      $query->where(function ($q) {
        $q->where('name', 'like', '%' . $this->search . '%')
          ->orWhere('email', 'like', '%' . $this->search . '%')
          ->orWhere('nidn', 'like', '%' . $this->search . '%');
      });
    }

    if ($this->filterRole) {
      $query->whereHas('roles', function ($q) {
        $q->where('name', $this->filterRole);
      });
    }

    $users = $query->latest()->paginate($this->perPage);
    $allRoles = Role::all();

    return view('livewire.admin.role-management', [
      'users' => $users,
      'allRoles' => $allRoles,
    ]);
  }
}
