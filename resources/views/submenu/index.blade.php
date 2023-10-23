<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('List of submenus') }}
    </h2>
  </x-slot>
  <div class="container">
    
    @can('submenu-create')
      <a href="{{ route('submenu.create') }}" class="btn btn-primary mt-5">Ajouter</a>
    @endcan

    <ul class="list-group mt-5">
      @forelse ($submenus as $submenu)
        <li class="list-group-item">
          <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('submenu.show', ['submenu' => $submenu->id]) }}" class="text-decoration-none text-black">
              {{ $submenu->title }} - [{{ $submenu->visible ? "Affiché" : "Pas affiché" }}]
            </a>
            <div class="d-flex gap-3">
                @can('submenu-edit')
                  <a href="{{ route('submenu.edit', ['submenu' => $submenu->id]) }}" class="btn btn-warning btn-sm">Modifier</a>
                @endcan
                @can('submenu-delete')
                  <form action="{{ route('submenu.destroy', $submenu) }}" method="post">
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
          Aucun sous-menu connu
        </li>
      @endforelse
    </ul>
  </div>
</x-app-layout>
