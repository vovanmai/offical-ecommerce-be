<?php

namespace App\Services\Admin\Category;

use App\Models\Category;

class StoreService
{

    /**
     * @param array $filters Filters
     *
     * @return
     */
    public function handle (array $data)
    {
        return Category::create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'type' => $data['type'] ?? Category::TYPE_PRODUCT,
            'parent_id' => $data['category_id'] ?? null,
        ]);
    }
}
