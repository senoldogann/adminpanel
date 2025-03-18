<?php

namespace SenolDogan\AdminPanel\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Blade;
use Livewire\Livewire;
use SenolDogan\AdminPanel\Console\InstallCommand;

class AdminPanelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Konfigurasyon dosyasını publish edebilmek için
        $this->publishes([
            __DIR__ . '/../../config/adminpanel.php' => config_path('adminpanel.php'),
        ], 'adminpanel-config');

        // Migrations dosyalarını publish edebilmek için
        $this->publishes([
            __DIR__ . '/../../database/migrations/' => database_path('migrations'),
        ], 'adminpanel-migrations');

        // View dosyalarını publish edebilmek için
        $this->publishes([
            __DIR__ . '/../../resources/views' => resource_path('views/vendor/adminpanel'),
        ], 'adminpanel-views');

        // Assets dosyalarını publish edebilmek için
        $this->publishes([
            __DIR__ . '/../../resources/assets' => public_path('vendor/adminpanel'),
        ], 'adminpanel-assets');

        // Paket migrations'larını yükle
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        // Paket view'lerini yükle
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'adminpanel');

        // Paket rotalarını yükle
        $this->loadRoutes();

        // Livewire bileşenlerini kaydet
        $this->registerLivewireComponents();
        
        // Komutları kaydet
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
            ]);
        }
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Konfigürasyon dosyasını kaydet
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/adminpanel.php', 'adminpanel'
        );

        // Admin panel yardımcı fonksiyonlarını yükle
        $this->app->singleton('adminpanel', function () {
            return new \SenolDogan\AdminPanel\AdminPanel();
        });
    }

    /**
     * Paket rotalarını yükle.
     */
    protected function loadRoutes(): void
    {
        Route::middleware('web')
            ->namespace('SenolDogan\AdminPanel\Http\Controllers')
            ->group(__DIR__ . '/../../routes/web.php');

        Route::prefix('api')
            ->middleware('api')
            ->namespace('SenolDogan\AdminPanel\Http\Controllers\Api')
            ->group(__DIR__ . '/../../routes/api.php');
    }

    /**
     * Livewire bileşenlerini kaydet.
     */
    protected function registerLivewireComponents(): void
    {
        // Dashboard bileşeni
        Livewire::component('adminpanel::dashboard', \SenolDogan\AdminPanel\Http\Livewire\Admin\Dashboard::class);

        // Kategori bileşenleri
        Livewire::component('adminpanel::category-index', \SenolDogan\AdminPanel\Http\Livewire\Admin\Categories\CategoryIndex::class);
        Livewire::component('adminpanel::category-create', \SenolDogan\AdminPanel\Http\Livewire\Admin\Categories\CategoryCreate::class);
        Livewire::component('adminpanel::category-edit', \SenolDogan\AdminPanel\Http\Livewire\Admin\Categories\CategoryEdit::class);

        // Etiket bileşenleri
        Livewire::component('adminpanel::tag-index', \SenolDogan\AdminPanel\Http\Livewire\Admin\Tags\TagIndex::class);
        Livewire::component('adminpanel::tag-create', \SenolDogan\AdminPanel\Http\Livewire\Admin\Tags\TagCreate::class);
        Livewire::component('adminpanel::tag-edit', \SenolDogan\AdminPanel\Http\Livewire\Admin\Tags\TagEdit::class);

        // Yazı bileşenleri
        Livewire::component('adminpanel::post-index', \SenolDogan\AdminPanel\Http\Livewire\Admin\Posts\PostIndex::class);
        Livewire::component('adminpanel::post-create', \SenolDogan\AdminPanel\Http\Livewire\Admin\Posts\PostCreate::class);
        Livewire::component('adminpanel::post-edit', \SenolDogan\AdminPanel\Http\Livewire\Admin\Posts\PostEdit::class);

        // Kullanıcı bileşenleri
        Livewire::component('adminpanel::user-index', \SenolDogan\AdminPanel\Http\Livewire\Admin\Users\UserIndex::class);
        Livewire::component('adminpanel::user-create', \SenolDogan\AdminPanel\Http\Livewire\Admin\Users\UserCreate::class);
        Livewire::component('adminpanel::user-edit', \SenolDogan\AdminPanel\Http\Livewire\Admin\Users\UserEdit::class);
        
        // Medya yönetimi bileşeni
        Livewire::component('adminpanel::media-manager', \SenolDogan\AdminPanel\Http\Livewire\Admin\Media\MediaManager::class);
        
        // Ayarlar bileşeni
        Livewire::component('adminpanel::general-settings', \SenolDogan\AdminPanel\Http\Livewire\Admin\Settings\GeneralSettings::class);
        
        // Profil bileşeni
        Livewire::component('adminpanel::profile-settings', \SenolDogan\AdminPanel\Http\Livewire\Admin\Profile\ProfileSettings::class);
    }
} 