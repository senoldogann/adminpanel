<?php

namespace App\Http\Livewire\Admin\Categories;

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Component;

class CategoryCreate extends Component
{
    public $name = '';
    public $slug = '';
    public $description = '';
    public $parent_id = null;

    protected $rules = [
        'name' => 'required|min:2|max:255|unique:categories,name',
        'slug' => 'required|min:2|max:255|unique:categories,slug',
        'description' => 'nullable|max:1000',
        'parent_id' => 'nullable|exists:categories,id',
    ];

    public function updatedName()
    {
        $this->slug = Str::slug($this->name);
    }

    public function save()
    {
        $this->validate();

        Category::create([
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'parent_id' => $this->parent_id,
        ]);

        session()->flash('message', 'Kategori başarıyla oluşturuldu.');
        return redirect()->route('admin.categories.index');
    }

    public function render()
    {
        $parentCategories = Category::where('parent_id', null)->get();
        
        return view('livewire.admin.categories.category-create', [
            'parentCategories' => $parentCategories,
        ]);
    }
} 