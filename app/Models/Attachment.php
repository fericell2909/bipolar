<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attachment extends Model
{
	use SoftDeletes;

	/**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'attachments';
    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function getUrlAttribute($value)
    {
        return env('DO_URL').$this->folder_path.$this->name;
    }
}