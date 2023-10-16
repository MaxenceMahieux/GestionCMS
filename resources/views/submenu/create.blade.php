@extends('layouts.app')

@section('title', 'Création d\'un sous-menu')

@section('content')
  <h2>Création d'un sous-menu</h2>
  <form action="{{ route('submenu.store') }}" method="post">

    @csrf

    <div>
      <label for="title">Titre</label>
      <input type="text" name="title" id="title" required value="{{ old('title') }}" maxlength="75">
    </div>

    <div>
      <label for="link">Lien</label>
      <input type="text" name="link" id="link" required value="{{ old('link') }}">
    </div>

    <div>
        <fieldset @required(true)>
            <label for="visible">Voulez-vous l'afficher ?</label>
            <input type="radio" name="radio_choice" id="yes" value="1"><label for="yes">Oui</label>
            <input type="radio" name="radio_choice" id="no" value="0"><label for="no">Non</label><br/>
        </fieldset>
    </div>

    <div>
        <label for="menu">Menu parent</label>
        <select name="menu_id" id="menu_id">
          @foreach ($menus as $menu)
            <option value="{{ $menu->id }}">{{ $menu->title }}</option>
          @endforeach
        </select>
    </div>


    <div>
      <input type="submit" value="Valider" class="btn btn-success">
    </div>

  </form>
@endsection
