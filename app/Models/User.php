<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @method static User findOrFail($id, array $columns = ['*'])
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'lastname', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

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
}
