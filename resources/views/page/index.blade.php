<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('List of pages') }}
    </h2>
  </x-slot>
  <div class="container">
    
    @can('page-create')
      <x-add-button :route="route('page.create')" />
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
                  <x-edit-button :route="route('page.edit', ['page' => $page->id])"/>
                @endcan
                @can('page-delete')
                  <x-delete-button :route="route('page.destroy', $page)" />
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
