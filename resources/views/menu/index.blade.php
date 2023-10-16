@extends('layouts.app')

@section('title', 'Liste des menus')

@section('content')
  <a href="{{ route('menu.create') }}" class="btn btn-primary">Ajouter</a>
  <ul>
    @forelse ($menus as $menu)
      <li>
          <div>
            {{ $menu->title }} - [{{ $menu->visible ? "Affiché" : "Pas affiché" }}]
          <a href="{{ route('menu.edit', ['menu' => $menu->id]) }}" class="btn btn-sm btn-warning">Modifier</a>
        </div>
      </li>
    @empty
      <li>
        Aucun menu connu
      </li>
    @endforelse
  </ul>
@endsection
