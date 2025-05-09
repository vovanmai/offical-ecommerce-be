<?php

namespace App\Services\User\Cart;

use App\Models\Cart;

class ListService
{

    /**
     * @param array $filters Filters
     *
     * @return
     */
    public function handle ()
    {
        $query = Cart::query()
            ->with([
                'user',
                'product.previewImage',
            ]);

        return $query->orderBy('id', 'ASC')->select(['carts.*', 'carts.id as key'])->get();
    }
}
