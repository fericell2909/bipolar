<?php

namespace App\Models;

use App\Notifications\PasswordReset;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/** @mixin \Eloquent */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'lastname', 'email', 'password', 'language'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function buys()
    {
        return $this->hasMany(Buy::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function getActiveLabelAdmin()
    {
        if ($this->active) {
            return "<span class='badge badge-danger'>Inactivo</span>";
        }

        return "<span class='badge badge-success'>Activo</span>";
    }

    public function getBirthdayOrNull($format = 'Y-m-d')
    {
        if ($this->birthday_date) {
            return Carbon::createFromFormat('Y-m-d', $this->birthday_date)->format($format);
        }

        return null;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordReset($token));
    }
}
