@props(['value'])

<label {{ $attributes->merge(['class' => 'd-block fw-medium small text-secondary']) }}>
    {{ $value ?? $slot }}
</label>