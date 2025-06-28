<?php

namespace App\Services\User\Order;

use App\Models\Order;

class ListService
{

    /**
     * @param array $filters Filters
     *
     * @return
     */
    public function handle (array $data)
    {
        $query = Order::query();
        $status = $data['status'] ?? null;

        if ($status) {
            $query->where('status', $status);
        }

        return $query->where('user_id', auth()->id())
            ->orderBy('id', 'DESC')
            ->get();
    }
}
