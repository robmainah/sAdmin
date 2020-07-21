<?php

namespace App\Http\Resources\Customer;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            'fullName' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phoneNumber,
            'id_number' => $this->idNumber,
            'address' => $this->address,
            'gender' => $this->gender,
        ];
    }
}
