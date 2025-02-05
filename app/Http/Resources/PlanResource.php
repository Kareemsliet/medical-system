<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
      return [
        'name'=>$this->name,
        'description'=>$this->description,
        'price'=>$this->price,
        'deuration_period'=>$this->invoice_period,
        'deuration_interval'=>$this->invoice_interval,
        'free'=>$this->isFree(),
        "terial_period"=>$this->hasTrial(),
        'features'=>FeatureResource::collection($this->features()->orderBy('sort_order')->get()),
      ];
    }
}
