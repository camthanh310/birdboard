@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'w-full border-none outline-none focus:ring-teal-300 px-6 py-3']) !!}>
