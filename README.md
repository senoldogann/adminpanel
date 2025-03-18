# Laravel Admin Panel CMS

Gelişmiş Laravel admin panel ve içerik yönetim sistemi.

## Özellikler

- 📝 Yazı yönetimi
- 🏷️ Kategori ve etiket sistemi
- 👥 Kullanıcı ve yetki yönetimi
- 🖼️ Medya yönetimi
- ⚙️ Site ayarları
- 👤 Kullanıcı profil yönetimi
- 🔑 API desteği

## Kurulum

Composer kullanarak paketi yükleyin:

```bash
composer require senoldogan/adminpanel
```

Servis sağlayıcıyı `config/app.php` dosyasına ekleyin:

```php
'providers' => [
    // ...
    SenolDogan\AdminPanel\Providers\AdminPanelServiceProvider::class,
],
```

Konfigürasyon dosyasını yayınlayın:

```bash
php artisan vendor:publish --provider="SenolDogan\AdminPanel\Providers\AdminPanelServiceProvider" --tag="adminpanel-config"
```

Migration'ları yayınlayın ve çalıştırın:

```bash
php artisan vendor:publish --provider="SenolDogan\AdminPanel\Providers\AdminPanelServiceProvider" --tag="adminpanel-migrations"
php artisan migrate
```

View dosyalarını yayınlayın (opsiyonel):

```bash
php artisan vendor:publish --provider="SenolDogan\AdminPanel\Providers\AdminPanelServiceProvider" --tag="adminpanel-views"
```

Assetleri yayınlayın:

```bash
php artisan vendor:publish --provider="SenolDogan\AdminPanel\Providers\AdminPanelServiceProvider" --tag="adminpanel-assets"
```

## Kullanım

Admin panele `/admin` URL'i ile erişebilirsiniz. İlk kullanımda, aşağıdaki komut ile admin kullanıcısı oluşturun:

```bash
php artisan adminpanel:install
```

Bu komut varsayılan bir admin kullanıcısı oluşturur:

- E-posta: admin@example.com
- Şifre: password

Üretim ortamında bu bilgileri değiştirmeyi unutmayın.

## Konfigürasyon

Admin panel davranışını `config/adminpanel.php` dosyasından özelleştirebilirsiniz:

```php
return [
    'title' => 'Admin Panel CMS', // Admin panel başlığı
    'prefix' => 'admin', // Admin panel rota ön eki
    // ...
];
```

## İçerik Yönetimi

### Yazılar

AdminPanel içindeki PostController sınıfını kullanarak yazı yönetimi yapabilirsiniz:

```php
use SenolDogan\AdminPanel\Models\Post;

// Tüm yazıları getir
$posts = Post::all();

// Yeni yazı oluştur
$post = Post::create([
    'title' => 'Başlık',
    'content' => 'İçerik',
    'category_id' => 1,
    'status' => 'published',
]);

// Yazıya etiket ekle
$post->tags()->attach([1, 2, 3]);
```

### Kategoriler ve Etiketler

Kategori ve etiket yönetimi için Category ve Tag modellerini kullanabilirsiniz:

```php
use SenolDogan\AdminPanel\Models\Category;
use SenolDogan\AdminPanel\Models\Tag;

// Kategori oluştur
$category = Category::create([
    'name' => 'Kategori Adı',
    'slug' => 'kategori-adi',
]);

// Etiket oluştur
$tag = Tag::create([
    'name' => 'Etiket Adı',
    'slug' => 'etiket-adi',
]);
```

## API Kullanımı

AdminPanel bir REST API sağlar. API'ye erişim için token almanız gerekir:

```
POST /api/auth/login
{
    "email": "user@example.com",
    "password": "password"
}
```

API üzerinden yazıları listelemek için:

```
GET /api/posts
```

Belirli bir yazıyı getirmek için:

```
GET /api/posts/{slug}
```

## Güvenlik

Güvenlik açıklarını bildirmek için lütfen e-posta gönderin: info@senoldogan.com

## Lisans

Bu paket MIT lisansı altında lisanslanmıştır. 