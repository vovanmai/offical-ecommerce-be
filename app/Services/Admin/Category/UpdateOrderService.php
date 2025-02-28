<?php

namespace App\Services\Admin\Category;

use App\Models\Category;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class UpdateOrderService
{

    /**
     * @param array $filters Filters
     *
     * @return
     */
    public function handle (array $data)
    {
        $categoryIds = $data['category_ids'] ?? [];
        if (!empty($categoryIds)) {
            $parentId = $data['parent_id'] ?? 'NULL';
            $sql = "UPDATE categories SET parent_id = {$parentId}, `order` = CASE";
            $ids = [];

            foreach ($categoryIds as $key => $id) {
                $index = $key + 1;
                $sql .= " WHEN id = {$id} THEN {$index}";
                $ids[] = $id;
            }

            $sql .= " END WHERE id IN (" . implode(',', $ids) . ")";

            DB::statement($sql);
        }
    }
}
