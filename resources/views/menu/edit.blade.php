<x-app-layout>
  <div class="container">
    <h1 class="my-5 text-3xl font-bold">{{ __('Editing menu') }}</h1>
    <form action="{{ route('menu.update', $menu) }}" method="post">
      @csrf
      @method('PUT')

      <div class="mb-3">
        <label for="title" class="form-label">Titre</label>
        <x-input-text property="title" :value="$menu->title" />
      </div>

      <div class="mb-3">
        <label for="link" class="form-label">Lien</label>
        <x-input-text property="link" :value="$menu->link" />
        </div>

      <div class="mb-3">
        <label class="form-label">Voulez-vous l'afficher ?</label>
        <div class="form-check">
            <input type="radio" name="radio_choice" id="yes" value="1" class="form-check-input" {{ $menu->visible == '1' ? 'checked' : '' }}>
            <label for="yes" class="form-check-label">Oui</label>
        </div>
        <div class="form-check">
            <input type="radio" name="radio_choice" id="no" value="0" class="form-check-input" {{ $menu->visible == '0' ? 'checked' : '' }}>
            <label for="no" class="form-check-label">Non</label>
        </div>
      </div>


      <div>
        <input type="submit" value="Valider" class="btn btn-success">
      </div>
    </form>
  </div>
</x-app-layout>
