<?php

namespace App\Services\Admin\Category;

use App\Models\Category;
use App\Models\Post;
use App\Models\Product;

class DeleteService
{

    /**
     * @param array $filters Filters
     *
     * @return
     */
    public function handle (int $id, array $data)
    {
        $type = $data['type'] ?? Category::TYPE_PRODUCT;

        $category = Category::findOrFail($id);

        $childrenIds = $category->children()->get()->pluck('id');

        $categoryIds = [...$childrenIds, $category->id];

        $category->delete();
        $category->children()->delete();

        if ($type === Category::TYPE_PRODUCT) {
            $products = Product::whereIn('category_id', $categoryIds)->get();
            foreach ($products as $product) {
                $product->previewImage()->delete();
                $product->detailFiles()->delete();
                $product->delete();
            }
        } else {
            $posts = Post::whereIn('category_id', $categoryIds)->get();
            foreach ($posts as $post) {
                $post->previewImage()->delete();
                $post->delete();
            }
        }

        $withCount = $type === Category::TYPE_PRODUCT ? 'products' : 'posts';

        return Category::where('type', $data['type'])
            ->withCount($withCount)
            ->orderBy('order')
            ->get()
            ->toArray();
    }
}
