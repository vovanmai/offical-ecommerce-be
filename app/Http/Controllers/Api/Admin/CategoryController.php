<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\Admin\Category\CreateRequest;
use App\Http\Requests\Admin\Category\EditRequest;
use App\Models\Category;
use App\Services\Admin\Category\ChangActiveService;
use App\Services\Admin\Category\CreateService;
use App\Services\Admin\Category\DeleteService;
use App\Services\Admin\Category\DetailService;
use App\Services\Admin\Category\EditService;
use App\Services\Admin\Category\GetAllService;
use App\Services\Admin\Category\ListService;
use App\Services\Admin\Category\StoreService;
use App\Services\Admin\Category\UpdateOrderService;
use App\Services\Admin\Category\UpdateService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Exception;
use Log;

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

        return response()->json($categories);
    }

    public function update (EditRequest $request, int $id)
    {
        $data = $request->only([
            'name',
            'description',
            'category_id',
        ]);

        $data['parent_id'] = $data['category_id'] ?? null;

        try {
            resolve(UpdateService::class)->handle($id, $data);

            session()->flash('error_msg', trans('message.admin.create_success'));

            return redirect()->back();
        } catch (Exception $ex) {
            Log::info($ex->getMessage());
            return redirect()->route('admin.error.error');
        }
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
