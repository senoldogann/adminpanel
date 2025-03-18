<?php

namespace App\Http\Livewire\Admin\Categories;

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Component;

class CategoryEdit extends Component
{
    public Category $category;
    
    public $name;
    public $slug;
    public $description;
    public $parent_id;

    protected function rules()
    {
        return [
            'name' => 'required|min:2|max:255|unique:categories,name,' . $this->category->id,
            'slug' => 'required|min:2|max:255|unique:categories,slug,' . $this->category->id,
            'description' => 'nullable|max:1000',
            'parent_id' => 'nullable|exists:categories,id',
        ];
    }

    public function mount(Category $category)
    {
        $this->category = $category;
        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->description = $category->description;
        $this->parent_id = $category->parent_id;
    }

    public function updatedName()
    {
        $this->slug = Str::slug($this->name);
    }

    public function save()
    {
        $this->validate();

        // Alt kategorilerin döngüye girmemesi için kontrol
        if ($this->parent_id == $this->category->id) {
            session()->flash('error', 'Kategori kendisinin üst kategorisi olamaz.');
            return;
        }

        // Alt kategoriler kontrol ediliyor
        $childrenIds = $this->getAllChildrenIds($this->category->id);
        if (in_array($this->parent_id, $childrenIds)) {
            session()->flash('error', 'Bir kategori, alt kategorisinin üst kategorisi olamaz.');
            return;
        }

        $this->category->update([
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'parent_id' => $this->parent_id,
        ]);

        session()->flash('message', 'Kategori başarıyla güncellendi.');
        return redirect()->route('admin.categories.index');
    }

    private function getAllChildrenIds($categoryId)
    {
        $children = Category::where('parent_id', $categoryId)->get(['id']);
        $ids = $children->pluck('id')->toArray();

        foreach ($children as $child) {
            $ids = array_merge($ids, $this->getAllChildrenIds($child->id));
        }

        return $ids;
    }

    public function render()
    {
        $parentCategories = Category::where('id', '!=', $this->category->id)
            ->whereNotIn('id', $this->getAllChildrenIds($this->category->id))
            ->get();
        
        return view('livewire.admin.categories.category-edit', [
            'parentCategories' => $parentCategories,
        ]);
    }
} 