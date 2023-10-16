<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Page;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        $menus = Menu::all();
        $pages = Page::all();
        return view('index', compact('menus', 'pages'));
    }
}
