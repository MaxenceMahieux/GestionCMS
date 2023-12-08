<?php

namespace App\Http\Controllers;

use App\Models\Submenu;
use App\Models\Menu;
use App\Models\Page;
use App\Http\Requests\SubmenuRequest;
use App\Http\Repositories\SubmenuRepository;
use App\Mail\DeleteSubmenuMail;
use Illuminate\Support\Facades\Mail;
use Auth;

class SubmenuController extends Controller
{
    private $repository;

    public function __construct(SubmenuRepository $repository)
    {
        // Middleware can pour vérifier l'autorisation "submenu-create"
        $this->middleware('can:submenu-create')->only('create');

        // Middleware can pour vérifier l'autorisation "submenu-edit"
        $this->middleware('can:submenu-edit')->only('edit');
        
        // Middleware can pour vérifier l'autorisation "submenu-delete"
        $this->middleware('can:submenu-delete')->only('destroy');

        $this->repository = $repository;
    }

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
    public function store(SubmenuRequest $request)
    {
        $this->repository->store($request);
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
    public function update(SubmenuRequest $request, Submenu $submenu)
    {
        $this->repository->update($request, $submenu);
        return redirect()->route('submenu.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page, Submenu $submenu)
    {
        $pages = Page::where('submenu_id', $submenu->id)->get();
        foreach ($pages as $page) {
            $page->delete();
        }
        $submenu->delete();

        return redirect()->route('submenu.index');
    }
}
