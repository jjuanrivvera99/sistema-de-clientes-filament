<?php

namespace Database\Seeders;

use App\Models\Customer;
use Faker\Factory as Faker;
use App\Models\DocumentType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $documentTypes = DocumentType::pluck('id')->toArray();

        for ($i = 0; $i < 1000; $i++) {
            $customer = Customer::create([
                'name' => $faker->name,
                'nationality' => $faker->country,
                'residence_place' => $faker->city,
                'postal_code' => $faker->postcode,
                'cencus' => $faker->words(3, true),
                'marital_status' => $faker->randomElement(['Soltero', 'Casado', 'Divorciado', 'Viudo', 'Unión Libre']),
                'family' => $faker->text,
                'document_number' => $faker->unique()->numerify('##########'),
                'document_type_id' => $faker->randomElement($documentTypes),
                'notes' => $faker->optional()->text,
                'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
                'updated_at' => $faker->dateTimeBetween('-1 year', 'now'),
                'deleted_at' => $faker->optional(0.05)->dateTimeBetween('-1 year', 'now'),
            ]);

            $contacts = [];

            for ($j = 0; $j < $faker->numberBetween(1, 3); $j++) {
                $contacts[] = [
                    'contact_number' => $faker->phoneNumber,
                    'address' => $faker->address,
                    'email' => $faker->email,
                ];
            }

            $customer->contacts()->createMany($contacts);

            $customer->membership()->create([
                'membership_number' => $faker->unique()->numerify('##########'),
                'membership_date' => $faker->dateTimeBetween('-1 year', 'now'),
                'membership_status' => $faker->randomElement(['active', 'inactive']),
                'wish' => $faker->optional()->text,
                'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
                'updated_at' => $faker->dateTimeBetween('-1 year', 'now'),
            ]);
        }
    }
}
