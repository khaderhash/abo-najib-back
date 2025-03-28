<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

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
        return $this->hasMany(Expense::class, 'user_id');
    }

    public function goals()
    {
        return $this->hasMany(Goal::class, 'user_id');
    }

    public function incomes()
    {
        return $this->hasMany(Income::class, 'user_id');
    }

    public function reminders()
    {
        return $this->hasMany(Reminder::class, 'user_id');
    }

    /**
     * الحصول على المعرف الذي سيتم تخزينه في حقل الموضوع (subject claim) من JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * إرجاع مصفوفة من القيم لتخصيص JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
