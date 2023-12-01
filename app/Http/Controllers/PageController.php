<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Submenu;
use App\Http\Requests\PageRequest;
use App\Http\Repositories\PageRepository;

class PageController extends Controller
{
    private $repository;

    public function __construct(PageRepository $repository)
    {
        // Middleware can pour vérifier l'autorisation "page-create"
        $this->middleware('can:page-create')->only('create');

        // Middleware can pour vérifier l'autorisation "page-edit"
        $this->middleware('can:page-edit')->only('edit');
        
        // Middleware can pour vérifier l'autorisation "page-delete"
        $this->middleware('can:page-delete')->only('destroy');

        $this->repository = $repository;
    }

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
    public function store(PageRequest $request, Submenu $submenu)
    {
        $this->repository->store($request);
        return redirect()->route('page.index');
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
        $this->repository->update($request, $page);
        return redirect()->route('page.index');
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
