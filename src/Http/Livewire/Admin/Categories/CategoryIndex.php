<?php

namespace App\Http\Livewire\Admin\Categories;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';
    
    public $showDeleteModal = false;
    public $categoryId;
    public $name;

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'name'],
        'sortDirection' => ['except' => 'asc'],
    ];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function openDeleteModal($categoryId)
    {
        $this->categoryId = $categoryId;
        $category = Category::findOrFail($categoryId);
        $this->name = $category->name;
        $this->showDeleteModal = true;
    }

    public function deleteCategory()
    {
        $category = Category::findOrFail($this->categoryId);
        
        // İlişkili yazılar kontrolü
        if ($category->posts()->count() > 0) {
            session()->flash('error', 'Bu kategoriye bağlı yazılar olduğu için silinemez.');
            $this->showDeleteModal = false;
            return;
        }
        
        // Kategoriyi sil
        $category->delete();
        
        $this->showDeleteModal = false;
        session()->flash('message', 'Kategori başarıyla silindi.');
    }

    public function render()
    {
        $categories = Category::query()
            ->withCount('posts')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.admin.categories.category-index', [
            'categories' => $categories,
        ]);
    }
} 