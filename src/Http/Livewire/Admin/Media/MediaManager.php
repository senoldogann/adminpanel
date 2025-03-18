<?php

namespace App\Http\Livewire\Admin\Media;

use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Models\MediaCollection;
use Illuminate\Support\Facades\Storage;

class MediaManager extends Component
{
    use WithFileUploads;

    public $files = [];
    public $selectedFiles = [];
    public $searchTerm = '';
    public $currentCollection = null;
    public $showDeleteModal = false;
    public $showCreateCollectionModal = false;
    public $newCollectionName = '';
    public $collections;
    
    protected $listeners = ['refreshMedia' => '$refresh'];

    public function mount()
    {
        $this->loadCollections();
    }

    public function loadCollections()
    {
        $this->collections = MediaCollection::all();
    }

    public function uploadFiles()
    {
        $this->validate([
            'files.*' => 'required|file|max:10240', // 10MB max
        ]);

        foreach ($this->files as $file) {
            $media = Media::create([
                'name' => $file->getClientOriginalName(),
                'file_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
                'collection_name' => $this->currentCollection ? $this->currentCollection : 'default',
            ]);

            $file->storeAs('public/media', $media->id . '/' . $file->getClientOriginalName());
        }

        $this->files = [];
        $this->emit('refreshMedia');
        session()->flash('message', 'Dosyalar başarıyla yüklendi.');
    }

    public function deleteSelected()
    {
        Media::whereIn('id', $this->selectedFiles)->delete();
        $this->selectedFiles = [];
        $this->showDeleteModal = false;
        $this->emit('refreshMedia');
        session()->flash('message', 'Seçili dosyalar silindi.');
    }

    public function createCollection()
    {
        $this->validate([
            'newCollectionName' => 'required|min:3|unique:media_collections,name'
        ]);

        MediaCollection::create([
            'name' => $this->newCollectionName
        ]);

        $this->newCollectionName = '';
        $this->showCreateCollectionModal = false;
        $this->loadCollections();
        session()->flash('message', 'Koleksiyon oluşturuldu.');
    }

    public function switchCollection($collectionName)
    {
        $this->currentCollection = $collectionName;
        $this->selectedFiles = [];
    }

    public function getMediaProperty()
    {
        $query = Media::query();

        if ($this->searchTerm) {
            $query->where('name', 'like', '%' . $this->searchTerm . '%');
        }

        if ($this->currentCollection) {
            $query->where('collection_name', $this->currentCollection);
        }

        return $query->latest()->paginate(12);
    }

    public function render()
    {
        return view('livewire.admin.media.media-manager', [
            'media' => $this->media
        ]);
    }
} 