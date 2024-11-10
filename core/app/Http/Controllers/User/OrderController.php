<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Session;
use App\{Models\courier_data,
    Models\courier_payment_data,
    Models\Order,
    Models\TrackOrder,
    Http\Controllers\Controller
};

use Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    /**
     * Constructor Method.
     *
     * Setting Authentication
     *
     */

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('localize');

    }

    public function index()
    {
        $orders = Order::whereUserId(Auth::user()->id)->latest('id')->get();
        $courier_info = courier_data::first();
//        return json_decode($orders[0]['cart']);
        return view('user.order.index', compact('orders', 'courier_info'));
    }


    public function details($id)
    {
        $user = Auth::user();
        $order = Order::findOrfail($id);
        $cart = json_decode($order->cart, true);
        return view('user.order.invoice', compact('user', 'order', 'cart'));
    }

    public function printOrder($id)
    {
        $user = Auth::user();
        $order = Order::findOrfail($id);
        $cart = json_decode($order->cart, true);
        return view('user.order.print', compact('user', 'order', 'cart'));
    }

    public function order_courier_update(Request $request)
    {
        
        $ext_courier = courier_payment_data::where('order_id', $request->order_id)->first();

        if ($ext_courier) {
            $ext_courier->order_id = $request->order_id;
            $ext_courier->trx_id = $request->trx_id;
            $ext_courier->save();
        } else {
            $order_courier_update = new courier_payment_data();
            $order_courier_update->order_id = $request->order_id;
            $order_courier_update->trx_id = $request->trx_id;
            $order_courier_update->save();
        }


        Session::flash('success', __('Order Courier update successfully'));
        return back();
    }
}
