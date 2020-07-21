<?php

namespace App\Models\Mpesa;

use Illuminate\Database\Eloquent\Model;

class StkPushResponses extends Model
{
    protected $table = "mpesa_stkpush_responses";

    public function storeData($query_response)
    {
        $this->responseCode = $query_response->ResponseCode;
        $this->responseDesc = $query_response->ResponseDescription;
        $this->merchantRequestID = $query_response->MerchantRequestID;
        $this->checkoutRequestID = $query_response->CheckoutRequestID;
        $this->responseFrom = $query_response->ResponseFrom;

        if ($query_response->ResponseFrom === "stkpush") {
            $this->CustomerMessage = $query_response->CustomerMessage;
        }

        if ($query_response->ResponseFrom === "stkpush_query") {
            $this->resultCode = $query_response->ResultCode;
            $this->resultDesc = $query_response->ResultDesc;
        }

        $this->save();

        return $this;
    }

}
