<div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <!-- Profil Bilgileri -->
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium text-gray-900">Profil Bilgileri</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Hesap bilgilerinizi ve e-posta adresinizi güncelleyin.
                        </p>
                    </div>
                </div>

                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <form wire:submit.prevent="saveProfile">
                            <div class="p-6 space-y-6">
                                <!-- Profil Fotoğrafı -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Profil Fotoğrafı</label>
                                    <div class="mt-2 flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            @if($avatar)
                                                <img src="{{ Storage::url($avatar) }}" alt="{{ $name }}" class="h-16 w-16 rounded-full object-cover">
                                            @else
                                                <div class="h-16 w-16 rounded-full bg-gray-200 flex items-center justify-center">
                                                    <span class="text-gray-500 text-lg">{{ substr($name, 0, 1) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <input type="file" wire:model="newAvatar" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                    </div>
                                    @error('newAvatar') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                    
                                    @if($newAvatar)
                                        <div class="mt-2">
                                            <span class="text-gray-500 text-sm">Önizleme:</span>
                                            <img src="{{ $newAvatar->temporaryUrl() }}" alt="Profil Önizleme" class="h-16 w-16 rounded-full object-cover mt-1">
                                        </div>
                                    @endif
                                </div>

                                <!-- İsim -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">İsim</label>
                                    <input type="text" wire:model="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('name') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                </div>

                                <!-- E-posta -->
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">E-posta Adresi</label>
                                    <input type="email" wire:model="email" id="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('email') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Kaydet
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="hidden sm:block" aria-hidden="true">
                <div class="py-5">
                    <div class="border-t border-gray-200"></div>
                </div>
            </div>

            <!-- Şifre Güncelleme -->
            <div class="mt-10 md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium text-gray-900">Şifre Güncelleme</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Güvenliğiniz için güçlü bir şifre kullanın.
                        </p>
                    </div>
                </div>

                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-lg font-medium text-gray-900">Şifre Değiştir</h3>
                                <button type="button" wire:click="toggleUpdatePasswordMode" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    {{ $updatePasswordMode ? 'İptal' : 'Şifre Değiştir' }}
                                </button>
                            </div>

                            @if($updatePasswordMode)
                                <form wire:submit.prevent="updatePassword" class="space-y-6">
                                    <!-- Mevcut Şifre -->
                                    <div>
                                        <label for="currentPassword" class="block text-sm font-medium text-gray-700">Mevcut Şifre</label>
                                        <input type="password" wire:model.defer="currentPassword" id="currentPassword" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        @error('currentPassword') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Yeni Şifre -->
                                    <div>
                                        <label for="newPassword" class="block text-sm font-medium text-gray-700">Yeni Şifre</label>
                                        <input type="password" wire:model.defer="newPassword" id="newPassword" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        @error('newPassword') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Şifre Onay -->
                                    <div>
                                        <label for="newPassword_confirmation" class="block text-sm font-medium text-gray-700">Şifre Onay</label>
                                        <input type="password" wire:model.defer="newPassword_confirmation" id="newPassword_confirmation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>

                                    <div class="flex justify-end">
                                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Şifre Güncelle
                                        </button>
                                    </div>
                                </form>
                            @else
                                <p class="text-gray-500 text-sm">Şifrenizi değiştirmek için "Şifre Değiştir" butonuna tıklayın.</p>
                            @endif
                        </div>
                    </div>
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