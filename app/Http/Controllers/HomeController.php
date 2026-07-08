<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Project;
use App\Models\Review;
use App\Models\Service;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $services = cache()->remember('home.services', 3600, fn () =>
            Service::orderBy('order')->take(8)->get()
        );

        $projects = cache()->remember('home.projects', 3600, fn () =>
            Project::where('featured', true)->with('media')->orderBy('order')->take(6)->get()
        );

        $reviews = cache()->remember('home.reviews', 3600, fn () =>
            Review::where('featured', true)->with('media')->orderBy('order')->take(4)->get()
        );

        $faqs = cache()->remember('home.faqs', 3600, fn () =>
            Faq::orderBy('order')->take(5)->get()
        );

        return view('pages.home', compact('services', 'projects', 'reviews', 'faqs'));
    }
}
