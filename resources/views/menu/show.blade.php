@extends('layouts.app')

@section('title', 'Menu')

@section('content')
  <h1>Présentation de la matière</h1>

  <h2>Intitulé</h2>
  <p>{{ $menu->title }}</p>

  {{-- <h2>Nombre de professeurs {{ $menu->professeurs->count() }}</h2> --}}
  <ul>
    @forelse ($submenu->menus as $menu)
      <li>
        <p>{{ $menu->title }}</p>
      </li>
    @empty
      <li>
        <p>Aucun enseignant pour cette matière</p>
      </li>
    @endforelse
  </ul>
@endsection
