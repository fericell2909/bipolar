<?php

namespace Tests\Feature;

use App\Instances\CartBipolar;
use App\Models\Buy;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\Mock;
use Tests\TestCase;

class CartsJsonTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_product_without_content()
    {
        $response = $this->postJson('/ajax/cart/product');

        $response->assertStatus(422);
    }

    public function test_add_product_with_content()
    {
        /** @var Product $product */
        $product = factory(Product::class)->create();

        $response = $this->postJson('/ajax/cart/product', [
            'product_id' => $product->hash_id,
            'quantity'   => 1,
        ]);

        $this->instance(CartBipolar::class, function ($mock) {
            /** @var Mock $mock */
            $mock->shouldReceive('add')->once();
        });

        $response->assertStatus(200)->assertExactJson(['success' => true]);
    }

    public function test_destroy_buy()
    {
        /**
         * @var Buy $buy
         * @var User $user
         */
        $user = factory(User::class)->create();
        $buy = factory(Buy::class)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->post("/ajax/buy/{$buy->hash_id}/delete");

        $this->instance(Buy::class, function ($mock) {
            /** @var Mock $mock */
            $mock->shouldReceive('delete')->once();
        });

        $this->assertAuthenticatedAs($user);
        $response->assertStatus(200)->assertExactJson(['success' => true]);
    }
}
