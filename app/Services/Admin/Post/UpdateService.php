<?php

namespace App\Services\Admin\Post;

use App\Models\Post;
use App\Services\Admin\Upload\UpdateService as UploadUpdateService;

class UpdateService
{

    /**
     * @param array $filters Filters
     *
     * @return
     */
    public function handle (int $id, array $data)
    {
        $post = Post::with([
            'previewImage',
        ])->findOrFail($id);

        if($data['preview_image_id'] !== $post->previewImage?->id) {
            $post->previewImage()->delete();
            resolve(UploadUpdateService::class)->handle([$data['preview_image_id']], $post, 'preview_image');
        }

        $post->update([
            'name' => $data['name'],
            'status' => $data['status'] ?? Post::STATUS_ACTIVE,
            'description' => $data['description'],
            'category_id' => $data['category_id'] ?? null,
        ]);

        return $post;
    }
}
