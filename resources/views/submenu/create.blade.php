<x-app-layout>
  <div class="container">
    <h1 class="my-5 text-3xl font-bold">Création d'un sous-menu</h1>
    <form action="{{ route('submenu.store') }}" method="post">
      @csrf

      <div class="mb-3">
        <label for="title" class="form-label">Titre</label>
        <input type="text" name="title" id="title" required class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="link" class="form-label">Lien</label>
        <input type="text" name="link" id="link" class="form-control" required>
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
        <label for="menu" class="form-label">Menu parent</label>
        <select name="menu_id" id="menu_id" class="form-select" required>
          @foreach ($menus as $menu)
            <option value="{{ $menu->id }}">{{ $menu->title }}</option>
          @endforeach
        </select>
      </div>

      <div>
        <input type="submit" value="Valider" class="btn btn-success">
      </div>
    </form>
  </div>
</x-app-layout>
