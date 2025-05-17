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
    public function handle (string $slug, array $data, array $filters = [])
    {
        $category = Category::query()
            ->where('slug', $slug)
            ->where('type', $data['type'] ?? Category::TYPE_PRODUCT)
            ->where('status', Category::STATUS_ACTIVE)
            ->firstOrFail(['id']);

        $products = Product::query()->with([
            'previewImage',
        ])->where('category_id', $category->id)
        ->where('status', Product::STATUS_ACTIVE)
        ->orderBy('id', 'DESC')
        ->select([
            'id',
            'name',
            'slug',
            'category_id',
            'price',
        ])
        ->paginate($data['limit']);

        return $products;
    }
}
