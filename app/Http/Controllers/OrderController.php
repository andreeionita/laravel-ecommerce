<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use App\Cart;
use App\Customer;
use App\Product;
use DB;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Session::has('cart') || empty(Session::get('cart')->getContents())){
            return redirect('products')->with('message' , 'No products in the cart');
        }
        $cart = Session::get('cart');
        return view('products.checkout' , compact('cart'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'billing_firstName'=> 'required',
            'billing_lastName'=> 'required',
            'billing_username'=> 'required',
            'billing_email'=> 'required',
            'billing_address1'=> 'required',
            'billing_address2'=> 'required',
            'billing_state'=> 'required',
            'billing_country'=> 'required',
            'billing_zip'=> 'required',
        ]);
       
        $cart = [];
        $order ='';
        $checkout='';
        if(Session::has('cart')){
            $cart = Session::get('cart');
        }
        if($request->shipping_address){
                 $customer = [
                    "billing_firstName" => $request->billing_firstName,
                    "billing_lastName" => $request->billing_lastName,
                    'username'=> $request->billing_username,
                    "email"=> $request->billing_email,
                    "billing_address1"=> $request->billing_address1,
                    "billing_address2" => $request->billing_address2,
                    "billing_country" => $request->billing_country,
                    "billing_state" => $request->billing_state,
                    "billing_zip" => $request->billing_zip,

                    "shipping_firstName" => $request->shipping_firstName,
                    "shipping_lastName" => $request->shippin_lastName,
                    "shipping_address1"=> $request->shipping_address1,
                    "shipping_address2" => $request->shipping_address2,
                    "shipping_country" => $request->shipping_country,
                    "shipping_state" => $request->shipping_state,
                    "shipping_zip" => $request->shipping_zip,
                ];
            }else{
                 $customer = [
                    "billing_firstName" => $request->billing_firstaName,
                    "billing_lastName" => $request->billing_lastName,
                    "username"=> $request->username,
                    "email"=> $request->email,
                    "billing_address1"=> $request->billing_address1,
                    "billing_address2" => $request->billing_address2,
                    "billing_country" => $request->billing_country,
                    "billing_state" => $request->billing_state,
                    "billing_zip" => $request->billing_zip,
                ];
            }
            
            DB::beginTransaction();
            $checkout = Customer::create($customer);
            foreach($cart->getContents() as $slug => $product){
            $products = [
                'user_id' => $checkout->id,
                'product_id' =>$product['product']->id,
                'qty'=>$product['qty'],
                'status'=>'Pending',
                'price'=>$product['price'],
                'payment_id'=>0,
            ];
            $order = Order::create($products);
            }

            // dd($checkout);
            if($checkout && $order){
                DB::commit();
                return view('products.payments');
            }
            else{
                DB::rollback();
                return redirect('checkout')->with('message','Invalid Activity!');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
