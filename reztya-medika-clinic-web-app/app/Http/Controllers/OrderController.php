<?php

namespace App\Http\Controllers;

use App\Mail\SendEmail;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Schedule;
use App\Models\PaymentReceipt;
use App\Models\DeliveryInfo;
use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function statusFilter($status)
    {
        if(Auth::user()->user_role_id == 1)
        {
            $orders = Order::where('status', $status)->get();
        }
        else
        {
            $orders = Order::where('user_id', Auth::user()->user_id)->where('status', $status)->get();
        }

        $printServiceOnce = false;
        $printProductOnce = false;

        if($status == "finished" || $status == "canceled")
        {
            return view('order_history')->with('orders', $orders)->with('printServiceOnce', $printServiceOnce)->with('printProductOnce',$printProductOnce);
        }
        return view('order_active')->with('orders', $orders)->with('printServiceOnce', $printServiceOnce)->with('printProductOnce',$printProductOnce);
    }

    public function create(Request $req)
    {
        // $order_duplicate = Order::with(['orderDetail' => function($query){
        //     $all_cart = Cart::where('user_id', Auth::user()->user_id)->whereNotNull('schedule_id')->get();

        //     $all_cart_arrays = $all_cart->map(function ($cart) {
        //         return collect($cart->toArray())
        //             ->only('schedule_id')
        //             ->all();
        //     })->unique();

        //     $query->whereIn('schedule_id', $all_cart_arrays);
        // }])->where('status', 'ongoing')->orWhere('status', 'waiting')->first();

        // if($order_duplicate)
        // {
        //     if(count($order_duplicate->orderDetail) != 0)
        //     {
        //         $invalid_schedule = Cart::where('user_id', Auth::user()->user_id)->whereNotNull('schedule_id', $order_duplicate->orderDetail()->first()->schedule_id)->toSql();
        //         dd($invalid_schedule);
        //         return redirect()->back()->withErrors(['schedule_invalid' => 'Pesanan tidak dapat dibuat karena jadwal perawatan ' . $invalid_schedule->service->name . ' sudah dipesan oleh member lain. Silahkan ubah jadwal perawatan tersebut.']);
        //     }
        // }
        
        $validated_delivery_service = $req->validate([
            'delivery_service' => 'required'
        ],[
            'delivery_service.required' => 'Tipe pengiriman wajib diisi'
        ]);

        if($validated_delivery_service['delivery_service'] == 1)
        {
            $validated_cost = $req->validate([
                'cost' => 'required'
            ],[
                'cost.required'=> 'Jasa pengiriman wajib diisi'
            ]);
            
            $json_decoded = json_decode($validated_cost['cost']);
            
            $order = Order::create([
                'user_id' => Auth::user()->user_id,
                'order_date' => Carbon::parse(Carbon::now())->format('Y-m-d'),
                'status' => 'ongoing'
            ]);

            $deliveryInfo = DeliveryInfo::create([
                'delivery_destination' => $req['origin'],
                'delivery_type' => $json_decoded->service,
                'estimated_days' => $json_decoded->cost[0]->etd,
                'weight' => $req['weight'],
                'delivery_fee' => $json_decoded->cost[0]->value * $req['weight'],
            ]);
            $order->delivery_info_id = $deliveryInfo->delivery_info_id;
            $order->save();
        }
        elseif($validated_delivery_service['delivery_service'] == 0)
        {
            $order = Order::create([
                'user_id' => Auth::user()->user_id,
                'order_date' => Carbon::parse(Carbon::now())->format('Y-m-d'),
                'status' => 'ongoing'
            ]);
        }

        $carts = Cart::where('user_id', Auth::user()->user_id)->get();
        
        foreach($carts as $cart)
        {
            if($cart->service_id)
            {
                if($cart->schedule_id || $cart->home_service)
                {
                    OrderDetail::create([
                        'order_id' => $order->order_id,
                        'service_id' => $cart->service_id,
                        'schedule_id' => $cart->schedule_id,
                        'home_service' => $cart->home_service
                    ]);

                    $schedule = Schedule::find($cart->schedule_id);
                    $schedule->status = 'unavailable';
                    $schedule->save();
                }
                else
                {
                    return redirect()->back()->with(['service_invalid' => 'Pesanan tidak dapat dibuat karena ada tempat dan jadwal perawatan yang belum lengkap. Silahkan lengkapi terlebih dahulu.']);
                }
            }    
            else
            {
                $product = Product::where('product_id', $cart->product_id)->first();

                if($product->stock == 0)
                {
                    Cart::where('user_id', Auth::user()->user_id)->where('product_id', $product->product_id)->delete();
                    return redirect('/cart')->with('error','Mohon maaf, produk ' . $product->name .' telah habis');
                }
                else
                {
                    if($cart->quantity > $product->stock)
                    {
                        $cart->quantity = $product->stock;
                        $product->stock = 0;
                    }
                    else if($cart->quantity == $product->stock)
                    {
                        $product->stock = 0;
                    }
                    else
                    {
                        $product->stock -= $cart->quantity;
                    }
                    $product->save();

                    OrderDetail::create([
                        'order_id' => $order->order_id,
                        'product_id' => $cart->product_id,
                        'quantity' => $cart->quantity
                    ]);
                }
            }
                
        }
        
        Cart::where('user_id', Auth::user()->user_id)->delete();
        return redirect()->route('detail_order', ['id' => $order->order_id])->with('success', 'Pesanan berhasil dibuat!');
    }

    public function createOrderWithoutProduct()
    {
        $carts = Cart::where('user_id', Auth::user()->user_id)->whereNotNull('schedule_id')->get();
        
        $carts_duplicate = $carts->groupBy('schedule_id')->map(function ($row) {
            return $row->count();
        });
        foreach($carts_duplicate as $cart)
        {
            if($cart > 1)
                return redirect()->back()->with(['service_invalid' => 'Tidak boleh ada jadwal perawatan yang duplikat. Silahkan ubah jadwal perawatan tersebut.']);
        }

        $orders = Order::create([
            'user_id' => Auth::user()->user_id,
            'order_date' => Carbon::parse(Carbon::now())->format('Y-m-d'),
            'status' => 'ongoing',
        ]);

        foreach($carts as $cart)
        {
            if($cart->service_id)
            {
                OrderDetail::create([
                    'order_id' => $orders->order_id,
                    'service_id' => $cart->service_id,
                    'schedule_id' => $cart->schedule_id
                ]);

                $schedule = Schedule::find($cart->schedule_id);
                $schedule->status = 'unavailable';
                $schedule->save();
            }
            else
            {
                OrderDetail::create([
                    'order_id' => $orders->order_id,
                    'product_id' => $cart->product_id,
                    'quantity' => $cart->quantity
                ]);
            }
        }

        Cart::where('user_id', Auth::user()->user_id)->delete();

        return redirect()->route('detail_order', ['id' => $orders->order_id])->with('success', 'Pesanan berhasil dibuat!');
    }

    public function activeOrder()
    {
        $orders = null;
        $totalPrice = 0;

        if(Auth::user()->user_role_id == 1)
        {
            $orders = Order::where('status', 'ongoing')->orWhere('status', 'waiting')->get();
        }
        else
        {
            $orders = Order::where('user_id', Auth::user()->user_id)->where(function ($query) {
                $query->where('status', 'waiting')->orWhere('status', 'ongoing');
            })->get();
        }

        return view('order_active')->with('orders', $orders)->with('totalPrice', $totalPrice);
    }

    public function cancelOrder($id)
    {
        $orders = Order::find($id);
        $orders->status = 'canceled';
        $orders->save();
        return redirect('/history-order');
    }

    public function historyOrder()
    {
        if(Auth::user()->user_role_id == 1)
        {
            $orders = Order::where('status','finished')->orWhere('status','canceled')->get();
        }
        else
        {
            $orders = Order::where('user_id', Auth::user()->user_id)->where('status','finished')->orWhere('status','canceled')->get();
        }
        $totalPrice = 0;

        return view('order_history')->with('orders', $orders)->with('totalPrice', $totalPrice);
    }

    public function repeatOrder($id)
    {
        $insufficientStockProduct = false;
        $serviceExist = false;
        $order_details = OrderDetail::where('order_id', $id)->get();

        foreach($order_details as $order_detail)
        {
            if($order_detail->service_id)
            {
                $carts = Cart::where('user_id', Auth::user()->user_id)->where('service_id', $order_detail->service_id)->get();
                $serviceExist = true;

                Cart::create([
                    'user_id' => Auth::user()->user_id,
                    'service_id' => $order_detail->service_id
                ]);
                // if($carts->isEmpty())
                // {
                //     Cart::create([
                //         'user_id' => Auth::user()->user_id,
                //         'service_id' => $order_detail->service_id
                //     ]);
                // }
                // else
                // {
                //     foreach($carts as $cart)
                //     {
                //         if($cart->schedule_id != $order_detail->schedule_id)
                //         {
                //             if($order_detail->schedule->status == 'available')
                //             {
                //                 $cart->schedule_id = $order_detail->schedule_id;
                //                 $cart->save();
                //             }
                //         }
                //     }
                // }
            }
            else
            {
                $carts = Cart::where('user_id', Auth::user()->user_id)->where('product_id', $order_detail->product_id)->get();
                $product = Product::find($order_detail->product_id);
                
                if(!$carts->isEmpty())
                {
                    foreach($carts as $cart)
                    {
                        $cart->quantity += $order_detail->quantity;
                        
                        if($cart->quantity >= $product->stock){
                            if($cart->quantity > $product->stock){
                                $insufficientStockProductId = true;
                                $cart->quantity = $product->stock;
                            }
                            // $product->stock = 0;
                        }
                        $cart->save();      
                    }
                }
                else
                {
                    if($order_detail->quantity >= $product->stock)
                    {
                        Cart::create([
                            'user_id' => Auth::user()->user_id,
                            'product_id' => $order_detail->product_id,
                            'quantity' => $product->stock
                        ]);
                        // $carts->quantity = $product->stock;
                    }
                    else
                    {
                        Cart::create([
                            'user_id' => Auth::user()->user_id,
                            'product_id' => $order_detail->product_id,
                            'quantity' => $order_detail->quantity
                        ]);
                    }
                }
            }
        }
        if($insufficientStockProduct){
            return redirect('/cart')->with('product_invalid', 'Berhasil ditambahkan ke keranjang. Mohon maaf, ada kuantitas produk yang tidak sesuai dengan permintaan karena stok terbatas.');
        }
        else if($serviceExist){
            return redirect('/cart')->with('service_invalid', 'Berhasil ditambahkan ke keranjang. Silahkan pilih tempat dan jadwal perawatan yang belum lengkap melalui tombol edit.');
        }
        return redirect('/cart')->with('success', 'Berhasil ditambahkan ke keranjang.');
    }
}
