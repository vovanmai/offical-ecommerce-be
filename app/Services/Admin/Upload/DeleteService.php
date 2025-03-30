<?php

namespace App\Services\Admin\Upload;

use App\Models\Upload;
use ImageKit\ImageKit;

class DeleteService
{

    public function __construct(private $imageKit)
    {
        $this->imageKit = new ImageKit(
            config('filesystems.imagekit.public_key'),
            config('filesystems.imagekit.private_key'),
            config('filesystems.imagekit.url_endpoint'),
        );
    }
    /**
     * @param array $filters Filters
     *
     * @return
     */
    public function handle (array $ids)
    {


        $uploads = Upload::whereIn('id', $ids)->get();

        foreach($uploads as $upload) {
            dd($files->result ?? 111);
            $deleteResponse = $imageKit->deleteFile($files->result[0]->fileId);
            dd($deleteResponse);
        }
    }


    function deleteFileByName($fileName, $folder = null) {
        $query = ['name' => $fileName];
        if ($folder) {
            $query['path'] = rtrim($folder, '/') . '/';
        }

        $files = $this->imageKit->listFiles($query);

        if (!empty($files) && isset($files[0]['fileId'])) {
            return $this->imageKit->deleteFile($files[0]['fileId']);
        }
    }
}
