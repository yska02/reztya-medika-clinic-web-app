<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PaymentReceipt;
use Carbon\Carbon;
use App\Models\User;

class PaymentReceiptController extends Controller
{
    public function uploadTransferReceipt(Request $req, $id)
    {
        $validated_data = $req->validate([
            'account_number' => 'required|numeric',
            'account_name' => 'required',
            'image_path' => 'required|image'
        ],[
            'account_number.required' => 'Nomor akun bank wajib diisi',
            'account_number.numeric' => 'Nomor akun bank harus angka',
            'account_name.required' => 'Nama akun bank wajib diisi',
            'image_path.required' => 'Foto bukti transfer wajib diisi',
            'image_path.image' => 'Foto bukti transfer tidak valid',
        ]);

        $order = Order::where('order_id', $id)->first();
        $order->status = 'waiting';
        $order->save();

        $order_details = OrderDetail::where('order_id', $id)->get();

        $totalPrice = 0;
        foreach($order_details as $order_detail)
        {
            if($order_detail->service_id)
                $totalPrice += $order_detail->service->price;
            else
                $totalPrice += $order_detail->product->price * $order_detail->quantity;
        }
        $totalPrice += $order->delivery_fee;

        $payment_receipt = PaymentReceipt::create([
            'payment_date' => Carbon::now(),
            'payment_amount' => $totalPrice,
            'payment_method' => 'Transfer',
            'account_number' => $validated_data['account_number'],
            'account_name' => $validated_data['account_name'],
            'image_path' => $validated_data['image_path']
        ]);

        $order->payment_receipt_id = $payment_receipt->payment_receipt_id;
        $order->save();

        if($req->file('image_path'))
        {
            $validated_data['image_path'] = $req->file('image_path')->store('transfer_images');
        }

        return redirect('/active-order');
    }

    public function formPaymentReceipt($id)
    {
        $order = Order::find($id);
        $totalPrice = 0;
        $payment_receipt = null;

        if($order->payment_receipt_id)
        {
            $payment_receipt = PaymentReceipt::where('payment_receipt_id', $order->payment_receipt_id)->first();
        }

        foreach($order->orderDetail as $order_detail)
        {
            if($order_detail->service_id)
                $totalPrice += $order_detail->service->price;
            else
                $totalPrice += $order_detail->product->price * $order_detail->quantity;
        }
        $totalPrice += $order->delivery_fee;

        return view('payment_receipt_form')->with('order', $order)->with('totalPrice', $totalPrice)->with('payment_receipt', $payment_receipt);
    }

    public function addPaymentReceipt(Request $req, $id)
    {
        $order = Order::find($id);
        $totalPrice = 0;

        foreach($order->orderDetail as $order_detail)
        {
            if($order_detail->service_id)
                $totalPrice += $order_detail->service->price;
            else
                $totalPrice += $order_detail->product->price * $order_detail->quantity;
        }
        $totalPrice += $order->delivery_fee;

        $validated_data = $req->validate([
            'confirmed_by' => 'required',
            'password' => 'required'
        ],[
            'confirmed_by.required' => 'Username wajib diisi',
            'password.required' => 'Kata sandi wajib diisi'
        ]);

        $user = User::where('username', $validated_data['confirmed_by'])->first();

        if($user)
        {
            if(password_verify($validated_data['password'], $user->password))
            {
                if($order->status == 'ongoing')
                {
                    $payment_receipt = PaymentReceipt::create([
                        'confirmed_by' => $validated_data['confirmed_by'],
                        'payment_date' => Carbon::parse(Carbon::now())->format('Y-m-d'),
                        'payment_amount' => $totalPrice,
                        'payment_method' => 'Cash'
                    ]);
                    $order->payment_receipt_id = $payment_receipt->payment_receipt_id;
                    $order->save();   
                }
                else if($order->status == 'waiting'){
                    $payment_receipt = PaymentReceipt::where('payment_receipt_id', $order->payment_receipt_id)->first();
                    $payment_receipt->confirmed_by = $validated_data['confirmed_by'];
                    $payment_receipt->save();
                }
                $order->status = 'finished';
                $order->save();
                return redirect('/history-order');
            }
        }
        return redirect()->back()->withErrors(['invalid' => 'Informasi yang dimasukkan salah!']);
    }

    public function upsertPaymentReceipt(Request $req, $id)
    {
        $order = Order::find($id);
        $totalPrice = 0;

        foreach($order->orderDetail as $order_detail)
        {
            if($order_detail->service_id)
                $totalPrice += $order_detail->service->price;
            else
                $totalPrice += $order_detail->product->price * $order_detail->quantity;
        }
        $totalPrice += $order->delivery_fee;

        $validated_data = $req->validate([
            'confirmed_by' => 'required',
            'password' => 'required'
        ],[
            'confirmed_by.required' => 'Username wajib diisi',
            'password.required' => 'Kata sandi wajib diisi'
        ]);

        $user = User::where('username', $validated_data['confirmed_by'])->first();

        if($user)
        {
            if(password_verify($validated_data['password'], $user->password))
            {
                if($order->status == 'ongoing')
                {
                    $payment_receipt = PaymentReceipt::create([
                        'confirmed_by' => $validated_data['confirmed_by'],
                        'payment_date' => Carbon::parse(Carbon::now())->format('Y-m-d'),
                        'payment_amount' => $totalPrice,
                        'payment_method' => 'Cash'
                    ]);
                    $order->payment_receipt_id = $payment_receipt->payment_receipt_id;
                    $order->save();   
                }
                else if($order->status == 'waiting'){
                    $payment_receipt = PaymentReceipt::where('payment_receipt_id', $order->payment_receipt_id)->first();
                    $payment_receipt->confirmed_by = $validated_data['confirmed_by'];
                    $payment_receipt->save();
                }
                $order->status = 'finished';
                $order->save();
                return redirect('/history-order');
            }
        }
        return redirect()->back()->withErrors(['invalid' => 'Informasi yang dimasukkan salah!']);
    }
}
