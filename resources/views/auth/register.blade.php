<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Create Account</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-950 text-slate-900">

    <main class="min-h-screen flex items-center justify-center px-4 py-10">

        <div class="w-full max-w-md">

            <!-- Logo / Brand -->
            <div class="text-center mb-8">

                <div class="mx-auto mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-500 shadow-lg shadow-emerald-500/20">

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.5a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>

                </div>

                <h1 class="text-3xl font-bold tracking-tight text-white">
                    Create an account
                </h1>

                <p class="mt-2 text-sm text-slate-400">
                    Get started by creating your account
                </p>

            </div>


            <!-- Register Card -->
            <div class="rounded-3xl bg-white shadow-2xl shadow-black/20">

                <div class="p-7 sm:p-9">

                    <form method="POST" action="/register" class="space-y-5">
                        @csrf


                        <!-- Name -->
                        <div>

                            <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">
                                Full name
                            </label>

                            <div class="relative">

                                <!-- User Icon -->
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                    </svg>

                                </div>


                                <input id="name" type="text" name="name" placeholder="John Doe" value="{{ old('name') }}" autocomplete="name" autofocus required class="h-12 w-full rounded-xl border border-slate-200 bg-slate-50 pl-12 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 @error('name') border-red-500 focus:border-red-500 focus:ring-red-500/10 @enderror" />

                            </div>


                            @error('name')
                            <p class="mt-2 text-xs font-medium text-red-500">
                                {{ $message }}
                            </p>
                            @enderror

                        </div>


                        <!-- Email -->
                        <div>

                            <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">
                                Email address
                            </label>

                            <div class="relative">

                                <!-- Email Icon -->
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25H4.5a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0l-7.5-4.615A2.25 2.25 0 012.25 6.993V6.75" />
                                    </svg>

                                </div>


                                <input id="email" type="email" name="email" placeholder="name@example.com" value="{{ old('email') }}" autocomplete="email" required class="h-12 w-full rounded-xl border border-slate-200 bg-slate-50 pl-12 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 @error('email') border-red-500 focus:border-red-500 focus:ring-red-500/10 @enderror" />

                            </div>


                            @error('email')
                            <p class="mt-2 text-xs font-medium text-red-500">
                                {{ $message }}
                            </p>
                            @enderror

                        </div>


                        <!-- Password -->
                        <div>

                            <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">
                                Password
                            </label>

                            <div class="relative">

                                <!-- Lock Icon -->
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 0h10.5A2.25 2.25 0 0119.5 12.75v6a2.25 2.25 0 01-2.25 2.25h-10.5A2.25 2.25 0 014.5 18.75v-6a2.25 2.25 0 012.25-2.25z" />
                                    </svg>

                                </div>


                                <input id="password" type="password" name="password" placeholder="Create a password" autocomplete="new-password" required class="h-12 w-full rounded-xl border border-slate-200 bg-slate-50 pl-12 pr-12 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 @error('password') border-red-500 focus:border-red-500 focus:ring-red-500/10 @enderror" />


                                <!-- Show Password -->
                                <button type="button" onclick="togglePassword('password', 'passwordIcon')" class="absolute inset-y-0 right-0 flex cursor-pointer items-center px-4 text-slate-400 transition hover:text-slate-700" aria-label="Show password">

                                    <svg id="passwordIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
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


                        <!-- Confirm Password -->
                        <div>

                            <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-slate-700">
                                Confirm password
                            </label>

                            <div class="relative">

                                <!-- Lock Icon -->
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 0h10.5A2.25 2.25 0 0119.5 12.75v6a2.25 2.25 0 01-2.25 2.25h-10.5A2.25 2.25 0 014.5 18.75v-6a2.25 2.25 0 012.25-2.25z" />
                                    </svg>

                                </div>


                                <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Repeat your password" autocomplete="new-password" required class="h-12 w-full rounded-xl border border-slate-200 bg-slate-50 pl-12 pr-12 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10" />


                                <!-- Show Password -->
                                <button type="button" onclick="togglePassword('password_confirmation', 'confirmationIcon')" class="absolute inset-y-0 right-0 flex cursor-pointer items-center px-4 text-slate-400 transition hover:text-slate-700" aria-label="Show password">

                                    <svg id="confirmationIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-6 9.75-6 9.75 6 9.75 6-3.75 6-9.75 6S2.25 12 2.25 12z" />

                                        <circle cx="12" cy="12" r="2.25" />
                                    </svg>

                                </button>

                            </div>

                        </div>


                        <!-- Register Button -->
                        <button type="submit" class="flex h-12 w-full cursor-pointer items-center justify-center gap-2 rounded-xl bg-emerald-500 px-4 text-sm font-bold text-white shadow-lg shadow-emerald-500/20 transition-all duration-200 hover:bg-emerald-600 hover:shadow-emerald-500/30 active:scale-[0.98]">

                            <span>Create Account</span>

                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>

                        </button>

                    </form>


                    <!-- Login Link -->
                    <div class="mt-7 border-t border-slate-100 pt-6 text-center">

                        <p class="text-sm text-slate-500">
                            Already have an account?
                        </p>

                        <a href="/login" class="mt-1 inline-flex cursor-pointer items-center gap-1 text-sm font-bold text-emerald-600 transition hover:text-emerald-700 hover:underline">
                            Sign in instead

                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
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
        function togglePassword(inputId, iconId) {

            const password = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

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
