<?php

namespace App\Http\Livewire\Admin\Tags;

use App\Models\Tag;
use Illuminate\Support\Str;
use Livewire\Component;

class TagCreate extends Component
{
    public $name = '';
    public $slug = '';
    public $description = '';
    public $color = '';

    protected $rules = [
        'name' => 'required|min:2|max:255|unique:tags,name',
        'slug' => 'required|min:2|max:255|unique:tags,slug',
        'description' => 'nullable|max:1000',
        'color' => 'nullable|max:50',
    ];

    public function updatedName()
    {
        $this->slug = Str::slug($this->name);
    }

    public function save()
    {
        $this->validate();

        Tag::create([
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'color' => $this->color,
        ]);

        session()->flash('message', 'Etiket başarıyla oluşturuldu.');
        return redirect()->route('admin.tags.index');
    }

    public function render()
    {
        return view('livewire.admin.tags.tag-create');
    }
} 