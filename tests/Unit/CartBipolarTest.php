<?php

namespace Tests\Unit;

use App\Instances\CartBipolar;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class CartBipolarTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    /** @var CartBipolar */
    private $cart;

    public function setUp()
    {
        parent::setUp();
        $this->cart = new CartBipolar();
    }
    
    public function test_add_coupon_quantity_to_cart()
    {
        $randomQuantity = $this->faker->numberBetween(10, 30);
        /** @var Product $product */
        $product = factory(Product::class)->create();
        /** @var Coupon $couponByQuantity */
        $couponByQuantity = factory(Coupon::class)->states('quantity')->create([
            'products' => [$product->id],
        ]);

        $this->cart->add($randomQuantity, $product);

        $this->assertEquals($product->price * $randomQuantity, $this->cart->model()->total);
        $this->assertEquals($product->price_dolar * $randomQuantity, $this->cart->model()->total_dolar);

        $cart = $this->cart->addCoupon($couponByQuantity);

        $this->assertEquals(($product->price * $randomQuantity) - $couponByQuantity->amount_pen, $cart->total);
        $this->assertEquals(($product->price_dolar * $randomQuantity) - $couponByQuantity->amount_usd, $cart->total_dolar);
    }

    public function add_coupon_percentage_to_cart()
    {
        /** @var Coupon $couponByPercentage  */

        //$couponByPercentage = factory(Coupon::class)->states('percentage')->create();
        //$this->assertTrue($this->cart->addCoupon($couponByPercentage));
    }
}
