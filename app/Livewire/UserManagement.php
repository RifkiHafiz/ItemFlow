<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class UserManagement extends Component
{
//    #[Validate('required')]
//    public $full_name = '';
//
//    #[Validate('required')]
//    public $username = '';
//
//    #[Validate('required')]
//    public $email = '';
//
//    #[Validate('required')]
//    public $password = '';
//
//
//    public function update()
//    {
//        $this->validate();
//
//        $user = Auth::user();
//        $user->full_name = $this->full_name;
//        $user->username = $this->username;
//        $user->email = $this->email;
//        $user->password = Hash::make($this->password);
//
//        $user->save();
//
//        return redirect()->route('user-management');
//    }
//
//    public function render()
//    {
//        return view('livewire.user-management', [
//            'users' => User::all()
//        ]);
//    }

    public $users;
    public $roles;
    public $selectedUser;

    // Modal States
    public $showCreateModal = false;
    public $showEditModal = false;
    public $showDeleteModal = false;

    // Form Fields
    public $username;
    public $full_name;
    public $email;
    public $password;
    public $selectedRole;

    protected $rules = [
        'full_name' => 'required|min:3',
        'username' => 'required|min:3|unique:users',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
        'selectedRole' => 'required|exists:roles,name'
    ];

    public function mount()
    {
        $this->roles = Role::all();
        $this->refreshUsers();
    }

    public function render()
    {
        return view('livewire.user-management');
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->showCreateModal = true;
    }

    public function openEditModal($userId)
    {
        $user = User::findOrFail($userId);
        $this->selectedUser = $user;
        $this->full_name = $user->full_name;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->selectedRole = $user->getRoleNames()->first();
        $this->showEditModal = true;
    }

    public function openDeleteModal($userId)
    {
        $this->selectedUser = User::findOrFail($userId);
        $this->showDeleteModal = true;
    }

//    public function createUser()
//    {
//        $this->validate();
//
//        try {
//            $user = User::create([
//                'full_name' => $this->full_name,
//                'username' => $this->username,
//                'email' => $this->email,
//                'password' => Hash::make($this->password)
//            ]);
//
//            $user->assignRole($this->selectedRole);
//
//            $this->closeModals();
//            $this->dispatch('alert', type: 'success', message: 'User berhasil dibuat');
//
//        } catch (\Exception $e) {
//            $this->dispatch('alert', type: 'error', message: 'Error: '.$e->getMessage());
//        }
//    }

    public function updateUser()
    {
        $this->validate([
            'email' => Rule::unique('users')->ignore($this->selectedUser->id),
            'password' => 'nullable|min:6',
            'selectedRole' => 'required'
        ]);

        $data = [
            'name' => $this->name,
            'email' => $this->email
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        $this->selectedUser->update($data);
        $this->selectedUser->syncRoles($this->selectedRole);

        $this->closeModals();
        $this->refreshUsers();
    }

    public function deleteUser()
    {
        $this->selectedUser->loans()->delete();

        $this->selectedUser->delete();
        $this->closeModals();
        $this->refreshUsers();
    }

    public function refreshUsers()
    {
        $this->users = User::with('roles')->get();
    }

    public function resetForm()
    {
        $this->reset(['full_name' ,'username', 'email', 'password', 'selectedRole']);
    }

    public function closeModals()
    {
        $this->reset(['showCreateModal', 'showEditModal', 'showDeleteModal', 'selectedUser']);
        $this->resetForm();
    }
}
