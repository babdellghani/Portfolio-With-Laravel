@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'nav-link active d-inline-flex align-items-center px-1 pt-1 border-bottom border-2 border-primary fw-medium'
            : 'nav-link d-inline-flex align-items-center px-1 pt-1 border-bottom border-2 border-transparent fw-medium text-muted';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
