<?php

namespace App\Services\User\Page;

use App\Models\Page;

class ShowService
{

    /**
     * @param array $filters Filters
     *
     * @return
     */
    public function handle (string $slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();

        return $page;
    }
}
