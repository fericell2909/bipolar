<?php

namespace App\Models;

use App\Traits\Hashable;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use Hashable;

    protected $table = 'photos';

    public function home_post()
    {
        return $this->belongsTo(HomePost::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
