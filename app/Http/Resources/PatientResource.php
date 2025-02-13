<?php

namespace App\Http\Resources;

use App\Http\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
class PatientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
            "name"=>$this->name,
            "another_name"=>$this->another_name,
            "first_phone"=>$this->first_phone,
            "second_phone"=> $this->second_phone,
            "personal_id"=>$this->personal_id,
            "personal_image"=>$this->personal_image?(new ImageService)->imageUrlToBase64(Storage::url("patients/$this->personal_image")):"",
            "status"=>$this->status,
            "gender"=>$this->gender->name,
            "description"=>$this->description,
            "user"=>new UserResource($this->user),
        ];
    }
}
