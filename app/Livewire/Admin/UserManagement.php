<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\User;

use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

#[Layout('components.layouts.app')]

class UserManagement extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $users = User::with('roles')
            ->where('name', 'like', '%'.$this->search.'%')
            ->orWhere('email', 'like', '%'.$this->search.'%')
            ->paginate(10);
            
        $roles = Role::all();

        return view('livewire.admin.user-management', [
            'users' => $users,
            'allRoles' => $roles
        ]);
    }

    public function updateRole($userId, $roleName)
    {
        if(!auth()->user()->hasRole('super-admin')) {
            abort(403);
        }

        $user = User::findOrFail($userId);
        
        $user->syncRoles($roleName);
        
        session()->flash('success', "Role user {$user->name} diubah menjadi {$roleName}.");
    }
}