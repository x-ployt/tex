<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    use HasFactory;

    protected $table = 'order_history';

    protected $fillable = [
        'order_id',
        'order_status',
        'delivery_remarks'
    ];

    /**
     * Connect with orders table
     */

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
