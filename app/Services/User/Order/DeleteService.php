<?php

namespace App\Services\User\Cart;

use App\Models\Cart;

class DeleteService
{

    /**
     * @param array $filters Filters
     *
     * @return
     */
    public function handle (int $id)
    {
        $cart = Cart::query()->findOrFail($id);

        return $cart->delete();
    }
}
