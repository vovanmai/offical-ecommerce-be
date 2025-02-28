<?php

namespace App\Services\Admin\Category;

use App\Models\Category;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class StoreService
{

    /**
     * @param array $filters Filters
     *
     * @return
     */
    public function handle (array $data)
    {
        return Category::create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'type' => $data['type'] ?? Category::TYPE_PRODUCT,
            'order' => $this->getNextOrder($data['category_id'] ?? null, $data) + 1,
            'parent_id' => $data['category_id'] ?? null,
        ]);
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
