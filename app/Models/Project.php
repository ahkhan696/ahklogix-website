<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Project extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'title', 'slug', 'client', 'category', 'tags',
        'problem', 'solution', 'stack', 'results',
        'featured', 'order', 'seo_title', 'seo_description',
    ];

    protected function casts(): array
    {
        return [
            'tags'     => 'array',
            'stack'    => 'array',
            'featured' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (self $model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->title);
            }
        });

        static::saved(fn () => Cache::flush());
        static::deleted(fn () => Cache::flush());
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')->singleFile();
        $this->addMediaCollection('gallery');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('full')
            ->performOnCollections('cover', 'gallery')
            ->width(1200)
            ->height(630)
            ->sharpen(5)
            ->format('webp')
            ->nonQueued();

        $this->addMediaConversion('thumb')
            ->performOnCollections('cover', 'gallery')
            ->width(800)
            ->height(500)
            ->sharpen(5)
            ->format('webp')
            ->nonQueued();
    }
}
