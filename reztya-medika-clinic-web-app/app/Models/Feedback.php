<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;
    public $table = 'feedbacks';
    protected $primaryKey = 'feedback_id';
    protected $guarded = ['feedback_id'];

    public function order(){
        return $this->belongsTo(Order::class, 'order_id');
    }
}
