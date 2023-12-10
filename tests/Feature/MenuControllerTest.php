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

    public function test_index_method_returns_view_with_menus()
    {
        Menu::factory()->count(3)->create();
        $response = $this->get(route('menu.index'));
        $response->assertStatus(200);
        $response->assertViewIs('menu.index');
        $response->assertViewHas('menus', Menu::all());
    }

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

    public function test_non_admin_cannot_access_menu_create_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get(route('menu.create'));
        $response->assertStatus(403);
    }

    public function test_show_method_returns_view_with_menu()
    {
        $menu = Menu::factory()->create();
        $response = $this->get(route('menu.show', ['menu' => $menu]));
        $response->assertStatus(200);
        $response->assertViewIs('menu.show');
        $response->assertViewHas('menu', $menu);
    }

    public function test_store_method_saves_menu_and_sends_email()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $menuData = [
            'title' => 'Test Menu',
            'link' => 'https://example.com',
            'radio_choice' => '1',
        ];

        $this->post(route('menu.store'), $menuData);

        $this->assertDatabaseHas('menus', [
            'title' => $menuData['title'],
            'link' => $menuData['link'],
            'visible' => $menuData['radio_choice'],
        ]);
    }

    public function test_admin_can_access_edit_page()
    {
        $admin = User::factory()->create();
        Bouncer::allow($admin)->to('menu-edit');
        $this->actingAs($admin);

        $menu = Menu::factory()->create();
        $response = $this->get(route('menu.edit', ['menu' => $menu]));

        $response->assertStatus(200);
        $response->assertViewIs('menu.edit');
        $response->assertViewHas('menu', $menu);
    }

    public function test_non_admin_cannot_access_edit_page()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $menu = Menu::factory()->create();

        $response = $this->get(route('menu.edit', ['menu' => $menu]));
        $response->assertStatus(403);
    }

    public function test_update_method_updates_menu()
    {
        $menu = Menu::factory()->create();

        $updatedData = [
            'title' => 'Updated Title',
            'link' => 'https://updatedlink.com',
            'radio_choice' => '1',
        ];

        $response = $this->put(route('menu.update', ['menu' => $menu->id]), $updatedData);

        $updatedMenu = Menu::find($menu->id);

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

        $response = $this->get(route('page.index'));
        $response->assertStatus(200);
        $response->assertViewIs('page.index');
    }
}