<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartsJsonTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_product_without_content()
    {
        $response = $this->postJson('/ajax/cart/product');

        $response->assertStatus(422);
    }
}
