<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-light border border-secondary rounded text-uppercase fw-semibold shadow-sm px-4 py-2 text-body-secondary hover-bg-light focus-outline-none focus-ring focus-ring-primary focus-ring-opacity-50 disabled-opacity-50 transition']) }}>
    {{ $slot }}
</button>
