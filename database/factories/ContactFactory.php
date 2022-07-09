<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // return [
        //     'name' => 'Hello',
        //     'position' => 'Hello',
        //     'phone' => 'Hello',
        //     'address' => 'Hello',
        //     'user_id' => 1,
        // ];
        return [
            'name' => $this->faker->name,
            'position' => $this->faker->word,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'user_id' => User::factory()->create()->id,
        ];
    }
}
