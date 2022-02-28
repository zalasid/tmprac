<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $eventStartDate = $this->faker->dateTimeBetween('-30 days', '+30 days');
        return [
            'name' => $this->faker->sentence(4, true),
            'place' => $this->faker->city(),
            'start_date' => $eventStartDate->format('Y-m-d H:i:s'),
            'end_date' => Carbon::createFromFormat('Y-m-d H:i:s', $eventStartDate->format('Y-m-d H:i:s'))
                ->addDays(rand(1, 10))
                ->format('Y-m-d H:i:s'),
            'fees' => rand(100, 500),
        ];
    }
}
