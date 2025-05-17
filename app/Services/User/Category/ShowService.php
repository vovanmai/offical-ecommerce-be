<?php

namespace App\Services\User\Category;

use App\Models\Category;

class ShowService
{

    /**
     * @param array $filters Filters
     *
     * @return
     */
    public function handle (string $slug, array $data = [])
    {
        $category = Category::with([
            'parent',
        ])
        ->where('slug', $slug)
        ->where('type', $data['type'] ?? Category::TYPE_PRODUCT)
        ->where('status', Category::STATUS_ACTIVE)
        ->firstOrFail();

        return $category;
    }
}
