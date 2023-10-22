<x-app-layout>
  <div class="container">
    <h1 class="mt-4">Présentation du menu</h1>

    <ul class="list-group mt-4">
      <li class="list-group-item">
        <p class="mb-0">Titre : {{ $menu->title }}</p>
      </li>
      <li class="list-group-item">
        <p class="mb-0">ID : {{ $menu->id }}</p>
      </li>
      <li class="list-group-item">
        <p class="mb-0">Lien : {{ $menu->link }}</p>
      </li>
      <li class="list-group-item">
        <p class="mb-0">
          <em>
            {{ $menu->title ? "Le menu est affiché" : "Le menu n'est pas affiché" }}
          </em>
        </p>
      </li>
    </ul>

    <a href="{{ route('menu.destroy', ['menu' => $menu->id]) }}" class="btn btn-danger mt-3">Supprimer</a>
  </div>
</x-app-layout>
