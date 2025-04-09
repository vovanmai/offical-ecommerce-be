<?php

namespace App\Services\Admin\Category;

use App\Models\Category;

class DeleteService
{

    /**
     * @param array $filters Filters
     *
     * @return
     */
    public function handle (int $id)
    {
        $category = Category::findOrFail($id);

        $category->delete();
    }
}
