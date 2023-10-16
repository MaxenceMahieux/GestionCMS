@extends('layouts.app')

@section('title', 'Création d\'un sous-menu')

@section('content')
  <div class="container">
    <h2>Création d'un sous-menu</h2>
    <form action="{{ route('page.update', $page) }}" method="post">
      @csrf
      @method('PUT')

      <div class="mb-3">
        <label for="title" class="form-label">Titre</label>
        <input type="text" name="title" id="title" required class="form-control" value="{{ $page->title }}" required>
      </div>

      <div class="mb-3">
        <label for="message" class="form-label">Message</label>
        <input type="text" name="message" id="message" class="form-control" value="{{ $page->message }}" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Voulez-vous l'afficher ?</label>
        <div class="form-check">
            <input type="radio" name="radio_choice" id="yes" value="1" class="form-check-input" {{ $page->visible == '1' ? 'checked' : '' }}>
            <label for="yes" class="form-check-label">Oui</label>
        </div>
        <div class="form-check">
            <input type="radio" name="radio_choice" id="no" value="0" class="form-check-input" {{ $page->visible == '0' ? 'checked' : '' }}>
            <label for="no" class="form-check-label">Non</label>
        </div>
      </div>

      <div class="mb-3">
        <label for="publication_date" class="form-label">Date de publication</label>
        <input type="date" name="publication_date" id="publication_date" class="form-control" value="{{ $page->publication_date }}">
      </div>

      <div class="mb-3">
        <label for="submenu" class="form-label">Menu parent</label>
        <select name="submenu_id" id="submenu_id" class="form-select" required>
            @foreach ($submenus as $submenu)
                <option value="{{ $submenu->id }}" {{ old('submenu_id', $submenu->id) == $submenu->id ? 'selected' : '' }}>
                    {{ $submenu->title }}
                </option>
            @endforeach
        </select>
      </div>

      <div>
        <input type="submit" value="Valider" class="btn btn-success">
      </div>
    </form>
  </div>
@endsection