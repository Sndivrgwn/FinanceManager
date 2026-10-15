@props(['name'])

@php
    $state = $errors->has($name)
        ? 'border-red-400 focus:border-red-500 focus:ring-red-100'
        : 'border-slate-300 focus:border-slate-500 focus:ring-slate-200';
@endphp

<textarea id="{{ $name }}" name="{{ $name }}" rows="3"
    {{ $attributes->merge(['class' => 'block w-full rounded-md border px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 ' . $state]) }}>{{ $slot }}</textarea>