<?php

namespace App\Services\User\Post;

use App\Models\Category;
use App\Models\Post;

class ListByCategoryService
{

    /**
     * @param array $filters Filters
     *
     * @return
     */
    public function handle (string $slug, array $data, array $filters = [])
    {

        $category = Category::query()
            ->where('slug', $slug)
            ->where('type', $data['type'] ?? Category::TYPE_POST)
            ->where('status', Category::STATUS_ACTIVE)
            ->firstOrFail(['id']);

        $posts = Post::query()->with([
            'previewImage',
        ])->where('category_id', $category->id)
        ->where('status', Post::STATUS_ACTIVE)
        ->orderBy('id', 'DESC')
        ->select([
            'id',
            'name',
            'short_description',
            'slug',
            'category_id',
        ])
        ->paginate($data['limit']);

        return $posts;
    }
}
