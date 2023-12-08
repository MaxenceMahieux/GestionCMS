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

class SubmenuControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Index method return view with menus
     */
    public function test_index_method_return_submenu_view()
    {
        $user = User::factory()->create();
        Bouncer::assign('admin')->to($user);
        $menu = Menu::factory()->create();
        
        $response = $this
            ->actingAs($user)
            ->post("/submenu", [
                'title' => 'Test update',
                'link' => 'update link',
                'radio_choice' => '1',
                'menu_id' => "{$menu->id}",
            ]);
        // When

        $response = $this->get(route('submenu.index'));


        // Then

        $response->assertStatus(200);

        $response->assertViewIs('submenu.index');
    }

    public function test_store_method_saves_submenu()
    {
        $user = User::factory()->create();
        Bouncer::assign('admin')->to($user);

        $menu = Menu::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post("/submenu", [
                'title' => 'Test update',
                'link' => 'update link',
                'radio_choice' => '1',
                'menu_id' => "{$menu->id}",
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect('/submenu');
    }

    /** @test */
    public function test_admin_can_access_submenu_create_page()
    {
        $admin = User::factory()->create();
        Bouncer::allow($admin)->to('submenu-create');
        $this->actingAs($admin);
        $response = $this->get(route('submenu.create'));
        $response->assertStatus(200);
        $response->assertViewIs('submenu.create');
        $response->assertViewHas('submenus', Submenu::all());
    }

    /** @test */
    public function test_non_admin_cannot_access_submenu_create_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get(route('submenu.create'));
        $response->assertStatus(403);
    }

            /**
     * Index method return view with menus
     */
    public function test_show_method_returns_view_with_submenu()
    {
        $menu = Menu::factory()->create();
        $submenu = Submenu::factory()->create([
            'title' => 'Test update',
            'link' => 'update link',
            'menu_id' => $menu->id,
            'visible' => '1',
        ]);
    
        $response = $this->get(route('submenu.show', ['submenu' => $submenu->id]));
    
        $response->assertStatus(200);
        $response->assertViewIs('submenu.show');
        $response->assertViewHas('submenu', $submenu);
    }
    
    /**
     * Index method return view with menus
     */
    public function test_admin_can_access_edit_page()
    {
        $menu = Menu::factory()->create();
        // Création d'un utilisateur administrateur
        $admin = User::factory()->create();
        Bouncer::allow($admin)->to('submenu-edit');
        // Simuler l'authentification de cet utilisateur
        $this->actingAs($admin);

        // Création d'un menu
        $submenu = Submenu::factory()->create([
            'title' => 'Test update',
            'link' => 'update link',
            'menu_id' => $menu->id,
            'visible' => '1',
        ]);

        // Accéder à la page d'édition en tant qu'administrateur
        $response = $this->get(route('submenu.edit', ['submenu' => $submenu]));

        // Vérification que l'administrateur peut accéder à la page
        $response->assertStatus(200);
        $response->assertViewIs('submenu.edit');
        $response->assertViewHas('submenu', $submenu);
    }

    public function test_non_admin_cannot_access_edit_page()
    {
        $menu = Menu::factory()->create();
        // Création d'un utilisateur sans privilèges administratifs
        $user = User::factory()->create();

        // Simuler l'authentification de cet utilisateur
        $this->actingAs($user);

        // Création d'un menu
        $submenu = Submenu::factory()->create([
            'title' => 'Test update',
            'link' => 'update link',
            'menu_id' => $menu->id,
            'visible' => '1',
        ]);

        // Tentative d'accéder à la page d'édition en tant qu'utilisateur régulier
        $response = $this->get(route('submenu.edit', ['submenu' => $submenu]));

        // Vérification que l'utilisateur régulier ne peut pas accéder à la page
        $response->assertStatus(403); // Code HTTP 403: Accès refusé
    }

    public function test_update_method_updates_menu()
    {
        $menu = Menu::factory()->create();
        // Création d'un menu
        $submenu = Submenu::factory()->create([
            'title' => 'Test update',
            'link' => 'update link',
            'menu_id' => $menu->id,
            'visible' => '1',
        ]);

        // Données simulées pour la mise à jour
        $updatedData = [
            'title' => 'Test update2',
            'link' => 'update link 2',
            'menu_id' => $menu->id,
            'radio_choice' => '0',
        ];

        // Appeler la méthode update avec les données simulées via une requête HTTP simulée
        $response = $this->put(route('submenu.update', ['submenu' => $submenu->id]), $updatedData);

        // Récupérer le menu mis à jour depuis la base de données
        $updatedSubmenu = Submenu::find($submenu->id);

        // Vérifier que les modifications ont été apportées au menu
        $this->assertEquals($updatedData['title'], $updatedSubmenu->title);
        $this->assertEquals($updatedData['link'], $updatedSubmenu->link);
        $this->assertEquals($updatedData['radio_choice'], $updatedSubmenu->visible);
    }

    public function test_user_with_admin_role_can_delete_menu() : void
    {
        $user = User::factory()->create();
        Bouncer::allow($user)->to('submenu-delete');
        // Simuler l'authentification de cet utilisateur

        $menu = Menu::factory()->create();

        $submenu = Submenu::factory()->create([
            'title' => 'Test update',
            'link' => 'update link',
            'menu_id' => $menu->id,
            'visible' => '1',
        ]);

        $this->assertDatabaseHas('submenus', ['id' => $submenu->id]);

        $response = $this
            ->actingAs($user)
            ->delete("/submenu/{$submenu->id}");

        $response->assertRedirect('/submenu');

        $this->assertDatabaseMissing('submenus', ['id' => $submenu->id]);

    }
}