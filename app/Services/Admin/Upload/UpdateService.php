<?php

namespace App\Services\Admin\Upload;

use App\Models\Product;
use App\Models\Upload;
use Illuminate\Database\Eloquent\Model;

class UpdateService
{

    /**
     * @param array $filters Filters
     *
     * @return
     */
    public function handle (array $ids, Model $model, string $key)
    {
        Upload::whereIn('id', $ids)->update([
            'uploadable_id' => $model->id,
            'uploadable_type' => $model->getMorphClass(),
            'key' => $key
        ]);
    }
}
