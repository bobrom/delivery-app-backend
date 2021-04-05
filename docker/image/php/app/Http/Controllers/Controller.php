<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Product;
use App\Order;
use App\Mail\OrderCreated;
use Illuminate\Support\Facades\Mail;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function addToCart(Request $request, $id, $num)
    {
        $i = 0;
        while($i < $num) {
            $request->user()->cart_products .= ','.$id;
            $i++;
        }
        $request->user()->update();
        return response()->json($request->user());
    }

    public function removeFromCart(Request $request, $id)
    {
        $ids = preg_split("/[\s,]+/", $request->user()->cart_products);
        foreach($ids as $key => $item){
            if ($item == $id){
                unset($ids[$key]);
            }
        }
        $request->user()->cart_products = implode(",", $ids);
        $request->user()->update();
        return response()->json($request->user());
    }

    public function getCartProducts(Request $request)
    {
        $ids = preg_split("/[\s,]+/", $request->user()->cart_products);
        $products = Product::find($ids);
        foreach ($products as $product) {
            $product->amount = 0;
            foreach ($ids as $id) {
                if($product->id == $id) $product->amount++;
            }
        }
        return response()->json($products);
    }

    public function getOrder(Request $request, $id)
    {
        $order = Order::find(['id' => $id])->first();
        $ids = preg_split("/[\s,]+/", $order->product_ids);
        $products = Product::find($ids);
        foreach ($products as $product) {
            $product->amount = 0;
            foreach ($ids as $id) {
                if($product->id == $id) $product->amount++;
            }
        }
        $order->products = $products;
        return response()->json($order);
    }

    public function createOrder(Request $request) {
        $order = new Order;
        $products_ids = false;
        foreach ($request->products as $product) {
            if (!$products_ids) {
                $products_ids = $product;
            } else {
                $products_ids .= ','.$product;
            }
        }
        $order->product_ids = $products_ids;
        $order->user_id = $request->user()->id;
        $order->address= $request->address;
        $order->status = 1;
        $order->save();
        $request->user()->cart_products = '';
        $request->user()->update();
        return response()->json(config('mail.to'));
        Mail::to(config('mail.to'))->send(new OrderCreated($order));
        return response()->json($order);
    }
}
