<?php

namespace App\Services\Admin\Banner;

use App\Models\Banner;
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
        $banner = Banner::create([
            'name' => $data['name'],
            'url' => $data['url'] ?? null,
            'status' => $data['status'] ?? Banner::STATUS_ACTIVE,
        ]);

        if(filled($data['image_id']) ?? null) {
            resolve(UpdateService::class)->handle([$data['image_id']], $banner, 'image');
        }

        return $banner;
    }
}
