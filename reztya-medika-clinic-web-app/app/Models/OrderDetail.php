<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_detail_id';
    protected $guarded = ['order_detail_id'];
    public function service(){
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function schedule(){
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }

    public function order(){
        return $this->belongsTo(Order::class, 'order_id');
    }
}
