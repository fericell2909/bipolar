<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** @mixin \Eloquent */
class Wishlist extends Model
{
    protected $fillable = ['user_id', 'product_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mainPhoto() {

        $product = Photo::Where('product_id',$this->product_id)->orderBy('order','ASC')->first();
        
        return $product->url ?? '';

    }
}