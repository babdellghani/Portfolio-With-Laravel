<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-danger d-inline-flex align-items-center px-4 py-2 rounded-3 fw-semibold text-uppercase lh-1 transition']) }}>
    {{ $slot }}
</button>
