<x-app-layout>
  <div class="container">
    <h1 class="mt-4">Présentation du menu</h1>

    <ul class="list-group my-4">
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
    @can('menu-delete')
    <form action="{{ route('menu.destroy', $menu) }}" method="post">
        @csrf
        @method('DELETE')
        <input type="submit" value="Supprimer" class="btn btn-danger btn-sm">
    </form>
    @endcan
  </div>
</x-app-layout>
