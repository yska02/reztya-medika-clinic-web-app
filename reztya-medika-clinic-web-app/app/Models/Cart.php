<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $primaryKey = 'cart_id';
    protected $guarded = ['cart_id'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function service(){
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function schedule(){
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }
}
