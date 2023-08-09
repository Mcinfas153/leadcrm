<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lead>
 */
class LeadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $createdBy = fake()->numberBetween(2,4);
        $assignTo = $createdBy == 2 ? fake()->numberBetween(3,4) : $createdBy;

        return [
            'fullname' => fake()->name(),
            'phone' => fake()->phoneNumber(),
            'secondary_phone' => fake()->phoneNumber(),
            'email' => fake()->safeEmail(),
            'whatsapp' => fake()->phoneNumber(),
            'city' => fake()->city(),
            'country' => fake()->country(),
            'budget' => fake()->numberBetween(500000,10000000),
            'contact_time' => fake()->dayOfWeek(),
            'purpose' => fake()->randomElement(['investmennt','living']),
            'inquiry' => fake()->text(100),
            'campaign_name' => fake()->randomElement(['azizi riviera','damac lagoon','emaar beachfront']),
            'property_type' => fake()->randomElement(['villa','apartment','townhouse']),
            'bedroom' => fake()->numberBetween(1,10),
            'status' => fake()->numberBetween(1,23),
            'source' => fake()->randomElement(['facebook', 'instagram', 'tiktok', 'google']),
            'priority' => fake()->numberBetween(1,3),
            'developer' => fake()->randomElement(['emaar', 'damac', 'azizi']),
            'type' => fake()->numberBetween(1,3),
            'assign_to' => $assignTo,
            'created_by' => $createdBy,
            'created_at' => fake()->dateTimeThisMonth(),
            'updated_at' => fake()->dateTimeThisMonth(),
        ];
    }
}
