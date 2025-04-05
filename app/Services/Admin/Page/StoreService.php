<?php

namespace App\Services\Admin\Page;

use App\Models\Page;
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
        $page = Page::create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'status' => $data['status'] ?? Page::STATUS_ACTIVE,
        ]);

        return $page;
    }
}
