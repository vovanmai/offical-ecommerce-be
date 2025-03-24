<?php

namespace App\Services\Admin\Product;

use App\Models\Product;
use Carbon\Carbon;

class ListService
{

    /**
     * @param array $filters Filters
     *
     * @return
     */
    public function handle (array $data)
    {
        $query = Product::query()->join('categories', 'categories.id', '=', 'products.category_id');

        if(filled($data['name'] ?? null)) {
            $query->where('products.name', 'like', $data['name']);
        }

        if(filled($data['created_at_from'] ?? null)) {
            $query->where('products.created_at', '>', Carbon::parse($data['created_at_from'])->startOfSecond());
        }

        if(filled($data['created_at_to'] ?? null)) {
            $query->where('products.created_at', '<', Carbon::parse($data['created_at_to'])->startOfSecond());
        }

        if(filled($data['category_id'] ?? null)) {
            $query->where('categories.category_id', $data['category_id']);
        }

        return $query->paginate($data['per_page'] ?? 20);
    }
}
