<div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold">Kullanıcı Düzenle</h2>
                        <a href="{{ route('admin.users.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                            <i class="fas fa-arrow-left mr-1"></i> Geri Dön
                        </a>
                    </div>

                    <form wire:submit.prevent="save">
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <!-- İsim -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">İsim</label>
                                <input 
                                    type="text" 
                                    id="name" 
                                    wire:model="name" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                >
                                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-posta</label>
                                <input 
                                    type="email" 
                                    id="email" 
                                    wire:model="email" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                >
                                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Şifre -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Şifre (Boş bırakırsanız değişmez)</label>
                                <input 
                                    type="password" 
                                    id="password" 
                                    wire:model="password" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                >
                                @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Şifre Onayı -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Şifre Onayı</label>
                                <input 
                                    type="password" 
                                    id="password_confirmation" 
                                    wire:model="password_confirmation" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                >
                                @error('password_confirmation') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Avatar -->
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Profil Fotoğrafı</label>
                            
                            @if ($avatar)
                                <div class="mb-3">
                                    <div class="flex items-center space-x-4">
                                        <img src="{{ Storage::url($avatar) }}" class="h-20 w-20 object-cover rounded-full">
                                        <button 
                                            type="button" 
                                            wire:click="removeAvatar" 
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm"
                                        >
                                            <i class="fas fa-trash mr-1"></i> Fotoğrafı Kaldır
                                        </button>
                                    </div>
                                </div>
                            @endif
                            
                            <input 
                                type="file" 
                                id="new_avatar" 
                                wire:model="new_avatar" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                accept="image/*"
                            >
                            <div wire:loading wire:target="new_avatar" class="mt-2 text-sm text-gray-500">
                                Yükleniyor...
                            </div>
                            @error('new_avatar') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                            @if ($new_avatar)
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 mb-1">Yeni Fotoğraf Önizleme:</p>
                                    <img src="{{ $new_avatar->temporaryUrl() }}" class="h-20 w-20 object-cover rounded-full">
                                </div>
                            @endif
                        </div>

                        <!-- Roller -->
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Roller</label>
                            <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 md:grid-cols-4">
                                @foreach($availableRoles as $role)
                                    <label class="inline-flex items-center">
                                        <input 
                                            type="checkbox" 
                                            wire:model="roles" 
                                            value="{{ $role->id }}"
                                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        >
                                        <span class="ml-2 text-sm text-gray-700">{{ $role->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('roles') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Güncelle Butonu -->
                        <div class="mt-6">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="fas fa-save mr-1"></i> Güncelle
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 