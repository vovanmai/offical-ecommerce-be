<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Exception;
use ImageKit\ImageKit;
use Log;

class CommonController extends BaseController
{
    public function upload (Request $request)
    {
        $file = $request->file('file');

        if(!$file) {
            return response()->error('File required.');
        }

        $imageKit = new ImageKit(
            config('filesystems.imagekit.public_key'),
            config('filesystems.imagekit.private_key'),
            config('filesystems.imagekit.url_endpoint'),
        );

        $fileData = file_get_contents($file->getRealPath());

        $uploadFile = $imageKit->uploadFile([
            'file' => base64_encode($fileData),
            'fileName' => $file->getClientOriginalName(),
            'folder' => "uploads"
        ]);

        $resultFile = $uploadFile->result ?? null;

        $fileInfo = pathinfo($resultFile->url);

        $upload = Upload::create([
            'filename' => $fileInfo['basename'],
            'path' => $fileInfo['dirname'],
            'file_size' => $resultFile->size,
        ]);

        return response()->success($upload);
    }
}
