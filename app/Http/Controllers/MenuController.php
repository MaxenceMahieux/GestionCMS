<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Page;
use App\Models\Submenu;
use App\Http\Requests\MenuRequest;
use Silber\Bouncer\Bouncer;

class MenuController extends Controller
{
    public function __construct()
    {
        // Middleware can pour vérifier l'autorisation "menu-create"
        $this->middleware('can:menu-create')->only('create');

        // Middleware can pour vérifier l'autorisation "menu-edit"
        $this->middleware('can:menu-edit')->only('edit');
        
        // Middleware can pour vérifier l'autorisation "menu-delete"
        $this->middleware('can:menu-delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::all();
        return view('menu.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menus = Menu::all();
        return view('menu.create', compact('menus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MenuRequest $request)
    {
        $data = $request->all();
        $menu = new Menu();
        $menu->title = $data['title'];
        $menu->link = $data['link'];
        $menu->visible = $data['radio_choice'];
        $menu->save();
        $menus = Menu::all();
        return view('menu.index', compact('menus'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        return view('menu.show', compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        return view('menu.edit', compact('menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MenuRequest $request, Menu $menu)
    {
        $data = $request->all();
        $menu->title = $data['title'];
        $menu->link = $data['link'];
        $menu->visible = $data['radio_choice'];
        $menu->save();
        return redirect()->route('menu.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu, Submenu $submenu)
    {
        $submenus = Submenu::where('menu_id', $menu->id)->get();
        foreach ($submenus as $submenu) {
            $pages = Page::where('submenu_id', $submenu->id)->get();
            foreach ($pages as $page) {
                $page->delete();
            }
            $submenu->delete();
        }
        $menu->delete();

        return redirect()->route('menu.index');
    }
}
