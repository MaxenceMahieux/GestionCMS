@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
  <div class="container">
    <h1 class="mb-5">Arborescense des menus</h1>
    <ul class="list-group">
      @forelse ($menus as $menu)
        <li class="list-group-item">
          <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('menu.show', ['menu' => $menu->id]) }}" class="text-decoration-none text-black">
              {{ $menu->title }} - {{ $menu->pages->where('visible', 1)->count() }} page(s) associée(s)
            </a>
          </div>
        </li>
      @empty
        <li class="list-group-item">
          Aucun menu connu
        </li>
      @endforelse
    </ul>
    <p class="m-3">{{ $menu->where('visible', 0)->count() }} menus non affichés et {{ $pages->where('visible', 0)->count() }} pages non publiées</p>
  </div>
@endsection
