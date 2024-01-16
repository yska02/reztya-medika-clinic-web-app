<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    protected $primaryKey = 'product_id';
    protected $guarded = ['product_id'];
    
    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function orderDetail(){
        return $this->hasMany(OrderDetail::class, 'product_id');
    }

    public function cart(){
        return $this->hasMany(Cart::class, 'product_id');
    }
}
