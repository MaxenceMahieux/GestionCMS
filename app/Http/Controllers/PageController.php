<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Submenu;
use App\Http\Requests\PageRequest;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pages = Page::all();
        return view('page.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pages = Page::all();
        $submenus = Submenu::all();
        return view('page.create', compact('pages', 'submenus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PageRequest $request)
    {
        $data = $request->all();

        $page = new Page();

        $page->title = $data['title'];
        $page->message = $data['message'];
        $page->visible = $data['radio_choice'];
        $page->publication_date = $data['publication_date'];
        $submenu = Submenu::find($data['submenu_id']);

        if ($submenu) {
            $page->menu_id = $submenu->menu_id;
            $page->submenu_id = $submenu->id;
            $page->save();

            return redirect()->route('page.index');
        } else {
            abort('404');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Page $page)
    {
        return view('page.show', compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
        $submenus = Submenu::all();
        return view('page.edit', compact('page', 'submenus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PageRequest $request, Page $page)
    {
        $data = $request->all();
        $page->title = $data['title'];
        $page->message = $data['message'];
        $page->visible = $data['radio_choice'];
        $page->publication_date = $data['publication_date'];
        $submenu = Submenu::find($data['submenu_id']);

        if ($submenu) {
            $page->menu_id = $submenu->menu_id;
            $page->submenu_id = $submenu->id;
            $page->save();

            return redirect()->route('page.index');
        } else {
            abort('404');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('page.index');
    }
}
