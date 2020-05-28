<?php

namespace Tests\Unit;

use App\Instances\CartBipolar;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Subtype;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class CartBipolarTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @var CartBipolar */
    private $cart;

    public function setUp(): void
    {
        parent::setUp();
        $this->cart = CartBipolar::getInstance();
    }
    // TODO: Test when you remove a product
    // TODO: Test when you remove a detail
    // TODO: Test when you add a 2x1 product
    // TODO: Test if cart is converted to user
    // TODO: Test price calculation after add / removing products

    public function test_add_single_product_to_cart()
    {
        $product = factory(Product::class)->create();
        $quantity = $this->faker->numberBetween(1, 10);

        $cartDetail = $this->cart->add($quantity, $product);

        $this->assertTrue($cartDetail->quantity === $quantity);
        $this->assertTrue($this->cart->count() === 1);
        $this->cart->clean();
    }

    public function test_add_multiple_products_to_cart()
    {
        $randomProducts = $this->faker->numberBetween(1, 3);

        for ($productOrder = 1; $productOrder <= $randomProducts; $productOrder++) {
            $product = factory(Product::class)->create();
            $quantity = $this->faker->numberBetween(1, 10);
            $cartDetail = $this->cart->add($quantity, $product);
            $this->assertTrue($cartDetail->quantity === $quantity);
        }

        $this->assertTrue($this->cart->count() === $randomProducts);
        $this->cart->clean();
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
