<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Requests\Admin\Product\CreateRequest;
use App\Http\Requests\Admin\Product\EditRequest;
use App\Models\Category;
use App\Services\Admin\Product\DeleteService;
use App\Services\User\Product\ListService;
use App\Services\Admin\Product\StoreService;
use App\Services\Admin\Category\UpdateOrderService;
use App\Services\User\Product\ShowService;
use App\Services\Admin\Product\UpdateService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Exception;
use Log;
use Illuminate\Support\Facades\DB;

class ProductController extends BaseController
{
    public function index (Request $request)
    {
        $data['limit'] = $request->get('limit', 12);

        $items = resolve(ListService::class)->handle($data);

        return response()->success($items);
    }

    public function show (string $slug)
    {
        $product = resolve(ShowService::class)->handle($slug);

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

    public function updateOrder (Request $request)
    {
        $data = $request->only([
            'categories',
        ]);
        $data['type'] = Category::TYPE_PRODUCT;

        $categories = resolve(UpdateOrderService::class)->handle($data);

        return response()->success($categories);
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
