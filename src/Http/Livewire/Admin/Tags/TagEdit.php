<?php

namespace App\Http\Livewire\Admin\Tags;

use App\Models\Tag;
use Illuminate\Support\Str;
use Livewire\Component;

class TagEdit extends Component
{
    public Tag $tag;
    
    public $name;
    public $slug;
    public $description;
    public $color;

    protected function rules()
    {
        return [
            'name' => 'required|min:2|max:255|unique:tags,name,' . $this->tag->id,
            'slug' => 'required|min:2|max:255|unique:tags,slug,' . $this->tag->id,
            'description' => 'nullable|max:1000',
            'color' => 'nullable|max:50',
        ];
    }

    public function mount(Tag $tag)
    {
        $this->tag = $tag;
        $this->name = $tag->name;
        $this->slug = $tag->slug;
        $this->description = $tag->description;
        $this->color = $tag->color;
    }

    public function updatedName()
    {
        $this->slug = Str::slug($this->name);
    }

    public function save()
    {
        $this->validate();

        $this->tag->update([
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'color' => $this->color,
        ]);

        session()->flash('message', 'Etiket başarıyla güncellendi.');
        return redirect()->route('admin.tags.index');
    }

    public function render()
    {
        return view('livewire.admin.tags.tag-edit');
    }
} 