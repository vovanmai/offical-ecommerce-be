<?php

namespace App\Services\Admin\Product;

use App\Models\Category;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

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

        $categories = Category::where('type', $data['type'])->orderBy('order')->get()->toArray();
        return $categories;
    }

    private function getNextOrder(?int $parentId, array $data): int
    {
        if ($parentId) {
            return Category::find($parentId)?->children()->orderByDesc('order')->first()?->order ?? 0;
        }

        return Category::where('type', $data['type'] ?? Category::TYPE_PRODUCT)
            ->whereNotExists(fn (Builder $query) =>
                $query->select(DB::raw(1))
                    ->from('categories as tmp')
                    ->whereColumn('tmp.parent_id', 'categories.id')
            )
            ->orderByDesc('order')
            ->first()?->order ?? 0;
    }
}
