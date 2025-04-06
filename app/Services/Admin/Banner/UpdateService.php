<?php

namespace App\Services\Admin\Banner;

use App\Models\Category;
use App\Models\Banner;
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
        $banner = Banner::with([
            'image',
        ])->findOrFail($id);

        if($data['image_id'] !== $banner->image?->id) {
            $banner->image()->delete();
            resolve(UploadUpdateService::class)->handle([$data['image_id']], $banner, 'image');
        }

        $banner->update([
            'name' => $data['name'],
            'status' => $data['status'] ?? Category::STATUS_ACTIVE,
            'url' => $data['url'],
        ]);

        return $banner;
    }
}
