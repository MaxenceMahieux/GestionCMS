<div>
    <input type="text" name="{{ $property }}" id="{{ $property }}" class="form-control @error($property) is-invalid @enderror" value="{{ $value ?? '' }}" required/>
    @error($property)
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>