<?php

namespace App\Services\Admin\Category;

use App\Models\Category;

class UpdateService
{

    /**
     * @param array $filters Filters
     *
     * @return
     */
    public function handle (int $id, array $data)
    {
        $category = Category::findOrFail($id);

        $category->update([
            'name' => $data['name'],
            'status' => $data['status'] ?? Category::STATUS_ACTIVE,
            'description' => $data['description'],
            'parent_id' => $data['parent_id'] ?? null,
        ]);

        $withCount = $data['type'] === Category::TYPE_PRODUCT ? 'products' : 'posts';

        return Category::where('type', $data['type'])
            ->withCount($withCount)
            ->orderBy('order')
            ->get()
            ->toArray();
    }
}
