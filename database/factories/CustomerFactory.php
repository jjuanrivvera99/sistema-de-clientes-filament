<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Customer;
use App\Models\DocumentType;

class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'nationality' => $this->faker->word(),
            'residence_place' => $this->faker->word(),
            'postal_code' => $this->faker->postcode(),
            'approx_enrollment' => $this->faker->date(),
            'marital_status' => $this->faker->word(),
            'family' => $this->faker->text(),
            'document_number' => $this->faker->word(),
            'document_type_id' => DocumentType::factory(),
            'unique' => $this->faker->word(),
        ];
    }
}
