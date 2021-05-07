<?php

namespace Database\Factories;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

class CurrencyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Currency::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'num_code' => $this->faker->buildingNumber(),
            'char_code' => $this->faker->currencyCode(),
            'nominal' => $this->faker->randomDigitNotNull(),
            'name' => $this->faker->creditCardType(),
            'value' => $this->faker->randomFloat(2, 1, 100)
        ];
    }
}
