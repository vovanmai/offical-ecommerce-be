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
        $limit = $data['limit'] ?? null;
        $keyword = $data['keyword'] ?? null;
        $query = Product::query()
            ->with([
                'previewImage'
            ])
            ->orderBy('id', 'DESC')
            ->where('status', Product::STATUS_ACTIVE)
            ->select([
                'id',
                'name',
                'slug',
                'price',
            ]);

        if($keyword) {
            $query->where('name', 'like', "%{$keyword}%");
        }

        if($limit) {
            return $query->limit($limit)->get();
        }

        return $query->paginate($data['per_page']);
    }
}
