@extends('layouts.app')

@section('title', 'Liste des sous -menus')

@section('content')
  <a href="{{ route('submenu.create') }}" class="btn btn-primary">Ajouter</a>
  <ul>
    @forelse ($submenus as $submenu)
      <li>
          <div>
            {{ $submenu->title }} - [{{ $submenu->visible ? "Affiché" : "Pas affiché" }}]
          <a href="{{ route('submenu.edit', ['submenu' => $submenu->id]) }}" class="btn btn-sm btn-warning">Modifier</a>
        </div>
      </li>
    @empty
      <li>
        Aucun sous-menu connu
      </li>
    @endforelse
  </ul>
@endsection
