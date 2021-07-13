<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Post;
use App\Observers\PostObserver;

class PostReaderController extends Controller
{
    public function __construct()
    {
        $this->cache = Cache::store('database');
        $this->perPage = config('app.min_pagination');
    }
    // get all posts and send to welcome view
    public function index(Request $request)
    {
        $currentPage = $request->input('page');
        if (!$currentPage)  $currentPage  = 1;

        $startPage = $request->input('startPage');
        if (!$startPage)    $startPage = 1;

        extract($this->readFromCache());

        $posts = $posts->slice($this->perPage*($currentPage-1), $this->perPage);
        return view('welcome', compact('posts', 'total', 'currentPage', 'startPage'));
    }

    // get all posts for a user
    public function userPosts(Request $request)
    {
        $currentPage = $request->input('page');
        if (!$currentPage)  $currentPage  = 1;

        $startPage = $request->input('startPage');
        if (!$startPage)    $startPage = 1;

        $id = auth()->id();
        $posts = $this->cache->remember(PostObserver::CACHE_KEY_USER_POSTS_PREFIX.$id, now()->addHour(), function () use ($id) {
            return Post::where('user_id', $id)->orderByDesc('created_at')->get();
        });

        $total = $posts->count();
        $posts = $posts->slice($this->perPage*($currentPage-1), $this->perPage);
        return view('dashboard', compact('posts', 'total', 'currentPage', 'startPage'));
    }

    private function readFromCache()
    {
        $total = $this->cache->rememberForever(PostObserver::CACHE_KEY_AMOUNT_OF_POSTS, function() {
            return Post::all()->count();
        });

        $posts = $this->cache->remember(PostObserver::CACHE_KEY_POSTS_QUEUE, now()->addDays(10), function () {
            return Post::orderByDesc('created_at')->get();
        });

        return ["posts"=>$posts->sortByDesc('created_at'), "total"=>$total];
    }
}
