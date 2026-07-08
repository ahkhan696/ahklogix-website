<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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

    protected static function booted(): void
    {
        static::saved(fn () => Cache::flush());
        static::deleted(fn () => Cache::flush());
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photo')->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('avatar')
            ->performOnCollections('photo')
            ->width(200)
            ->height(200)
            ->fit(\Spatie\Image\Enums\Fit::Crop)
            ->format('webp')
            ->nonQueued();
    }
}
