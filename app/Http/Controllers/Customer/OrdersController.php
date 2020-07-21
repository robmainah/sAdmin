<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Customer\OrderResource;
use App\Models\Customer\Orders\CreateOrder;
use App\Models\Customer\Orders\Order;
use App\Models\Customer\Orders\OrderProduct;
use DB;
use Symfony\Component\HttpFoundation\Response;

class OrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $order = Order::where(['customer_id' => auth()->id(), 'status' => 'pending'])
                ->latest()->with('orderProduct:id,order_id,price,quantity')->get();

        return OrderResource::collection($order);
    }

    public function previousOrders()
    {
        $order = Order::where([
                ['customer_id', auth()->id()],
                ['status', '<>', 'pending']
                ])->latest('updated_at')->with('orderProduct:id,order_id,price,quantity')->get();

        return OrderResource::collection($order);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $checkout = new CreateOrder();
        $create_checkout = $checkout->createCheckout($request);

        return $create_checkout;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return $order;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        return $order;
    }

    public function cancel(Request $request, Order $order)
    {
        $this->authorize('owner', $order);

        $order->update(['status' => 'cancelled']);

        return $order;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $this->authorize('owner', $order);

        $order->update(['status' => 'cancelled']);

        $order->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
