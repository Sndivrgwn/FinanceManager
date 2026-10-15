@props(['name', 'label', 'type' => 'text', 'icon' => null])

@php
    $isPassword = $type === 'password';
    $hasError = $errors->has($name);

    $state = $hasError
        ? 'border-red-400 focus:border-red-500 focus:ring-red-500/10'
        : 'border-slate-200 focus:border-emerald-500 focus:ring-emerald-500/10';
@endphp

<div>
    <label for="{{ $name }}" class="mb-1.5 block text-sm font-medium text-slate-700">{{ $label }}</label>

    <div class="relative">
        @if ($icon)
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    @if ($icon === 'mail')
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25H4.5a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0l-7.5-4.615A2.25 2.25 0 012.25 6.993V6.75"/>
                    @elseif ($icon === 'lock')
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 0h10.5A2.25 2.25 0 0119.5 12.75v6a2.25 2.25 0 01-2.25 2.25h-10.5A2.25 2.25 0 014.5 18.75v-6a2.25 2.25 0 012.25-2.25z"/>
                    @elseif ($icon === 'user')
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                    @endif
                </svg>
            </div>
        @endif

        <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}"
            @unless ($isPassword) value="{{ old($name) }}" @endunless
            @if ($hasError) aria-invalid="true" @endif
            {{ $attributes->merge([
                'class' => 'h-12 w-full rounded-xl border bg-white text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:ring-4 '
                    . ($icon ? 'pl-11 ' : 'pl-4 ')
                    . ($isPassword ? 'pr-12 ' : 'pr-4 ')
                    . $state,
            ]) }}>

        @if ($isPassword)
            <button type="button" data-toggle-password="{{ $name }}" aria-label="Tampilkan password"
                class="absolute inset-y-0 right-0 flex items-center px-3.5 text-slate-400 transition hover:text-slate-700">
                <svg data-eye class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-6 9.75-6 9.75 6 9.75 6-3.75 6-9.75 6S2.25 12 2.25 12z"/>
                    <circle cx="12" cy="12" r="2.25"/>
                </svg>
                <svg data-eye-off class="hidden h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 002.25 12s3.75 6 9.75 6c1.69 0 3.24-.382 4.61-1.057M6.228 6.228A10.45 10.45 0 0112 6c6 0 9.75 6 9.75 6a18.91 18.91 0 01-3.108 3.824M6.228 6.228L3 3m3.228 3.228l3.515 3.515m4.034 4.034L21 21"/>
                </svg>
            </button>
        @endif
    </div>

    @error($name)
        <p class="mt-1.5 text-xs font-medium text-red-600" role="alert">{{ $message }}</p>
    @enderror
</div>