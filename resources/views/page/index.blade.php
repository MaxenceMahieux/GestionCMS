@extends('layouts.app')

@section('title', 'Liste des pages')

@section('content')
  <a href="{{ route('page.create') }}" class="btn btn-primary">Ajouter</a>
  <ul>
    @forelse ($pages as $page)
      <li>
          <div>
            {{ $page->title }} - [{{ $page->visible ? "Affiché" : "Pas affiché" }}]
          <a href="{{ route('page.edit', ['page' => $page->id]) }}" class="btn btn-sm btn-warning">Modifier</a>
        </div>
      </li>
    @empty
      <li>
        Aucune page connu
      </li>
    @endforelse
  </ul>
@endsection
