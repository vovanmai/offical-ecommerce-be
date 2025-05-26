<?php

namespace App\Services\User\Page;

use App\Models\Page;

class ListService
{

    /**
     * @param array $filters Filters
     *
     * @return
     */
    public function handle (array $data)
    {
        $query = Page::query()
            ->where('status', Page::STATUS_ACTIVE);

        return $query->select([
            'id',
            'name',
            'slug',
            'is_display_main_menu',
            'is_display_footer',
        ])->get();
    }
}
