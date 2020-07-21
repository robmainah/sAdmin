<?php

namespace App\Http\Controllers\Mpesa;

use App\Http\Controllers\Controller;
use App\Mail\TestingMails;
use App\Models\Mpesa\StkPushPayment;
use App\Models\Mpesa\StkPushQuery;
use Illuminate\Http\Request;
use Mail;

class MpesaController extends Controller
{


    public function stkPush()
    {
        $stk_pay = new StkPushPayment();
        $payment = $stk_pay->createPayment();
    }

    public function stkPushCallback(Request $request)
    {
        Mail::send(new TestingMails($request));

        $callback = new StkPushPayment();
        $callback = $callback->callback();

        Mail::send(new TestingMails($callback));
    }

    public function stkPushQuery(Request $request)
    {
        $stk_query = new StkPushQuery();
        $stk_query = $stk_query->execute($request);
    }

}
