<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'service_id';
    protected $guarded = ['service_id'];
    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function schedule(){
        return $this->hasMany(Schedule::class, 'schedule_id');
    }

    public function orderDetail(){
        return $this->hasMany(OrderDetail::class, 'service_id');
    }

    public function cart(){
        return $this->hasMany(Cart::class, 'service_id');
    }
}
