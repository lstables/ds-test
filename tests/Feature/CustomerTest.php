<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_displays_all_customers()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->component('Dashboard')
            ->has('customers')
        );
    }

    public function test_storing_new_customer()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $attributes = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'address' => '123 Main St',
        ];

        $response = $this->post(route('customers.store', $attributes));

        $response->assertRedirect('/dashboard');
        $this->assertDatabaseHas('customers', $attributes);
        $response->assertSessionHas('message', 'Customer created successfully.');
    }

    public function test_updating_a_customer()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $customer = Customer::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'address' => '123 Main St',
        ]);

        $attributes = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'phone' => '0987654321',
            'address' => '321 Main St',
        ];

        $response = $this->put(route('customer.update', $customer->id), $attributes);

        $response->assertRedirect('/dashboard');
        $this->assertDatabaseHas('customers', $attributes);
        $response->assertSessionHas('message', 'Customer updated successfully.');
    }

    public function test_deleting_a_customer()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $customer = Customer::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'address' => '123 Main St',
        ]);

        $response = $this->delete(route('customer.destroy', $customer->id));

        $response->assertRedirect('/dashboard');
        $this->assertDatabaseMissing('customers', ['id' => $customer->id]);
        $response->assertSessionHas('message', 'Customer deleted successfully.');
    }
}
