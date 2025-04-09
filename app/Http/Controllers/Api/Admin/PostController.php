<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\Admin\Post\CreateRequest;
use App\Http\Requests\Admin\Post\EditRequest;
use App\Models\Category;
use App\Services\Admin\Post\DeleteService;
use App\Services\Admin\Post\ListService;
use App\Services\Admin\Post\StoreService;
use App\Services\Admin\Post\ShowService;
use App\Services\Admin\Post\UpdateService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class PostController extends BaseController
{
    public function index (Request $request)
    {
        $data = $request->only([
            'name',
            'category_id',
            'status',
            'created_at_from',
            'created_at_to',
            'per_page',
            'sort',
            'order',
        ]);

        $items = resolve(ListService::class)->handle($data);

        return response()->success($items);
    }

    public function show (int $id)
    {
        $product = resolve(ShowService::class)->handle($id);

        return response()->success($product);
    }

    public function store (CreateRequest $request)
    {
        $data = $request->validated();

        $product = DB::transaction(function () use ($data) {
            return resolve(StoreService::class)->handle($data);
        });

        return response()->success($product);
    }

    public function update (EditRequest $request, int $id)
    {
        $data = $request->validated();

        DB::transaction(function () use ($id, $data) {
            resolve(UpdateService::class)->handle($id, $data);
        });

        return response()->success();
    }

    public function destroy ($id)
    {
        DB::transaction(function () use ($id) {
            resolve(DeleteService::class)->handle($id);
        });
        return response()->success([], 'Thành công');
    }
}
