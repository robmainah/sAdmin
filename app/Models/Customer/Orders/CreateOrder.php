<?php

namespace App\Models\Customer\Orders;

// use App\Models\Customer\Orders\Order;
// use App\Models\Customer\Orders\OrderProduct;
// use App\Models\Customer\Orders\OrderTrack;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateOrder extends Model
{
    public function createCheckout(Request $request)
    {
        $cart_products = collect($request);
        $productsId = $this->filterProductIds($cart_products);

        $product = new Product();
        $getProductsData = $product->select('id', 'title', 'quantity', 'price')->whereIn('id', $productsId)->get();

        $sortProducts = $this->sortAllProducts($cart_products, $getProductsData);

        $calculate_qty = $this->calculateQuantities($sortProducts[0],$sortProducts[1]);

        $hasExcessStock = $calculate_qty[0];
        $hasLessStock = $calculate_qty[1];
        $newProductQtys = $calculate_qty[2];

        if (count($hasLessStock) > 0) {
            return response()->json([
                'errors' => [
                    'fewStock' => $hasLessStock
                ]
            ], 422);
        }

        if (count($hasExcessStock) > 0) {
            $this->completeCheckout($hasExcessStock, $cart_products, $newProductQtys);

            return response(null, Response::HTTP_CREATED);
            // return response()->json(['success' => 'success'], 201);
        }
    }

    protected function filterProductIds($cart_products)
    {
        $productsId = $cart_products->map(function ($item, $key) {
            return $item['product_id'];
        });

        return $productsId;
    }

    protected function sortAllProducts($cart_products, $getProductsData)
    {
        $cart_products = $cart_products->sortBy('product_id')->values();
        $getProductsData = $getProductsData->sortBy('id')->values();

        return array($cart_products, $getProductsData);
    }

    protected function calculateQuantities($cart_products,$getProductsData)
    {
        $hasExcessStock = [];
        $hasLessStock = [];
        $newProductQtys = [];

        foreach ($getProductsData as $key => $product) {
            $qtyDiff = $product->quantity - $cart_products[$key]['qty'];

            if ($qtyDiff >= 0) {
                $hasExcessStock[] = $product;
                $newProductQtys[] = ["id" => $product->id, "newQuantity" => $qtyDiff];
            } else {
                $hasLessStock[] = ["id" => $product->id, 'title' => $product->title, 'excess_qty' => abs($qtyDiff)];
            }
        }

        // $result = [$hasExcessStock,$hasLessStock,$newProductQtys];

        return array($hasExcessStock,$hasLessStock,$newProductQtys);
    }

    protected function saveOrder()
    {
        $order = new Order();
        $order->code = Order::generateOrderCode();
        $order->customer_id = auth()->user()->id;
        $order->comment = null;
        $order->is_active = true;
        $order->status = 'pending';
        $order->shippingDate = null;
        $order->shippingAddress = null;
        $order->save();

        return $order;
    }

    protected function saveOrderTrack($order)
    {
        $orderTrack = new OrderAnalytic();
        $orderTrack->description = 'created';
        $orderTrack->order_id = $order->id;
        $orderTrack->orderable_type = 'customer';
        $orderTrack->orderable_id = auth()->user()->id;
        $orderTrack->save();

        return $orderTrack;
    }

    public function saveOrderProduct($hasExcessStock, $cart_products, $order)
    {
        foreach ($hasExcessStock as $key => $db_prod) {
            foreach ($cart_products as $cart) {
                if ($db_prod->id == $cart['product_id']) {
                    $orderProduct = new OrderProduct();
                    $orderProduct->order_Id = $order->id;
                    $orderProduct->product_Id = $db_prod->id;
                    $orderProduct->lineItemsNo = $key + 1;
                    $orderProduct->price = $db_prod->price;
                    $orderProduct->quantity = $cart['qty'];
                    $orderProduct->status = "pending";
                    $orderProduct->save();
                }
            }
        }
    }

    protected function completeCheckout($hasExcessStock, $cart_products, $newProductQtys)
    {
        $order = $this->saveOrder();

        $this->saveOrderTrack($order);

        $this->saveOrderProduct($hasExcessStock, $cart_products, $order);

        foreach ($newProductQtys as $key => $product) {
            Product::where('id', $product['id'])->update(['quantity' => $product['newQuantity']]);
        }
    }
}
