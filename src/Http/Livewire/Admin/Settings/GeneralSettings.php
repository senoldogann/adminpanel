<?php

namespace App\Http\Livewire\Admin\Settings;

use Livewire\Component;
use App\Models\Setting;
use Livewire\WithFileUploads;

class GeneralSettings extends Component
{
    use WithFileUploads;

    public $settings = [
        'site_title' => '',
        'site_description' => '',
        'site_keywords' => '',
        'site_logo' => '',
        'site_favicon' => '',
        'contact_email' => '',
        'contact_phone' => '',
        'contact_address' => '',
        'social_facebook' => '',
        'social_twitter' => '',
        'social_instagram' => '',
        'social_linkedin' => '',
        'footer_text' => '',
        'google_analytics' => '',
        'meta_description' => '',
        'meta_keywords' => '',
    ];

    public $newLogo;
    public $newFavicon;

    public function mount()
    {
        foreach ($this->settings as $key => $value) {
            $this->settings[$key] = Setting::get($key, '');
        }
    }

    public function save()
    {
        $this->validate([
            'settings.site_title' => 'required|min:3',
            'settings.site_description' => 'required',
            'settings.contact_email' => 'required|email',
            'newLogo' => 'nullable|image|max:1024',
            'newFavicon' => 'nullable|image|max:1024',
        ]);

        if ($this->newLogo) {
            $logoPath = $this->newLogo->store('public/site');
            $this->settings['site_logo'] = str_replace('public/', '', $logoPath);
        }

        if ($this->newFavicon) {
            $faviconPath = $this->newFavicon->store('public/site');
            $this->settings['site_favicon'] = str_replace('public/', '', $faviconPath);
        }

        foreach ($this->settings as $key => $value) {
            Setting::set($key, $value);
        }

        session()->flash('message', 'Ayarlar başarıyla kaydedildi.');
    }

    public function render()
    {
        return view('livewire.admin.settings.general-settings');
    }
} 