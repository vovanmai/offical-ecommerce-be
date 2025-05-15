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
        $category = Category::with('parent')->where('slug', $slug)
            ->where('status', Category::STATUS_ACTIVE)
            ->select([
                'id',
                'name',
                'slug',
                'parent_id',
            ])
            ->firstOrFail();

        $posts = Post::query()->with([
            'previewImage',
            // 'category.parent',
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

        return [
            'post_paginate' => $posts,
            'category' => $category,
        ];
    }
}
