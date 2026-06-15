@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'form-control rounded-xl border-light-subtle shadow-sm']) }}>
