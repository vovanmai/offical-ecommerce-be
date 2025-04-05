<?php

namespace App\Services\Admin\Page;

use App\Models\Page;
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
            'name' => 'pages.name',
        ];
        $query = Page::query();

        if(filled($data['name'] ?? null)) {
            $query->where('pages.name', 'like', "%{$data['name']}%");
        }

        if(filled($data['created_at_from'] ?? null)) {
            $query->where('pages.created_at', '>', Carbon::parse($data['created_at_from'])->startOfSecond());
        }

        if(filled($data['created_at_to'] ?? null)) {
            $query->where('pages.created_at', '<', Carbon::parse($data['created_at_to'])->startOfSecond());
        }

        if(filled($data['sort'] ?? null)) {
            $query->orderBy($sortColumns[$data['sort']], $data['order']);
        } else {
            $query->orderBy('pages.id', 'DESC');
        }

        return $query->paginate($data['per_page'] ?? 15, [
            'pages.*',
        ]);
    }
}
