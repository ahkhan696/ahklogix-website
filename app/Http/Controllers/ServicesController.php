<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Service;
use Illuminate\View\View;

class ServicesController extends Controller
{
    public function index(): View
    {
        $services = cache()->remember('services.all', 3600, fn () =>
            Service::orderBy('order')->get()
        );

        return view('pages.services.index', compact('services'));
    }

    public function show(string $slug): View
    {
        $service = cache()->remember("service.{$slug}", 3600, fn () =>
            Service::where('slug', $slug)->firstOrFail()
        );

        // Related: projects whose tags or category loosely match the service title word.
        // Falls back to any 3 featured projects.
        $serviceWords = collect(explode(' ', strtolower($service->title)))
            ->filter(fn ($w) => strlen($w) > 3)
            ->values();

        $related = cache()->remember("service.{$slug}.related", 3600, function () use ($serviceWords) {
            $projects = Project::where('featured', true)->with('media')->orderBy('order')->get();

            $matched = $projects->filter(function ($p) use ($serviceWords) {
                $haystack = strtolower($p->category . ' ' . implode(' ', (array) $p->tags));
                return $serviceWords->contains(fn ($w) => str_contains($haystack, $w));
            });

            return $matched->isNotEmpty() ? $matched->take(3) : $projects->take(3);
        });

        return view('pages.services.show', compact('service', 'related'));
    }
}
