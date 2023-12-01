<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Home') }}
    </h2>
  </x-slot>

  <div class="container">
    <ul class="list-group mt-5">
      @forelse ($menus as $menu)
        <li class="list-group-item">
          <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('menu.show', ['menu' => $menu->id]) }}" class="text-decoration-none text-black">
              {{ $menu->title }} - {{ $menu->pages->where('visible', 1)->count() }} page(s) associée(s)
            </a>
          </div>
        </li>
      @empty
        <li class="list-group-item">
          Aucun menu connu
        </li>
      @endforelse
    </ul>
    <p class="m-3">{{ $menus->where('visible', 0)->count() }} menus non affichés et {{ $pages->where('visible', 0)->count() }} pages non publiées</p>
  </div>
</x-app-layout>
