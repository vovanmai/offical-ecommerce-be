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
        $save = $request->get('save', true);

        if(!$file) {
            return response()->error('File required.');
        }

        $imageKit = new ImageKit(
            config('filesystems.imagekit.public_key'),
            config('filesystems.imagekit.private_key'),
            config('filesystems.imagekit.url_endpoint'),
        );

        $fileData = file_get_contents($file->getRealPath());

        $folder = config('filesystems.imagekit.folder');

        $uploadFile = $imageKit->uploadFile([
            'file' => base64_encode($fileData),
            'fileName' => $file->getClientOriginalName(),
            'folder' => $folder,
        ]);

        $resultFile = $uploadFile->result ?? null;

        if($save) {
            $upload = Upload::create([
                'filename' => $resultFile->name,
                'path' => $folder,
                'file_size' => $resultFile->size,
                'data' => [
                    'endpoint_url' => config('filesystems.imagekit.url_endpoint'),
                    'file_id' => $resultFile->fileId,
                ]
            ]);
            return response()->success($upload);
        }

        return response()->success([
            'url' => config('filesystems.imagekit.url_endpoint') . '/' . $folder . '/' . $resultFile->name,
        ]);
    }
}
