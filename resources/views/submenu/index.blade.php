@extends('layouts.app')

@section('title', 'Liste des sous-menus')

@section('content')
  <div class="container">
    <h1 class="mb-5">Liste des sous-menus</h1>
    <a href="{{ route('submenu.create') }}" class="btn btn-primary mb-3">Ajouter</a>

    <ul class="list-group">
      @forelse ($submenus as $submenu)
        <li class="list-group-item">
          <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('submenu.show', ['submenu' => $submenu->id]) }}" class="text-decoration-none text-black">
              {{ $submenu->title }} - [{{ $submenu->visible ? "Affiché" : "Pas affiché" }}]
            </a>
            <div class="d-flex gap-3">
                <a href="{{ route('submenu.edit', ['submenu' => $submenu->id]) }}" class="btn btn-warning btn-sm">Modifier</a>
                <form action="{{ route('submenu.destroy', $submenu) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="Supprimer" class="btn btn-danger btn-sm">
                </form>
            </div>
          </div>
        </li>
      @empty
        <li class="list-group-item">
          Aucun sous-menu connu
        </li>
      @endforelse
    </ul>
  </div>
@endsection
