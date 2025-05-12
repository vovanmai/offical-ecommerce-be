<?php

namespace App\Services\User\Post;

use App\Models\Post;

class ListService
{

    /**
     * @param array $filters Filters
     *
     * @return
     */
    public function handle (array $data)
    {
        $limit = $data['limit'] ?? null;

        $query = Post::query()->with([
            'previewImage'
        ])->where('status', Post::STATUS_ACTIVE);

        if ($limit) {
            return $query->orderBy('id', 'DESC')->limit($limit)->get();
        }
    }
}
