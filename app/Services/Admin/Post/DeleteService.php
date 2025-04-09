<?php

namespace App\Services\Admin\Post;

use App\Models\Post;

class DeleteService
{

    /**
     * @param array $filters Filters
     *
     * @return
     */
    public function handle (int $id)
    {
        $post = Post::findOrFail($id);
        $post->previewImage()->delete();

        $post->delete();
    }
}
