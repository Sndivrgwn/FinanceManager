@props(['label'])

<div class="grid gap-1 px-6 py-4 sm:grid-cols-3 sm:gap-4">
    <dt class="text-sm font-medium text-slate-500">{{ $label }}</dt>
    <dd class="text-sm text-slate-900 sm:col-span-2">{{ $slot }}</dd>
</div>