<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sign In</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-950 text-slate-900">

    <main class="min-h-screen flex items-center justify-center px-4 py-10">

        <div class="w-full max-w-md">

            <!-- Logo / Brand -->
            <div class="text-center mb-8">

                <div class="mx-auto mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-500 shadow-lg shadow-emerald-500/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>

                <h1 class="text-3xl font-bold tracking-tight text-white">
                    Welcome back
                </h1>

                <p class="mt-2 text-sm text-slate-400">
                    Sign in to continue to your account
                </p>

            </div>


            <!-- Login Card -->
            <div class="rounded-3xl bg-white shadow-2xl shadow-black/20">
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                <div class="p-7 sm:p-9">

                    <form method="POST" action="/login" class="space-y-6">
                        @csrf

                        <!-- Email -->
                        <div>

                            <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">
                                Email address
                            </label>

                            <div class="relative">

                                <!-- Icon -->
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25H4.5a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0l-7.5-4.615A2.25 2.25 0 012.25 6.993V6.75" />
                                    </svg>
                                </div>

                                <input id="email" type="email" name="email" placeholder="name@example.com" value="{{ old('email') }}" autocomplete="email" autofocus required class="h-12 w-full rounded-xl border border-slate-200 bg-slate-50 pl-12 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 @error('email') border-red-500 focus:border-red-500 focus:ring-red-500/10 @enderror" />

                            </div>

                            @error('email')
                            <p class="mt-2 text-xs font-medium text-red-500">
                                {{ $message }}
                            </p>
                            @enderror

                        </div>


                        <!-- Password -->
                        <div>

                            <div class="mb-2 flex items-center justify-between">

                                <label for="password" class="block text-sm font-semibold text-slate-700">
                                    Password
                                </label>

                                @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-xs font-semibold text-emerald-600 transition hover:text-emerald-700 hover:underline">
                                    Forgot password?
                                </a>
                                @endif

                            </div>


                            <div class="relative">

                                <!-- Lock Icon -->
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 0h10.5A2.25 2.25 0 0119.5 12.75v6a2.25 2.25 0 01-2.25 2.25h-10.5A2.25 2.25 0 014.5 18.75v-6a2.25 2.25 0 012.25-2.25z" />
                                    </svg>
                                </div>


                                <input id="password" type="password" name="password" placeholder="Enter your password" autocomplete="current-password" required class="h-12 w-full rounded-xl border border-slate-200 bg-slate-50 pl-12 pr-12 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 @error('password') border-red-500 focus:border-red-500 focus:ring-red-500/10 @enderror" />


                                <!-- Show Password -->
                                <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 flex cursor-pointer items-center px-4 text-slate-400 transition hover:text-slate-700" aria-label="Show password">
                                    <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-6 9.75-6 9.75 6 9.75 6-3.75 6-9.75 6S2.25 12 2.25 12z" />

                                        <circle cx="12" cy="12" r="2.25" />
                                    </svg>
                                </button>

                            </div>


                            @error('password')
                            <p class="mt-2 text-xs font-medium text-red-500">
                                {{ $message }}
                            </p>
                            @enderror

                        </div>


                        <!-- Login Button -->
                        <button type="submit" class="flex h-12 w-full cursor-pointer items-center justify-center gap-2 rounded-xl bg-emerald-500 px-4 text-sm font-bold text-white shadow-lg shadow-emerald-500/20 transition-all duration-200 hover:bg-emerald-600 hover:shadow-emerald-500/30 active:scale-[0.98]">
                            <span>Sign In</span>

                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </button>

                    </form>


                    <!-- Register -->
                    <div class="mt-7 border-t border-slate-100 pt-6 text-center">

                        <p class="text-sm text-slate-500">
                            Don't have an account?
                        </p>

                        <a href="/register" class="mt-1 inline-flex cursor-pointer items-center gap-1 text-sm font-bold text-emerald-600 transition hover:text-emerald-700 hover:underline">
                            Create an account

                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>

                    </div>

                </div>

            </div>


            <!-- Footer -->
            <p class="mt-8 text-center text-xs text-slate-500">
                &copy; {{ date('Y') }} Sandi Virgiawan
            </p>

        </div>

    </main>


    <!-- Password Toggle -->
    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            const icon = document.getElementById('eyeIcon');

            if (password.type === 'password') {

                password.type = 'text';

                icon.innerHTML = `
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3.98 8.223A10.477 10.477 0 002.25 12s3.75 6 9.75 6c1.69 0 3.24-.382 4.61-1.057M6.228 6.228A10.45 10.45 0 0112 6c6 0 9.75 6 9.75 6a18.91 18.91 0 01-3.108 3.824M6.228 6.228L3 3m3.228 3.228l3.515 3.515m4.034 4.034L21 21"
                    />
                `;

            } else {

                password.type = 'password';

                icon.innerHTML = `
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M2.25 12s3.75-6 9.75-6 9.75 6 9.75 6-3.75 6-9.75 6S2.25 12 2.25 12z"
                    />

                    <circle
                        cx="12"
                        cy="12"
                        r="2.25"
                    />
                `;

            }
        }

    </script>

</body>
</html>
