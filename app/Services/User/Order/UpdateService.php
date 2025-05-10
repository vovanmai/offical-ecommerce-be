<?php

namespace App\Services\User\Cart;

use App\Models\Cart;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class UpdateService
{

    /**
     * @param array $filters Filters
     *
     * @return
     */
    public function handle (int $id, array $data)
    {
        $userId = auth()->id();

        $cart = Cart::findOrFail($id);

        $product = $cart->product;

        if ($data['quantity'] > $product->inventory_quantity + $cart->quantity) {
            throw new BadRequestException('Số lượng tồn kho không đủ.');
        }

        $cart->update([
            'quantity' => $data['quantity']
        ]);
    }
}
