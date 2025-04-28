<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\Admin\Category\CreateRequest;
use App\Http\Requests\Admin\Category\EditRequest;
use App\Models\Category;
use App\Services\Admin\Category\DeleteService;
use App\Services\Admin\Category\ListService;
use App\Services\Admin\Category\StoreService;
use App\Services\Admin\Category\UpdateOrderService;
use App\Services\Admin\Category\UpdateService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class CategoryController extends BaseController
{
    public function index (Request $request)
    {
        $data = [
            'type' => Category::TYPE_PRODUCT,
        ];
        $categories = resolve(ListService::class)->handle($data);

        return response()->success($categories);
    }

    public function show (int $id)
    {
        $category = Category::findOrFail($id);

        return response()->success( $category);
    }

    public function store (CreateRequest $request)
    {
        $data = $request->validated();
        $data['type'] = Category::TYPE_PRODUCT;

        $categories = resolve(StoreService::class)->handle($data);

        return response()->success($categories);
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
        $data['type'] = Category::TYPE_PRODUCT;

        $categories = resolve(UpdateService::class)->handle($id, $data);

        return response()->success($categories);
    }

    public function destroy ($id)
    {
        $data['type'] = Category::TYPE_PRODUCT;
        $products = DB::transaction(function () use ($id, $data) {
            return resolve(DeleteService::class)->handle($id, $data);
        });

        return response()->success($products);
    }
}
