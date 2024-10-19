<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Product;
use App\Models\User;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');

        // Create a test user
        $this->user = User::factory()->create();

        // Create a test product
        $this->product = Product::factory()->create();
    }

    /** @test */
    public function it_can_add_product_to_cart()
    {
        $response = $this->actingAs($this->user)
                         ->post(route('cart.add', $this->product->id));

        $response->assertRedirect(route('cart.index'));
        $response->assertSessionHas('cart');

        $cart = session('cart');
        $this->assertEquals(1, $cart[$this->product->id]['quantity']);
    }
}
