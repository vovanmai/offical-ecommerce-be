<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\Admin\Page\CreateRequest;
use App\Http\Requests\Admin\Page\EditRequest;
use App\Models\Page;
use App\Services\Admin\Page\DeleteService;
use App\Services\Admin\Page\ListService;
use App\Services\Admin\Page\StoreService;
use App\Services\Admin\Page\ShowService;
use App\Services\Admin\Page\UpdateService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Exception;
use Illuminate\Support\Facades\DB;

class PageController extends BaseController
{
    public function index (Request $request)
    {dd(111);
        $data = $request->only([
            'name',
        ]);

        $items = resolve(ListService::class)->handle($data);

        return response()->success($items);
    }

    public function show (int $id)
    {
        $page = resolve(ShowService::class)->handle($id);

        return response()->success($page);
    }

    public function store (CreateRequest $request)
    {
        $data = $request->validated();

        $page = DB::transaction(function () use ($data) {
            return resolve(StoreService::class)->handle($data);
        });

        return response()->success($page);
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
