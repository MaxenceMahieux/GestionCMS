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
                'menu_id' => $menu->id,
            ]);

        $response = $this->get(route('page.index'));
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

        $submenuId = Submenu::latest()->first()->id;

        $response = $this
            ->actingAs($user)
            ->post("/page", [
                'title' => 'Test update',
                'message' => 'update message',
                'radio_choice' => '1',
                'publication_date' => fake()->date,
                'menu_id' => $menu->id,
                'submenu_id' => $submenuId,
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect('/page');

        $this->assertDatabaseHas('pages', [
            'title' => 'Test update',
            'message' => 'update message',
            'menu_id' => $menu->id,
            'submenu_id' => $submenuId,
        ]);
    }


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

    public function test_non_editor_cannot_access_submenu_create_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get(route('page.create'));
        $response->assertStatus(403);
    }

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

    public function test_editor_can_access_edit_page()
    {
        $menu = Menu::factory()->create();
        $editor = User::factory()->create();
        Bouncer::allow($editor)->to('page-edit');
        $this->actingAs($editor);

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

        $response = $this->get(route('page.edit', ['page' => $page]));

        $response->assertStatus(200);
        $response->assertViewIs('page.edit');
        $response->assertViewHas('page', $page);
    }

    public function test_non_editor_cannot_access_edit_page()
    {
        $menu = Menu::factory()->create();
        $user = User::factory()->create();

        $this->actingAs($user);

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

        $response = $this->get(route('page.edit', ['page' => $page]));

        $response->assertStatus(403);
    }

    public function test_update_method_updates_menu()
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

        $updatedData = [
            'title' => 'Test update 2',
            'message' => 'update message 2',
            'radio_choice' => '0',
            'publication_date' => fake()->date,
            'menu_id' => $menu->id,
            'submenu_id' => $submenu->id,
        ];

        $response = $this->put(route('page.update', ['page' => $page->id]), $updatedData);

        $updatedPage = Page::find($page->id);

        $this->assertEquals($updatedData['title'], $updatedPage->title);
        $this->assertEquals($updatedData['message'], $updatedPage->message);
        $this->assertEquals($updatedData['radio_choice'], $updatedPage->visible);
        $this->assertEquals($updatedData['publication_date'], $updatedPage->publication_date);
        $this->assertEquals($updatedData['menu_id'], $updatedPage->menu_id);
        $this->assertEquals($updatedData['submenu_id'], $updatedPage->submenu_id);
    }

    public function test_editor_can_delete_menu() : void
    {
        
        $editor = User::factory()->create();
        Bouncer::allow($editor)->to('page-delete');

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