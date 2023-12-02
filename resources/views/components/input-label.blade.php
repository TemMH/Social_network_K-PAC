@props(['value'])

<label {{ $attributes->merge(['class' => 'input_label']) }}>
    {{ $value ?? $slot }}
</label>
