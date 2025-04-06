<?php

namespace App\Services\Admin\Banner;

use App\Models\Banner;

class DeleteService
{

    /**
     * @param array $filters Filters
     *
     * @return
     */
    public function handle (int $id)
    {
        $product = Banner::findOrFail($id);

        $product->delete();
    }
}
