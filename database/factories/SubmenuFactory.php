<?php

namespace Database\Factories;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Submenu>
 */
class SubmenuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $menu = Menu::inRandomOrder()->first();

        return [
            'title' => fake()->word(),
            'link' => fake()->url(),
            'visible' => 1,
            'menu_id' => $menu->id
        ];
    }
}
