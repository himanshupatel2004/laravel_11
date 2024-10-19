<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        // Run the migrations
        $this->artisan('migrate');

        // Check the current database connection
        $connectionName = \DB::connection()->getDatabaseName();
        echo "Connected to database: " . $connectionName . PHP_EOL;

        // Create a test user
        $this->user = User::factory()->create();

        // Create a test product
        $this->product = Product::factory()->create([
            'price' => 100.00, // Ensure price matches the factory
        ]);

        // Add product to cart
        $this->actingAs($this->user)->post(route('cart.add', $this->product->id));
    }

    /** @test */
    public function it_can_complete_a_checkout()
    {
        $response = $this->actingAs($this->user)
                         ->post(route('cart.processCheckout'), [
                             'payment_method' => 'stripe',
                         ]);

        $response->assertRedirect(route('order.confirmation', 1));

        $this->assertDatabaseHas('orders', [
            'id' => 1,
            'user_id' => $this->user->id,
            'total' => 100.00, // Ensure this matches the product price
            'payment_method' => 'stripe',
            'status' => 'completed',
        ]);

        $this->assertDatabaseHas('order_items', [
            'order_id' => 1,
            'product_id' => $this->product->id,
            'quantity' => 1,
            'price' => 100.00,
        ]);
    }
}
