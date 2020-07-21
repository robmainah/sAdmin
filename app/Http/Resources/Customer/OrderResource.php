<?php

namespace App\Http\Resources\Customer;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'id' => $this->id,
            'code' => $this->code,
            'status' => $this->status,
            'shippingDate' => $this->shippingDate,
            'updated_at' => $this->updated_at->format('Y-m-d'),
            'customer' => $this->customer_id,
            'items' => $this->orderProduct
        ];
    }
}
