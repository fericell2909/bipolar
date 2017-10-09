<?php

namespace App\Traits;

trait Hashable
{
    /**
     * @param $hashedId
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Model|$this
     */
    public static function findByHash($hashedId, array $columns = ['*'])
    {
        return static::whereId(\Hashids::decode($hashedId))->firstOrFail($columns);
    }

    /**
     * @return string
     */
    public function getHashIdAttribute()
    {
        return \Hashids::encode($this->getKey());
    }
}