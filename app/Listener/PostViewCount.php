<?php

namespace App\Listener;
use App\Post;
use App\Events\PostViewEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;


class PostViewCount implements ShouldQueue
{
    Private $posts;
    public function __construct()
    {

    }

    /**
     * @param PostViewEvent $event
     */
    public function handle(PostViewEvent $event)
    {
        $this->posts=$event->posts;
        $this->posts->increment('count');;
        $this->posts->save();
    }

}
