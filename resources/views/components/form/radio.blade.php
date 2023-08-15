@props([
    'name', 'options', 'checked' => false
])


@foreach ($options as $value => $text)

<div class="form-checked">
    <input type="radio" class="form-check-input ml-3" name="{{ $name }}" value="{{ $value }}"
        @checked(old($name, $checked) == $value)
        {{ $attributes->class([
            'form-check-input',
            'is-invalid' => $errors->has($name),
        ]) }}
    >
    <label class="form-check-label ml-4 pl-2">
        {{ $text }}
    </label>
</div>

@endforeach
