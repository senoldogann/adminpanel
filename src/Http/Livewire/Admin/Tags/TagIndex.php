<?php

namespace App\Http\Livewire\Admin\Tags;

use App\Models\Tag;
use Livewire\Component;
use Livewire\WithPagination;

class TagIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';
    
    public $showDeleteModal = false;
    public $tagId;
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

    public function openDeleteModal($tagId)
    {
        $this->tagId = $tagId;
        $tag = Tag::findOrFail($tagId);
        $this->name = $tag->name;
        $this->showDeleteModal = true;
    }

    public function deleteTag()
    {
        $tag = Tag::findOrFail($this->tagId);
        
        // İlişkili bağlantıları kaldır
        $tag->posts()->detach();
        
        // Etiketi sil
        $tag->delete();
        
        $this->showDeleteModal = false;
        session()->flash('message', 'Etiket başarıyla silindi.');
    }

    public function render()
    {
        $tags = Tag::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.admin.tags.tag-index', [
            'tags' => $tags,
        ]);
    }
} 