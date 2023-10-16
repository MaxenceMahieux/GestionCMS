@extends('layouts.app')

@section('title', 'Création d\'un sous-menu')

@section('content')
  <div class="container">
    <h2>Création d'un sous-menu</h2>
    <form action="{{ route('submenu.update', $submenu) }}" method="post">
      @csrf
      @method('PUT')

      <div class="mb-3">
        <label for="title" class="form-label">Titre</label>
        <input type="text" name="title" id="title" required class="form-control" value="{{ $submenu->title }}" required>
      </div>

      <div class="mb-3">
        <label for="link" class="form-label">Lien</label>
        <input type="text" name="link" id="link" class="form-control" value="{{ $submenu->link }}" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Voulez-vous l'afficher ?</label>
        <div class="form-check">
            <input type="radio" name="radio_choice" id="yes" value="1" class="form-check-input" {{ $submenu->visible == '1' ? 'checked' : '' }}>
            <label for="yes" class="form-check-label">Oui</label>
        </div>
        <div class="form-check">
            <input type="radio" name="radio_choice" id="no" value="0" class="form-check-input" {{ $submenu->visible == '0' ? 'checked' : '' }}>
            <label for="no" class="form-check-label">Non</label>
        </div>
      </div>

      <div class="mb-3">
        <label for="menu" class="form-label">Menu parent</label>
        <select name="menu_id" id="menu_id" class="form-select" required>
            @foreach ($menus as $menu)
                <option value="{{ $menu->id }}" {{ old('menu_id', $menu->id) == $menu->id ? 'selected' : '' }}>
                    {{ $menu->title }}
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