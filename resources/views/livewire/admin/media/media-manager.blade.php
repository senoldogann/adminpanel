<div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Üst Bar -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <!-- Koleksiyon Seçici -->
                        <select wire:model="currentCollection" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">Tüm Dosyalar</option>
                            @foreach($collections as $collection)
                                <option value="{{ $collection->name }}">{{ $collection->name }}</option>
                            @endforeach
                        </select>

                        <!-- Yeni Koleksiyon Butonu -->
                        <button wire:click="$set('showCreateCollectionModal', true)" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                            <i class="fas fa-plus mr-2"></i>
                            Yeni Koleksiyon
                        </button>
                    </div>

                    <!-- Arama -->
                    <div class="flex-1 max-w-sm ml-4">
                        <input wire:model.debounce.300ms="searchTerm" type="search" placeholder="Dosya ara..." class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>

                    <!-- Dosya Yükleme -->
                    <div class="ml-4">
                        <input type="file" wire:model="files" multiple class="hidden" id="file-upload">
                        <label for="file-upload" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 cursor-pointer">
                            <i class="fas fa-upload mr-2"></i>
                            Dosya Yükle
                        </label>
                    </div>
                </div>
            </div>

            <!-- Dosya Listesi -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($media->count() > 0)
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @foreach($media as $item)
                                <div class="relative group">
                                    <div class="aspect-w-16 aspect-h-9 rounded-lg overflow-hidden bg-gray-100">
                                        @if(Str::startsWith($item->mime_type, 'image/'))
                                            <img src="{{ Storage::url('media/' . $item->id . '/' . $item->file_name) }}" alt="{{ $item->name }}" class="object-cover">
                                        @else
                                            <div class="flex items-center justify-center h-full">
                                                <i class="fas fa-file text-4xl text-gray-400"></i>
                                            </div>
                                        @endif
                                        
                                        <!-- Seçim Overlay -->
                                        <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <div class="absolute inset-0 flex items-center justify-center">
                                                <input type="checkbox" wire:model="selectedFiles" value="{{ $item->id }}" class="h-5 w-5 text-indigo-600 rounded border-gray-300">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $item->name }}</p>
                                        <p class="text-sm text-gray-500">{{ number_format($item->size / 1024, 2) }} KB</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $media->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <i class="fas fa-images text-gray-400 text-5xl mb-4"></i>
                            <p class="text-gray-500">Henüz dosya yüklenmemiş.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Alt Bar -->
            @if(count($selectedFiles) > 0)
                <div class="fixed bottom-0 inset-x-0 pb-6">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="bg-indigo-600 rounded-lg shadow-lg p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <span class="text-white">{{ count($selectedFiles) }} dosya seçildi</span>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <button wire:click="$set('showDeleteModal', true)" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                                        <i class="fas fa-trash-alt mr-2"></i>
                                        Sil
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Silme Modal -->
    <div x-data="{ show: @entangle('showDeleteModal') }" x-show="show" class="fixed z-10 inset-0 overflow-y-auto" style="display: none;">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="show" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fas fa-exclamation-triangle text-red-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Dosyaları Sil
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Seçili dosyaları silmek istediğinizden emin misiniz? Bu işlem geri alınamaz.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click="deleteSelected" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Sil
                    </button>
                    <button @click="show = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        İptal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Koleksiyon Oluşturma Modal -->
    <div x-data="{ show: @entangle('showCreateCollectionModal') }" x-show="show" class="fixed z-10 inset-0 overflow-y-auto" style="display: none;">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="show" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form wire:submit.prevent="createCollection">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                                <i class="fas fa-folder-plus text-indigo-600"></i>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    Yeni Koleksiyon Oluştur
                                </h3>
                                <div class="mt-2">
                                    <input wire:model.defer="newCollectionName" type="text" placeholder="Koleksiyon adı" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    @error('newCollectionName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Oluştur
                        </button>
                        <button @click="show = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            İptal
                        </button>
                    </div>
                </form>
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