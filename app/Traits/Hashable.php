<?php

namespace App\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

trait Hashable
{
    /** @method static $this findOrFail($id, array $columns = []) */
    /** @method static $this findByHash($hashedId, array $columns = []) */

    /**
     * @param $hashedId
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Model|$this
     */
    public static function findByHash($hashedId, array $columns = ['*'])
    {
        return static::whereId(\Hashids::decode($hashedId))->first($columns);
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
            array_push($ids, Arr::first(\Hashids::decode($hashId)));
        }

        return static::whereIn($key, $ids)->get();
    }

    /**
     * @param $hashedId
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Model|$this
     */
    public static function findByHashTrashed($hashedId, array $columns = ['*'])
    {
        return static::whereId(\Hashids::decode($hashedId))->withTrashed()->firstOrFail($columns);
    }

    /**
     * @return string
     */
    public function getHashIdAttribute()
    {
        return \Hashids::encode($this->getKey());
    }
}
