<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title', 50);
            $table->text('link');
            $table->boolean('visible');
        });

        Schema::create('submenus', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title', 50);
            $table->text('link');
            $table->boolean('visible');
            $table->integer('menu_id');
        });

        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title', 50);
            $table->text('message');
            $table->boolean('visible');
            $table->integer('menu_id');
            $table->integer('submenu_id');
            $table->date('publication_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
        Schema::dropIfExists('submenus');
        Schema::dropIfExists('pages');
    }
};
