<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Membership;
use Illuminate\Database\Eloquent\Factories\Factory;

class MembershipFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Membership::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'membership_number' => $this->faker->word(),
            'membership_date' => $this->faker->date(),
            'membership_status' => $this->faker->word(),
            'customer_id' => Customer::factory(),
            'wish' => $this->faker->text(),
        ];
    }
}
