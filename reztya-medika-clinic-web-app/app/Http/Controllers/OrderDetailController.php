<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;

class OrderDetailController extends Controller
{
    public function detailOrder($id)
    {
        $order = null;
        $schedules = Schedule::where('start_time', '>', Carbon::now())->get();
        $printServiceOnce = false;
        $printProductOnce = false;
        $totalPrice = 0;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=166&destination=".Auth::user()->city_id."&weight=1000&courier=jne",
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

        // Validation if need delivery option change based on if there are no home_service
        $isHomeService = false;
        $allOrderDetail = OrderDetail::where('order_id', $id)->where('home_service','=','1')->get();

        $orderDetailFilter = DB::table('order_details')->whereNotNull('order_details.schedule_id')
                                ->join('schedules','schedules.schedule_id','=','order_details.schedule_id')
                                ->orderBy('start_time')->first();

        if($orderDetailFilter)
        {
            if($orderDetailFilter->home_service == 1)
            {
                $isHomeService = true;
            }
            else
                $isHomeService = false;
        }

        $order = Order::find($id);

        $isProductExist = DB::table('order_details')->whereNotNull('product_id')->first() ? true : false;

        $feedback = null;
        if ($order->status == 'finished') {
            $feedback = DB::table('feedbacks')->where('order_id', 'LIKE', $id)->get();
        }

        $noSchedule = false;
        $scheduleSearch = DB::table('schedules')->where('status','LIKE', 'available')->get();
        if ($scheduleSearch->isEmpty()) {
            $noSchedule = true;
        }

        return view('order_detail')
            ->with('order', $order)
            ->with('schedules', $schedules)
            ->with('printServiceOnce', $printServiceOnce)
            ->with('printProductOnce',$printProductOnce)
            ->with('totalPrice', $totalPrice)
            ->with(compact('costs'))
            ->with(compact('origin'))
            ->with(compact('feedback'))
            ->with('isHomeService', $isHomeService)
            ->with('isProductExist', $isProductExist)
            ->with(compact('noSchedule'));
    }

    public function reschedule(Request $req, $id)
    {
        $validated_data = $req->validate([
            'schedule_id' => 'required',
            'home_service' => 'required'
        ]);

        if($req['schedule_id'] != $req['old_schedule_id'])
        {
            $old_schedule = Schedule::find($req['old_schedule_id']);
            $old_schedule->status = 'available';
            $old_schedule->save();

            $new_schedule = Schedule::find($req['schedule_id']);
            $new_schedule->status = 'unavailable';
            $new_schedule->save();
        }

        $validated_data['order_detail_id'] = $id;

        $newSchedule = Schedule::find($validated_data['schedule_id']);
        $content = [
            'title' => 'Informasi Perubahan Jadwal Perawatan di Klinik Reztya Medika',
            'username' => $req['username'],
            'name' => $req['name'],
            'old_schedule' => Carbon::parse($req['old_schedule'])->translatedFormat('l, d F Y, H:i'),
            'old_schedule_id' => $req['old_schedule_id'],
            'order_id' => $req['order_id'],
            'service_name' => $req['service_name'],
            'new_schedule' => Carbon::parse($newSchedule->start_time)->translatedFormat('l, d F Y, H:i')
        ];

        OrderDetail::find($id)->update($validated_data);
        $order_detail = OrderDetail::find($id);

        if(OrderDetail::where('schedule_id', $validated_data['schedule_id'])->count() == 0){
            return redirect()
            ->route('detail_order', ['id' => $order_detail->order_id])
            ->with('error', 'Jadwal ulang gagal karena terdapat perawatan di keranjang yang mempunyai jadwal yang sama');
        }

        if(Auth::user()->user_role_id == 2){
            $emailAddress = "klinikreztya@gmail.com";
            Mail::to($emailAddress)->send(new SendEmail($content));
        }else{
            $emailAddress = $req['email'];
            Mail::to($emailAddress)->send(new SendEmail($content));
        }

        return redirect()
        ->route('detail_order', ['id' => $order_detail->order_id])
        ->with('success', 'Jadwal ulang perawatan berhasil');
    }
}
