<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_of_expense', 'price', 'category','user_id',
    ];
    public function user()
    {

        return $this->belongsTo(User::class);
    }}
