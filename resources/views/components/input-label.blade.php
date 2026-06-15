@props(['value'])

<label {{ $attributes->merge(['class' => 'form-label small fw-semibold text-secondary mb-1']) }}>
    {{ $value ?? $slot }}
</label>
