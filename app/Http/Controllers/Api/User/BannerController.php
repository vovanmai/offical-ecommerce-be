<?php

namespace App\Http\Controllers\Api\User;

use App\Services\User\Banner\ListService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class BannerController extends BaseController
{
    public function index (Request $request)
    {
        $items = resolve(ListService::class)->handle();

        return response()->success($items);
    }
}
