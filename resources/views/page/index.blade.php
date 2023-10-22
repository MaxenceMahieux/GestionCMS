<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Liste des menus') }}
    </h2>
  </x-slot>
  <div class="container">
    
    @can('page-create')
      <a href="{{ route('page.create') }}" class="btn btn-primary mt-5">Ajouter</a>
    @endcan

    <ul class="list-group mt-5">
      @forelse ($pages as $page)
        <li class="list-group-item">
          <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('page.show', ['page' => $page->id]) }}" class="text-decoration-none text-black">
              {{ $page->title }} - [{{ $page->visible ? "Affiché" : "Pas affiché" }}]
            </a>
            <div class="d-flex gap-3">
                @can('page-edit')
                  <a href="{{ route('page.edit', ['page' => $page->id]) }}" class="btn btn-warning btn-sm">Modifier</a>
                @endcan
                @can('page-delete')
                  <form action="{{ route('page.destroy', $page) }}" method="post">
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
          Aucune page connue
        </li>
      @endforelse
    </ul>
  </div>
</x-app-layout>
