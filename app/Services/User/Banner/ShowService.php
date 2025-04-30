<?php

namespace App\Services\Admin\Product;

use App\Models\Product;

class ShowService
{

    /**
     * @param array $filters Filters
     *
     * @return
     */
    public function handle (int $id)
    {
        $product = Product::with([
            'previewImage',
            'detailFiles'
        ])->findOrFail($id);

        return $product;
    }
}
