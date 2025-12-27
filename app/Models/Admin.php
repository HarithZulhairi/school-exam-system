<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Model
{
    use HasFactory;

    // 1. Define the custom primary key
    protected $primaryKey = 'admin_id';

    // 2. Define fillable fields
    protected $fillable = [
        'user_id',
        'admin_phone_number',
        'admin_position',
        'admin_age',
    ];

    // 3. Relationships

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
