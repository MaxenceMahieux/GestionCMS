<x-app-layout>
  <div class="container">
    <h1 class="my-5 text-3xl font-bold">Création d'un menu</h1>
    <form action="{{ route('menu.store') }}" method="post">
      @csrf

      <div class="mb-3">
        <label for="title" class="form-label">Titre</label>
        <x-input-text property="title" />
      </div>

      <div class="mb-3">
        <label for="link" class="form-label">Lien</label>
        <x-input-text property="link" />
      </div>

      <x-input-radio />

      <div>
        <input type="submit" value="Valider" class="btn btn-success">
      </div>
    </form>
  </div>
</x-app-layout>
