<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Panel Web Routes
|--------------------------------------------------------------------------
*/

Route::middleware(config('adminpanel.middleware'))
    ->prefix(config('adminpanel.prefix'))
    ->name('admin.')
    ->group(function () {
    
    // Dashboard
    Route::get('/', \SenolDogan\AdminPanel\Http\Livewire\Admin\Dashboard::class)->name('dashboard');

    // Category Routes
    Route::get('/categories', \SenolDogan\AdminPanel\Http\Livewire\Admin\Categories\CategoryIndex::class)->name('categories.index');
    
    // Tag Routes
    Route::get('/tags', \SenolDogan\AdminPanel\Http\Livewire\Admin\Tags\TagIndex::class)->name('tags.index');
    Route::get('/tags/create', \SenolDogan\AdminPanel\Http\Livewire\Admin\Tags\TagCreate::class)->name('tags.create');
    Route::get('/tags/{tag}/edit', \SenolDogan\AdminPanel\Http\Livewire\Admin\Tags\TagEdit::class)->name('tags.edit');
    
    // Post Routes
    Route::get('/posts', \SenolDogan\AdminPanel\Http\Livewire\Admin\Posts\PostIndex::class)->name('posts.index');
    Route::get('/posts/create', \SenolDogan\AdminPanel\Http\Livewire\Admin\Posts\PostCreate::class)->name('posts.create');
    Route::get('/posts/{post}/edit', \SenolDogan\AdminPanel\Http\Livewire\Admin\Posts\PostEdit::class)->name('posts.edit');
    
    // Media Routes
    Route::get('/media', \SenolDogan\AdminPanel\Http\Livewire\Admin\Media\MediaManager::class)->name('media.index');
    
    // Settings Routes
    Route::get('/settings', \SenolDogan\AdminPanel\Http\Livewire\Admin\Settings\GeneralSettings::class)->name('settings.index');
    
    // Profile Routes
    Route::get('/profile', \SenolDogan\AdminPanel\Http\Livewire\Admin\Profile\ProfileSettings::class)->name('profile.index');
    
    // User Routes - Sadece admin erişebilir
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/users', \SenolDogan\AdminPanel\Http\Livewire\Admin\Users\UserIndex::class)->name('users.index');
        Route::get('/users/create', \SenolDogan\AdminPanel\Http\Livewire\Admin\Users\UserCreate::class)->name('users.create');
        Route::get('/users/{user}/edit', \SenolDogan\AdminPanel\Http\Livewire\Admin\Users\UserEdit::class)->name('users.edit');
    });
}); 