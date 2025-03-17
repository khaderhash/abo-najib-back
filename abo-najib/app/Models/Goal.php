<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'time', 'price', 'category', 'user_id','Collectedmoney'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
