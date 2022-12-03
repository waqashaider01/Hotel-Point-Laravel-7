<?php

namespace Database\Factories;

use App\Models\ExtraChargesCategory;
use App\Models\ExtraChargesType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ExtraChargeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product' => $this->faker->name(),
            'status' => 'Enabled',
            'vat' => $this->faker->numberBetween(1,90),
            'unit_price' => $this->faker->numberBetween(10,1000),
            'extra_charge_category_id' => ExtraChargesCategory::query()->inRandomOrder()->first()->id,
            'extra_charge_type_id' => ExtraChargesType::query()->inRandomOrder()->first()->id,
        ];
    }
}
