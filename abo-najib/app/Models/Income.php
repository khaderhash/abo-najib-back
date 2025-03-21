<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Income extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_of_income', 'price', 'category', 'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class); // علاقة belongsTo لربط الدخل بالمستخدم
    }
}
