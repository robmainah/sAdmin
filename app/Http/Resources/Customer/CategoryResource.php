<?php

namespace App\Http\Resources\Customer;

use App\Http\Resources\BrandsResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'category_id' => $this->id,
            'category_title' => $this->title,
            'category_code' => $this->code,
            'category_status' => $this->status,
            'category_created_by' => $this->created_by,
            'category_created_at' => $this->created_at->format('/Y/m/d'),
            'brands' => BrandsResource::collection($this->brands)
        ];
    }
}
