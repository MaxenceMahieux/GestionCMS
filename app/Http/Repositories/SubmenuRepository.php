<?php

namespace App\Http\Repositories;

use App\Models\Submenu;
use App\Mail\StoreMenuMail;
use Illuminate\Support\Facades\Mail;
use Auth;

class SubmenuRepository 
{
    public function store($request) {
        $submenu = new Submenu();
        $submenu->title = $request['title'];
        $submenu->link = $request['link'];
        $submenu->visible = $request['radio_choice'];
        $submenu->menu_id = $request['menu_id'];
        $submenu->save();

        /* Mail::to(Auth::user()->email)->send(new StoreMenuMail($menu)); */
    }

    public function update($request, $submenu) {
        $submenu->title = $request['title'];
        $submenu->link = $request['link'];
        $submenu->visible = $request['radio_choice'];
        $submenu->save();
    }
}