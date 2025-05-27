<?php

namespace App\Services\Admin\User;

use App\Models\Post;

class ShowService
{

    /**
     * @param array $filters Filters
     *
     * @return
     */
    public function handle (int $id)
    {
        $post = Post::with([
            'previewImage',
        ])->findOrFail($id);

        return $post;
    }
}
