<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\District;

/** @mixin \Eloquent */
class ShippingDistrict extends Model
{
    public $timestamps = false;
    protected $table = 'shippings_districts';
    
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id','id');
    }

}
