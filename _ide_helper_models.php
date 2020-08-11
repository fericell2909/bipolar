<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Wishlist
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wishlist newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wishlist newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wishlist query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wishlist whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wishlist whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wishlist whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wishlist whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wishlist whereUserId($value)
 */
	class Wishlist extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Category
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $hash_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Post[] $posts
 * @property-read int|null $posts_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereUpdatedAt($value)
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Buy
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $user_id
 * @property int|null $coupon_id
 * @property int|null $shipping_id
 * @property int $billing_address_id
 * @property int $shipping_address_id
 * @property int|null $buy_number
 * @property float|null $discount_coupon
 * @property float $subtotal
 * @property float|null $shipping_fee
 * @property float $total
 * @property string $currency
 * @property string|null $payed
 * @property int $showroom
 * @property string|null $bsale_document_url
 * @property mixed|null $metadata
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Address $billing_address
 * @property-read \App\Models\Coupon|null $coupon
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BuyDetail[] $details
 * @property-read int|null $details_count
 * @property-read mixed $discount_coupon_currency
 * @property-read string $hash_id
 * @property-read mixed $shipping_fee_currency
 * @property-read string $status
 * @property-read mixed $subtotal_currency
 * @property-read mixed $total_currency
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Payment[] $payments
 * @property-read int|null $payments_count
 * @property-read \App\Models\Shipping|null $shipping
 * @property-read \App\Models\Address $shipping_address
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\ModelStatus\Status[] $statuses
 * @property-read int|null $statuses_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Buy currentStatus($names)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Buy newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Buy newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Buy orCurrentStatus($names)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Buy otherCurrentStatus($names)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Buy query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Buy whereBillingAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Buy whereBsaleDocumentUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Buy whereBuyNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Buy whereCouponId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Buy whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Buy whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Buy whereDiscountCoupon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Buy whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Buy whereMetadata($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Buy wherePayed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Buy whereShippingAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Buy whereShippingFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Buy whereShippingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Buy whereShowroom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Buy whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Buy whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Buy whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Buy whereUserId($value)
 */
	class Buy extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PostType
 *
 * @mixin \Eloquent
 * @property int $id
 * @property array $name
 * @property string|null $slug
 * @property-read string $hash_id
 * @property-read array $translations
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\HomePost[] $home_posts
 * @property-read int|null $home_posts_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostType findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostType query()
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
 * @mixin \Eloquent
 * @property int $id
 * @property int $cart_id
 * @property int $product_id
 * @property int|null $stock_id
 * @property int $quantity
 * @property int|null $order
 * @property float $total
 * @property float $total_dolar
 * @property-read \App\Models\Cart $cart
 * @property-read string $hash_id
 * @property-read mixed $total_currency
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\Stock|null $stock
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartDetail whereCartId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartDetail whereOrder($value)
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
 * @mixin \Eloquent
 * @property int $id
 * @property int $buy_id
 * @property int $product_id
 * @property int|null $stock_id
 * @property int $quantity
 * @property float $total
 * @property-read \App\Models\Buy $buy
 * @property-read mixed $total_currency
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\Stock|null $stock
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyDetail whereBuyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyDetail whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyDetail whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyDetail whereStockId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyDetail whereTotal($value)
 */
	class BuyDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Size
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property string|null $slug
 * @property-read string $hash_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Stock[] $stocks
 * @property-read int|null $stocks_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Size findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Size newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Size newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Size query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Size whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Size whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Size whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Size whereUuid($value)
 */
	class Size extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\HomePost
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int|null $post_type_id
 * @property int|null $state_id
 * @property string $name
 * @property string|null $slug
 * @property string|null $redirection_link
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $begin_date
 * @property \Illuminate\Support\Carbon|null $end_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $hash_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Photo[] $photos
 * @property-read int|null $photos_count
 * @property-read \App\Models\PostType|null $post_type
 * @property-read \App\Models\State|null $state
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HomePost findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HomePost newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HomePost newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HomePost query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HomePost whereBeginDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HomePost whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HomePost whereEndDate($value)
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
 * App\Models\DiscountTask
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property int|null $discount_pen
 * @property int|null $discount_usd
 * @property \Illuminate\Support\Carbon $begin
 * @property \Illuminate\Support\Carbon $end
 * @property array|null $products
 * @property array|null $product_subtypes
 * @property array|null $product_types
 * @property int $is_2x1
 * @property int $available
 * @property int $executed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read string $hash_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DiscountTask newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DiscountTask newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DiscountTask query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DiscountTask whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DiscountTask whereBegin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DiscountTask whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DiscountTask whereDiscountPen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DiscountTask whereDiscountUsd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DiscountTask whereEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DiscountTask whereExecuted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DiscountTask whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DiscountTask whereIs2x1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DiscountTask whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DiscountTask whereProductSubtypes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DiscountTask whereProductTypes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DiscountTask whereProducts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DiscountTask whereUpdatedAt($value)
 */
	class DiscountTask extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Settings
 *
 * @mixin \Eloquent
 * @property int $id
 * @property float $dolar_change
 * @property int $free_shipping
 * @property int $deal_2x1
 * @property int $bipolar_counts
 * @property int $facebook_counts
 * @property int $instagram_counts
 * @property int $current_buy
 * @property string|null $background_suscribe
 * @property string|null $background_counter
 * @property array|null $open_hours
 * @property-read array $translations
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings whereBackgroundCounter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings whereBackgroundSuscribe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings whereBipolarCounts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings whereCurrentBuy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings whereDeal2x1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings whereDolarChange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings whereFacebookCounts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings whereFreeShipping($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings whereInstagramCounts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings whereOpenHours($value)
 */
	class Settings extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Type
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $uuid
 * @property array $name
 * @property string|null $slug
 * @property int $order
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read string $hash_id
 * @property-read array $translations
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Subtype[] $subtypes
 * @property-read int|null $subtypes_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Type findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Type newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Type newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Type query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Type whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Type whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Type whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Type whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Type whereUuid($value)
 */
	class Type extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Cart
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int|null $user_id
 * @property string|null $session_id
 * @property int|null $coupon_id
 * @property float|null $discount_coupon_pen
 * @property float|null $discount_coupon_usd
 * @property float $subtotal
 * @property float $subtotal_dolar
 * @property float $total
 * @property float $total_dolar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Coupon|null $coupon
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CartDetail[] $details
 * @property-read int|null $details_count
 * @property-read mixed $subtotal_currency
 * @property-read mixed $total_currency
 * @property-read mixed $total_discount_coupon
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereCouponId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereDiscountCouponPen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereDiscountCouponUsd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereSubtotalDolar($value)
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
 * @mixin \Eloquent
 * @property int $id
 * @property mixed $uuid
 * @property int|null $state_id
 * @property int|null $label_id
 * @property int $fit_size_id
 * @property int $fit_width_id
 * @property array $name
 * @property string|null $slug
 * @property array|null $description
 * @property int|null $discount_pen
 * @property int|null $discount_usd
 * @property \Illuminate\Support\Carbon|null $begin_discount
 * @property \Illuminate\Support\Carbon|null $end_discount
 * @property \Illuminate\Support\Carbon|null $publish_date
 * @property float $price
 * @property float|null $price_pen_discount
 * @property float $price_dolar
 * @property float|null $price_usd_discount
 * @property float|null $weight
 * @property float $instep_level_very_high
 * @property float $instep_level_high
 * @property float $instep_level_normal
 * @property float $instep_level_low
 * @property float $instep_level_very_low
 * @property float $width_level_very_high
 * @property float $width_level_high
 * @property float $width_level_normal
 * @property float $width_level_low
 * @property float $width_level_very_low
 * @property int $order
 * @property int $free_shipping
 * @property int $is_showroom_sale
 * @property int $is_deal_2x1
 * @property string|null $is_salient
 * @property int $is_soldout
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Color[] $colors
 * @property-read int|null $colors_count
 * @property-read \App\Models\FitSize $fit_size
 * @property-read \App\Models\FitWidth $fit_width
 * @property-read mixed $discount_amount
 * @property-read string $hash_id
 * @property-read mixed $price_currency
 * @property-read mixed $price_discount_currency
 * @property-read array $translations
 * @property-read \App\Models\Label|null $label
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Photo[] $photos
 * @property-read int|null $photos_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $recommendations
 * @property-read int|null $recommendations_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $recommended_by
 * @property-read int|null $recommended_by_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Size[] $sizes_active
 * @property-read int|null $sizes_active_count
 * @property-read \App\Models\State|null $state
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Stock[] $stocks
 * @property-read int|null $stocks_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Subtype[] $subtypes
 * @property-read int|null $subtypes_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereBeginDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereDiscountPen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereDiscountUsd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereEndDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereFitSizeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereFitWidthId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereFreeShipping($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereInstepLevelHigh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereInstepLevelLow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereInstepLevelNormal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereInstepLevelVeryHigh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereInstepLevelVeryLow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereIsDeal2x1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereIsSalient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereIsShowroomSale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereIsSoldout($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereLabelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product wherePriceDolar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product wherePricePenDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product wherePriceUsdDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product wherePublishDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereStateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereWidthLevelHigh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereWidthLevelLow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereWidthLevelNormal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereWidthLevelVeryHigh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereWidthLevelVeryLow($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product withoutTrashed()
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Post
 *
 * @mixin \Eloquent
 * @property int $id
 * @property array $title
 * @property array|null $content
 * @property string|null $slug
 * @property string|null $main_photo
 * @property string|null $main_video
 * @property int|null $state_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Category[] $categories
 * @property-read int|null $categories_count
 * @property-read string $hash_id
 * @property-read string $status
 * @property-read array $translations
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Photo[] $photos
 * @property-read int|null $photos_count
 * @property-read \App\Models\State|null $state
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\ModelStatus\Status[] $statuses
 * @property-read int|null $statuses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post currentStatus($names)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post otherCurrentStatus($names)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereMainPhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereMainVideo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereStateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereUpdatedAt($value)
 */
	class Post extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Banner
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $state_id
 * @property int $order
 * @property string|null $link
 * @property array|null $text
 * @property string|null $url
 * @property string|null $relative_url
 * @property float $padding_bottom_mobile
 * @property float $padding_bottom_tablet
 * @property float $padding_bottom_desktop
 * @property string|null $font
 * @property string $color
 * @property string|null $background_color
 * @property float $font_size_mobile
 * @property float $font_size_tablet
 * @property float $font_size_desktop
 * @property float $line_height_mobile
 * @property float $line_height_tablet
 * @property float $line_height_desktop
 * @property float $letter_spacing_mobile
 * @property float $letter_spacing_tablet
 * @property float $letter_spacing_desktop
 * @property \Illuminate\Support\Carbon $begin_date
 * @property \Illuminate\Support\Carbon $end_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $hash_id
 * @property-read array $translations
 * @property-read \App\Models\State $state
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner fromColorType()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereBackgroundColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereBeginDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereFont($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereFontSizeDesktop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereFontSizeMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereFontSizeTablet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereLetterSpacingDesktop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereLetterSpacingMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereLetterSpacingTablet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereLineHeightDesktop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereLineHeightMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereLineHeightTablet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner wherePaddingBottomDesktop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner wherePaddingBottomMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner wherePaddingBottomTablet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereRelativeUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereStateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereUrl($value)
 */
	class Banner extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Shipping
 *
 * @mixin \Eloquent
 * @property int $id
 * @property array $title
 * @property int $allow_showroom
 * @property int $is_dni_required
 * @property int $active
 * @property float|null $g200
 * @property float|null $g200_dolar
 * @property float|null $g500
 * @property float|null $g500_dolar
 * @property float|null $kg1
 * @property float|null $kg1_dolar
 * @property float|null $kg2
 * @property float|null $kg2_dolar
 * @property float|null $kg3
 * @property float|null $kg3_dolar
 * @property float|null $kg4
 * @property float|null $kg4_dolar
 * @property float|null $kg5
 * @property float|null $kg5_dolar
 * @property float|null $kg6
 * @property float|null $kg6_dolar
 * @property float|null $kg7
 * @property float|null $kg7_dolar
 * @property float|null $kg8
 * @property float|null $kg8_dolar
 * @property float|null $kg9
 * @property float|null $kg9_dolar
 * @property float|null $kg10
 * @property float|null $kg10_dolar
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Buy[] $buys
 * @property-read int|null $buys_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Country[] $excluded_countries
 * @property-read int|null $excluded_countries_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CountryState[] $excluded_states
 * @property-read int|null $excluded_states_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ShippingExclude[] $excludes
 * @property-read int|null $excludes_count
 * @property-read array $translations
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Country[] $included_countries
 * @property-read int|null $included_countries_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CountryState[] $included_states
 * @property-read int|null $included_states_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ShippingInclude[] $includes
 * @property-read int|null $includes_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shipping newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shipping newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shipping query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shipping whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shipping whereAllowShowroom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shipping whereG200($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shipping whereG200Dolar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shipping whereG500($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shipping whereG500Dolar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shipping whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shipping whereIsDniRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shipping whereKg1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shipping whereKg10($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shipping whereKg10Dolar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shipping whereKg1Dolar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shipping whereKg2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shipping whereKg2Dolar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shipping whereKg3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shipping whereKg3Dolar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shipping whereKg4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shipping whereKg4Dolar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shipping whereKg5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shipping whereKg5Dolar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shipping whereKg6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shipping whereKg6Dolar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shipping whereKg7($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shipping whereKg7Dolar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shipping whereKg8($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shipping whereKg8Dolar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shipping whereKg9($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shipping whereKg9Dolar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shipping whereTitle($value)
 */
	class Shipping extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Country
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $sortname
 * @property string $name
 * @property int $phonecode
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CountryState[] $states
 * @property-read int|null $states_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country query()
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
 * @mixin \Eloquent
 * @property int $id
 * @property int $user_id
 * @property int $address_type_id
 * @property int $country_state_id
 * @property string $name
 * @property string $lastname
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property string|null $zip
 * @property int $main
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\AddressType $address_type
 * @property-read \App\Models\CountryState $country_state
 * @property-read string $hash_id
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Address onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereAddressTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereCountryStateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereMain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereZip($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Address withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Address withoutTrashed()
 */
	class Address extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Label
 *
 * @property int $id
 * @property array $name
 * @property string $color_text
 * @property string $color
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read string $hash_id
 * @property-read array $translations
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Label findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Label newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Label newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Label query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Label whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Label whereColorText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Label whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Label whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Label whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Label whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Label whereUpdatedAt($value)
 */
	class Label extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Stock
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $product_id
 * @property int|null $size_id
 * @property int|null $bsale_stock_id
 * @property array|null $bsale_stock_ids
 * @property string $incoming_date
 * @property int $quantity
 * @property string|null $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BuyDetail[] $buy_details
 * @property-read int|null $buy_details_count
 * @property-read string $hash_id
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\Size|null $size
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stock newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stock newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stock query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stock whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stock whereBsaleStockId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stock whereBsaleStockIds($value)
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
 * App\Models\Tag
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property-read string $hash_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Post[] $posts
 * @property-read int|null $posts_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereSlug($value)
 */
	class Tag extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $email
 * @property string $name
 * @property string|null $lastname
 * @property string|null $dni
 * @property int|null $foot_instep
 * @property int|null $foot_width
 * @property float|null $common_size
 * @property string $password
 * @property string|null $active
 * @property string|null $facebook_id
 * @property string|null $payme_wallet_token
 * @property string|null $birthday_date
 * @property string|null $language
 * @property int $has_showroom_sale
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Buy[] $buys
 * @property-read int|null $buys_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Cart[] $carts
 * @property-read int|null $carts_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Wishlist[] $wishlists
 * @property-read int|null $wishlists_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereBirthdayDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCommonSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereDni($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereFacebookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereFootInstep($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereFootWidth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereHasShowroomSale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePaymeWalletToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Role
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereName($value)
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ShippingInclude
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $shipping_id
 * @property int|null $country_id
 * @property int|null $country_state_id
 * @property int $all_countries
 * @property-read \App\Models\Country|null $country
 * @property-read \App\Models\CountryState|null $country_state
 * @property-read \App\Models\Shipping $shipping
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShippingInclude newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShippingInclude newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShippingInclude query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShippingInclude whereAllCountries($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShippingInclude whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShippingInclude whereCountryStateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShippingInclude whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShippingInclude whereShippingId($value)
 */
	class ShippingInclude extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FitSize
 *
 * @property int $id
 * @property string $uuid
 * @property array $name
 * @property float $value
 * @property-read array $translations
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FitSize newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FitSize newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FitSize query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FitSize whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FitSize whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FitSize whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FitSize whereValue($value)
 */
	class FitSize extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Payment
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $buy_id
 * @property string|null $auth_result
 * @property string|null $auth_result_text
 * @property string|null $auth_code
 * @property string|null $error_code
 * @property string|null $card_brand
 * @property string|null $reference
 * @property string|null $verification
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Buy $buy
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereAuthCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereAuthResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereAuthResultText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereBuyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereCardBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereErrorCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereVerification($value)
 */
	class Payment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CountryState
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property int $country_id
 * @property-read \App\Models\Country $country
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CountryState newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CountryState newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CountryState query()
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
 * @mixin \Eloquent
 * @property int $id
 * @property int|null $product_id
 * @property int|null $post_id
 * @property int|null $home_post_id
 * @property string $url
 * @property string|null $relative_url
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $hash_id
 * @property-read \App\Models\HomePost|null $home_post
 * @property-read \App\Models\Post|null $post
 * @property-read \App\Models\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Photo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Photo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Photo query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Photo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Photo whereHomePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Photo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Photo whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Photo wherePostId($value)
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
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $color
 * @property-read string $hash_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\State newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\State newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\State query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\State whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\State whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\State whereName($value)
 */
	class State extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FitWidth
 *
 * @property int $id
 * @property string $uuid
 * @property array $name
 * @property-read array $translations
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FitWidth newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FitWidth newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FitWidth query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FitWidth whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FitWidth whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FitWidth whereUuid($value)
 */
	class FitWidth extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Color
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $uuid
 * @property array $name
 * @property-read string $hash_id
 * @property-read array $translations
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Color newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Color newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Color query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Color whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Color whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Color whereUuid($value)
 */
	class Color extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ShippingExclude
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $shipping_id
 * @property int|null $country_id
 * @property int|null $country_state_id
 * @property-read \App\Models\Country|null $country
 * @property-read \App\Models\CountryState|null $country_state
 * @property-read \App\Models\Shipping $shipping
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShippingExclude newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShippingExclude newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShippingExclude query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShippingExclude whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShippingExclude whereCountryStateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShippingExclude whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShippingExclude whereShippingId($value)
 */
	class ShippingExclude extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Subtype
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $uuid
 * @property int $type_id
 * @property array $name
 * @property string|null $slug
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read string $hash_id
 * @property-read array $translations
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @property-read \App\Models\Type $type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subtype findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subtype newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subtype newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subtype query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subtype whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subtype whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subtype whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subtype whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subtype whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subtype whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subtype whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subtype whereUuid($value)
 */
	class Subtype extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Manager
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int|null $role_id
 * @property string $email
 * @property string $name
 * @property string $password
 * @property string|null $remember_token
 * @property-read \App\Models\Role|null $role
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Manager newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Manager newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Manager query()
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
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Address[] $addresses
 * @property-read int|null $addresses_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AddressType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AddressType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AddressType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AddressType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AddressType whereName($value)
 */
	class AddressType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Page
 *
 * @property int $id
 * @property string $slug
 * @property array $title
 * @property array $body
 * @property string|null $main_image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read array $translations
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereMainImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereUpdatedAt($value)
 */
	class Page extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CouponType
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Coupon[] $coupons
 * @property-read int|null $coupons_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponType whereName($value)
 */
	class CouponType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Coupon
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $type_id
 * @property string $code
 * @property float $amount_pen
 * @property float $amount_usd
 * @property int $frequency
 * @property float $minimum_pen
 * @property float $minimum_usd
 * @property \Illuminate\Support\Carbon $begin
 * @property \Illuminate\Support\Carbon $end
 * @property array|null $products
 * @property array|null $product_subtypes
 * @property array|null $product_types
 * @property int $discounted_products
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Buy[] $buys
 * @property-read int|null $buys_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Cart[] $carts
 * @property-read int|null $carts_count
 * @property-read mixed $discount_format
 * @property-read \App\Models\CouponType $type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon whereAmountPen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon whereAmountUsd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon whereBegin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon whereDiscountedProducts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon whereEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon whereFrequency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon whereMinimumPen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon whereMinimumUsd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon whereProductSubtypes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon whereProductTypes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon whereProducts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon whereUpdatedAt($value)
 */
	class Coupon extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Image
 *
 * @property int $id
 * @property string|null $background_suscribe
 * @property string|null $background_counter
 * @property \Illuminate\Support\Carbon $start_time
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereBackgroundCounter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereBackgroundSuscribe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereUpdatedAt($value)
 */
	class Image extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Historic
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $photo
 * @property string $photo_relative
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read string $hash_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Historic newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Historic newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Historic onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Historic query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Historic whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Historic whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Historic whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Historic whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Historic whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Historic wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Historic wherePhotoRelative($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Historic whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Historic withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Historic withoutTrashed()
 */
	class Historic extends \Eloquent {}
}

