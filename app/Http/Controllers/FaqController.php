<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function __invoke(): View
    {
        $grouped = cache()->remember('faqs.grouped', 3600, function () {
            return Faq::orderBy('order')->get()->groupBy('category');
        });

        return view('pages.faq', compact('grouped'));
    }
}
