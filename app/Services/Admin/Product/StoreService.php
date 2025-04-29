<?php

namespace App\Services\Admin\Product;

use App\Models\Product;
use App\Services\Admin\Upload\UpdateService;

class StoreService
{

    /**
     * @param array $filters Filters
     *
     * @return
     */
    public function handle (array $data)
    {
        $product = Product::create([
            'name' => $data['name'],
            'price' => $data['price'],
            'description' => $data['description'] ?? null,
            'category_id' => $data['category_id'],
            'inventory_quantity' => $data['inventory_quantity'],
            'status' => $data['status'] ?? Product::STATUS_ACTIVE,
            'unit' => $data['unit'],
        ]);

        if(filled($data['preview_image_id']) ?? null) {
            resolve(UpdateService::class)->handle([$data['preview_image_id']], $product, 'preview_image');
        }

        if(filled($data['detail_file_ids']) ?? null) {
            resolve(UpdateService::class)->handle($data['detail_file_ids'], $product, 'detail_file');
        }

        return $product;
    }
}
