<?php

namespace Tests\Unit;

use App\Instances\CartBipolar;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Subtype;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class CartBipolarTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    /** @var CartBipolar */
    private $cart;

    public function setUp() : void
    {
        parent::setUp();
        $this->cart = CartBipolar::getInstance();
    }

    public function test_add_coupon_quantity_to_cart()
    {
        $randomQuantity = $this->faker->numberBetween(10, 30);
        /** @var Product $product */
        $product = factory(Product::class)->create();
        $product->subtypes()->sync(factory(Subtype::class, 2)->create()->pluck('id')->toArray());
        $product->load('subtypes');
        /** @var Coupon $couponByQuantity */
        $couponByQuantity = factory(Coupon::class)->states('quantity')->create([
            'products'         => [$product->id],
            'product_subtypes' => $product->subtypes->pluck('id')->toArray(),
        ]);

        $this->cart->add($randomQuantity, $product);
        $this->cart->add($randomQuantity, factory(Product::class)->create());

        $this->assertEquals($this->cart->content()->sum('total'), $this->cart->model()->total);
        $this->assertEquals($this->cart->content()->sum('total_dolar'), $this->cart->model()->total_dolar);

        $cartAfterCoupon = $this->cart->addCoupon($couponByQuantity);

        $this->assertEquals($this->cart->content()->sum('total') - $cartAfterCoupon->discount_coupon_pen, $cartAfterCoupon->total);
        $this->assertEquals($this->cart->content()->sum('total_dolar') - $cartAfterCoupon->discount_coupon_usd, $cartAfterCoupon->total_dolar);
    }

    public function test_add_coupon_percentage_to_cart()
    {
        $randomQuantity = $this->faker->numberBetween(10, 30);
        /** @var Product $product */
        $product = factory(Product::class)->create();
        $product->subtypes()->sync(factory(Subtype::class, 2)->create()->pluck('id')->toArray());
        $product->load('subtypes');
        /** @var Coupon $couponByPercentage */
        $couponByPercentage = factory(Coupon::class)->states('percentage')->create([
            'products'         => [$product->id],
            'product_subtypes' => $product->subtypes->pluck('id')->toArray(),
        ]);

        $this->cart->add($randomQuantity, $product);
        $this->cart->add($randomQuantity, factory(Product::class)->create());

        $this->assertEquals($this->cart->content()->sum('total') - $this->cart->model()->discount_coupon_pen, $this->cart->model()->total);
        $this->assertEquals($this->cart->content()->sum('total_dolar') - $this->cart->model()->discount_coupon_usd, $this->cart->model()->total_dolar);

        $cartAfterCoupon = $this->cart->addCoupon($couponByPercentage);

        $this->assertEquals($this->cart->content()->sum('total') - $cartAfterCoupon->discount_coupon_pen, $cartAfterCoupon->total);
        $this->assertEquals($this->cart->content()->sum('total_dolar') - $cartAfterCoupon->discount_coupon_usd, $cartAfterCoupon->total_dolar);
    }
}
