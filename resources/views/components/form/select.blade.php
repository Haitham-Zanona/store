@if ($label)
    <label for="" class="d-block">{{ $label }}</label>
@endif

<select
    name="{{ $name }}"
    {{-- {{ $attributes->class([
        'form-control',
        'form-select',
        'is-invalid' => $errors->has($name)
    ]) }} --}}
    class(form-control form-select {{ $errors->has('name') ? 'is-invalid' : '' }})
>

    @foreach($options as $value => $text)
        <option value="{{ $value }}" @selected($value == $selected) >{{ $text }}</option>
    @endforeach
</select>

{{-- <x-form.validation-feedback :name="$name" /> --}}
