<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $table = 'branches';

    protected $fillable = [
        'branch_name',
        'branch_address'
    ];

    /**
     * Connect with users table
     */
    public function users() {
        return $this->hasMany(User::class);
    }

    /**
     * Connect with branches table
     */
    public function branches() {
        return $this->hasMany(Branch::class);
    }
}
