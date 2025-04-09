<?php

namespace App\Services\Admin\Post;

use App\Models\Post;
use Carbon\Carbon;

class ListService
{

    /**
     * @param array $filters Filters
     *
     * @return
     */
    public function handle (array $data)
    {
        $sortColumns = [
            'name' => 'posts.name',
            'price' => 'posts.price',
        ];
        $query = Post::query()
            ->with([
                'previewImage'
            ])
            ->join('categories', 'categories.id', '=', 'posts.category_id');

        if(filled($data['name'] ?? null)) {
            $query->where('posts.name', 'like', "%{$data['name']}%");
        }

        if(filled($data['created_at_from'] ?? null)) {
            $query->where('posts.created_at', '>', Carbon::parse($data['created_at_from'])->startOfSecond());
        }

        if(filled($data['created_at_to'] ?? null)) {
            $query->where('posts.created_at', '<', Carbon::parse($data['created_at_to'])->startOfSecond());
        }

        if(filled($data['category_id'] ?? null)) {
            $query->where('categories.id', $data['category_id']);
        }

        if(filled($data['sort'] ?? null)) {
            $query->orderBy($sortColumns[$data['sort']], $data['order']);
        } else {
            $query->orderBy('posts.id', 'DESC');
        }

        return $query->paginate($data['per_page'] ?? 15, [
            'posts.*',
            'categories.name as category_name',
        ]);
    }
}
