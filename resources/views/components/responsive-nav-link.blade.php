@props(['active'])

@php
$classes = ($active ?? false)
            ? 'd-block w-100 ps-3 pe-4 py-2 border-start border-primary text-start text-body fw-medium text-primary bg-light focus-outline-none transition'
            : 'd-block w-100 ps-3 pe-4 py-2 border-start border-transparent text-start text-body fw-medium text-secondary hover-text-dark hover-bg-light focus-outline-none transition';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
