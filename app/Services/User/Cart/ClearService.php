<?php

namespace App\Services\User\Cart;

use App\Models\Cart;

class ClearService
{

    /**
     * @param array $filters Filters
     *
     * @return
     */
    public function handle ()
    {
        $userId = auth()->id();

        return Cart::query()->where('user_id', $userId)->delete();
    }
}
