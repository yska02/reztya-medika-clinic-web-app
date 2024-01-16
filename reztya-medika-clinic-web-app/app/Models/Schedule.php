<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Schedule extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'schedule_id';
    protected $guarded = ['schedule_id'];

    public function orderDetail(){
        return $this->hasMany(OrderDetail::class, 'schedule_id');
    }

    public function cart(){
        return $this->hasMany(Cart::class, 'schedule_id');
    }
}
