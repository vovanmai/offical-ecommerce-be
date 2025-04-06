<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\Admin\Setting\CreateRequest;
use App\Services\Admin\Setting\ListService;
use App\Services\Admin\Setting\StoreService;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class SettingController extends BaseController
{

    public function index ()
    {
        $settings = resolve(ListService::class)->handle();

        return response()->success($settings);
    }

    public function store (CreateRequest $request)
    {
        $data = $request->only(['data']);

        DB::transaction(function () use ($data) {
            return resolve(StoreService::class)->handle($data);
        });

        return response()->success();
    }
}
