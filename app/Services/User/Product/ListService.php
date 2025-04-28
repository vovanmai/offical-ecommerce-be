<?php

namespace App\Services\User\Product;

use App\Models\Product;

class ListService
{

    /**
     * @param array $filters Filters
     *
     * @return
     */
    public function handle (array $data)
    {
        $query = Product::query()
            ->with([
                'previewImage'
            ]);

        return $query->orderBy('id', 'DESC')->limit($data['limit'])->get();
    }
}
