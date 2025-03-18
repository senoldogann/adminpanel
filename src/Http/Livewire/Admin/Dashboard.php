<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public $postCount;
    public $categoryCount;
    public $userCount;
    public $tagCount;
    public $recentPosts;
    public $popularPosts;
    public $monthlyStats;
    public $userStats;
    
    public function mount()
    {
        // Genel istatistikler
        $this->postCount = Post::count();
        $this->categoryCount = Category::count();
        $this->userCount = User::count();
        $this->tagCount = Tag::count();
        
        // Son eklenen yazılar
        $this->recentPosts = Post::with(['user', 'category'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        // En çok görüntülenen yazılar (views field'ı eklendiğini varsayıyorum)
        $this->popularPosts = Post::with(['user', 'category'])
            ->orderBy('views', 'desc')
            ->limit(5)
            ->get();
            
        // Aylık yazı istatistikleri
        $this->monthlyStats = Post::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('COUNT(*) as count')
        )
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->limit(12)
            ->get()
            ->reverse()
            ->values();
            
        // Kullanıcı istatistikleri
        $this->userStats = User::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('COUNT(*) as count')
        )
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->limit(12)
            ->get()
            ->reverse()
            ->values();
    }
    
    public function render()
    {
        return view('livewire.admin.dashboard');
    }
} 