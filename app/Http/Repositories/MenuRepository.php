<?php

namespace App\Http\Repositories;

use App\Models\Menu;
use App\Mail\StoreMenuMail;
use Illuminate\Support\Facades\Mail;
use Auth;

class MenuRepository 
{
    public function store($request) {
        $menu = new Menu();
        $menu->title = $request['title'];
        $menu->link = $request['link'];
        $menu->visible = $request['radio_choice'];
        $menu->save();

        Mail::to(Auth::user()->email)->send(new StoreMenuMail($menu));
    }

    public function update($request, $menu) {
        $menu->title = $request['title'];
        $menu->link = $request['link'];
        $menu->visible = $request['radio_choice'];
        $menu->save();
    }
}