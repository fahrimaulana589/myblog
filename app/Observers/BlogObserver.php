<?php

namespace App\Observers;

use App\Models\Blog;

class BlogObserver
{
    public function created(Blog $blog)
    {
    }

    public function updated(Blog $blog)
    {
    }

    public function deleted(Blog $blog)
    {
        $blog->read()->delete();
    }

    public function restored(Blog $blog)
    {
    }

    public function forceDeleted(Blog $blog)
    {
    }
}
