<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    public function submenus()
    {
        return $this->hasMany(Submenu::class);
    }

    public function pages()
    {
        return $this->hasMany(Page::class, 'menu_id');
    }
}
