<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Review extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name', 'company', 'rating', 'quote', 'featured', 'order',
    ];

    protected function casts(): array
    {
        return [
            'featured' => 'boolean',
            'rating'   => 'integer',
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photo')->singleFile();
    }
}
