@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-danger small list-unstyled mb-0']) }}>
        @foreach ((array) $messages as $message)
            <li class="mb-2">{{ $message }}</li>
        @endforeach
    </ul>
@endif