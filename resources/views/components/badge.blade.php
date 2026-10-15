@props(['color' => 'slate'])

@php
    $colors = [
        'slate' => 'bg-slate-100 text-slate-700',
        'emerald' => 'bg-emerald-50 text-emerald-700',
        'red' => 'bg-red-50 text-red-700',
        'sky' => 'bg-sky-50 text-sky-700',
        'amber' => 'bg-amber-50 text-amber-700',
        'violet' => 'bg-violet-50 text-violet-700',
    ];
@endphp

<span {{ $attributes->merge(['class' => 'inline-block rounded-full px-2 py-0.5 text-xs font-medium ' . ($colors[$color] ?? $colors['slate'])]) }}>
    {{ $slot }}
</span>