<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white text-slate-800 antialiased">
    @php
        $logo = '<svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
    @endphp

    <div class="grid min-h-screen lg:grid-cols-2">

        {{-- Panel kiri: branding (hanya desktop) --}}
        <aside class="relative hidden flex-col justify-between overflow-hidden bg-slate-950 p-12 text-white lg:flex">
            <div class="pointer-events-none absolute -left-24 -top-24 h-96 w-96 rounded-full bg-emerald-500/20 blur-3xl"></div>
            <div class="pointer-events-none absolute -bottom-32 -right-24 h-96 w-96 rounded-full bg-sky-500/10 blur-3xl"></div>

            <div class="relative flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-500">{!! $logo !!}</div>
                <span class="text-lg font-semibold">Financial Manager</span>
            </div>

            <div class="relative">
                <h2 class="max-w-md text-4xl font-bold leading-tight tracking-tight">
                    Semua keuanganmu, <span class="text-emerald-400">dalam satu dashboard.</span>
                </h2>

                <ul class="mt-6 space-y-3 text-sm text-slate-300">
                    @foreach ([
                        'Catat pemasukan dan pengeluaran dengan cepat',
                        'Pantau saldo semua wallet dan rekening',
                        'Transfer antar wallet tanpa mengacaukan laporan',
                    ] as $feature)
                        <li class="flex items-center gap-3">
                            <svg class="h-5 w-5 shrink-0 text-emerald-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd"/>
                            </svg>
                            {{ $feature }}
                        </li>
                    @endforeach
                </ul>

                {{-- Pratinjau dekoratif (data contoh) --}}
                <div class="mt-10 max-w-sm rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur" aria-hidden="true">
                    <p class="text-xs uppercase tracking-wide text-slate-400">Total Saldo (contoh)</p>
                    <p class="mt-1 text-2xl font-bold">Rp 12.450.000</p>

                    <div class="mt-5 flex h-16 items-end gap-2">
                        @foreach ([40, 65, 50, 80, 55, 95, 70] as $h)
                            <div class="flex-1 rounded-t bg-emerald-500/70" style="height: {{ $h }}%"></div>
                        @endforeach
                    </div>

                    <div class="mt-4 flex justify-between text-xs">
                        <span class="text-emerald-400">+ Rp 5.200.000</span>
                        <span class="text-red-400">- Rp 2.150.000</span>
                    </div>
                </div>
            </div>

            <p class="relative text-xs text-slate-500">&copy; {{ date('Y') }} Sandi Virgiawan</p>
        </aside>

        {{-- Panel kanan: form --}}
        <main class="flex flex-col justify-center bg-slate-50 px-6 py-10 sm:px-12 lg:bg-white">
            <div class="mx-auto w-full max-w-md">

                {{-- Logo (hanya mobile) --}}
                <div class="mb-8 flex items-center gap-3 lg:hidden">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-500">{!! $logo !!}</div>
                    <span class="text-lg font-semibold text-slate-900">Financial Manager</span>
                </div>

                <h1 class="text-3xl font-bold tracking-tight text-slate-900">@yield('heading')</h1>
                <p class="mt-2 text-sm text-slate-500">@yield('subheading')</p>

                @if (session('success'))
                    <div class="mt-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mt-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="mt-8">
                    @yield('content')
                </div>

                <p class="mt-8 text-center text-xs text-slate-400 lg:hidden">&copy; {{ date('Y') }} Sandi Virgiawan</p>
            </div>
        </main>
    </div>

    <script>
        // Satu handler untuk semua tombol "tampilkan password".
        document.addEventListener('click', (event) => {
            const button = event.target.closest('[data-toggle-password]');
            if (!button) return;

            const input = document.getElementById(button.dataset.togglePassword);
            const show = input.type === 'password';

            input.type = show ? 'text' : 'password';
            button.querySelector('[data-eye]').classList.toggle('hidden', show);
            button.querySelector('[data-eye-off]').classList.toggle('hidden', !show);
            button.setAttribute('aria-label', show ? 'Sembunyikan password' : 'Tampilkan password');
        });
    </script>
</body>
</html>