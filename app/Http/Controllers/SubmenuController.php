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
        $submenu = new Submenu();
        $submenu->title = $data['title'];
        $submenu->link = $data['link'];
        $submenu->visible = $data['radio_choice'];
        $submenu->menu_id = $data['menu_id'];
        $submenu->save();

        return redirect()->route('submenu.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Submenu $submenu)
    {
        return view('submenu.show', compact('submenu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Submenu $submenu)
    {
        $menus = Menu::all();
        return view('submenu.edit', compact('submenu', 'menus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Submenu $submenu)
    {
        $data = $request->all();
        $submenu->title = $data['title'];
        $submenu->link = $data['link'];
        $submenu->visible = $data['radio_choice'];
        $submenu->save();
        return redirect()->route('submenu.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
