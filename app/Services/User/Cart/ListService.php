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
                'product',
            ]);

        return $query->orderBy('id', 'ASC')->get();
    }
}
