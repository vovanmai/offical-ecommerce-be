<?php

namespace App\Services\Admin\Page;

use App\Models\Page;

class DeleteService
{

    /**
     * @param array $filters Filters
     *
     * @return
     */
    public function handle (int $id)
    {
        $product = Page::findOrFail($id);

        $product->delete();
    }
}
