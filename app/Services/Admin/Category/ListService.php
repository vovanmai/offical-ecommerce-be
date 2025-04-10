<?php

namespace App\Services\Admin\Category;

use App\Models\Category;

class ListService
{

    /**
     * @param array $filters Filters
     *
     * @return
     */
    public function handle (array $data)
    {
        $withCount = $data['type'] === Category::TYPE_PRODUCT ? 'products' : 'posts';
        $categories = Category::where('type', $data['type'])
            ->withCount($withCount)
            ->orderBy('order')->get()->toArray();
        return $categories;
    }
}
