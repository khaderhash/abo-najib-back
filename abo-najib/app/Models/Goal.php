<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{

    use HasFactory;
    protected $fillable = [
        'goal_name', 'amount', 'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }}
