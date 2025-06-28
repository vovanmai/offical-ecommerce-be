<?php

namespace App\Services\Admin\Page;

use App\Models\Page;

class UpdateService
{

    /**
     * @param array $filters Filters
     *
     * @return
     */
    public function handle (int $id, array $data)
    {
        $page = Page::findOrFail($id);

        $page->update([
            'name' => $data['name'],
            'status' => $data['status'] ?? Page::STATUS_ACTIVE,
            'description' => $data['description'],
            'short_description' => $data['short_description'] ?? null,
            'is_display_main_menu' => $data['is_display_main_menu'] ?? true,
            'is_display_footer' => $data['is_display_footer'] ?? true,
        ]);

        return $page;
    }
}
