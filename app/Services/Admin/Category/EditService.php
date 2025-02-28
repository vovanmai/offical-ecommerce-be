<?php

namespace App\Services\Admin\Category;

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
