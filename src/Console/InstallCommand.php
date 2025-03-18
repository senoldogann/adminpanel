<?php

namespace SenolDogan\AdminPanel\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\User;

class InstallCommand extends Command
{
    protected $signature = 'adminpanel:install';
    protected $description = 'Admin Panel kurulumunu tamamlar';

    public function handle()
    {
        $this->info('Admin Panel kurulumu başlıyor...');

        // Yetkileri ve rolleri oluştur
        $this->createRolesAndPermissions();

        // Admin kullanıcısı oluştur
        $this->createAdminUser();

        // Başlangıç ayarlarını oluştur
        $this->createInitialSettings();

        $this->info('Admin Panel kurulumu tamamlandı!');
        $this->info('Admin panele erişmek için: '.url('/admin'));

        return 0;
    }

    protected function createRolesAndPermissions()
    {
        $this->info('Roller ve yetkiler oluşturuluyor...');

        // Temel roller
        foreach (config('adminpanel.roles') as $role => $name) {
            Role::firstOrCreate(['name' => $role]);
            $this->line("- $name rolü oluşturuldu");
        }
    }

    protected function createAdminUser()
    {
        $this->info('Admin kullanıcısı oluşturuluyor...');

        // E-posta ve şifre sor
        $email = $this->ask('Admin e-posta adresi:', 'admin@example.com');
        $password = $this->secret('Admin şifresi (minimum 8 karakter):') ?: 'password';

        // Kullanıcı var mı kontrol et
        $user = User::where('email', $email)->first();

        if ($user) {
            if ($this->confirm("$email e-posta adresine sahip bir kullanıcı zaten var. Admin rolü eklensin mi?", true)) {
                $user->assignRole('admin');
                $this->line("- Kullanıcıya admin rolü verildi: $email");
            }
        } else {
            // Admin kullanıcısı oluştur
            $user = User::create([
                'name' => 'Admin',
                'email' => $email,
                'password' => Hash::make($password),
            ]);

            $user->assignRole('admin');
            $this->line("- Admin kullanıcısı oluşturuldu: $email");
        }
    }

    protected function createInitialSettings()
    {
        $this->info('Temel site ayarları oluşturuluyor...');

        // Site başlığı
        $siteTitle = $this->ask('Site başlığı:', config('app.name', 'Laravel Admin Panel'));

        // Site ayarlarını kaydet
        if (class_exists(\SenolDogan\AdminPanel\Models\Setting::class)) {
            \SenolDogan\AdminPanel\Models\Setting::set('site_title', $siteTitle);
            \SenolDogan\AdminPanel\Models\Setting::set('site_description', 'Laravel Admin Panel ile oluşturulmuş site');
            $this->line("- Temel ayarlar kaydedildi");
        } else {
            $this->warn("- Ayarlar modeli bulunamadı, temel ayarlar oluşturulamadı");
        }
    }
} 