<?php

namespace Database\Factories;

use App\Models\Menu;
use App\Models\Submenu;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Page>
 */
class PageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $submenu = Submenu::inRandomOrder()->first();
        $menu = Menu::inRandomOrder()->first();

        return [
            'title' => fake()->word(),
            'message' => fake()->text(),
            'submenu_id' => $submenu->id,
            'menu_id' => $menu->id,
            'visible' => 1,
            'publication_date' => fake()->date()
        ];
    }
}
