<?php

namespace App\Http\Livewire\Admin\Posts;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class PostEdit extends Component
{
    use WithFileUploads;

    public Post $post;
    
    public $title;
    public $slug;
    public $content;
    public $excerpt;
    public $category_id;
    public $tags = [];
    public $status;
    public $featured_image;
    public $new_featured_image;
    public $published_at;

    protected function rules()
    {
        return [
            'title' => 'required|min:3|max:255',
            'slug' => 'required|min:3|max:255|unique:posts,slug,' . $this->post->id,
            'content' => 'required',
            'excerpt' => 'nullable|max:500',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'status' => 'required|in:draft,published,pending,private',
            'new_featured_image' => 'nullable|image|max:2048',
            'published_at' => 'nullable|date',
        ];
    }

    public function mount(Post $post)
    {
        $this->post = $post;
        $this->title = $post->title;
        $this->slug = $post->slug;
        $this->content = $post->content;
        $this->excerpt = $post->excerpt;
        $this->category_id = $post->category_id;
        $this->tags = $post->tags->pluck('id')->toArray();
        $this->status = $post->status;
        $this->featured_image = $post->featured_image;
        $this->published_at = $post->published_at ? $post->published_at->format('Y-m-d H:i:s') : now()->format('Y-m-d H:i:s');
    }

    public function updatedTitle()
    {
        if ($this->title !== $this->post->title) {
            $this->slug = Str::slug($this->title);
        }
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
            'published_at' => $this->status === 'published' ? $this->published_at : null,
        ];

        if ($this->new_featured_image) {
            // Eski görseli sil
            if ($this->featured_image && Storage::disk('public')->exists($this->featured_image)) {
                Storage::disk('public')->delete($this->featured_image);
            }
            
            // Yeni görseli kaydet
            $data['featured_image'] = $this->new_featured_image->store('posts', 'public');
        }

        $this->post->update($data);

        // Etiketleri güncelle
        $this->post->tags()->sync($this->tags);

        session()->flash('message', 'Yazı başarıyla güncellendi.');
        return redirect()->route('admin.posts.index');
    }

    public function removeFeaturedImage()
    {
        if ($this->featured_image && Storage::disk('public')->exists($this->featured_image)) {
            Storage::disk('public')->delete($this->featured_image);
        }
        
        $this->post->update(['featured_image' => null]);
        $this->featured_image = null;
    }

    public function render()
    {
        return view('livewire.admin.posts.post-edit', [
            'categories' => Category::orderBy('name')->get(),
            'allTags' => Tag::orderBy('name')->get(),
        ]);
    }
} 