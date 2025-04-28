<?php

namespace App\Services\Admin\Product;

use App\Models\Product;

class DeleteService
{

    /**
     * @param array $filters Filters
     *
     * @return
     */
    public function handle (int $id)
    {
        $product = Product::findOrFail($id);
        $product->previewImage()->delete();
        $product->detailFiles()->delete();

        $product->delete();
    }
}
