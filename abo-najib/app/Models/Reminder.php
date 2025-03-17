<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'price','collectedoprice','user_id','time',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
