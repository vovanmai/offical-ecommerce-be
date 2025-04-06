<?php

namespace App\Services\Admin\Banner;

use App\Models\Banner;

class ShowService
{

    /**
     * @param array $filters Filters
     *
     * @return
     */
    public function handle (int $id)
    {
        $banner = Banner::with([
            'image',
        ])->findOrFail($id);

        return $banner;
    }
}
