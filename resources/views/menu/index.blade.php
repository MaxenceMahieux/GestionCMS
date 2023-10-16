@extends('layouts.app')

@section('title', 'Liste des menus')

@section('content')
  <div class="container">
    <h1 class="mb-5">Liste des menus</h1>
    <a href="{{ route('menu.create') }}" class="btn btn-primary mb-3">Ajouter</a>

    <ul class="list-group">
      @forelse ($menus as $menu)
        <li class="list-group-item">
          <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('menu.show', ['menu' => $menu->id]) }}" class="text-decoration-none text-black">
              {{ $menu->title }} - [{{ $menu->visible ? "Affiché" : "Pas affiché" }}]
            </a>
            <a href="{{ route('menu.edit', ['menu' => $menu->id]) }}" class="btn btn-warning btn-sm">Modifier</a>
          </div>
        </li>
      @empty
        <li class="list-group-item">
          Aucun menu connu
        </li>
      @endforelse
    </ul>
  </div>
@endsection
