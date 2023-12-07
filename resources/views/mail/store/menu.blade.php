<style>

.container {
    font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif';
}

</style>

    <div class="container">
        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
        <h2>Bonjour {{ Auth::user()->name }}</h2>
        <p>Nous vous informons qu'un nouveau menu a été ajouté.</p>
        <p>Cordialement,<br/> Votre gestionnaire CMS</p>
    </div>
