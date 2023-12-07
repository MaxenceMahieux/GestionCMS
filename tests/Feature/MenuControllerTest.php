<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Bouncer;

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
        Menu::factory()->count(3)->create();
        $response = $this->get(route('menu.show'));
        $response->assertStatus(200);
        $response->assertViewIs('menu.show');
        $response->assertViewHas('menus', compact('menu'));
    }
}
