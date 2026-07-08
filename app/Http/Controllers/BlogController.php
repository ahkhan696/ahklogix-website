<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $activeTag = $request->query('tag');
        $page      = $request->query('page', 1);

        $allTags = Cache::remember('blog.allTags', 3600, fn () =>
            Post::published()
                ->whereNotNull('tags')
                ->pluck('tags')
                ->flatten()
                ->filter()
                ->unique()
                ->sort()
                ->values()
        );

        $cacheKey = 'blog.index.' . ($activeTag ?: 'all') . '.p' . $page;

        $posts = Cache::remember($cacheKey, 3600, function () use ($activeTag) {
            $query = Post::published()->orderBy('published_at', 'desc');

            if ($activeTag) {
                $query->whereJsonContains('tags', $activeTag);
            }

            return $query->paginate(9);
        });

        return view('pages.blog.index', compact('posts', 'activeTag', 'allTags'));
    }

    public function show(string $slug)
    {
        $post = Cache::remember("blog.post.{$slug}", 3600, fn () =>
            Post::published()->where('slug', $slug)->firstOrFail()
        );

        $related = Cache::remember("blog.related.{$slug}", 3600, function () use ($post) {
            if (empty($post->tags)) {
                return Post::published()
                    ->where('id', '!=', $post->id)
                    ->orderBy('published_at', 'desc')
                    ->limit(3)
                    ->get();
            }

            // Wrap tag conditions in a closure so OR doesn't break the published() scope
            $tags  = $post->tags;
            return Post::published()
                ->where('id', '!=', $post->id)
                ->where(function ($q) use ($tags) {
                    foreach ($tags as $tag) {
                        $q->orWhereJsonContains('tags', $tag);
                    }
                })
                ->orderBy('published_at', 'desc')
                ->limit(3)
                ->get();
        });

        return view('pages.blog.show', compact('post', 'related'));
    }
}
