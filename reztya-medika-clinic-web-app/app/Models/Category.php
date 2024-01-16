<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'category_id';
    protected $guarded = ['category_id'];

    public function service(){
        return $this->hasMany(Service::class);
    }
    public function product(){
        return $this->hasMany(Product::class);
    }
}
