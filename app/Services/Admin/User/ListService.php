<?php

namespace App\Services\Admin\User;

use App\Models\User;
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
            'name' => 'users.name',
            'email' => 'users.email',
        ];
        $query = User::query();


        if(filled($data['name'] ?? null)) {
            $query->where('users.name', 'like', "%{$data['name']}%");
        }

        if(filled($data['email'] ?? null)) {
            $query->where('users.email', 'like', "%{$data['email']}%");
        }

        if(filled($data['created_at_from'] ?? null)) {
            $query->where('users.created_at', '>', Carbon::parse($data['created_at_from'])->startOfSecond());
        }

        if(filled($data['created_at_to'] ?? null)) {
            $query->where('users.created_at', '<', Carbon::parse($data['created_at_to'])->startOfSecond());
        }

        if(filled($data['sort'] ?? null)) {
            $query->orderBy($sortColumns[$data['sort']], $data['order']);
        } else {
            $query->orderBy('users.id', 'DESC');
        }

        return $query->paginate($data['per_page'] ?? 15, [
            'users.*',
        ]);
    }
}
