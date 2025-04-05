<?php

namespace App\Services\Admin\Product;

use App\Models\Category;
use App\Models\Product;
use App\Services\Admin\Upload\UpdateService as UploadUpdateService;

class UpdateService
{

    /**
     * @param array $filters Filters
     *
     * @return
     */
    public function handle (int $id, array $data)
    {
        $product = Product::findOrFail($id);

        if($data['preview_image_id'] !== $product->previewImage->id) {
            $product->previewImage()->delete();
            resolve(UploadUpdateService::class)->handle([$data['preview_image_id']], $product, 'preview_image');
        }

        $product->update([
            'name' => $data['name'],
            'status' => $data['status'] ?? Category::STATUS_ACTIVE,
            'description' => $data['description'],
            'price' => $data['price'] ?? null,
            'category_id' => $data['category_id'] ?? null,
            'inventory_quantity' => $data['inventory_quantity'] ?? null,
        ]);

        return $product;
    }
}
