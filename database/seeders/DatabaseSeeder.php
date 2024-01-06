<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Creates new demo user for ease of use.
        $admin = User::create([
            'name'              => 'Demo Co',
            'email'             => 'demo@demo.com',
            'email_verified_at' => now(),
            'password'          => bcrypt('password1'),
        ]);

        $team = Team::forceCreate([
            'user_id' => $admin->id,
            'name' => explode(' ', $admin->name, 2)[0]."'s Team",
            'personal_team' => true,
        ]);

        $admin->current_team_id = $team->id;
        $admin->save();

        // Creates 5 Customers using the CustomerFactory.
        Customer::factory()->count(3)->create();
    }
}
