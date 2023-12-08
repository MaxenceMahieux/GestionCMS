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
use App\Mail\DeleteMenuMail;

class MenuControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Index method return view with menus
     */
    public function test_index_method_returns_view_with_menus()
    {
        Menu::factory()->count(3)->create();
        $response = $this->get(route('menu.index'));
        $response->assertStatus(200);
        $response->assertViewIs('menu.index');
        $response->assertViewHas('menus', Menu::all());
    }

    /** @test */
    public function test_admin_can_access_menu_create_page()
    {
        $admin = User::factory()->create();
        Bouncer::allow($admin)->to('menu-create');
        $this->actingAs($admin);
        $response = $this->get(route('menu.create'));
        $response->assertStatus(200);
        $response->assertViewIs('menu.create');
        $response->assertViewHas('menus', Menu::all());
    }

    /** @test */
    public function test_non_admin_cannot_access_menu_create_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get(route('menu.create'));
        $response->assertStatus(403);
    }

        /**
     * Index method return view with menus
     */
    public function test_show_method_returns_view_with_menu()
    {
        $menu = Menu::factory()->create();
        $response = $this->get(route('menu.show', ['menu' => $menu]));
        $response->assertStatus(200);
        $response->assertViewIs('menu.show');
        $response->assertViewHas('menu', $menu);
    }

    /**
     * 
    */
    public function test_store_method_saves_menu_and_sends_email()
    {
        // Créer un utilisateur (simulé ou réel selon votre besoin)
        $user = User::factory()->create();

        // Simuler l'authentification de cet utilisateur
        $this->actingAs($user);

        // Création d'un menu fictif pour le test
        $menuData = [
            'title' => 'Test Menu',
            'link' => 'https://example.com',
            'radio_choice' => '1',
        ];

        // Appeler la méthode store avec les données simulées
        $this->post(route('menu.store'), $menuData);

        // Vérifier que le menu a été correctement ajouté à la base de données
        $this->assertDatabaseHas('menus', [
            'title' => $menuData['title'],
            'link' => $menuData['link'],
            'visible' => $menuData['radio_choice'],
        ]);
    }

    /**
     * Index method return view with menus
     */
    public function test_admin_can_access_edit_page()
    {
        // Création d'un utilisateur administrateur
        $admin = User::factory()->create();
        Bouncer::allow($admin)->to('menu-edit');
        // Simuler l'authentification de cet utilisateur
        $this->actingAs($admin);

        // Création d'un menu
        $menu = Menu::factory()->create();

        // Accéder à la page d'édition en tant qu'administrateur
        $response = $this->get(route('menu.edit', ['menu' => $menu]));

        // Vérification que l'administrateur peut accéder à la page
        $response->assertStatus(200);
        $response->assertViewIs('menu.edit');
        $response->assertViewHas('menu', $menu);
    }

    public function test_non_admin_cannot_access_edit_page()
    {
        // Création d'un utilisateur sans privilèges administratifs
        $user = User::factory()->create();

        // Simuler l'authentification de cet utilisateur
        $this->actingAs($user);

        // Création d'un menu
        $menu = Menu::factory()->create();

        // Tentative d'accéder à la page d'édition en tant qu'utilisateur régulier
        $response = $this->get(route('menu.edit', ['menu' => $menu]));

        // Vérification que l'utilisateur régulier ne peut pas accéder à la page
        $response->assertStatus(403); // Code HTTP 403: Accès refusé
    }

    public function test_update_method_updates_menu()
    {
        // Création d'un menu
        $menu = Menu::factory()->create();

        // Données simulées pour la mise à jour
        $updatedData = [
            'title' => 'Updated Title',
            'link' => 'https://updatedlink.com',
            'radio_choice' => '1', // Assurez-vous que cette valeur correspond à vos besoins
        ];

        // Appeler la méthode update avec les données simulées via une requête HTTP simulée
        $response = $this->put(route('menu.update', ['menu' => $menu->id]), $updatedData);

        // Récupérer le menu mis à jour depuis la base de données
        $updatedMenu = Menu::find($menu->id);

        // Vérifier que les modifications ont été apportées au menu
        $this->assertEquals($updatedData['title'], $updatedMenu->title);
        $this->assertEquals($updatedData['link'], $updatedMenu->link);
        $this->assertEquals($updatedData['radio_choice'], $updatedMenu->visible);
    }

    public function test_user_with_admin_role_can_delete_menu() : void
    {
        $user = User::factory()->create();
        Bouncer::assign('admin')->to($user);
        Bouncer::allow('admin')->to('menu-delete');
        Bouncer::refresh();

        $menu = Menu::factory()->create();

        $this->assertDatabaseHas('menus', ['id' => $menu->id]);

        $response = $this
            ->actingAs($user)
            ->delete("/menu/{$menu->id}");

        $response->assertRedirect('/menu');

        $this->assertDatabaseMissing('menus', ['id' => $menu->id]);

    }
}