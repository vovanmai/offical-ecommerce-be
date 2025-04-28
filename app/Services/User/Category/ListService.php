<?php

namespace App\Services\User\Category;

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
        $query = Category::query()
        ->where('type', $data ?? 'type', Category::TYPE_POST)
        ->where('status', Category::STATUS_ACTIVE);

        return $query->orderBy('order', 'ASC')->select([
            'id',
            'name',
            'slug',
            'parent_id',
        ])->get();
    }
}
