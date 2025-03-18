<?php

namespace App\Http\Livewire\Admin\Profile;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileSettings extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $avatar;
    public $newAvatar;
    public $currentPassword;
    public $newPassword;
    public $newPassword_confirmation;
    public $updatePasswordMode = false;

    protected $listeners = ['refresh' => '$refresh'];

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->avatar = $user->profile_photo_path;
    }

    public function saveProfile()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore(Auth::id())],
            'newAvatar' => 'nullable|image|max:1024',
        ]);

        $user = Auth::user();
        $user->name = $this->name;
        $user->email = $this->email;

        if ($this->newAvatar) {
            $avatarPath = $this->newAvatar->store('profile-photos', 'public');
            $user->profile_photo_path = $avatarPath;
            $this->avatar = $avatarPath;
        }

        $user->save();

        $this->newAvatar = null;
        session()->flash('message', 'Profil bilgileri başarıyla güncellendi.');
    }

    public function toggleUpdatePasswordMode()
    {
        $this->updatePasswordMode = !$this->updatePasswordMode;
        $this->resetPasswordFields();
    }

    public function updatePassword()
    {
        $this->validate([
            'currentPassword' => 'required|current_password',
            'newPassword' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->password = Hash::make($this->newPassword);
        $user->save();

        $this->resetPasswordFields();
        $this->updatePasswordMode = false;
        session()->flash('message', 'Şifre başarıyla güncellendi.');
    }

    protected function resetPasswordFields()
    {
        $this->currentPassword = '';
        $this->newPassword = '';
        $this->newPassword_confirmation = '';
    }

    public function render()
    {
        return view('livewire.admin.profile.profile-settings');
    }
} 