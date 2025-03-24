<?php

namespace App\Services\Admin\Product;

use App\Models\Category;

class EditService
{

    /**
     * @param array $filters Filters
     *
     * @return
     */
    public function handle (int $id)
    {
        return Category::findOrFail($id);
    }
}
