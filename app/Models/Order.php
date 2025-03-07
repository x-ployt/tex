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
        'order_status',
        'assigned_user_id',
        'branch_id',
        'customer_name',
        'customer_address',
        'customer_contact_number',
        'file_paths',
        'reason'
    ];

    protected $casts = [
        'file_paths' => 'array'
    ];

    /**
     * Connect with user table
     */
    public function assignedUser() {
        return $this->belongsTo(User::class, 'assigned_user_id', 'id'); 
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    
    public function orderHistory() {
        return $this->hasMany(OrderHistory::class); 
    }
}
