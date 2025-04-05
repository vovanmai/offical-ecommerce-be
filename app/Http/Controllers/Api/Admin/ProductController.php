<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\Admin\Product\CreateRequest;
use App\Http\Requests\Admin\Product\EditRequest;
use App\Models\Category;
use App\Services\Admin\Category\ChangActiveService;
use App\Services\Admin\Product\DeleteService;
use App\Services\Admin\Product\ListService;
use App\Services\Admin\Product\StoreService;
use App\Services\Admin\Category\UpdateOrderService;
use App\Services\Admin\Product\ShowService;
use App\Services\Admin\Product\UpdateService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Exception;
use Log;
use Illuminate\Support\Facades\DB;

class ProductController extends BaseController
{
    public function index (Request $request)
    {
        $data = $request->only([
            'name',
            'category_id',
            'price',
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

        $categories = resolve(UpdateService::class)->handle($id, $data);

        return response()->success($categories);
    }

    public function destroy ($id)
    {
        DB::transaction(function () use ($id) {
            resolve(DeleteService::class)->handle($id);
        });
        return response()->success([], 'Thành công');
    }

    public function changeActive (Request $request, int $id)
    {
        $data = $request->only([
            'active'
        ]);
        try {
            resolve(ChangActiveService::class)->handle($id, $data);
            return response()->success('Thành công');
        } catch (ModelNotFoundException $exception) {
            return response()->notFound();
        } catch (Exception $exception) {
            return response()->error('Máy chủ bị lỗi', $exception);
        }
    }
}
