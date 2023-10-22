<x-app-layout>
  <div class="container">
    <h1 class="my-5 text-3xl font-bold">Liste des pages</h1>
    <a href="{{ route('page.create') }}" class="btn btn-primary mb-3">Ajouter</a>

    <ul class="list-group">
      @forelse ($pages as $page)
        <li class="list-group-item">
          <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('page.show', ['page' => $page->id]) }}" class="text-decoration-none text-black">
              {{ $page->title }} - [{{ $page->visible ? "Affiché" : "Pas affiché" }}]
            </a>
            <div class="d-flex gap-3">
                <a href="{{ route('page.edit', ['page' => $page->id]) }}" class="btn btn-warning btn-sm">Modifier</a>
                <form action="{{ route('page.destroy', $page) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="Supprimer" class="btn btn-danger btn-sm">
                </form>
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
