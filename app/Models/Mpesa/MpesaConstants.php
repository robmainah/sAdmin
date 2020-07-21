<?php

namespace App\Models\Mpesa;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class MpesaConstants extends Model
{
    protected $consumer_key;
    protected $consumer_secret;
    protected $pass_key;

    public function __construct()
    {
        $this->consumer_key = "GvKYsYcww7GBbD4FXwCulefamij08pPb";
        $this->consumer_secret = "7B8kIAz6YQbkxTGC";
        $this->pass_key = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
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
}
