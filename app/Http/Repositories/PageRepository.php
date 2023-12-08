<?php

namespace App\Http\Repositories;

use App\Models\Page;
use App\Models\Submenu;
use App\Mail\StorePageMail;
use App\Mail\EditPageMail;
use Illuminate\Support\Facades\Mail;
use Auth;

class PageRepository 
{
    public function store($request) {
        $page = new Page();

        $page->title = $request['title'];
        $page->message = $request['message'];
        $page->visible = $request['radio_choice'];
        $page->publication_date = $request['publication_date'];
        $submenu = Submenu::find($request['submenu_id']);
        $page->menu_id = $submenu->menu_id;
        $page->submenu_id = $submenu->id;
        $page->save();

        Mail::to(Auth::user()->email)->send(new StorePageMail($page));
    }

    public function update($request, $page) {
        $page->title = $request['title'];
        $page->message = $request['message'];
        $page->visible = $request['radio_choice'];
        $page->publication_date = $request['publication_date'];
        $submenu = Submenu::find($request['submenu_id']);
        $page->menu_id = $submenu->menu_id;
        $page->submenu_id = $submenu->id;
        $page->save();

        Mail::to(Auth::user()->email)->send(new EditPageMail($page));
    }
}