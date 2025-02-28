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
        $categories = Category::where('type', $data['type'])->orderBy('id', 'ASC')->get()->toArray();
        return buildTree($categories);
    }
}
