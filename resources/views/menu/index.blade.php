<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('List of menus') }}
    </h2>
  </x-slot>
  <div class="container">
    @can('menu-create')
      <a href="{{ route('menu.create') }}" class="btn btn-primary mt-5">Ajouter</a>
    @endcan

    <ul class="list-group mt-5">
      @forelse ($menus as $menu)
        <li class="list-group-item">
          <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('menu.show', ['menu' => $menu->id]) }}" class="text-decoration-none text-black">
              {{ $menu->title }} - [{{ $menu->visible ? "Affiché" : "Pas affiché" }}]
            </a>
            <div class="d-flex gap-3">
              @can('menu-edit')
                <a href="{{ route('menu.edit', ['menu' => $menu->id]) }}" class="btn btn-warning btn-sm">Modifier</a>
              @endcan
              @can('menu-delete')
              <form action="{{ route('menu.destroy', $menu) }}" method="post">
                  @csrf
                  @method('DELETE')
                  <input type="submit" value="Supprimer" class="btn btn-danger btn-sm">
              </form>
              @endcan
            </div>
          </div>
        </li>
      @empty
        <li class="list-group-item">
          Aucun menu connu
        </li>
      @endforelse
    </ul>
  </div>
</x-app-layout>
