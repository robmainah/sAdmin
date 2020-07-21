<?php

namespace App\Models\Customer;

use App\Models\Customer\Orders\Order;
use App\Models\Customer\Review;
use App\Notifications\Customer\ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Tymon\JWTAuth\Contracts\JWTSubject;

class Customer extends Authenticatable
// class Customer extends Authenticatable implements JWTSubject
{
    use Notifiable; use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'code', 'email', 'password', 'phoneNumber', 'idNumber', 'address', 'gender',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function comments()
    {
        return $this->hasMany(Review::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function scopeGenerateCustomerCode() {
        $code = mt_rand(100000, 999999);

        if (Customer::whereCode($code)->exists()) {
            return $this->generateCustomerCode();
        }

        return $code;
    }


    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    // protected function customerCodeExists($code) {
    //     return Customer::whereCode($code)->exists();
    // }

}
