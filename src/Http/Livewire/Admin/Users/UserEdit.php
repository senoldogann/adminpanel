<?php

namespace App\Http\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class UserEdit extends Component
{
    use WithFileUploads;

    public User $user;
    public $name;
    public $email;
    public $password = '';
    public $password_confirmation = '';
    public $roles = [];
    public $avatar;
    public $new_avatar;
    
    protected function rules()
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'password' => 'nullable|min:8|confirmed',
            'password_confirmation' => 'nullable',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
            'new_avatar' => 'nullable|image|max:1024',
        ];
    }
    
    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->avatar = $user->avatar;
        $this->roles = $user->roles->pluck('id')->toArray();
    }
    
    public function save()
    {
        $this->validate();
        
        $userData = [
            'name' => $this->name,
            'email' => $this->email,
        ];
        
        if (!empty($this->password)) {
            $userData['password'] = Hash::make($this->password);
        }
        
        if ($this->new_avatar) {
            // Eski avatarı sil
            if ($this->avatar && Storage::disk('public')->exists($this->avatar)) {
                Storage::disk('public')->delete($this->avatar);
            }
            
            // Yeni avatarı kaydet
            $userData['avatar'] = $this->new_avatar->store('avatars', 'public');
        }
        
        $this->user->update($userData);
        
        // Rolleri güncelle
        $this->user->syncRoles($this->roles);
        
        session()->flash('message', 'Kullanıcı başarıyla güncellendi.');
        return redirect()->route('admin.users.index');
    }
    
    public function removeAvatar()
    {
        if ($this->avatar && Storage::disk('public')->exists($this->avatar)) {
            Storage::disk('public')->delete($this->avatar);
        }
        
        $this->user->update(['avatar' => null]);
        $this->avatar = null;
    }
    
    public function render()
    {
        return view('livewire.admin.users.user-edit', [
            'availableRoles' => Role::all(),
        ]);
    }
} 