<style>

.container {

}

</style>

<div class="container">
    <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
    <h1>Bonjour {{ Auth::user()->name }}</h1>
    <p>Un nouveau menu a été ajouté.</p>
</div>
