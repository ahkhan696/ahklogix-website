<?php

namespace App\Http\Controllers;

use App\Models\App as AppModel;
use Illuminate\View\View;

class AppController extends Controller
{
    public function index(): View
    {
        $apps = cache()->remember('apps.all', 3600, fn () =>
            AppModel::orderBy('sort_order')->get()
        );

        return view('pages.apps.index', compact('apps'));
    }

    public function show(AppModel $app): View
    {
        return view('pages.apps.show', compact('app'));
    }

    public function run(AppModel $app): View
    {
        abort_unless($app->status === 'live', 404);

        $viewSlug = str_replace('-', '_', $app->slug);
        return view("pages.apps.use.{$viewSlug}", compact('app'));
    }
}
