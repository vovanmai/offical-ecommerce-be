<?php

namespace App\Services\Admin\Setting;

use App\Models\Setting;

class ListService
{

    /**
     * @param array $filters Filters
     *
     * @return
     */
    public function handle ()
    {
        $settings = Setting::all();

        return $settings;
    }
}
