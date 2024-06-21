<?php

namespace Database\Factories;

use App\Models\Url;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Url>
 */
class UrlFactory extends Factory
{
    protected $model = Url::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => Str::uuid(),
            'user_id' => 1,
            'original_url' => $this->faker->url,
            'shortened_url' => strtolower(Str::random(7)),
        ];
    }
}
