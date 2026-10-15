<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Financial Manager') - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 antialiased">
    @php
        $navLinks = [
            ['label' => 'Dashboard', 'route' => 'dashboard', 'match' => 'dashboard'],
            ['label' => 'Wallet', 'route' => 'wallets.index', 'match' => 'wallets.*'],
            ['label' => 'Kategori', 'route' => 'categories.index', 'match' => 'categories.*'],
            ['label' => 'Transaksi', 'route' => 'transactions.index', 'match' => 'transactions.*'],
            ['label' => 'Transfer', 'route' => 'transfers.index', 'match' => 'transfers.*'],
        ];
    @endphp

    <header class="border-b border-slate-200 bg-white">
        <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-3 px-4 py-3">
            <a href="{{ route('dashboard') }}" class="text-lg font-semibold text-slate-900">
                Financial Manager
            </a>

            <nav class="flex flex-wrap items-center gap-1 text-sm">
                @foreach ($navLinks as $link)
                    <a href="{{ route($link['route']) }}"
                       class="rounded-md px-3 py-2 font-medium {{ request()->routeIs($link['match']) ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100' }}">
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </nav>

            <form method="POST" action="{{ route('logout') }}" class="flex items-center gap-3 text-sm">
                @csrf
                <span class="hidden text-slate-500 sm:inline">{{ auth()->user()->name }}</span>
                <button type="submit" class="rounded-md border border-slate-300 px-3 py-2 font-medium text-slate-700 hover:bg-slate-100">
                    Keluar
                </button>
            </form>
        </div>
    </header>

    <main class="mx-auto max-w-6xl px-4 py-6">
        @if (session('success'))
            <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>