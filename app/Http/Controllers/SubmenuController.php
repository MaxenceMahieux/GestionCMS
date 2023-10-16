<?php

namespace App\Http\Controllers;

use App\Models\Submenu;
use App\Models\Menu;
use Illuminate\Http\Request;

class SubmenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $submenus = Submenu::all();
        return view('submenu.index', compact('submenus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menus = Menu::all();
        $submenus = Submenu::all();
        return view('submenu.create', compact('submenus', 'menus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $menu = new Submenu();
        $menu->title = $data['title'];
        $menu->link = $data['link'];
        $menu->visible = $data['radio_choice'];
        $menu->menu_id = $data['menu_id'];
        $menu->save();
        $submenus = Submenu::all();
        return view('submenu.index', compact('submenus'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
