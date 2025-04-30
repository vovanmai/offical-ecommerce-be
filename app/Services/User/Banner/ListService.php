<?php

namespace App\Services\User\Banner;

use App\Models\Banner;

class ListService
{

    /**
     * @param array $filters Filters
     *
     * @return
     */
    public function handle ()
    {
        $query = Banner::query()
            ->with('image')
            ->where('status', Banner::STATUS_ACTIVE);

        return $query->select([
            '*'
        ])->get();
    }
}
