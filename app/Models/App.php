<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class App extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'title', 'slug', 'icon', 'tagline', 'description',
        'feature_list', 'status', 'sort_order',
    ];

    protected function casts(): array
    {
        return ['feature_list' => 'array'];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
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
        $this->addMediaCollection('tile_image')->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('card')
            ->performOnCollections('tile_image')
            ->width(600)
            ->height(400)
            ->format('webp')
            ->nonQueued();
    }
}
