<?php

namespace App\Services\Admin\Banner;

use App\Models\Banner;
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
            'name' => 'banners.name',
        ];
        $query = Banner::query()
            ->with([
                'image'
            ]);

        if(filled($data['name'] ?? null)) {
            $query->where('banners.name', 'like', "%{$data['name']}%");
        }

        if(filled($data['created_at_from'] ?? null)) {
            $query->where('banners.created_at', '>', Carbon::parse($data['created_at_from'])->startOfSecond());
        }

        if(filled($data['created_at_to'] ?? null)) {
            $query->where('banners.created_at', '<', Carbon::parse($data['created_at_to'])->startOfSecond());
        }

        if(filled($data['sort'] ?? null)) {
            $query->orderBy($sortColumns[$data['sort']], $data['order']);
        } else {
            $query->orderBy('banners.id', 'DESC');
        }

        return $query->paginate($data['per_page'] ?? 15, [
            'banners.*',
        ]);
    }
}
