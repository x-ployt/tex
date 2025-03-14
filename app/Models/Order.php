<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'order_no',
        'order_date',
        'order_status',
        'assigned_user_id',
        'branch_id',
        'customer_name',
        'customer_address',
        'customer_contact_number',
        'order_amount',
        'order_mop',
        'file_paths',
        'reason'
    ];

    protected $casts = [
        'file_paths' => 'array'
    ];

    /**
     * Connect with users table
     */
    public function assignedUser() {
        return $this->belongsTo(User::class, 'assigned_user_id', 'id'); 
    }

    /**
     * Connect with branches table
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    
    /**
     * Connect with order_history table
     */
    public function orderHistory() {
        return $this->hasMany(OrderHistory::class); 
    }
}
