<?php

namespace SenolDogan\AdminPanel;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class AdminPanel
{
    /**
     * Aktif menü öğesini kontrol et
     */
    public function isActiveMenu(string $route, string $resource = null): bool
    {
        if ($resource) {
            return request()->routeIs("admin.{$resource}.*");
        }
        
        return request()->routeIs($route);
    }

    /**
     * Kullanıcının rollerini kontrol et
     */
    public function hasRole(string|array $roles): bool
    {
        if (!Auth::check()) {
            return false;
        }
        
        return Auth::user()->hasRole($roles);
    }

    /**
     * Kullanıcının izinlerini kontrol et
     */
    public function hasPermission(string|array $permissions): bool
    {
        if (!Auth::check()) {
            return false;
        }
        
        return Auth::user()->hasPermissionTo($permissions);
    }

    /**
     * Admin panel sürümünü al
     */
    public function version(): string
    {
        return '1.0.0';
    }

    /**
     * Paketin rotalarının kayıtlı olup olmadığını kontrol et
     */
    public function hasRoutes(): bool
    {
        return Route::has('admin.dashboard');
    }
} 