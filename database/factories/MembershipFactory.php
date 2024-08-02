<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Customer;
use App\Models\Membership;

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
