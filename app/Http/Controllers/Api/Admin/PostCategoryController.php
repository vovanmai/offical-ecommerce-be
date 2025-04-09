<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\Admin\PostCategory\CreateRequest;
use App\Http\Requests\Admin\PostCategory\EditRequest;
use App\Models\Category;
use App\Services\Admin\Category\DeleteService;
use App\Services\Admin\Category\ListService;
use App\Services\Admin\Category\StoreService;
use App\Services\Admin\Category\UpdateOrderService;
use App\Services\Admin\Category\UpdateService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Exception;
use Log;

class PostCategoryController extends BaseController
{
    public function index (Request $request)
    {
        $data = [
            'type' => Category::TYPE_POST,
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
        $data['type'] = Category::TYPE_POST;

        $categories = resolve(StoreService::class)->handle($data);

        return response()->success($categories);
    }

    public function updateOrder (Request $request)
    {
        $data = $request->only([
            'categories',
        ]);
        $data['type'] = Category::TYPE_POST;

        $categories = resolve(UpdateOrderService::class)->handle($data);

        return response()->success($categories);
    }

    public function update (EditRequest $request, int $id)
    {
        $data = $request->validated();
        $data['type'] = Category::TYPE_POST;

        $categories = resolve(UpdateService::class)->handle($id, $data);

        return response()->success($categories);
    }

    public function destroy ($id)
    {
        try {
            $result = resolve(DeleteService::class)->handle($id);
            return response()->success('Xóa danh mục thành công thành công', $result);
        } catch (ModelNotFoundException $exception) {
            return response()->notFound();
        } catch (Exception $exception) {
            return response()->error('Máy chủ bị lỗi', $exception);
        }
    }
}
