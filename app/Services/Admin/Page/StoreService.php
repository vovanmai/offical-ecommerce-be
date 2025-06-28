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
            'short_description' => $data['short_description'] ?? null,
            'status' => $data['status'] ?? Page::STATUS_ACTIVE,
            'is_display_main_menu' => $data['is_display_main_menu'] ?? true,
            'is_display_footer' => $data['is_display_footer'] ?? true,
        ]);

        return $page;
    }
}
