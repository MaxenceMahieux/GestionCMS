<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Bouncer;
use Auth;
use App\Models\Submenu;
use App\Models\Page;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_method_returns_view_with_menus_and_pages()
    {
        // Création de données de test pour les menus
        $menus = Menu::factory()->count(3)->create();

        // Création d'un menu supplémentaire
        $menu = Menu::factory()->create();

        // Création d'un sous-menu
        $submenu = Submenu::factory()->create();

        // Création d'une page associée à un menu et un sous-menu fictifs
        $page = Page::factory()->create([
            'title' => 'Test update',
            'message' => 'update message',
            'visible' => '1',
            'publication_date' => now(), // Utilisation de la date actuelle
            'menu_id' => $menu->id,
            'submenu_id' => $submenu->id,
        ]);

        // Ajout du menu supplémentaire aux menus existants
        $menus[] = $menu;

        // Appel de la méthode index du contrôleur
        $response = $this->get(route('index'));

        // Vérification du code de réponse et de la vue retournée
        $response->assertStatus(200);
        $response->assertViewIs('index');

        // Vérification que les données des menus sont passées à la vue
        $response->assertViewHas('menus', $menus);

        // Vérification que les données des pages sont passées à la vue
        $response->assertViewHas('pages', function ($viewPages) use ($page) {
            return $viewPages->contains($page);
        });
    }



}