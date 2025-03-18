<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold">Yazı Düzenle</h2>
        <a href="{{ route('admin.posts.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
            Geri Dön
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <form wire:submit.prevent="save">
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Başlık</label>
                        <input
                            type="text"
                            id="title"
                            wire:model="title"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        >
                        @error('title') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                        <input
                            type="text"
                            id="slug"
                            wire:model="slug"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        >
                        @error('slug') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-1">İçerik</label>
                    <div wire:ignore>
                        <textarea
                            id="content"
                            wire:model="content"
                            rows="15"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        ></textarea>
                    </div>
                    @error('content') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-1">Özet</label>
                    <textarea
                        id="excerpt"
                        wire:model="excerpt"
                        rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    ></textarea>
                    @error('excerpt') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select 
                            id="category_id" 
                            wire:model="category_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        >
                            <option value="">Kategori Seçin</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Durum</label>
                        <select 
                            id="status" 
                            wire:model="status"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        >
                            <option value="draft">Taslak</option>
                            <option value="published">Yayınlandı</option>
                            <option value="pending">Beklemede</option>
                            <option value="private">Özel</option>
                        </select>
                        @error('status') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label for="tags" class="block text-sm font-medium text-gray-700 mb-1">Etiketler</label>
                    <div class="flex flex-wrap gap-2 p-2 border border-gray-300 rounded-md">
                        @foreach($allTags as $tag)
                            <label class="inline-flex items-center bg-gray-100 px-2 py-1 rounded-lg text-sm">
                                <input 
                                    type="checkbox" 
                                    wire:model="tags" 
                                    value="{{ $tag->id }}"
                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 mr-1"
                                >
                                {{ $tag->name }}
                            </label>
                        @endforeach
                    </div>
                    @error('tags') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="new_featured_image" class="block text-sm font-medium text-gray-700 mb-1">Öne Çıkan Görsel</label>
                    
                    @if ($featured_image)
                        <div class="mb-3">
                            <p class="text-sm text-gray-500 mb-2">Mevcut Görsel:</p>
                            <div class="flex items-center space-x-4">
                                <img src="{{ Storage::url($featured_image) }}" class="w-40 h-40 object-cover rounded">
                                <button 
                                    type="button" 
                                    wire:click="removeFeaturedImage" 
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm"
                                >
                                    Görseli Kaldır
                                </button>
                            </div>
                        </div>
                    @endif
                    
                    <input
                        type="file"
                        id="new_featured_image"
                        wire:model="new_featured_image"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        accept="image/*"
                    >
                    @error('new_featured_image') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    
                    @if ($new_featured_image)
                        <div class="mt-2">
                            <p class="text-sm text-gray-500 mb-1">Yeni Görsel Önizleme:</p>
                            <img src="{{ $new_featured_image->temporaryUrl() }}" class="w-40 h-40 object-cover rounded">
                        </div>
                    @endif
                </div>

                <div x-data="{ showDatePicker: false }" x-cloak>
                    <label for="published_at" class="block text-sm font-medium text-gray-700 mb-1">Yayınlanma Tarihi</label>
                    <div class="relative">
                        <input
                            type="text"
                            id="published_at"
                            wire:model="published_at"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            placeholder="YYYY-MM-DD HH:MM:SS"
                            x-on:focus="showDatePicker = true"
                            x-on:click.away="showDatePicker = false"
                        >
                    </div>
                    @error('published_at') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 text-right">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Güncelle
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
    <script src="{{ asset('vendor/tinymce/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
    <script>
        document.addEventListener('livewire:load', function () {
            tinymce.init({
                selector: '#content',
                height: 400,
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code help wordcount'
                ],
                toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
                setup: function (editor) {
                    editor.on('change', function (e) {
                        @this.set('content', editor.getContent());
                    });
                    editor.on('init', function (e) {
                        if (@this.content) {
                            editor.setContent(@this.content);
                        }
                    });
                }
            });
        });
    </script>
    @endpush
</div> 