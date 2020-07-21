<?php

namespace App\Http\Resources\Customer;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'product_id' => $this->id,
            'product_code' => $this->code,
            'product_category' => $this->category->title,
            'product_brand' => $this->brand->title,
            'product_title' => $this->title,
            'product_slug' => $this->slug,
            'product_body' => $this->body,
            'product_price' => $this->price,
            'product_quantity' => $this->quantity,
            'product_image' => $this->image,
        ];
    }
}
