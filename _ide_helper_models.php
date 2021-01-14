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
 * @method static \Illuminate\Database\Eloquent\Builder|Address newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Address newQuery()
 * @method static \Illuminate\Database\Query\Builder|Address onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Address query()
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereAddressTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCountryStateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereMain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereZip($value)
 * @method static \Illuminate\Database\Query\Builder|Address withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Address withoutTrashed()
 */
	class Address extends \Eloquent {}
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
 * @method static \Illuminate\Database\Eloquent\Builder|AddressType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AddressType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AddressType query()
 * @method static \Illuminate\Database\Eloquent\Builder|AddressType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AddressType whereName($value)
 */
	class AddressType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Attachment
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $alt
 * @property string|null $name_original
 * @property string|null $s3_url
 * @property string|null $folder_path
 * @property string|null $mime_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read mixed $url
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment newQuery()
 * @method static \Illuminate\Database\Query\Builder|Attachment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereAlt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereFolderPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereNameOriginal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereS3Url($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Attachment withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Attachment withoutTrashed()
 */
	class Attachment extends \Eloquent {}
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
 * @property string $padding_bottom_mobile
 * @property string $padding_bottom_tablet
 * @property string $padding_bottom_desktop
 * @property string|null $font
 * @property string $color
 * @property string|null $background_color
 * @property string $font_size_mobile
 * @property string $font_size_tablet
 * @property string $font_size_desktop
 * @property string $line_height_mobile
 * @property string $line_height_tablet
 * @property string $line_height_desktop
 * @property string $letter_spacing_mobile
 * @property string $letter_spacing_tablet
 * @property string $letter_spacing_desktop
 * @property \Illuminate\Support\Carbon $begin_date
 * @property \Illuminate\Support\Carbon $end_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $hash_id
 * @property-read array $translations
 * @property-read \App\Models\State $state
 * @method static \Illuminate\Database\Eloquent\Builder|Banner fromColorType()
 * @method static \Illuminate\Database\Eloquent\Builder|Banner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Banner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Banner onlyImageType()
 * @method static \Illuminate\Database\Eloquent\Builder|Banner query()
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereBackgroundColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereBeginDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereFont($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereFontSizeDesktop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereFontSizeMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereFontSizeTablet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereLetterSpacingDesktop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereLetterSpacingMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereLetterSpacingTablet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereLineHeightDesktop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereLineHeightMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereLineHeightTablet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner wherePaddingBottomDesktop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner wherePaddingBottomMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner wherePaddingBottomTablet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereRelativeUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereStateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereUrl($value)
 */
	class Banner extends \Eloquent {}
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
 * @property string|null $discount_coupon
 * @property string $subtotal
 * @property string|null $shipping_fee
 * @property string $total
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
 * @method static \Illuminate\Database\Eloquent\Builder|Buy currentStatus($names)
 * @method static \Illuminate\Database\Eloquent\Builder|Buy newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Buy newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Buy orCurrentStatus($names)
 * @method static \Illuminate\Database\Eloquent\Builder|Buy otherCurrentStatus($names)
 * @method static \Illuminate\Database\Eloquent\Builder|Buy query()
 * @method static \Illuminate\Database\Eloquent\Builder|Buy whereBillingAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buy whereBsaleDocumentUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buy whereBuyNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buy whereCouponId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buy whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buy whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buy whereDiscountCoupon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buy whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buy whereMetadata($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buy wherePayed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buy whereShippingAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buy whereShippingFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buy whereShippingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buy whereShowroom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buy whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buy whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buy whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buy whereUserId($value)
 */
	class Buy extends \Eloquent {}
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
 * @property string $total
 * @property-read \App\Models\Buy $buy
 * @property-read mixed $total_currency
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\Stock|null $stock
 * @method static \Illuminate\Database\Eloquent\Builder|BuyDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BuyDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BuyDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|BuyDetail whereBuyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuyDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuyDetail whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuyDetail whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuyDetail whereStockId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuyDetail whereTotal($value)
 */
	class BuyDetail extends \Eloquent {}
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
 * @property string|null $discount_coupon_pen
 * @property string|null $discount_coupon_usd
 * @property string $subtotal
 * @property string $subtotal_dolar
 * @property string $total
 * @property string $total_dolar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Coupon|null $coupon
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CartDetail[] $details
 * @property-read int|null $details_count
 * @property-read mixed $subtotal_currency
 * @property-read mixed $total_currency
 * @property-read mixed $total_discount_coupon
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Cart newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cart newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cart query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereCouponId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereDiscountCouponPen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereDiscountCouponUsd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereSubtotalDolar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereTotalDolar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereUserId($value)
 */
	class Cart extends \Eloquent {}
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
 * @method static \Illuminate\Database\Eloquent\Builder|CartDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CartDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CartDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|CartDetail whereCartId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartDetail whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartDetail whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartDetail whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartDetail whereStockId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartDetail whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartDetail whereTotalDolar($value)
 */
	class CartDetail extends \Eloquent {}
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
 * @method static \Illuminate\Database\Eloquent\Builder|Category findSimilarSlugs(string $attribute, array $config, string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 */
	class Category extends \Eloquent {}
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
 * @method static \Illuminate\Database\Eloquent\Builder|Color newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Color newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Color query()
 * @method static \Illuminate\Database\Eloquent\Builder|Color whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Color whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Color whereUuid($value)
 */
	class Color extends \Eloquent {}
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
 * @method static \Illuminate\Database\Eloquent\Builder|Country newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Country newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Country query()
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country wherePhonecode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereSortname($value)
 */
	class Country extends \Eloquent {}
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
 * @method static \Illuminate\Database\Eloquent\Builder|CountryState newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CountryState newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CountryState query()
 * @method static \Illuminate\Database\Eloquent\Builder|CountryState whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CountryState whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CountryState whereName($value)
 */
	class CountryState extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Coupon
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $type_id
 * @property string $code
 * @property string $amount_pen
 * @property string $amount_usd
 * @property int $frequency
 * @property string $minimum_pen
 * @property string $minimum_usd
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
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon query()
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereAmountPen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereAmountUsd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereBegin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereDiscountedProducts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereFrequency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereMinimumPen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereMinimumUsd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereProductSubtypes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereProductTypes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereProducts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereUpdatedAt($value)
 */
	class Coupon extends \Eloquent {}
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
 * @method static \Illuminate\Database\Eloquent\Builder|CouponType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CouponType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CouponType query()
 * @method static \Illuminate\Database\Eloquent\Builder|CouponType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponType whereName($value)
 */
	class CouponType extends \Eloquent {}
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
 * @method static \Illuminate\Database\Eloquent\Builder|DiscountTask newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DiscountTask newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DiscountTask query()
 * @method static \Illuminate\Database\Eloquent\Builder|DiscountTask whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiscountTask whereBegin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiscountTask whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiscountTask whereDiscountPen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiscountTask whereDiscountUsd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiscountTask whereEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiscountTask whereExecuted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiscountTask whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiscountTask whereIs2x1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiscountTask whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiscountTask whereProductSubtypes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiscountTask whereProductTypes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiscountTask whereProducts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiscountTask whereUpdatedAt($value)
 */
	class DiscountTask extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FitSize
 *
 * @property int $id
 * @property string $uuid
 * @property array $name
 * @property string $value
 * @property-read array $translations
 * @method static \Illuminate\Database\Eloquent\Builder|FitSize newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FitSize newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FitSize query()
 * @method static \Illuminate\Database\Eloquent\Builder|FitSize whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FitSize whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FitSize whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FitSize whereValue($value)
 */
	class FitSize extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FitWidth
 *
 * @property int $id
 * @property string $uuid
 * @property array $name
 * @property-read array $translations
 * @method static \Illuminate\Database\Eloquent\Builder|FitWidth newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FitWidth newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FitWidth query()
 * @method static \Illuminate\Database\Eloquent\Builder|FitWidth whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FitWidth whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FitWidth whereUuid($value)
 */
	class FitWidth extends \Eloquent {}
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
 * @method static \Illuminate\Database\Eloquent\Builder|Historic newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Historic newQuery()
 * @method static \Illuminate\Database\Query\Builder|Historic onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Historic query()
 * @method static \Illuminate\Database\Eloquent\Builder|Historic whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Historic whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Historic whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Historic whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Historic whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Historic wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Historic wherePhotoRelative($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Historic whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Historic withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Historic withoutTrashed()
 */
	class Historic extends \Eloquent {}
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
 * @method static \Illuminate\Database\Eloquent\Builder|HomePost findSimilarSlugs(string $attribute, array $config, string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|HomePost newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HomePost newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HomePost query()
 * @method static \Illuminate\Database\Eloquent\Builder|HomePost whereBeginDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomePost whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomePost whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomePost whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomePost whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomePost whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomePost wherePostTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomePost whereRedirectionLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomePost whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomePost whereStateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomePost whereUpdatedAt($value)
 */
	class HomePost extends \Eloquent {}
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
 * @method static \Illuminate\Database\Eloquent\Builder|Image newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Image newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Image query()
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereBackgroundCounter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereBackgroundSuscribe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereUpdatedAt($value)
 */
	class Image extends \Eloquent {}
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
 * @method static \Illuminate\Database\Eloquent\Builder|Label findSimilarSlugs(string $attribute, array $config, string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Label newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Label newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Label query()
 * @method static \Illuminate\Database\Eloquent\Builder|Label whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Label whereColorText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Label whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Label whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Label whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Label whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Label whereUpdatedAt($value)
 */
	class Label extends \Eloquent {}
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
 * @method static \Illuminate\Database\Eloquent\Builder|Manager newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Manager newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Manager query()
 * @method static \Illuminate\Database\Eloquent\Builder|Manager whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manager whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manager whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manager wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manager whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manager whereRoleId($value)
 */
	class Manager extends \Eloquent {}
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
 * @method static \Illuminate\Database\Eloquent\Builder|Page findSimilarSlugs(string $attribute, array $config, string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Page newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Page newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Page query()
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereMainImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereUpdatedAt($value)
 */
	class Page extends \Eloquent {}
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
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereAuthCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereAuthResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereAuthResultText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereBuyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCardBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereErrorCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereVerification($value)
 */
	class Payment extends \Eloquent {}
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
 * @method static \Illuminate\Database\Eloquent\Builder|Photo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Photo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Photo query()
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereHomePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photo wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereRelativeUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereUrl($value)
 */
	class Photo extends \Eloquent {}
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
 * @method static \Illuminate\Database\Eloquent\Builder|Post currentStatus($names)
 * @method static \Illuminate\Database\Eloquent\Builder|Post findSimilarSlugs(string $attribute, array $config, string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post otherCurrentStatus($names)
 * @method static \Illuminate\Database\Eloquent\Builder|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereMainPhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereMainVideo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereStateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUpdatedAt($value)
 */
	class Post extends \Eloquent {}
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
 * @method static \Illuminate\Database\Eloquent\Builder|PostType findSimilarSlugs(string $attribute, array $config, string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|PostType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostType query()
 * @method static \Illuminate\Database\Eloquent\Builder|PostType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostType whereSlug($value)
 */
	class PostType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PremiumLink
 *
 * @mixin \Eloquent
 * @property int $id
 * @property mixed $uuid
 * @property array $name
 * @property \Illuminate\Support\Carbon $end
 * @property array|null $products
 * @property int $available
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read string $hash_id
 * @property-read array $translations
 * @method static \Illuminate\Database\Eloquent\Builder|PremiumLink newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PremiumLink newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PremiumLink query()
 * @method static \Illuminate\Database\Eloquent\Builder|PremiumLink whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PremiumLink whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PremiumLink whereEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PremiumLink whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PremiumLink whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PremiumLink whereProducts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PremiumLink whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PremiumLink whereUuid($value)
 */
	class PremiumLink extends \Eloquent {}
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
 * @property string $price
 * @property string|null $price_pen_discount
 * @property string $price_dolar
 * @property string|null $price_usd_discount
 * @property string|null $weight
 * @property string $instep_level_very_high
 * @property string $instep_level_high
 * @property string $instep_level_normal
 * @property string $instep_level_low
 * @property string $instep_level_very_low
 * @property string $width_level_very_high
 * @property string $width_level_high
 * @property string $width_level_normal
 * @property string $width_level_low
 * @property string $width_level_very_low
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
 * @property-read \Illuminate\Database\Eloquent\Collection|Product[] $recommendations
 * @property-read int|null $recommendations_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Product[] $recommended_by
 * @property-read int|null $recommended_by_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Size[] $sizes_active
 * @property-read int|null $sizes_active_count
 * @property-read \App\Models\State|null $state
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Stock[] $stocks
 * @property-read int|null $stocks_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Subtype[] $subtypes
 * @property-read int|null $subtypes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Video[] $videos
 * @property-read int|null $videos_count
 * @method static \Illuminate\Database\Eloquent\Builder|Product findSimilarSlugs(string $attribute, array $config, string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Query\Builder|Product onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereBeginDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDiscountPen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDiscountUsd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereEndDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereFitSizeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereFitWidthId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereFreeShipping($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereInstepLevelHigh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereInstepLevelLow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereInstepLevelNormal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereInstepLevelVeryHigh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereInstepLevelVeryLow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsDeal2x1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsSalient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsShowroomSale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsSoldout($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereLabelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePriceDolar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePricePenDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePriceUsdDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePublishDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereWidthLevelHigh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereWidthLevelLow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereWidthLevelNormal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereWidthLevelVeryHigh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereWidthLevelVeryLow($value)
 * @method static \Illuminate\Database\Query\Builder|Product withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Product withoutTrashed()
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Role
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Settings
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $dolar_change
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
 * @method static \Illuminate\Database\Eloquent\Builder|Settings newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Settings newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Settings query()
 * @method static \Illuminate\Database\Eloquent\Builder|Settings whereBackgroundCounter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settings whereBackgroundSuscribe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settings whereBipolarCounts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settings whereCurrentBuy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settings whereDeal2x1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settings whereDolarChange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settings whereFacebookCounts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settings whereFreeShipping($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settings whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settings whereInstagramCounts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settings whereOpenHours($value)
 */
	class Settings extends \Eloquent {}
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
 * @property string|null $g200
 * @property string|null $g200_dolar
 * @property string|null $g500
 * @property string|null $g500_dolar
 * @property string|null $kg1
 * @property string|null $kg1_dolar
 * @property string|null $kg2
 * @property string|null $kg2_dolar
 * @property string|null $kg3
 * @property string|null $kg3_dolar
 * @property string|null $kg4
 * @property string|null $kg4_dolar
 * @property string|null $kg5
 * @property string|null $kg5_dolar
 * @property string|null $kg6
 * @property string|null $kg6_dolar
 * @property string|null $kg7
 * @property string|null $kg7_dolar
 * @property string|null $kg8
 * @property string|null $kg8_dolar
 * @property string|null $kg9
 * @property string|null $kg9_dolar
 * @property string|null $kg10
 * @property string|null $kg10_dolar
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
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping query()
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereAllowShowroom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereG200($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereG200Dolar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereG500($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereG500Dolar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereIsDniRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereKg1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereKg10($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereKg10Dolar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereKg1Dolar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereKg2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereKg2Dolar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereKg3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereKg3Dolar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereKg4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereKg4Dolar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereKg5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereKg5Dolar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereKg6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereKg6Dolar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereKg7($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereKg7Dolar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereKg8($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereKg8Dolar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereKg9($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereKg9Dolar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereTitle($value)
 */
	class Shipping extends \Eloquent {}
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
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingExclude newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingExclude newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingExclude query()
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingExclude whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingExclude whereCountryStateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingExclude whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingExclude whereShippingId($value)
 */
	class ShippingExclude extends \Eloquent {}
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
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingInclude newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingInclude newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingInclude query()
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingInclude whereAllCountries($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingInclude whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingInclude whereCountryStateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingInclude whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingInclude whereShippingId($value)
 */
	class ShippingInclude extends \Eloquent {}
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
 * @property int $is_available_filter_sale
 * @property-read string $hash_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Stock[] $stocks
 * @property-read int|null $stocks_count
 * @method static \Illuminate\Database\Eloquent\Builder|Size findSimilarSlugs(string $attribute, array $config, string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Size newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Size newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Size query()
 * @method static \Illuminate\Database\Eloquent\Builder|Size whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Size whereIsAvailableFilterSale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Size whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Size whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Size whereUuid($value)
 */
	class Size extends \Eloquent {}
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
 * @method static \Illuminate\Database\Eloquent\Builder|State newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|State newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|State query()
 * @method static \Illuminate\Database\Eloquent\Builder|State whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|State whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|State whereName($value)
 */
	class State extends \Eloquent {}
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
 * @method static \Illuminate\Database\Eloquent\Builder|Stock newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Stock newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Stock query()
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereBsaleStockId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereBsaleStockIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereIncomingDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereSizeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereUpdatedAt($value)
 */
	class Stock extends \Eloquent {}
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
 * @method static \Illuminate\Database\Eloquent\Builder|Subtype findSimilarSlugs(string $attribute, array $config, string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Subtype newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subtype newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subtype query()
 * @method static \Illuminate\Database\Eloquent\Builder|Subtype whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subtype whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subtype whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subtype whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subtype whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subtype whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subtype whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subtype whereUuid($value)
 */
	class Subtype extends \Eloquent {}
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
 * @method static \Illuminate\Database\Eloquent\Builder|Tag findSimilarSlugs(string $attribute, array $config, string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereSlug($value)
 */
	class Tag extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TextCondition
 *
 * @mixin \Eloquent
 * @property int $id
 * @property mixed $uuid
 * @property array|null $name
 * @property array|null $description
 * @property array|null $products
 * @property int $available
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read string $hash_id
 * @property-read array $translations
 * @method static \Illuminate\Database\Eloquent\Builder|TextCondition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TextCondition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TextCondition query()
 * @method static \Illuminate\Database\Eloquent\Builder|TextCondition whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TextCondition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TextCondition whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TextCondition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TextCondition whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TextCondition whereProducts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TextCondition whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TextCondition whereUuid($value)
 */
	class TextCondition extends \Eloquent {}
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
 * @method static \Illuminate\Database\Eloquent\Builder|Type findSimilarSlugs(string $attribute, array $config, string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Type newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Type newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Type query()
 * @method static \Illuminate\Database\Eloquent\Builder|Type whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Type whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Type whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Type whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Type whereUuid($value)
 */
	class Type extends \Eloquent {}
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
 * @property string|null $common_size
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
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBirthdayDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCommonSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDni($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFacebookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFootInstep($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFootWidth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereHasShowroomSale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePaymeWalletToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Video
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int|null $product_id
 * @property int $attachment_id
 * @property string|null $url
 * @property string|null $relative_url
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Attachment $attachment
 * @property-read string $hash_id
 * @property-read \App\Models\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder|Video newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Video newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Video query()
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereAttachmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereRelativeUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereUrl($value)
 */
	class Video extends \Eloquent {}
}

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
 * @method static \Illuminate\Database\Eloquent\Builder|Wishlist newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Wishlist newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Wishlist query()
 * @method static \Illuminate\Database\Eloquent\Builder|Wishlist whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wishlist whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wishlist whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wishlist whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wishlist whereUserId($value)
 */
	class Wishlist extends \Eloquent {}
}

