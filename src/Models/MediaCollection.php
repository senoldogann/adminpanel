<?php

namespace SenolDogan\AdminPanel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaCollection extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function media()
    {
        return $this->hasMany(Media::class, 'collection_name', 'name');
    }
} 