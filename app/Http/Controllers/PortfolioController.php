<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function index(): View
    {
        $projects = cache()->remember('portfolio.all', 3600, fn () =>
            Project::with('media')->orderBy('order')->get()
        );

        $categories = $projects
            ->pluck('category')
            ->filter()
            ->unique()
            ->sort()
            ->values();

        return view('pages.portfolio.index', compact('projects', 'categories'));
    }

    public function show(string $slug): View
    {
        $project = cache()->remember("portfolio.{$slug}", 3600, fn () =>
            Project::with('media')->where('slug', $slug)->firstOrFail()
        );

        return view('pages.portfolio.show', compact('project'));
    }
}
