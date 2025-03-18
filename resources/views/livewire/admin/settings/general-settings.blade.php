<div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form wire:submit.prevent="save" class="space-y-8">
                        <!-- Genel Ayarlar -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Genel Ayarlar</h3>
                            <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Site Başlığı</label>
                                    <input type="text" wire:model="settings.site_title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('settings.site_title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Site Açıklaması</label>
                                    <textarea wire:model="settings.site_description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                                    @error('settings.site_description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Logo ve Favicon -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Logo ve Favicon</h3>
                            <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Site Logo</label>
                                    <div class="mt-1 flex items-center space-x-4">
                                        @if($settings['site_logo'])
                                            <img src="{{ Storage::url($settings['site_logo']) }}" alt="Site Logo" class="h-12">
                                        @endif
                                        <input type="file" wire:model="newLogo" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                    </div>
                                    @error('newLogo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Site Favicon</label>
                                    <div class="mt-1 flex items-center space-x-4">
                                        @if($settings['site_favicon'])
                                            <img src="{{ Storage::url($settings['site_favicon']) }}" alt="Site Favicon" class="h-8">
                                        @endif
                                        <input type="file" wire:model="newFavicon" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                    </div>
                                    @error('newFavicon') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- İletişim Bilgileri -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-2">İletişim Bilgileri</h3>
                            <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">E-posta Adresi</label>
                                    <input type="email" wire:model="settings.contact_email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('settings.contact_email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Telefon</label>
                                    <input type="text" wire:model="settings.contact_phone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Adres</label>
                                    <textarea wire:model="settings.contact_address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Sosyal Medya -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Sosyal Medya</h3>
                            <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Facebook</label>
                                    <input type="url" wire:model="settings.social_facebook" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Twitter</label>
                                    <input type="url" wire:model="settings.social_twitter" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Instagram</label>
                                    <input type="url" wire:model="settings.social_instagram" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">LinkedIn</label>
                                    <input type="url" wire:model="settings.social_linkedin" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>

                        <!-- SEO Ayarları -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-2">SEO Ayarları</h3>
                            <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                                <div class="sm:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Meta Açıklaması</label>
                                    <textarea wire:model="settings.meta_description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Meta Anahtar Kelimeleri</label>
                                    <input type="text" wire:model="settings.meta_keywords" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Virgülle ayırın">
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Google Analytics Kodu</label>
                                    <textarea wire:model="settings.google_analytics" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="GA-XXXX"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Footer Ayarları</h3>
                            <div class="mt-6">
                                <label class="block text-sm font-medium text-gray-700">Footer Metni</label>
                                <textarea wire:model="settings.footer_text" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                            </div>
                        </div>

                        <div class="pt-5">
                            <div class="flex justify-end">
                                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Ayarları Kaydet
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bildirimler -->
    @if (session()->has('message'))
        <div x-data="{ show: true }"
             x-show="show"
             x-init="setTimeout(() => show = false, 3000)"
             class="fixed bottom-0 right-0 m-6 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg">
            {{ session('message') }}
        </div>
    @endif
</div> 