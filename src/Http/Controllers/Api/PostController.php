<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Post::with(['category', 'tags', 'user'])
            ->where('status', 'published');

        // Kategori filtresi
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        
        // Etiket filtresi
        if ($request->has('tag_id')) {
            $query->whereHas('tags', function($q) use ($request) {
                $q->where('tags.id', $request->tag_id);
            });
        }
        
        // Arama filtresi
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Sıralama
        $sortField = $request->sort_by ?? 'created_at';
        $sortOrder = $request->sort_order ?? 'desc';
        $query->orderBy($sortField, $sortOrder);

        $perPage = $request->per_page ?? 10;
        $posts = $query->paginate($perPage);

        return response()->json([
            'status' => true,
            'data' => $posts
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $post = Post::with(['category', 'tags', 'user'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Görüntülenme sayısını artır
        $post->increment('views');

        return response()->json([
            'status' => true,
            'data' => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Get all categories.
     */
    public function categories()
    {
        $categories = Category::withCount(['posts' => function($query) {
            $query->where('status', 'published');
        }])->get();

        return response()->json([
            'status' => true,
            'data' => $categories
        ]);
    }

    /**
     * Get all tags.
     */
    public function tags()
    {
        $tags = Tag::withCount(['posts' => function($query) {
            $query->where('status', 'published');
        }])->get();

        return response()->json([
            'status' => true,
            'data' => $tags
        ]);
    }

    /**
     * Get popular posts.
     */
    public function popular()
    {
        $posts = Post::with(['category', 'tags', 'user'])
            ->where('status', 'published')
            ->orderBy('views', 'desc')
            ->limit(5)
            ->get();

        return response()->json([
            'status' => true,
            'data' => $posts
        ]);
    }

    /**
     * Get recent posts.
     */
    public function recent()
    {
        $posts = Post::with(['category', 'tags', 'user'])
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return response()->json([
            'status' => true,
            'data' => $posts
        ]);
    }
}
