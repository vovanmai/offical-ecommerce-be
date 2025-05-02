<?php

namespace App\Services\User\Cart;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class StoreService
{

    /**
     * @param array $filters Filters
     *
     * @return
     */
    public function handle (array $data)
    {
        $userId = auth()->id();

        $product = Product::query()
            ->where('id', $data['product_id'])
            ->firstOrFail();

        $productInCart = Cart::query()
            ->where('user_id', $userId)
            ->where('product_id', $data['product_id'])
            ->first();


        if ($productInCart) {
            $quantity = $productInCart->quantity + $data['quantity'];

            if ($quantity > $product->inventory_quantity) {
                throw new BadRequestException('Số lượng tồn kho không đủ.');
            }

            $productInCart->update([
                'quantity' => $productInCart->quantity + $data['quantity'],
            ]);

            return $productInCart;
        }

        return Cart::query()->create([
            'user_id' => $userId,
            'product_id' => $data['product_id'],
            'quantity' => $data['quantity'],
        ]);
    }
}
