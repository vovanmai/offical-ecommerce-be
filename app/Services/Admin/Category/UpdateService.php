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
        $cat = Category::findOrFail($id);

        return $cat->update([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'parent_id' => $data['category_id'] ?? null,
        ]);
    }
}
