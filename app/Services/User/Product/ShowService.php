<?php

namespace App\Services\User\Product;

use App\Models\Product;

class ShowService
{

    /**
     * @param array $filters Filters
     *
     * @return
     */
    public function handle (string $slug)
    {
        $product = Product::with([
            'category.parent',
            'previewImage',
            'detailFiles'
        ])->where('status', Product::STATUS_ACTIVE)
            ->where('slug', $slug)->firstOrFail();

        return $product;
    }
}
