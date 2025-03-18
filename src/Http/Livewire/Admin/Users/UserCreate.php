<?php

namespace App\Http\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserCreate extends Component
{
    use WithFileUploads;

    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $roles = [];
    public $avatar;

    protected $rules = [
        'name' => 'required|string|min:3|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8|confirmed',
        'password_confirmation' => 'required',
        'roles' => 'nullable|array',
        'roles.*' => 'exists:roles,id',
        'avatar' => 'nullable|image|max:1024',
    ];
    
    public function save()
    {
        $this->validate();
        
        $userData = [
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ];
        
        if ($this->avatar) {
            $userData['avatar'] = $this->avatar->store('avatars', 'public');
        }
        
        $user = User::create($userData);
        
        if (!empty($this->roles)) {
            $user->syncRoles($this->roles);
        }
        
        session()->flash('message', 'Kullanıcı başarıyla oluşturuldu.');
        return redirect()->route('admin.users.index');
    }
    
    public function render()
    {
        return view('livewire.admin.users.user-create', [
            'availableRoles' => Role::all(),
        ]);
    }
} 