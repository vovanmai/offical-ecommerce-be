<?php

namespace App\Services\Admin\Upload;

use App\Models\Upload;
use ImageKit\ImageKit;

class DeleteService
{
    public $imageKit;

    public function __construct()
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
            $response = $this->imageKit->deleteFile($upload->data['file_id']);

            if(!isset($response->error)) {
                $upload->delete();
            }
        }
    }
}
