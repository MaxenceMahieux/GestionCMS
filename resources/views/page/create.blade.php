@extends('layouts.app')

@section('title', 'Création d\'une page')

@section('content')
  <h2>Création d'une page</h2>
  <form action="{{ route('page.store') }}" method="post">

    @csrf

    <div>
      <label for="title">Titre</label>
      <input type="text" name="title" id="title" required value="{{ old('title') }}" maxlength="75">
    </div>

    <div>
      <label for="message">Message</label>
      <input type="text" name="message" id="message" required value="{{ old('message') }}">
    </div>

    <div>
        <fieldset @required(true)>
            <label for="visible">Voulez-vous l'afficher ?</label>
            <input type="radio" name="radio_choice" id="yes" value="1"><label for="yes">Oui</label>
            <input type="radio" name="radio_choice" id="no" value="0"><label for="no">Non</label><br/>
        </fieldset>
    </div>

    <div>
        <label for="menu">Sous-menu parent</label>
        <select name="menu_id" id="menu_id">
          @foreach ($submenus as $submenu)
            <option value="{{ $submenu->id }}">{{ $submenu->title }}</option>
          @endforeach
        </select>
    </div>


    <div>
      <input type="submit" value="Valider" class="btn btn-success">
    </div>

  </form>
@endsection
