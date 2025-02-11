<?php

namespace App\Http\Resources;

use App\Http\Services\ImageService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class DoctorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "name"=> $this->name,
            "image"=>$this->image?(new ImageService)->imageUrlToBase64(Storage::url("doctors/$this->image")):"",
            "signature"=>$this->signature?( new ImageService)->imageUrlToBase64(Storage::url("doctors/$this->signature")):"",
            "scond_phone"=>$this->second_phone,
            "commission"=>$this->commission."%",
            "first_phone"=>$this->first_phone,
            "user"=>new UserResource($this->user),
            "status"=> $this->status,
            "personal_id"=> $this->personal_id,
            "created_at"=>$this->created_at,
            "clinics"=>ClinicResource::collection($this->clinics()->orderByPivot("created_at","desc")->get()),
            "register_id"=>$this->register_id,
            "grander"=>$this->grander->name,
        ];
    }
}
