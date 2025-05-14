<?php

namespace App\Services\User\Product;

use App\Models\Category;
use App\Models\Product;

class ListByCategoryService
{

    /**
     * @param array $filters Filters
     *
     * @return
     */
    public function handle (string $slug)
    {
        $category = Category::where('slug', $slug)
            ->where('status', Category::STATUS_ACTIVE)
            ->firstOrFail();

        $products = Product::with([
            'previewImage',
            'category.parent',
        ])->where('category_id', $category->id)
        ->where('status', Product::STATUS_ACTIVE)
        ->orderBy('id', 'DESC')
        ->firstOrFail();

        return $products;
    }
}
