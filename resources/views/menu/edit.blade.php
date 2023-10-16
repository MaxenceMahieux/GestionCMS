@extends('layouts.app')

@section('content')
  <h2>Mise à jour</h2>
  <form action="{{ route('matiere.update', ['matiere' => $matiere->id]) }}" method="post">

    @csrf
    @method('put')

    <div>
      <label for="libelle">Libellé</label>
      <input type="text" name="libelle" id="libelle" value="{{ old('libelle', $matiere->libelle) }}" required maxlength="75">
      @error('libelle')
        <p class="text-danger">{{ $message }}</p>
      @enderror
    </div>

    <div>
      <label for="niveau">Niveau</label>
      <input type="text" name="niveau" id="niveau" value="{{ old('niveau', $matiere->niveau) }}" required maxlength="20">
      @error('niveau')
        <p class="text-danger">{{ $message }}</p>
      @enderror
    </div>

    <div>
      <input type="submit" value="Valider" class="btn btn-success">
    </div>

  </form>
@endsection
