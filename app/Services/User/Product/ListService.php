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

        return $query->orderBy('id', 'DESC')
            ->where('status', Product::STATUS_ACTIVE)
            ->limit($data['limit'])
            ->select([
                'id',
                'name',
                'slug',
                'price',
            ])
            ->get();
    }
}
