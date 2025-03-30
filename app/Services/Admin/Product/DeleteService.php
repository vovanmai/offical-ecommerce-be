<?php

namespace App\Services\Admin\Product;

use App\Models\Product;
use App\Services\Admin\Upload\DeleteService as UploadDeleteService;

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

        $previewImage = $product->previewImage;

        resolve(UploadDeleteService::class)->handle([$previewImage->id]);

        $detailMedias = $product->detailMedias;


    }
}
