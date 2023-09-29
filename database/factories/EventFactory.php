<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Event;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{

    protected $model = Event::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
    
        $futureDate = $this->faker->dateTimeBetween('+1 day', '+30 days')->format('Y-m-d H:i:s');

        return [
            'title' => $this->faker->words(5, true),
            'timestamp' => $futureDate,
        ];
        
    }
}