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

class PageControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Index method return view with menus
     */
    public function test_index_method_return_page_view()
    {
        $user = User::factory()->create();
        Bouncer::assign('admin')->to($user);
        $menu = Menu::factory()->create();
        
        $response = $this
            ->actingAs($user)
            ->post("/page", [
                'title' => 'Test update',
                'link' => 'update link',
                'radio_choice' => '1',
                'menu_id' => "{$menu->id}",
            ]);
        // When

        $response = $this->get(route('page.index'));


        // Then

        $response->assertStatus(200);

        $response->assertViewIs('page.index');
    }

    public function test_store_method_saves_submenu()
    {
        $user = User::factory()->create();
        Bouncer::assign('admin')->to($user);

        $menu = Menu::factory()->create();
        
        $submenu = $this
            ->actingAs($user)
            ->post("/submenu", [
                'title' => 'Test update',
                'link' => 'update message',
                'radio_choice' => '1',
                'menu_id' => $menu->id,
            ]);

        $submenuId = Submenu::latest()->first()->id; // Récupérer l'ID du dernier sous-menu créé

        $response = $this
            ->actingAs($user)
            ->post("/page", [
                'title' => 'Test update',
                'message' => 'update message',
                'radio_choice' => '1',
                'publication_date' => fake()->date,
                'menu_id' => $menu->id,
                'submenu_id' => $submenuId, // Utiliser l'ID du sous-menu créé
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect('/page');

        // Vérification si la page a été créée avec succès
        $this->assertDatabaseHas('pages', [
            'title' => 'Test update',
            'message' => 'update message',
            'menu_id' => $menu->id,
            'submenu_id' => $submenuId,
        ]);
    }


    /** @test */
    public function test_editor_can_access_page_create_page()
    {
        $editor = User::factory()->create();
        Bouncer::allow($editor)->to('page-create');
        $this->actingAs($editor);
        $response = $this->get(route('page.create'));
        $response->assertStatus(200);
        $response->assertViewIs('page.create');
        $response->assertViewHas('pages', Page::all());
    }

    /** @test */
    public function test_non_editor_cannot_access_submenu_create_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get(route('page.create'));
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

        $page = Page::factory()->create([
            'title' => 'Test update',
            'message' => 'update message',
            'visible' => '1',
            'publication_date' => fake()->date,
            'menu_id' => $menu->id,
            'submenu_id' => $submenu->id,
        ]);

        $response = $this->get(route('page.show', ['page' => $page->id]));
    
        $response->assertStatus(200);
        $response->assertViewIs('page.show');
        $response->assertViewHas('page', $page);
    }
    
    /**
     * Index method return view with menus
     */
    public function test_editor_can_access_edit_page()
    {
        $menu = Menu::factory()->create();
        // Création d'un utilisateur administrateur
        $editor = User::factory()->create();
        Bouncer::allow($editor)->to('page-edit');
        // Simuler l'authentification de cet utilisateur
        $this->actingAs($editor);

        // Création d'un menu
        $submenu = Submenu::factory()->create([
            'title' => 'Test update',
            'link' => 'update link',
            'menu_id' => $menu->id,
            'visible' => '1',
        ]);

        $page = Page::factory()->create([
            'title' => 'Test update',
            'message' => 'update message',
            'visible' => '1',
            'publication_date' => fake()->date,
            'menu_id' => $menu->id,
            'submenu_id' => $submenu->id,
        ]);

        // Accéder à la page d'édition en tant qu'administrateur
        $response = $this->get(route('page.edit', ['page' => $page]));

        // Vérification que l'administrateur peut accéder à la page
        $response->assertStatus(200);
        $response->assertViewIs('page.edit');
        $response->assertViewHas('page', $page);
    }

    public function test_non_editor_cannot_access_edit_page()
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

        $page = Page::factory()->create([
            'title' => 'Test update',
            'message' => 'update message',
            'visible' => '1',
            'publication_date' => fake()->date,
            'menu_id' => $menu->id,
            'submenu_id' => $submenu->id,
        ]);

        // Tentative d'accéder à la page d'édition en tant qu'utilisateur régulier
        $response = $this->get(route('page.edit', ['page' => $page]));

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

        $page = Page::factory()->create([
            'title' => 'Test update',
            'message' => 'update message',
            'visible' => '1',
            'publication_date' => fake()->date,
            'menu_id' => $menu->id,
            'submenu_id' => $submenu->id,
        ]);

        // Données simulées pour la mise à jour
        $updatedData = [
            'title' => 'Test update 2',
            'message' => 'update message 2',
            'radio_choice' => '0',
            'publication_date' => fake()->date,
            'menu_id' => $menu->id,
            'submenu_id' => $submenu->id,
        ];

        // Appeler la méthode update avec les données simulées via une requête HTTP simulée
        $response = $this->put(route('page.update', ['page' => $page->id]), $updatedData);

        // Récupérer le menu mis à jour depuis la base de données
        $updatedPage = Page::find($page->id);

        // Vérifier que les modifications ont été apportées au menu
        $this->assertEquals($updatedData['title'], $updatedPage->title);
        $this->assertEquals($updatedData['message'], $updatedPage->message);
        $this->assertEquals($updatedData['radio_choice'], $updatedPage->visible);
        $this->assertEquals($updatedData['publication_date'], $updatedPage->publication_date);
        $this->assertEquals($updatedData['menu_id'], $updatedPage->menu_id);
        $this->assertEquals($updatedData['submenu_id'], $updatedPage->submenu_id);
    }

    public function test_user_with_editor_role_can_delete_menu() : void
    {
        
        $editor = User::factory()->create();
        Bouncer::allow($editor)->to('page-delete');
        // Simuler l'authentification de cet utilisateur

        $menu = Menu::factory()->create();

        $submenu = Submenu::factory()->create([
            'title' => 'Test update',
            'link' => 'update link',
            'menu_id' => $menu->id,
            'visible' => '1',
        ]);

        $page = Page::factory()->create([
            'title' => 'Test update',
            'message' => 'update message',
            'visible' => '1',
            'publication_date' => fake()->date,
            'menu_id' => $menu->id,
            'submenu_id' => $submenu->id,
        ]);

        $this->assertDatabaseHas('pages', ['id' => $page->id]);

        $response = $this
            ->actingAs($editor)
            ->delete("/page/{$page->id}");

        $response->assertRedirect('/page');

        $this->assertDatabaseMissing('pages', ['id' => $page->id]);

    }
}