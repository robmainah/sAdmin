<?php

namespace App\Models\Mpesa;

use Illuminate\Database\Eloquent\SoftDeletes;
use Safaricom\Mpesa\Mpesa;

class StkPushPayment extends MpesaConstants
{
    use SoftDeletes;

    protected $table = "mpesa_stkpush_payments";

    public function createPayment()
    {
        $BusinessShortCode = 174379;
        $LipaNaMpesaPasskey = $this->pass_key;
        $TransactionType = 'CustomerPayBillOnline';
        $Amount = 1;
        $PartyA = 254703249349;
        $PartyB = 174379;
        $PhoneNumber = 254703249349;
        $CallBackURL = "https://backend-ecommerce-api.herokuapp.com/api/v1/callback/cst-st";
        $AccountReference = "Mpesa tutorial";
        $TransactionDesc = "Testing stk push on sandbox";
        $remarks = "remarks";

        $mpesa = new Mpesa();
        $stk = $mpesa->STKPushSimulation($BusinessShortCode, $LipaNaMpesaPasskey,
                                    $TransactionType, $Amount, $PartyA, $PartyB, $PhoneNumber,
                                    $CallBackURL, $AccountReference, $TransactionDesc, $remarks);


        $decoded_data = json_decode($stk);
        $decoded_data->ResponseFrom = "stkpush";

        $store_response = new StkPushResponses();
        $store_data = $store_response->storeData($decoded_data);

        return $store_data;
    }

    public function callback()
    {
        $callbackResponse = json_decode($this->processSTKCallback());

        if ($callbackResponse) {
            $this->resultDesc = $callbackResponse->resultDesc;
            $this->resultCode = $callbackResponse->resultCode;
            $this->merchantRequestID = $callbackResponse->merchantRequestID;
            $this->checkoutRequestID = $callbackResponse->checkoutRequestID;
            $this->amount = $callbackResponse->amount;
            $this->mpesaReceiptNumber = $callbackResponse->mpesaReceiptNumber;
            $this->transactionDate = $callbackResponse->transactionDate;
            $this->phoneNumber = $callbackResponse->phoneNumber;

            $this->save();
        }

        return $this;
    }

    protected function processSTKCallback()
    {
            $callbackJSONData = file_get_contents('php://input');
            $callbackData = json_decode($callbackJSONData);

            if ($callbackData->Body->stkCallback->ResultCode !== 0) {
                return false;
            }

            $resultCode = $callbackData->Body->stkCallback->ResultCode;
            $resultDesc = $callbackData->Body->stkCallback->ResultDesc;
            $merchantRequestID = $callbackData->Body->stkCallback->MerchantRequestID;
            $checkoutRequestID = $callbackData->Body->stkCallback->CheckoutRequestID;
            $amount = $callbackData->Body->stkCallback->CallbackMetadata->Item[0]->Value;
            $mpesaReceiptNumber = $callbackData->Body->stkCallback->CallbackMetadata->Item[1]->Value;
            $transactionDate = $callbackData->Body->stkCallback->CallbackMetadata->Item[3]->Value;
            $phoneNumber = $callbackData->Body->stkCallback->CallbackMetadata->Item[4]->Value;

            $result = [
                "resultDesc" => $resultDesc,
                "resultCode" => $resultCode,
                "merchantRequestID" => $merchantRequestID,
                "checkoutRequestID" => $checkoutRequestID,
                "amount" => $amount,
                "mpesaReceiptNumber" => $mpesaReceiptNumber,
                "transactionDate" => $transactionDate,
                "phoneNumber" => $phoneNumber
            ];

            return json_encode($result);
    }

}
