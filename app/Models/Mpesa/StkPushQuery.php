<?php

namespace App\Models\Mpesa;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Safaricom\Mpesa\Mpesa;

class StkPushQuery extends MpesaConstants
{
    use SoftDeletes;

    protected $table = "mpesa_stkpush_queries";

    public function execute(Request $request)
    {

        $environment = "sandbox";
        $checkoutRequestID = "ws_CO_030420200147161473";
        $businessShortCode = 174379;
        $password = $this->lipaNaMpesaPassword();
        $timestamp = Carbon::rawParse('now')->format('YmdHms');

        $mpesa = new Mpesa();
        $query_response = $mpesa->STKPushQuery($environment,$checkoutRequestID,$businessShortCode,$password,$timestamp);

        $decoded_data = json_decode($query_response);
        $decoded_data->ResponseFrom = "stkpush_query";

        $store_response = new StkPushResponses();
        $store_data = $store_response->storeData($decoded_data);

        return $store_data;
    }

}
