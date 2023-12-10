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
        $menus = Menu::factory()->count(3)->create();
        $menu = Menu::factory()->create();
        $submenu = Submenu::factory()->create();
        $page = Page::factory()->create([
            'title' => 'Test update',
            'message' => 'update message',
            'visible' => '1',
            'publication_date' => now(),
            'menu_id' => $menu->id,
            'submenu_id' => $submenu->id,
        ]);

        $menus[] = $menu;

        $response = $this->get(route('index'));
        $response->assertStatus(200);
        $response->assertViewIs('index');
        $response->assertViewHas('menus', $menus);
        $response->assertViewHas('pages', function ($viewPages) use ($page) {
            return $viewPages->contains($page);
        });
    }



}