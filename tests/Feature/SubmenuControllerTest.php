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

        $response = $this->get(route('submenu.index'));

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

    public function test_non_admin_cannot_access_submenu_create_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get(route('submenu.create'));
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
    
        $response = $this->get(route('submenu.show', ['submenu' => $submenu->id]));
    
        $response->assertStatus(200);
        $response->assertViewIs('submenu.show');
        $response->assertViewHas('submenu', $submenu);
    }
    
    public function test_admin_can_access_edit_page()
    {
        $menu = Menu::factory()->create();
        $admin = User::factory()->create();
        Bouncer::allow($admin)->to('submenu-edit');
        $this->actingAs($admin);

        $submenu = Submenu::factory()->create([
            'title' => 'Test update',
            'link' => 'update link',
            'menu_id' => $menu->id,
            'visible' => '1',
        ]);

        $response = $this->get(route('submenu.edit', ['submenu' => $submenu]));

        $response->assertStatus(200);
        $response->assertViewIs('submenu.edit');
        $response->assertViewHas('submenu', $submenu);
    }

    public function test_non_admin_cannot_access_edit_page()
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

        $response = $this->get(route('submenu.edit', ['submenu' => $submenu]));
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

        $updatedData = [
            'title' => 'Test update2',
            'link' => 'update link 2',
            'menu_id' => $menu->id,
            'radio_choice' => '0',
        ];

        $response = $this->put(route('submenu.update', ['submenu' => $submenu->id]), $updatedData);

        $updatedSubmenu = Submenu::find($submenu->id);

        $this->assertEquals($updatedData['title'], $updatedSubmenu->title);
        $this->assertEquals($updatedData['link'], $updatedSubmenu->link);
        $this->assertEquals($updatedData['radio_choice'], $updatedSubmenu->visible);
    }

    public function test_user_with_admin_role_can_delete_menu() : void
    {
        $user = User::factory()->create();
        Bouncer::allow($user)->to('submenu-delete');

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