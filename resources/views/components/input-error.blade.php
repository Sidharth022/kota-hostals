@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'list-unstyled text-danger small mt-1 mb-0']) }}>
        @foreach ((array) $messages as $message)
            <li class="d-flex align-items-center gap-1">
                <i class="fa-solid fa-circle-exclamation" style="font-size: 10px;"></i>
                <span>{{ $message }}</span>
            </li>
        @endforeach
    </ul>
@endif
