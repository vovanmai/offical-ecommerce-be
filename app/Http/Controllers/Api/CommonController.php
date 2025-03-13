<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Exception;
use ImageKit\ImageKit;
use Log;

class CommonController extends BaseController
{
    public function upload (Request $request)
    {

        $imageKit = new ImageKit(
            'public_wmozLO3kUXddAcuegw7QZlIbDgA=',
            'private_bnGuMmW6BCdpAvB/JuyesDSjzNU=',
            'https://ik.imagekit.io/ejqr7rydp/test'
        );


        $file = $request->file('upload');
        $fileData = file_get_contents($file->getRealPath());

        $uploadFile = $imageKit->uploadFile([
            'file' => base64_encode($fileData),
            'fileName' => $file->getClientOriginalName(),
            'folder' => "uploads"
        ]);

        dd($uploadFile);
    }
}
