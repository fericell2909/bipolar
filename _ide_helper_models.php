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
 * App\Models\Buy
 *
 * @property int $id
 * @property int $user_id
 * @property int $billing_address_id
 * @property int $shipping_address_id
 * @property float $subtotal
 * @property float $total
 * @property float $total_dolar
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\Address $billing_address
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BuyDetail[] $details
 * @property-read mixed $total_currency
 * @property-read mixed $total_session
 * @property-read \App\Models\Address $shipping_address
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Buy whereBillingAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Buy whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Buy whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Buy whereShippingAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Buy whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Buy whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Buy whereTotalDolar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Buy whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Buy whereUserId($value)
 */
	class Buy extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PostType
 *
 * @property int $id
 * @property string $name
 * @property string|null $slug
 * @property-read string $hash_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\HomePost[] $home_posts
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostType findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostType whereSlug($value)
 */
	class PostType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CartDetail
 *
 * @property int $id
 * @property int $cart_id
 * @property int $product_id
 * @property int|null $stock_id
 * @property int $quantity
 * @property float $total
 * @property float $total_dolar
 * @property-read \App\Models\Cart $cart
 * @property-read string $hash_id
 * @property-read mixed $total_currency
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\Stock|null $stock
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartDetail whereCartId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartDetail whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartDetail whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartDetail whereStockId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartDetail whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartDetail whereTotalDolar($value)
 */
	class CartDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BuyDetail
 *
 * @property int $id
 * @property int $buy_id
 * @property int $product_id
 * @property int|null $stock_id
 * @property int $quantity
 * @property float $total
 * @property float $total_dolar
 * @property-read \App\Models\Buy $buy
 * @property-read mixed $total_currency
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\Stock|null $stock
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyDetail whereBuyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyDetail whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyDetail whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyDetail whereStockId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyDetail whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyDetail whereTotalDolar($value)
 */
	class BuyDetail extends \Eloquent {}
}

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
 * App\Models\HomePost
 *
 * @property int $id
 * @property int $post_type_id
 * @property int|null $state_id
 * @property string $name
 * @property string|null $slug
 * @property string|null $redirection_link
 * @property int $order
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read string $hash_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Photo[] $photos
 * @property-read \App\Models\PostType $post_type
 * @property-read \App\Models\State|null $state
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HomePost findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HomePost whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HomePost whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HomePost whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HomePost whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HomePost wherePostTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HomePost whereRedirectionLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HomePost whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HomePost whereStateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HomePost whereUpdatedAt($value)
 */
	class HomePost extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Settings
 *
 * @property int $id
 * @property float $dolar_change
 * @property int $free_shipping
 * @property int $bipolar_counts
 * @property int $current_buy
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings whereBipolarCounts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings whereCurrentBuy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings whereDolarChange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings whereFreeShipping($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings whereId($value)
 */
	class Settings extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Type
 *
 * @property int $id
 * @property array $name
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
 * App\Models\Cart
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $session_id
 * @property float $subtotal
 * @property float $total
 * @property float $total_dolar
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CartDetail[] $details
 * @property-read mixed $total_currency
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereTotalDolar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereUserId($value)
 */
	class Cart extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Product
 *
 * @property int $id
 * @property int|null $state_id
 * @property array $name
 * @property string|null $slug
 * @property array $description
 * @property float $price
 * @property float $price_dolar
 * @property float|null $weight
 * @property int $order
 * @property int $free_shipping
 * @property string|null $is_salient
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Color[] $colors
 * @property-read string $hash_id
 * @property-read mixed $price_currency
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereFreeShipping($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereIsSalient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product wherePriceDolar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereStateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereWeight($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product withoutTrashed()
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Banner
 *
 * @property int $id
 * @property int $state_id
 * @property int $order
 * @property string $url
 * @property string|null $relative_url
 * @property \Carbon\Carbon $begin_date
 * @property \Carbon\Carbon $end_date
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\State $state
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereBeginDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereRelativeUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereStateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereUrl($value)
 */
	class Banner extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Country
 *
 * @property int $id
 * @property string $sortname
 * @property string $name
 * @property int $phonecode
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CountryState[] $states
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country wherePhonecode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereSortname($value)
 */
	class Country extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Address
 *
 * @property int $id
 * @property int $user_id
 * @property int $address_type_id
 * @property int $country_state_id
 * @property string $name
 * @property string $lastname
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property string $zip
 * @property int $main
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\AddressType $address_type
 * @property-read \App\Models\CountryState $country_state
 * @property-read string $hash_id
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereAddressTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereCountryStateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereMain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereZip($value)
 */
	class Address extends \Eloquent {}
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Buy[] $buys
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Cart[] $carts
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
 * App\Models\CountryState
 *
 * @property int $id
 * @property string $name
 * @property int $country_id
 * @property-read \App\Models\CountryState $country
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CountryState whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CountryState whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CountryState whereName($value)
 */
	class CountryState extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Photo
 *
 * @property int $id
 * @property int|null $product_id
 * @property int|null $home_post_id
 * @property string $url
 * @property string|null $relative_url
 * @property int $order
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read string $hash_id
 * @property-read \App\Models\HomePost|null $home_post
 * @property-read \App\Models\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Photo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Photo whereHomePostId($value)
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
 * @property string $color
 * @property-read string $hash_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\State whereColor($value)
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
 * @property array $name
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
 * @property array $name
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

namespace App\Models{
/**
 * App\Models\AddressType
 *
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AddressType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AddressType whereName($value)
 */
	class AddressType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Historic
 *
 * @property int $id
 * @property string $name
 * @property string $photo
 * @property int $order
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Historic whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Historic whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Historic whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Historic whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Historic wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Historic whereUpdatedAt($value)
 */
	class Historic extends \Eloquent {}
}

