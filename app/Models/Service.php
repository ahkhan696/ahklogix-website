<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Service extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'title', 'slug', 'icon', 'short_description', 'body',
        'featured', 'order', 'seo_title', 'seo_description',
    ];

    protected function casts(): array
    {
        return [
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
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('icon_image')->singleFile();
    }
}
