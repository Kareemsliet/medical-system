<?php

namespace App\Http\Resources;

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
            "image"=>$this->image?Storage::url("doctors/$this->image"):"",
            "signature"=>$this->image?Storage::url("doctors/$this->signature"):"",
            "scond_phone"=>$this->second_phone,
            "commission"=>$this->commission."%",
            "first_phone"=>$this->first_phone,
            "company"=>new CompanyResource($this->company),
            "status"=> $this->status,
            "personal_id"=> $this->personal_id,
            "created_at"=>$this->created_at,
        ];
    }
}
