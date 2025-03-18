<?php

namespace App\Http\Livewire\Admin\Posts;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class PostCreate extends Component
{
    use WithFileUploads;

    public $title = '';
    public $slug = '';
    public $content = '';
    public $excerpt = '';
    public $category_id = null;
    public $tags = [];
    public $status = 'draft';
    public $featured_image;
    public $published_at;

    protected $rules = [
        'title' => 'required|min:3|max:255',
        'slug' => 'required|min:3|max:255|unique:posts,slug',
        'content' => 'required',
        'excerpt' => 'nullable|max:500',
        'category_id' => 'nullable|exists:categories,id',
        'tags' => 'nullable|array',
        'tags.*' => 'exists:tags,id',
        'status' => 'required|in:draft,published,pending,private',
        'featured_image' => 'nullable|image|max:2048',
        'published_at' => 'nullable|date',
    ];

    public function mount()
    {
        $this->published_at = now()->format('Y-m-d H:i:s');
    }

    public function updatedTitle()
    {
        $this->slug = Str::slug($this->title);
    }

    public function save()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'excerpt' => $this->excerpt,
            'category_id' => $this->category_id,
            'status' => $this->status,
            'user_id' => auth()->id(),
            'published_at' => $this->status === 'published' ? $this->published_at : null,
        ];

        if ($this->featured_image) {
            $data['featured_image'] = $this->featured_image->store('posts', 'public');
        }

        $post = Post::create($data);

        if (!empty($this->tags)) {
            $post->tags()->attach($this->tags);
        }

        session()->flash('message', 'Yazı başarıyla oluşturuldu.');
        return redirect()->route('admin.posts.index');
    }

    public function render()
    {
        return view('livewire.admin.posts.post-create', [
            'categories' => Category::orderBy('name')->get(),
            'allTags' => Tag::orderBy('name')->get(),
        ]);
    }
} 