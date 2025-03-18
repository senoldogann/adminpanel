<?php

namespace App\Http\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $role = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    
    public $showRolesModal = false;
    public $showDeleteModal = false;
    
    public $userId;
    public $name;
    public $email;
    public $selectedRoles = [];
    public $availableRoles;
    
    protected $queryString = [
        'search' => ['except' => ''],
        'role' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];
    
    public function mount()
    {
        $this->availableRoles = Role::all();
    }
    
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }
    
    public function openRolesModal($userId)
    {
        $this->userId = $userId;
        $user = User::findOrFail($userId);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->selectedRoles = $user->roles->pluck('id')->toArray();
        $this->showRolesModal = true;
    }
    
    public function updateRoles()
    {
        $user = User::findOrFail($this->userId);
        $user->syncRoles($this->selectedRoles);
        
        $this->showRolesModal = false;
        session()->flash('message', 'Kullanıcı rolleri başarıyla güncellendi.');
    }
    
    public function openDeleteModal($userId)
    {
        // Kendimizi silmeye çalışmıyoruz değil mi?
        if ($userId === auth()->id()) {
            session()->flash('error', 'Kendi hesabınızı silemezsiniz.');
            return;
        }
        
        $this->userId = $userId;
        $user = User::findOrFail($userId);
        $this->name = $user->name;
        $this->showDeleteModal = true;
    }
    
    public function deleteUser()
    {
        // Ekstra kontrol
        if ($this->userId === auth()->id()) {
            session()->flash('error', 'Kendi hesabınızı silemezsiniz.');
            $this->showDeleteModal = false;
            return;
        }
        
        $user = User::findOrFail($this->userId);
        
        try {
            DB::transaction(function () use ($user) {
                // Kullanıcının rollerini kaldır
                $user->syncRoles([]);
                
                // Kullanıcıyı sil
                $user->delete();
            });
            
            session()->flash('message', 'Kullanıcı başarıyla silindi.');
        } catch (\Exception $e) {
            session()->flash('error', 'Kullanıcı silinirken bir hata oluştu: ' . $e->getMessage());
        }
        
        $this->showDeleteModal = false;
    }
    
    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                          ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->role, function ($query) {
                $query->whereHas('roles', function ($query) {
                    $query->where('name', $this->role);
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);
        
        $roles = Role::all();
        
        return view('livewire.admin.users.user-index', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }
}