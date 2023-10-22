<x-app-layout>
  <div class="container">
    <h1 class="my-5 text-3xl font-bold">Création d'une page</h1>
    <form action="{{ route('page.store') }}" method="post">
      @csrf

      <div class="mb-3">
        <label for="title" class="form-label">Titre</label>
        <input type="text" name="title" id="title" required class="form-control" value="{{ old('title') }}" maxlength="75">
      </div>

      <div class="mb-3">
        <label for="message" class="form-label">Message</label>
        <input type="text" name="message" id="message" required class="form-control" value="{{ old('message') }}">
      </div>

      <div class="mb-3">
        <label class="form-label">Voulez-vous l'afficher ?</label>
        <div class="form-check">
          <input type="radio" name="radio_choice" id="yes" value="1" class="form-check-input">
          <label for="yes" class="form-check-label">Oui</label>
        </div>
        <div class="form-check">
          <input type="radio" name="radio_choice" id="no" value="0" class="form-check-input">
          <label for="no" class="form-check-label">Non</label>
        </div>
      </div>

      <div class="mb-3">
        <label for="submenu">Menu parent</label>
        <select name="submenu_id" id="submenu_id" class="form-select">
          @foreach ($submenus as $submenu)
            <option value="{{ $submenu->id }}">{{ $submenu->title }}</option>
          @endforeach
        </select>
      </div>

      <div class="mb-3">
        <label for="publication_date" class="form-label">Date de publication</label>
        <input type="date" name="publication_date" id="publication_date" class="form-control">
      </div>

      <div>
        <input type="submit" value="Valider" class="btn btn-success">
      </div>
    </form>
  </div>
</x-app-layout>
