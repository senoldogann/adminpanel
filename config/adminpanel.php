<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Admin Panel Başlık
    |--------------------------------------------------------------------------
    |
    | Admin panel sayfalarında görüntülenecek başlık
    |
    */
    'title' => 'Admin Panel CMS',

    /*
    |--------------------------------------------------------------------------
    | Rota Ön Eki
    |--------------------------------------------------------------------------
    |
    | Admin panel rotaları için ön ek
    |
    */
    'prefix' => 'admin',

    /*
    |--------------------------------------------------------------------------
    | Middleware
    |--------------------------------------------------------------------------
    |
    | Admin panel rotaları için kullanılacak middleware'ler
    |
    */
    'middleware' => [
        'web',
        'auth',
        'role:admin|editor',
    ],

    /*
    |--------------------------------------------------------------------------
    | Auth Middleware
    |--------------------------------------------------------------------------
    |
    | Admin panel kimlik doğrulama için kullanılacak middleware
    |
    */
    'auth_middleware' => 'auth',

    /*
    |--------------------------------------------------------------------------
    | Admin Roller
    |--------------------------------------------------------------------------
    |
    | Admin panele erişebilecek roller
    |
    */
    'roles' => [
        'admin' => 'Yönetici',
        'editor' => 'Editör',
        'user' => 'Kullanıcı',
    ],

    /*
    |--------------------------------------------------------------------------
    | Medya Konfigürasyonu
    |--------------------------------------------------------------------------
    |
    | Medya yönetimi ile ilgili ayarlar
    |
    */
    'media' => [
        'max_file_size' => 10240, // KB cinsinden (10MB)
        'allowed_extensions' => ['jpg', 'jpeg', 'png', 'gif', 'svg', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt'],
        'disk' => 'public',
    ],

    /*
    |--------------------------------------------------------------------------
    | İçerik Ayarları
    |--------------------------------------------------------------------------
    |
    | İçerik yönetimi ile ilgili ayarlar
    |
    */
    'content' => [
        'posts_per_page' => 10,
        'allow_comments' => true,
        'default_status' => 'draft', // published, draft, pending
    ],

    /*
    |--------------------------------------------------------------------------
    | Dashboard Bileşenleri
    |--------------------------------------------------------------------------
    |
    | Dashboard'da görüntülenecek bileşenler
    |
    */
    'dashboard' => [
        'show_stats' => true,
        'show_recent_posts' => true,
        'show_popular_posts' => true,
        'show_activity_log' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Tema Ayarları
    |--------------------------------------------------------------------------
    |
    | Admin panel tema ayarları
    |
    */
    'theme' => [
        'sidebar_dark' => true,
        'primary_color' => '#4f46e5', // indigo-600
    ],
]; 