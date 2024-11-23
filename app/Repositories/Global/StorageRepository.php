<?php

namespace App\Repositories\Global;

use Illuminate\Support\Facades\Storage;

class StorageRepository {

    private $disk;

    public function __construct()
    {
        $this->disk = Storage::disk('gcs');
    }

    public static function addFile($file , $url){

    }

    public static function deleteFile($file , $url){
        
    }
}