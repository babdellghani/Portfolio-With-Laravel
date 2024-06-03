<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-dark d-inline-flex align-items-center px-4 py-2 rounded-3 fw-semibold text-uppercase']) }}>
    {{ $slot }}
</button>
