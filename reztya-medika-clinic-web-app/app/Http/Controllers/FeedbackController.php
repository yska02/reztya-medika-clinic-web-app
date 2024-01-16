<?php

namespace App\Http\Controllers;

use App\Mail\NotifySuggestionsAndCritics;
use App\Mail\SendEmail;
use App\Models\Feedback;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class FeedbackController extends Controller
{
    public function addClinicFeedback(Request $request) {
        $review = $request->validate([
            'review' => 'required|min:10',
            'order_id' => 'required',
            'order_date' => 'required|date'
        ],
        [
            'review.required' => 'Kritik dan Saran tidak boleh kosong.',
            'review.min' => 'Kritik dan Saran harus lebih dari 10 karakter.'
        ]);

        $order_id = $request->order_id;

        $exists = DB::table('feedbacks')->where('order_id', 'LIKE', $order_id)->get();
        if ($exists->isEmpty()){
            $feedback = Feedback::create([
                'order_id' => $order_id,
                'feedback_body' => $review['review']
            ]);

            $order = Order::find($order_id);
            $order->feedback_id = $feedback->feedback_id;
            $order->save();

            if(Auth::user()->user_role_id == 2){
                $emailAddress = 'klinikreztya@gmail.com';
                $content = [
                    'review' => $review['review'],
                    'username' => Auth::user()->username,
                    'name' => Auth::user()->name,
                    'order_id' => $review['order_id'],
                    'order_date' => $review['order_date']
                ];
                Mail::to($emailAddress)->send(new NotifySuggestionsAndCritics($content));
            }

            return back()->with('success', 'Kritik dan Saran berhasil dikirim!');
        }

        return back()->with('success', 'Sudah pernah mengirim Kritik dan Saran!');
    }
}
