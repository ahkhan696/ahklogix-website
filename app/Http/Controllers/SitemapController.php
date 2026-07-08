<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    public function __invoke()
    {
        $sitemap = Sitemap::create();

        // Static pages
        $statics = [
            ['/',          1.0, 'weekly'],
            ['/services',  0.9, 'weekly'],
            ['/portfolio', 0.8, 'weekly'],
            ['/blog',      0.8, 'daily'],
            ['/posr',      0.8, 'monthly'],
            ['/about',     0.6, 'monthly'],
            ['/contact',   0.6, 'monthly'],
            ['/faq',       0.6, 'monthly'],
        ];

        foreach ($statics as [$path, $priority, $freq]) {
            $sitemap->add(
                Url::create(url($path))
                    ->setPriority($priority)
                    ->setChangeFrequency($freq)
            );
        }

        // Services
        Service::orderBy('order')->get()->each(function (Service $service) use ($sitemap) {
            $sitemap->add(
                Url::create(route('services.show', $service->slug))
                    ->setPriority(0.9)
                    ->setChangeFrequency('monthly')
                    ->setLastModificationDate($service->updated_at)
            );
        });

        // Portfolio
        Project::orderBy('order')->get()->each(function (Project $project) use ($sitemap) {
            $sitemap->add(
                Url::create(route('portfolio.show', $project->slug))
                    ->setPriority(0.8)
                    ->setChangeFrequency('monthly')
                    ->setLastModificationDate($project->updated_at)
            );
        });

        // Blog posts (published only)
        Post::published()->orderBy('published_at', 'desc')->get()->each(function (Post $post) use ($sitemap) {
            $sitemap->add(
                Url::create(route('blog.show', $post->slug))
                    ->setPriority(0.8)
                    ->setChangeFrequency('weekly')
                    ->setLastModificationDate($post->updated_at)
            );
        });

        return $sitemap->toResponse(request());
    }
}
