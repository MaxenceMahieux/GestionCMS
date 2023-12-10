<div>
    <form action="{{ $route }}" method="post">
        @csrf
        @method('DELETE')
        <input type="submit" value="Supprimer" class="btn btn-danger btn-sm">
    </form>
</div>