<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

class ProfileController extends Controller
{
    public function resetPassword(Request $request) {
        $reset = $request->validate([
            'email' => 'required',
            'username' => 'required',
            'birthdate' => 'required',
            'password' => 'required',
            'confirm_password' => 'required'
        ]);

        $new_pass = Hash::make($reset['password']);
        $confirm_new_pass = Hash::make($reset['confirm_password']);

        if(!RateLimiter::tooManyAttempts('failed', 3)) {
            if (Hash::check($reset['password'], $confirm_new_pass) && Hash::check($reset['confirm_password'], $new_pass)) {
                $email = $request['email'];
                $username = $request['username'];
                $birthdate = $request['birthdate'];

                $user = DB::table('users')
                    ->where('email', $email)
                    ->where('username', $username)
                    ->where('birthdate', $birthdate)
                    ->first();

                if ($user) {
                    if (!Hash::check($reset['confirm_password'], $user->password)) {
                        DB::table('users')->where('email', $email)->update([
                            'password' => $confirm_new_pass
                        ]);
                        $request->session()->regenerate();

                        RateLimiter::resetAttempts('failed');
                        return redirect()->intended('/signin')->with('success', 'Kata sandi berhasil diubah! Harap masuk!');
                    }
                    RateLimiter::hit('failed', 300);
                    return back()->with('resetError', 'Kata sandi baru wajib berbeda dengan kata sandi lama!');
                }
                RateLimiter::hit('failed', 300);
                return redirect('/signup')->with('signupError', 'User tidak ditemukan! Harap daftar terlebih dahulu!');
            }
        } else {
            RateLimiter::hit('failed', 300);
            return back()->with('resetError', 'Terlalu banyak gagal memasukkan input! Harap tunggu '. round(RateLimiter::availableIn('failed') / 60) .' menit lagi untuk mencoba ulang!');
        }

        return back()->with('resetError', 'Kata sandi dan konfirmasi kata sandi wajib sama!');
    }

    public function changePassword(Request $request) {
        $password = $request->validate([
            'oldpass' => 'required',
            'newpass' => 'required',
            'confnewpass' => 'required'
        ]);

        $old_pass = Hash::make($password['oldpass']);
        $new_pass = Hash::make($password['newpass']);
        $confirm_new_pass = Hash::make($password['confnewpass']);

        if (Hash::check($request['confnewpass'], $new_pass) && Hash::check($request['newpass'], $confirm_new_pass)) {
            if (Hash::check($password['oldpass'], \auth()->user()->password)) {
                if (!Hash::check($password['newpass'], $old_pass)) {
                    $newPassword = $password['confnewpass'];
                    $newPassword = Hash::make($newPassword);
                    $email = \auth()->user()->email;
                    DB::table('users')->where('email', $email)->update([
                        'password' => $newPassword
                    ]);
                    $request->session()->regenerate();
                    return redirect()->intended('/home');
                }
                return back()->with('passwordChangeError', 'Kata sandi baru wajib berbeda dengan kata sandi lama!');
            }
            return back()->with('passwordChangeError', 'Kata sandi lama tidak sesuai!');
        }
        return back()->with('passwordChangeError', 'Kata sandi baru dan konfirmasi kata sandi baru wajib sama!');
    }

    public function viewProfile() {
        // Pemesanan Aktif
        $orders = null;
        $totalPrice = 0;
        $servicePrice = 0;
        $productPrice = 0;
        $totalItemProduct = 0;
        $totalItemService = 0;
        $schedules = Schedule::all();
        $printOnce = false;


        if(Auth::user()){
            if(Auth::user()->user_role_id == 1)
            {
                $orders = Order::where('status', 'ONGOING')->orWhere('status', 'WAITING')->get();
            }
            else
            {
                $orders = Order::where('user_id', Auth::user()->user_id)->where('status', 'WAITING')->orWhere('status', 'ONGOING')->get();
            }
        }

        $once = false;
        if(!$orders->isEmpty())
        {
            foreach($orders as $order)
            {
                if ($once == false) {
                    foreach($order->orderDetail as $order_detail)
                    {
                        if($order_detail->service_id) {
                            $totalPrice += $order_detail->service->price;
                            $servicePrice += $order_detail->service->price;
                            $totalItemService += 1;
                        }
                        else {
                            $totalPrice += $order_detail->product->price * $order_detail->quantity;
                            $productPrice += $order_detail->product->price * $order_detail->quantity;
                            $totalItemProduct += 1;
                        }
                    }
                    $once = true;
                }
            }
        }

        // Riwayat Pemesanan
        $order_history = null;
        $printServiceOnce = false;
        $printProductOnce = false;
        $serviceItemHistory = 0;
        $productItemHistory = 0;
        $totalPriceHistory = 0;
        $productPriceHistory = 0;
        $servicePriceHistory = 0;

        if(Auth::user()) {
            if (Auth::user()->user_role_id == 1) {
                $order_history = Order::where('status', 'FINISHED')->orWhere('status', 'CANCELED')->get();
            } else {
                $order_history = Order::where('user_id', Auth::user()->user_id)->where('status', 'FINISHED')->orWhere('status', 'CANCELED')->get();
            }
        }

        $once = false;
        if(!$order_history->isEmpty())
        {
            foreach($order_history as $order)
            {
                if ($once == false) {
                    foreach ($order->orderDetail as $order_detail) {
                        if ($order_detail->service_id) {
                            $totalPriceHistory += $order_detail->service->price;
                            $servicePriceHistory += $order_detail->service->price;
                            $serviceItemHistory += 1;
                        } else {
                            $totalPriceHistory += $order_detail->product->price * $order_detail->quantity;
                            $productPriceHistory += $order_detail->product->price * $order_detail->quantity;
                            $productItemHistory += 1;
                        }
                    }
                    $once = true;
                }
            }
        }


        return view('profile.view-profile')
            ->with(compact('printOnce'))
            ->with(compact('orders'))
            ->with(compact('totalPrice'))
            ->with(compact('servicePrice'))
            ->with(compact('productPrice'))
            ->with(compact('totalItemService'))
            ->with(compact('totalItemProduct'))
            ->with(compact('order_history'))
            ->with(compact('printServiceOnce'))
            ->with(compact('printProductOnce'))
            ->with(compact('totalPriceHistory'))
            ->with(compact('productPriceHistory'))
            ->with(compact('servicePriceHistory'))
            ->with(compact('productItemHistory'))
            ->with(compact('serviceItemHistory'));
    }

    public function editProfile(Request $request) {
        $validated = $request->validate([
            'photo' => 'required|image',
            'name' => 'required',
            'username' => 'required',
            'birthdate' => 'required|date|before:2010',
            'phone' => 'required|numeric',
            'address' => 'required|max:255',
            'email' => 'required|email:rfc,dns',
            'password' => 'required|current_password',
            'city_id' => 'required'
        ]);

        if ($validated) {
            $name = $request->name;
            $email = $request->email;
            $birthdate = $request->birthdate;
            $phone = strval($request->phone);
            $address = $request->address;
            $username = $request->username;
            $city = $request->city_id;

            $photo = $request->file('photo');
            $profilePicture = $photo->storeAs('profile-images', time().'.'.$photo->getClientOriginalExtension());

            $currentEmail = auth()->user()->email;

            DB::table('users')->where('email', $currentEmail)->update([
                'name' => $name,
                'email' => $email,
                'profile_picture' => $profilePicture,
                'birthdate' => $birthdate,
                'phone' => $phone,
                'address' => $address,
                'username' => $username,
                'city_id' => $city
            ]);
            return redirect()->intended('/view-profile/{username}');
        }
        return redirect()->back()->with('updateError', 'Ubah profil gagal!');
    }

    function viewEditProfile() {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/city",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: 460abd066bcb244bf02b1c284f49e55a"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return redirect()->back()->with('updateError', 'Terjadi masalah dengan perubahan. Harap coba ulang.');
        }

        $provinceOrigin = "Provinsi";
        $cityOrigin = "Kota / Kabupaten";
        $provinces = [];
        foreach (json_decode($response)->rajaongkir->results as $each) {
            if (!in_array($each->province_id, array_column($provinces, 'province_id'))) {
                array_push($provinces, array('province_id' => $each->province_id, 'province' => $each->province));
            }
            if ($each->city_id == \auth()->user()->city_id) {
                $cityOrigin = $each->city_name;
                $provinceOrigin = $each->province;
            }
        }
        sort($provinces);

        return view('profile.edit-profile')
            ->with(compact('provinces'))
            ->with(compact('response'))
            ->with(compact('cityOrigin'))
            ->with(compact('provinceOrigin'));
    }
}
