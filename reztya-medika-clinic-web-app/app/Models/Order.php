<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_id';
    protected $guarded = ['order_id'];

    public function orderDetail(){
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function cancel(){
        return $this->hasOne(OrderCancel::class, 'cancel_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function paymentReceipt(){
        return $this->belongsTo(PaymentReceipt::class, 'payment_receipt_id');
    }

    public function feedback(){
        return $this->hasOne(Feedback::class, 'feedback_id');
    }

    public function deliveryInfo(){
        return $this->belongsTo(DeliveryInfo::class, 'delivery_info_id');
    }
}
