<?php

namespace App\Services\Admin\Page;

use App\Models\Page;

class ShowService
{

    /**
     * @param array $filters Filters
     *
     * @return
     */
    public function handle (int $id)
    {
        $page = Page::findOrFail($id);

        return $page;
    }
}
