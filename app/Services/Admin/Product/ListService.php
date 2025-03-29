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
        $sortColumns = [
            'name' => 'products.name',
            'price' => 'products.price',
        ];
        $query = Product::query()
            ->with([
                'previewImage'
            ])
            ->join('categories', 'categories.id', '=', 'products.category_id');

        if(filled($data['name'] ?? null)) {
            $query->where('products.name', 'like', "%{$data['name']}%");
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

        if(filled($data['sort'] ?? null)) {
            $query->orderBy($sortColumns[$data['sort']], $data['order']);
        } else {
            $query->orderBy('products.id', 'DESC');
        }

        return $query->paginate($data['per_page'] ?? 15, [
            'products.*',
            'categories.id as category_id',
            'categories.name as category_name',
        ]);
    }
}
