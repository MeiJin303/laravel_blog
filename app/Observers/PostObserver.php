<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;
use Psr\SimpleCache\CacheException;

class PostObserver
{
    public const CACHE_KEY_AMOUNT_OF_POSTS = "_amount_of_posts";
    public const CACHE_KEY_POSTS_QUEUE = "_posts_queue";
    public const CACHE_KEY_USER_POSTS_PREFIX = "_posts_of_user#";
    public function __construct()
    {
        $this->cache = Cache::store('database');
    }
    /**
     * Handle the Post "created" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function created(Post $post)
    {
        /**
         * get the total entry number from the cache,
         * use it to calculate queue id
         */
        $total = $this->cache->rememberForever(self::CACHE_KEY_AMOUNT_OF_POSTS, function() {
            return Post::all()->count();
        });
        /**
         * append the $post->id to the top of the queue
         */
        $queue = $this->cache->get(self::CACHE_KEY_POSTS_QUEUE, function() {
            return Post::all()->orderByDesc('created_at')->get();
        });
        $queue->prepend($post);
        $this->cache->forget(self::CACHE_KEY_USER_POSTS_PREFIX.$post->user_id);
        try{
            $this->cache->add(self::CACHE_KEY_POSTS_QUEUE, $queue, now()->addDays(10));
        } catch(CacheException $e) {
            die();
        }

        // increment the amount of posts by 1
        $this->cache->increment(self::CACHE_KEY_AMOUNT_OF_POSTS);
    }

    /**
     * Handle the Post "updated" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function updated(Post $post)
    {
        //
    }

    /**
     * Handle the Post "deleted" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function deleted(Post $post)
    {
        //
    }

    /**
     * Handle the Post "restored" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function restored(Post $post)
    {
        //
    }

    /**
     * Handle the Post "force deleted" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function forceDeleted(Post $post)
    {
        //
    }
}
