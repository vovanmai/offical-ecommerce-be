<?php

namespace App\Services\Admin\User;

use App\Models\Post;
use App\Services\Admin\Upload\UpdateService;

class StoreService
{

    /**
     * @param array $filters Filters
     *
     * @return
     */
    public function handle (array $data)
    {
        $post = Post::create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'short_description' => $data['short_description'] ?? null,
            'category_id' => $data['category_id'],
            'status' => $data['status'] ?? Post::STATUS_ACTIVE,
        ]);

        if(filled($data['preview_image_id']) ?? null) {
            resolve(UpdateService::class)->handle([$data['preview_image_id']], $post, 'preview_image');
        }

        return $post;
    }
}
