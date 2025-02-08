<?php

namespace App\Http\Services;

use GuzzleHttp\Client;
class ImageService
{
    public function uploadImage($file,$folderPath)
    {        
        $image = uniqid().'.'.$file->getClientOriginalExtension();

        $file->move(storage_path("/app/public/".$folderPath),$image);

        return $image;
    }
    public function destroyImage($fileName,$folderPath){
      unlink(storage_path("/app/public/".$folderPath.'/'.$fileName));
    }
    public function imageUrlToBase64($imageUrl){

      $client= new Client();

      $response = $client->get(url($imageUrl));

      $imageContent = $response->getBody()->getContents();

      $contentType = $response->getHeader('Content-Type')[0];
      
      $extension = explode('/', $contentType)[1]; // Get the image extension

      $imageBase64=base64_encode($imageContent);

      $dataUri = "data:image/{$extension};base64,{$imageBase64}";

      return $dataUri;
    }
}

