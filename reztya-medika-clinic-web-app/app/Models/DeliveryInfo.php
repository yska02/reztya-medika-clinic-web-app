<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryInfo extends Model
{
    use HasFactory;

    protected $primaryKey = 'delivery_info_id';
    protected $guarded = ['delivery_info_id'];

    public function order(){
        return $this->hasOne(Order::class, 'delivery_info_id');
    }
}
