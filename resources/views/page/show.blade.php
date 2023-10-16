@extends('layouts.app')

@section('title', 'Menu')

@section('content')
  <div class="container">
    <h1 class="mt-4">Présentation d'une page</h1>

    <ul class="list-group mt-4">
      <li class="list-group-item">
        <p class="mb-0">Titre : {{ $page->title }}</p>
      </li>
      <li class="list-group-item">
        <p class="mb-0">ID : {{ $page->id }}</p>
      </li>
      <li class="list-group-item">
        <p class="mb-0">Message : {{ $page->message }}</p>
      </li>
      <li class="list-group-item">
        <p class="mb-0">Date de publication : {{ $page->publication_date }}</p>
      </li>
      <li class="list-group-item">
        <p class="mb-0">
          <em>
            {{ $page->title ? "Le page est publiée" : "Le page n'est pas publiée" }}
          </em>
        </p>
      </li>
    </ul>

    <a href="{{ route('page.destroy', ['page' => $page->id]) }}" class="btn btn-danger mt-3">Supprimer</a>
  </div>
@endsection
