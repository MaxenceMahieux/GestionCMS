<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('List of submenus') }}
    </h2>
  </x-slot>
  <div class="container">
    
    @can('submenu-create')
      <x-add-button :route="route('submenu.create')" />
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
                  <x-edit-button :route="route('submenu.edit', ['submenu' => $submenu->id])"/>
                @endcan
                @can('submenu-delete')
                  <x-delete-button :route="route('submenu.destroy', $submenu)" />
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
