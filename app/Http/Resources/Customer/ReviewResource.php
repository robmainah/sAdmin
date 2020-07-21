<?php

namespace App\Http\Resources\Customer;

use App\Http\Resources\Customer\ProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            "id" => $this->id,
            "body" => $this->body,
            "creator" => new CustomerResource($this->customer),
            "created_at" => (string) $this->created_at->diffForHumans()
        ];
    }
}
