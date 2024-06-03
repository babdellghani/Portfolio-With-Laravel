@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'form-control border-secondary rounded shadow-sm focus-border-primary focus-ring focus-ring-primary']) !!}>
