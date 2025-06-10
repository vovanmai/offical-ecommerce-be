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
        $keyword = $data['keyword'] ?? null;

        $query = Post::query()->with([
            'previewImage'
        ])->where('status', Post::STATUS_ACTIVE)
            ->orderBy('id', 'DESC')
            ->select([
                'id',
                'name',
                'short_description',
                'slug',
            ]);

        if ($limit) {
            return $query->limit($limit)
                ->get();
        }

        if($keyword) {

        }
    }
}
