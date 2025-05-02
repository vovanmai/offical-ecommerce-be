<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Requests\User\Cart\CreateRequest;
use App\Services\User\Cart\ClearService;
use App\Services\User\Cart\DeleteService;
use App\Services\User\Cart\ListService;
use App\Services\User\Cart\StoreService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class CartController extends BaseController
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
