<?php

namespace App\Services\User\Post;

use App\Models\Post;

class ShowService
{

    /**
     * @param array $filters Filters
     *
     * @return
     */
    public function handle (string $slug)
    {
        $post = Post::with([
            'previewImage',
            'category.parent',
        ])->where('slug', $slug)->where('status', Post::STATUS_ACTIVE)->firstOrFail();

        return $post;
    }
}
