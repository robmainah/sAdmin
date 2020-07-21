<?php

namespace App\Http\Controllers\Mpesa;

use App\Http\Controllers\Controller;
use App\Mail\TestingMails;
use App\Models\Mpesa\MpesaPayment;
use App\Models\Mpesa\StkPushPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Safaricom\Mpesa\Mpesa;
use Mail;
use Safaricom\Mpesa\TransactionCallbacks;

class MpesaController_Old extends Controller
{

    /**
     * Class constructor.
     */
    protected $consumer_key;
    protected $consumer_secret;

    public function __construct()
    {
        $this->consumer_key = "GvKYsYcww7GBbD4FXwCulefamij08pPb";
        $this->consumer_secret = "7B8kIAz6YQbkxTGC";
    }

    public function securityCredential()
    {
        return base64_encode($this->consumer_key.":".$this->consumer_secret);
    }

    public function generateAccessToken()
    {
        // $consumer_key = $this->consumer_key;
        // $consumer_secret = $this->consumer_secret;
        $credentials = $this->securityCredential();
        $url = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Basic ".$credentials));
        curl_setopt($curl, CURLOPT_HEADER,false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $curl_response = curl_exec($curl);
        $access_token=json_decode($curl_response);

        return $access_token->access_token;
    }

    public function lipaNaMpesaPassword()
    {
        $lipa_time = Carbon::rawParse('now')->format('YmdHms');
        $passkey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
        $BusinessShortCode = 174379;
        $timestamp =$lipa_time;
        $lipa_na_mpesa_password = base64_encode($BusinessShortCode.$passkey.$timestamp);

        return $lipa_na_mpesa_password;
    }

    public function stkPush()
    {
        $mpesa = new Mpesa();

        $BusinessShortCode = 174379;
        $LipaNaMpesaPasskey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
        $TransactionType = 'CustomerPayBillOnline';
        $Amount = 1;
        $PartyA = 254703249349;
        $PartyB = 174379;
        $PhoneNumber = 254703249349;
        $CallBackURL = 'https://backend-ecommerce-api.herokuapp.com/api/v1/callback/stk/push';
        $AccountReference = "Mpesa tutorial";
        $TransactionDesc = "Testing stk push on sandbox";
        $remarks = "remarks";

        $stkPushSimulation = $mpesa->STKPushSimulation($BusinessShortCode,
                                $LipaNaMpesaPasskey, $TransactionType,
                                $Amount, $PartyA, $PartyB, $PhoneNumber,
                                $CallBackURL, $AccountReference,
                                $TransactionDesc, $remarks
                            );

        return $stkPushSimulation;
    }

    public function stkPushQuery()
    {
        $mpesa = new Mpesa();

        $environment = "sandbox";
        $checkoutRequestID = "ws_CO_020420201142132211";
        $businessShortCode = 174379;
        $password = $this->lipaNaMpesaPassword();
        $timestamp = Carbon::rawParse('now')->format('YmdHms');
        $STKPushRequestStatus = $mpesa->STKPushQuery($environment,$checkoutRequestID,$businessShortCode,$password,$timestamp);

        return $STKPushRequestStatus;
    }

    public function createValidationResponse($result_code, $result_description){
        $result=json_encode(["ResultCode"=>$result_code, "ResultDesc"=>$result_description]);
        $response = new Response();
        $response->headers->set("Content-Type","application/json; charset=utf-8");
        $response->setContent($result);

        return $response;
    }

    public function mpesaValidation()
    {
        $result_code = "0";
        $result_description = "Accepted validation request.";

        return $this->createValidationResponse($result_code, $result_description);
    }

    public function mpesaConfirmation(Request $request)
    {
        $content=json_decode($request->getContent());

        $mpesa_transaction = new MpesaPayment();

        $mpesa_transaction->TransactionType = $content->TransactionType;
        $mpesa_transaction->TransID = $content->TransID;
        $mpesa_transaction->TransTime = $content->TransTime;
        $mpesa_transaction->TransAmount = $content->TransAmount;
        $mpesa_transaction->BusinessShortCode = $content->BusinessShortCode;
        $mpesa_transaction->BillRefNumber = $content->BillRefNumber;
        $mpesa_transaction->InvoiceNumber = $content->InvoiceNumber;
        $mpesa_transaction->OrgAccountBalance = $content->OrgAccountBalance;
        $mpesa_transaction->ThirdPartyTransID = $content->ThirdPartyTransID;
        $mpesa_transaction->MSISDN = $content->MSISDN;
        $mpesa_transaction->FirstName = $content->FirstName;
        $mpesa_transaction->MiddleName = $content->MiddleName;
        $mpesa_transaction->LastName = $content->LastName;
        $mpesa_transaction->save();

        // Responding to the confirmation request
        $response = new Response();
        $response->headers->set("Content-Type","text/xml; charset=utf-8");
        $response->setContent(json_encode(["C2BPaymentConfirmationResult"=>"Success"]));

        return $response;
    }

    public function mpesaRegisterUrls()
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl');
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization: Bearer '. $this->generateAccessToken()));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array(
            'ShortCode' => 600141,
            'ResponseType' => 'Completed',
            'ValidationURL' => "https://backend-ecommerce-api.herokuapp.com/api/v1/payment/transaction/validation",
            'ConfirmationURL' => "https://backend-ecommerce-api.herokuapp.com/api/v1/payment/transaction/confirmation"
        )));
        $curl_response = curl_exec($curl);
        echo $curl_response;
    }

    public function b2cMpesaPayment()
    {
        $mpesa= new Mpesa();

        $InitiatorName = "apitest361";
        $SecurityCredential = $this->securityCredential();
        $CommandID = "BusinessPayment";
        $Amount = 10;
        $PartyA = 601426;
        $PartyB = 254708374149;
        $Remarks = "please";
        $QueueTimeOutURL = "https://backend-ecommerce-api.herokuapp.com/api/v1/payment/transaction/timeout";
        $ResultURL = "https://backend-ecommerce-api.herokuapp.com/api/v1/payment/transaction/result";
        $Occasion = "work";

        $b2cTransaction=$mpesa->b2c($InitiatorName, $SecurityCredential, $CommandID, $Amount, $PartyA, $PartyB, $Remarks, $QueueTimeOutURL, $ResultURL, $Occasion);

        return $b2cTransaction;
    }

    public function c2bMpesaPayment()
    {
        $mpesa= new Mpesa();

        $ShortCode = 600141;
        $CommandID = "CustomerPayBillOnline";
        $Amount = 100;
        $Msisdn = 254708374149;
        $BillRefNumber = "account";

        $c2bTransaction = $mpesa->c2b($ShortCode, $CommandID, $Amount, $Msisdn, $BillRefNumber );

        return $c2bTransaction;
    }

    public function checkAccountBalance()
    {
        $mpesa= new Mpesa();

        $CommandID = "AccountBalance";
        $Initiator = "apitest";
        $SecurityCredential = $this->generateAccessToken();
        $PartyA = 600141;
        $IdentifierType = 4;
        $Remarks = "balance";
        $QueueTimeOutURL = "https://backend-ecommerce-api.herokuapp.com/api/v1/payment/transaction/timeout";
        $ResultURL = "https://backend-ecommerce-api.herokuapp.com/api/v1/payment/transaction/result";

        $balanceInquiry = $mpesa->accountBalance($CommandID, $Initiator, $SecurityCredential, $PartyA, $IdentifierType, $Remarks, $QueueTimeOutURL, $ResultURL);
    }

    public function checkTransactionStatus()
    {
        $mpesa= new Mpesa();

        $TransactionID = "ws_CO_280320201747287281";
        $CommandID = "TransactionStatusQuery";
        $Initiator = "apitest";
        $SecurityCredential = $this->generateAccessToken();
        $PartyA = 600141;
        $IdentifierType = 1;
        $Remarks = "status";
        $Occasion = "work";
        $QueueTimeOutURL = "https://backend-ecommerce-api.herokuapp.com/api/v1/payment/transaction/timeout";
        $ResultURL = "https://backend-ecommerce-api.herokuapp.com/api/v1/payment/transaction/result";

        $trasactionStatus=$mpesa->transactionStatus($Initiator, $SecurityCredential, $CommandID, $TransactionID, $PartyA, $IdentifierType, $ResultURL, $QueueTimeOutURL, $Remarks, $Occasion);
    }

    public function stkPushCallback(Request $request)
    {
        // return $request;
        Mail::send(new TestingMails($request));

        $callbackResponse=json_decode($this->processSTKCallback());

        // $callback = new TransactionCallbacks();
        // $get_data = $callback->processSTKPushRequestCallback();

        // Mail::send(new TestingMails($get_data));

        // $callbackResponse = json_decode($get_data);

        $stkPush = new StkPushPayment();
        $stkPush->resultDesc = $callbackResponse->resultDesc;
        $stkPush->resultCode = $callbackResponse->resultCode;
        $stkPush->merchantRequestID = $callbackResponse->merchantRequestID;
        $stkPush->checkoutRequestID = $callbackResponse->checkoutRequestID;
        $stkPush->amount = $callbackResponse->amount;
        $stkPush->mpesaReceiptNumber = $callbackResponse->mpesaReceiptNumber;
        $stkPush->transactionDate = $callbackResponse->transactionDate;
        $stkPush->phoneNumber = $callbackResponse->phoneNumber;

        $stkPush->save();
        Mail::send(new TestingMails($stkPush));

        return $stkPush;
    }

    public function timeoutUrl(Request $request)
    {
        return $request;
        //
    }

    public function resultURL(Request $request)
    {
        return $request;
        //
    }

    public function processSTKCallback()
    {
            $callbackJSONData=file_get_contents('php://input');
            $callbackData=json_decode($callbackJSONData);

            $resultCode=$callbackData->Body->stkCallback->ResultCode;
            $resultDesc=$callbackData->Body->stkCallback->ResultDesc;
            $merchantRequestID=$callbackData->Body->stkCallback->MerchantRequestID;
            $checkoutRequestID=$callbackData->Body->stkCallback->CheckoutRequestID;

            // $amount=$callbackData->stkCallback->Body->CallbackMetadata->Item[0]->Value;
            // $balance=$callbackData->stkCallback->Body->CallbackMetadata->Item[2]->Value;

            $amount=$callbackData->Body->stkCallback->CallbackMetadata->Item[0]->Value;
            $mpesaReceiptNumber=$callbackData->Body->stkCallback->CallbackMetadata->Item[1]->Value;
            // $balance=$callbackData->Body->stkCallback->CallbackMetadata->Item[2]->Value;
            // $b2CUtilityAccountAvailableFunds=$callbackData->Body->stkCallback->CallbackMetadata->Item[3]->Value;
            $transactionDate=$callbackData->Body->stkCallback->CallbackMetadata->Item[3]->Value;
            $phoneNumber=$callbackData->Body->stkCallback->CallbackMetadata->Item[4]->Value;

            $result=[
                "resultDesc"=>$resultDesc,
                "resultCode"=>$resultCode,
                "merchantRequestID"=>$merchantRequestID,
                "checkoutRequestID"=>$checkoutRequestID,
                "amount"=>$amount,
                "mpesaReceiptNumber"=>$mpesaReceiptNumber,
                "transactionDate"=>$transactionDate,
                "phoneNumber"=>$phoneNumber
            ];

            return json_encode($result);
    }

}
