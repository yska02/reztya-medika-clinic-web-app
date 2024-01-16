<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $weight = 0;
        $cart = null;

        if (Auth::user()->user_role_id != 1) {
            $schedules = Schedule::all();
            $printServiceOnce = false;
            $printProductOnce = false;
            $totalPrice = 0;
            $costs = 0;
            $origin = null;
            $productExists = false;
            $serviceIncomplete = false;
            $homeService = false;

            if(Auth::user()->user_role_id == 2){
                $cart = Cart::where('user_id', Auth::user()->user_id)->get();
                $homeService = $cart->where('home_service', 1)->first() != null ? true : false;
            }

            if(!$cart->isEmpty())
            {
                foreach ($cart as $item) {
                    if ($item->product_id) {
                        if (preg_match('/[A-Za-z]/', $item->product->size) && preg_match('/[0-9]/', $item->product->size)) {
                            if ($item->product->size == trim($item->product->size) && str_contains($item->product->size, ' ')) {
                                $size_str = explode(' ', $item->product->size);
                                $size_int = (int)$size_str[0];
                                $weight += $size_int * $item->quantity;
                                $productExists = true;
                            }
                        } else {
                            $weight += 10 * $item->quantity; // 10 grams
                        }
                    }
                    else
                    {
                        if(!$item->schedule_id || !$item->home_service)
                        {
                            $serviceIncomplete = true;
                        }
                    }
                }
            }

            if (!$cart->isEmpty() && $productExists == true) {
                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                        CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS => "origin=166&destination=".Auth::user()->city_id."&weight=".$weight."&courier=jne",
                        CURLOPT_HTTPHEADER => array(
                            "content-type: application/x-www-form-urlencoded",
                            "key: 460abd066bcb244bf02b1c284f49e55a"
                        ),
                    ));

                    $response = curl_exec($curl);
                    $err = curl_error($curl);

                    curl_close($curl);

                    $costs = json_decode($response)->rajaongkir->results[0]->costs;

                    $origin[0] = json_decode($response)->rajaongkir->destination_details->province;
                    if (json_decode($response)->rajaongkir->destination_details->type == 'Kota') {
                        $origin[1] = "Kota ".json_decode($response)->rajaongkir->destination_details->city_name;
                    } else if (json_decode($response)->rajaongkir->destination_details->type == 'Kabupaten') {
                        $origin[1] = "Kab. ".json_decode($response)->rajaongkir->destination_details->city_name;
                    } else {
                        $origin[1] = str(json_decode($response)->rajaongkir->destination_details->city_name);
                    }

                    if ($err) {
                        return redirect('/home')->with('signupError', 'Terjadi masalah dengan pendaftaran. Harap coba ulang.');
                    }
            }

            if($serviceIncomplete)
            {
                return view('view_cart')
                    ->with('cart', $cart)
                    ->with('schedules', $schedules)
                    ->with('weight',$weight)
                    ->with('printServiceOnce', $printServiceOnce)
                    ->with('printProductOnce',$printProductOnce)
                    ->with('totalPrice', $totalPrice)
                    ->with(compact('costs'))
                    ->with(compact('origin'))
                    ->with('homeService', $homeService)
                    ->with('error', 'Ada tempat dan jadwal perawatan yang masih kosong. Silahkan lengkapi melalui tombol edit.');
            }

            return view('view_cart')
                ->with('cart', $cart)
                ->with('schedules', $schedules)
                ->with('weight',$weight)
                ->with('printServiceOnce', $printServiceOnce)
                ->with('printProductOnce',$printProductOnce)
                ->with('totalPrice', $totalPrice)
                ->with(compact('costs'))
                ->with(compact('origin'))
                ->with('homeService', $homeService);
        }
        return view('view_cart')->with('cart', $cart)->with('weight',$weight);
    }

    public function updateCartSchedule(Request $req, $id)
    {
        $validated_data = $req->validate([
            'schedule_id' => 'required',
            'home_service' => 'required'
        ]);

        if($req['old_schedule_id'])
        {
            if($req['schedule_id'] != $req['old_schedule_id'])
            {
                $old_schedule = Schedule::find($req['old_schedule_id']);
                $old_schedule->status = 'available';
                $old_schedule->save();

                $new_schedule = Schedule::find($req['schedule_id']);
                $new_schedule->status = 'unavailable';
                $new_schedule->save();
            }
        }

        $validated_data['cart_id'] = $id;

        Cart::find($id)->update($validated_data);

        return redirect('/cart');
    }

    public function updateCartQuantity(Request $req, $id)
    {
        $cart = Cart::find($id);
        $product = Product::find($cart->product_id);
        $stock = $product->stock;

        $validated_data = $req->validate([
            'quantity' => "required|integer|min:1|max:$stock"
        ],[
            'quantity.required' => 'Jumlah produk wajib diisi',
            'quantity.min' => 'Jumlah produk minimal 1',
            'quantity.max' => "Jumlah produk maksimal $stock",
        ]);

        Cart::find($id)->update($validated_data);
        return redirect('/cart')->withErrors('');
    }

    public function removeCart($id)
    {
        $cart = Cart::find($id);

        Cart::find($id)->delete();

        return redirect('/cart')->with('success','Pesanan telah dihapus!');
    }

    public function buyProduct(Request $request)
    {
        $userId = Auth::user()->user_id;
        $product = Product::find($request['product_id']);
        $stock = $product->stock;
        $validatedData = $request->validate(
            [
                'product_id' => 'required',
                'quantity' => "required|integer|min:1|max:$stock"
            ],
            [
                'product_id.required' => 'Produk wajib diisi',
                'quantity.required' => 'Jumlah produk wajib diisi',
                'quantity.min' => 'Jumlah produk minimal 1',
                'quantity.max' => "Jumlah produk maksimal $stock",
            ]
        );
        $validatedData['user_id'] = $userId;
        $currentOrder = DB::table('carts')
        ->where('product_id', '=', $validatedData['product_id'])
        ->first();
        if($currentOrder){
            $newQuantity = $currentOrder->quantity + $validatedData['quantity'];
            DB::update('update carts set quantity = ? where product_id = ?',[$newQuantity, $validatedData['product_id']]);
        }else{
            Cart::create($validatedData);
        }

        return redirect('/cart')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function bookService(Request $request)
    {
        $userId = Auth::user()->user_id;
        $validatedData = $request->validate(
            [
                'service_id' => 'required',
                'schedule_id' => 'required',
                'home_service' => 'required'
            ],
            [
                'service_id.required' => 'Perawatan wajib diisi',
                'schedule_id.required' => 'Jadwal perawatan wajib diisi',
                'home_service.required' => 'Tempat perawatan wajib diisi'
            ]
        );
        $validatedData['user_id'] = $userId;
        Cart::create($validatedData);
        return redirect('/cart')->with('success', 'Perawatan berhasil ditambahkan ke keranjang!');
    }
}
