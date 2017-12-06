<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Size
 *
 * @property int $id
 * @property string $name
 * @property string|null $slug
 * @property-read string $hash_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Stock[] $stocks
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Size findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Size whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Size whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Size whereSlug($value)
 */
	class Size extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Settings
 *
 * @property int $id
 * @property float $dolar_change
 * @property int $bipolar_counts
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings whereBipolarCounts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings whereDolarChange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings whereId($value)
 */
	class Settings extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Type
 *
 * @property int $id
 * @property string $name
 * @property string|null $slug
 * @property-read string $hash_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Subtype[] $subtypes
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Type findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Type whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Type whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Type whereSlug($value)
 */
	class Type extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Product
 *
 * @property int $id
 * @property int|null $state_id
 * @property string $name
 * @property string|null $slug
 * @property string|null $description
 * @property float $price
 * @property string|null $is_salient
 * @property string|null $is_home
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Color[] $colors
 * @property-read string $hash_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Photo[] $photos
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $recommendeds
 * @property-read \App\Models\State|null $state
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Stock[] $stocks
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Subtype[] $subtypes
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product findSimilarSlugs($attribute, $config, $slug)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereIsHome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereIsSalient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereStateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product withoutTrashed()
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Stock
 *
 * @property int $id
 * @property int $product_id
 * @property int|null $size_id
 * @property string $incoming_date
 * @property int $quantity
 * @property string|null $active
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read string $hash_id
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\Size|null $size
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stock whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stock whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stock whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stock whereIncomingDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stock whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stock whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stock whereSizeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stock whereUpdatedAt($value)
 */
	class Stock extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @method static User findOrFail($id, array $columns = ['*'])
 * @property int $id
 * @property string $email
 * @property string $name
 * @property string|null $lastname
 * @property string|null $photo
 * @property string $password
 * @property string|null $active
 * @property string|null $facebook_id
 * @property string|null $birthday_date
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereBirthdayDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereFacebookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereName($value)
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Photo
 *
 * @property int $id
 * @property int $product_id
 * @property string $url
 * @property string|null $relative_url
 * @property int $order
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read string $hash_id
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Photo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Photo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Photo whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Photo whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Photo whereRelativeUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Photo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Photo whereUrl($value)
 */
	class Photo extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\State
 *
 * @property int $id
 * @property string $name
 * @property-read string $hash_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\State whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\State whereName($value)
 */
	class State extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Color
 *
 * @property int $id
 * @property string $name
 * @property-read string $hash_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Color whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Color whereName($value)
 */
	class Color extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Subtype
 *
 * @property int $id
 * @property int $type_id
 * @property string $name
 * @property string|null $slug
 * @property-read string $hash_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read \App\Models\Type $type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subtype findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subtype whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subtype whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subtype whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subtype whereTypeId($value)
 */
	class Subtype extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Manager
 *
 * @property int $id
 * @property int|null $role_id
 * @property string $email
 * @property string $name
 * @property string $password
 * @property string|null $remember_token
 * @property-read \App\Models\Role|null $role
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Manager whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Manager whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Manager whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Manager wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Manager whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Manager whereRoleId($value)
 */
	class Manager extends \Eloquent {}
}

