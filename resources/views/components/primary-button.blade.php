<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-primary px-4 py-2 rounded-xl fw-bold shadow-sm d-inline-flex align-items-center gap-2']) }}>
    {{ $slot }}
</button>
