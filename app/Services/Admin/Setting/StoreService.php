<?php

namespace App\Services\Admin\Setting;

use App\Models\Setting;

class StoreService
{

    /**
     * @param array $filters Filters
     *
     * @return
     */
    public function handle (array $data)
    {
        foreach ($data['data'] ?? [] as $item) {
            Setting::updateOrCreate(
                ['key' => $item['key']],
                ['value' => is_array($item['value']) ? json_encode($item['value']) : $item['value']],
            );
        }
    }
}
