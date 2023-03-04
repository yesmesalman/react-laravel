<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class Plans extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Plan::create([
            'name' => 'Basic',
            'slug' => 'basic',
            'stripe_plan' => 'basic',
            'price' => 500,
            'description' => "basic",
        ]);

        Plan::create([
            'name' => 'Premium',
            'slug' => 'premium',
            'stripe_plan' => 'premium',
            'price' => 1000,
            'description' => "premium",
        ]);

        Plan::create([
            'name' => 'Enterprise',
            'slug' => 'enterprise',
            'stripe_plan' => 'enterprise',
            'price' => 1500,
            'description' => "enterprise",
        ]);
    }
}
