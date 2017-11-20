<?php

namespace App\Traits;

use Illuminate\Support\Collection;

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
     * @param array $hashedIds
     * @param string $key
     * @return \Illuminate\Support\Collection
     */
    public static function findByManyHash(array $hashedIds, $key = 'id') : Collection
    {
        $ids = [];
        foreach($hashedIds as $hashId) {
            array_push($ids, array_first(\Hashids::decode($hashId)));
        }

        return static::whereIn($key, $ids)->get();
    }

    /**
     * @return string
     */
    public function getHashIdAttribute()
    {
        return \Hashids::encode($this->getKey());
    }
}