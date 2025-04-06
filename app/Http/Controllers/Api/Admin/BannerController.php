<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\Admin\Banner\CreateRequest;
use App\Http\Requests\Admin\Banner\EditRequest;
use App\Services\Admin\Banner\DeleteService;
use App\Services\Admin\Banner\ListService;
use App\Services\Admin\Banner\StoreService;
use App\Services\Admin\Banner\ShowService;
use App\Services\Admin\Banner\UpdateService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class BannerController extends BaseController
{
    public function index (Request $request)
    {
        $data = $request->only([
            'name',
            'status',
            'created_at_from',
            'created_at_to',
            'per_page',
            'sort',
            'order',
        ]);

        $banners = resolve(ListService::class)->handle($data);

        return response()->success($banners);
    }

    public function show (int $id)
    {
        $banner = resolve(ShowService::class)->handle($id);

        return response()->success($banner);
    }

    public function store (CreateRequest $request)
    {
        $data = $request->validated();

        $banner = DB::transaction(function () use ($data) {
            return resolve(StoreService::class)->handle($data);
        });

        return response()->success($banner);
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
