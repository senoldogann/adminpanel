<?php

namespace App\Http\Livewire\Admin\Posts;

use App\Models\Post;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class PostIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $category = '';
    public $status = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    
    public $showDeleteModal = false;
    public $postId;
    public $title;

    protected $queryString = [
        'search' => ['except' => ''],
        'category' => ['except' => ''],
        'status' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
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

    public function openDeleteModal($postId)
    {
        $this->postId = $postId;
        $post = Post::findOrFail($postId);
        $this->title = $post->title;
        $this->showDeleteModal = true;
    }

    public function deletePost()
    {
        $post = Post::findOrFail($this->postId);
        
        // Görseli sil
        if ($post->featured_image && Storage::disk('public')->exists($post->featured_image)) {
            Storage::disk('public')->delete($post->featured_image);
        }
        
        // İlişkileri temizle
        $post->tags()->detach();
        
        // Yazıyı sil
        $post->delete();
        
        $this->showDeleteModal = false;
        session()->flash('message', 'Yazı başarıyla silindi.');
    }

    public function render()
    {
        $posts = Post::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('content', 'like', '%' . $this->search . '%');
            })
            ->when($this->category, function ($query) {
                $query->where('category_id', $this->category);
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        $categories = Category::orderBy('name')->get();

        return view('livewire.admin.posts.post-index', [
            'posts' => $posts,
            'categories' => $categories,
        ]);
    }
} 