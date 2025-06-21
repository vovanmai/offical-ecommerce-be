<?php

namespace App\Services\User\Order;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
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

        $carts = Cart::with(['product'])->where('user_id', $userId)->get();

        $order = Order::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'shipping_address' => $data['shipping_address'],
            'user_id' => $userId,
            'status' => 1,
            'shipping_fee' => 30000,
            'payment_method' => $data['payment_method'] ?? Order::PAYMENT_METHOD_COD,
            'total' => $carts
                ->sum(function ($cart) {
                    return ($cart->product->sale_price ?? $cart->product->price) * $cart->quantity;
                }) + 30000,
        ]);

        $order->orderDetails()->createMany($carts->map(function ($cart) {
            return [
                'product_id' => $cart->product_id,
                'quantity' => $cart->quantity,
                'price' => $cart->product->sale_price ?? $cart->product->price,
            ];
        })->toArray());

        $carts->each(function ($cart) {
            $product = Product::find($cart->product_id);

            if ($product->inventory_quantity < $cart->quantity) {
                throw new BadRequestException('Số lượng tồn kho không đủ.');
            }

            $product->update([
                'inventory_quantity' => $product->inventory_quantity - $cart->quantity,
            ]);
        });

        Cart::query()->where('user_id', $userId)->delete();

        return $order;
    }
}
