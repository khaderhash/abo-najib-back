<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'password',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function expenses()
    {
        return $this->hasMany(Expense::class,'expense_id');
    }

    public function goals()
    {
        return $this->hasMany(Goal::class,'goal_id');
    }

    public function incomes()
    {
        return $this->hasMany(Income::class,'income_id');
    }

    public function reminders()
    {
        return $this->hasMany(Reminder::class,'reminder_id');
    }
}
