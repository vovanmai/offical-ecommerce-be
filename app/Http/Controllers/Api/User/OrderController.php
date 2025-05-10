<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Requests\User\Order\CreateRequest;
use App\Http\Requests\User\Cart\EditRequest;
use App\Services\User\Cart\ClearService;
use App\Services\User\Cart\DeleteService;
use App\Services\User\Cart\ListService;
use App\Services\User\Order\StoreService;
use App\Services\User\Cart\UpdateService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class OrderController extends BaseController
{
    public function index (Request $request)
    {

        $items = resolve(ListService::class)->handle();

        return response()->success($items);
    }

    public function store (CreateRequest $request)
    {
        $data = $request->validated();

        $item = DB::transaction(function () use ($data) {
            return resolve(StoreService::class)->handle($data);
        });

        return response()->success($item);
    }

    public function update (EditRequest $request, $id)
    {
        $data = $request->validated();

        $item = DB::transaction(function () use ($id, $data) {
            return resolve(UpdateService::class)->handle($id, $data);
        });

        return response()->success($item);
    }

    public function destroy ($id)
    {
        DB::transaction(function () use ($id) {
            resolve(DeleteService::class)->handle($id);
        });
        return response()->success([], 'Thành công');
    }

    public function clear ()
    {
        DB::transaction(function () {
            resolve(ClearService::class)->handle();
        });
        return response()->success([], 'Thành công');
    }
}
