<?php

namespace App\Http\Services;

use Illuminate\Http\Request;

class ImageService
{

    public function uploadImage($file,$folderPath)
    {        
        $image = uniqid().'.'.$file->getClientOriginalExtension();

        $file->move(storage_path("/app/public/".$folderPath),$image);

        return $image;
    }

    public function destroyImage($fileName,$folderPath){
      unlink(storage_path("app/public/".$folderPath.'/'.$fileName));
    }
    
}

