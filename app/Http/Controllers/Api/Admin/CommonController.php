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

        $upload = Upload::create([
            'filename' => $resultFile->name,
            'path' => 'uploads',
            'file_size' => $resultFile->size,
            'data' => [
                'endpoint_url' => config('filesystems.imagekit.url_endpoint'),
                'file_id' => $resultFile->fileId,
            ]
        ]);

        return response()->success($upload);
    }
}
