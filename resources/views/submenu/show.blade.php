<x-app-layout>
  <div class="container">
    <h1 class="my-5 text-3xl font-bold">Présentation du menu</h1>

    <ul class="list-group mt-4">
      <li class="list-group-item">
        <p class="mb-0">Titre : {{ $submenu->title }}</p>
      </li>
      <li class="list-group-item">
        <p class="mb-0">ID : {{ $submenu->id }}</p>
      </li>
      <li class="list-group-item">
        <p class="mb-0">Lien : {{ $submenu->link }}</p>
      </li>
      <li class="list-group-item">
        <p class="mb-0">
          <em>
            {{ $submenu->title ? "Le sous-menu est affiché" : "Le sous-menu n'est pas affiché" }}
          </em>
        </p>
      </li>
    </ul>

    <a href="{{ route('submenu.destroy', ['submenu' => $submenu->id]) }}" class="btn btn-danger mt-3">Supprimer</a>
  </div>
</x-app-layout>
