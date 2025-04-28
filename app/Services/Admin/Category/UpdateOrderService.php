<?php

namespace App\Services\Admin\Category;

use App\Models\Category;
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
        $categories = $data['categories'] ?? [];

        $updates = $this->prepareUpdateData($categories);

        if (!empty($updates)) {
            $this->updateCategoryOrder($updates);
        }
    }

    private function prepareUpdateData(array $categories, int|null $parentId = null, &$updates = [])
    {
        foreach ($categories as $index => $category) {
            $updates[] = [
                'id' => $category['id'],
                'parent_id' => $parentId,
                'order' => $index + 1,
            ];

            if (!empty($category['children'])) {
                $this->prepareUpdateData($category['children'], $category['id'], $updates);
            }
        }
        return $updates;
    }

    function updateCategoryOrder(array $categories)
    {
        if (empty($categories)) {
            return;
        }

        // Lấy danh sách ID từ dữ liệu đầu vào
        $ids = array_column($categories, 'id');

        // Tạo câu lệnh CASE cho `order`
        $orderCases = "CASE ";
        $parentCases = "CASE ";

        foreach ($categories as $index => $category) {
            $orderCases .= "WHEN id = {$category['id']} THEN {$category['order']} ";
            $parentId = $category['parent_id'] ?? 'NULL'; // Xử lý giá trị NULL hợp lệ
            $parentCases .= "WHEN id = {$category['id']} THEN " . ($parentId === 'NULL' ? "NULL" : $parentId) . " ";
        }

        $orderCases .= "END";
        $parentCases .= "END";

        // Cập nhật database chỉ với 1 câu lệnh duy nhất
        DB::table('categories')
            ->whereIn('id', $ids)
            ->update([
                'order' => DB::raw($orderCases),
                'parent_id' => DB::raw($parentCases),
            ]);
    }
}
