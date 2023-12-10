<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('List of menus') }}
    </h2>
  </x-slot>
  <div class="container">
    @can('menu-create')
      <x-add-button :route="route('menu.create')" />
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
                <x-edit-button :route="route('menu.edit', ['menu' => $menu->id])"/>
              @endcan
              @can('menu-delete')
                <x-delete-button :route="route('menu.destroy', $menu)" />
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
