<?php

namespace App\Models;

use App\Traits\Hashable;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use Hashable;

    protected $table = 'states';
    public $timestamps = false;

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
