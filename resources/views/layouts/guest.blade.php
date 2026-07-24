<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-white antialiased dark:bg-slate-950">
<div class="flex min-h-full">

    {{--
        Left: brand panel. Hidden below lg so small screens get the form
        immediately instead of scrolling past decoration.
    --}}
    <div class="relative hidden w-0 flex-1 overflow-hidden bg-slate-900 lg:block">
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 via-violet-600 to-fuchsia-600"></div>

        {{-- Soft light blooms; aria-hidden since they carry no meaning. --}}
        <div aria-hidden="true"
             class="absolute -top-24 -left-24 h-96 w-96 rounded-full bg-white/20 blur-3xl"></div>
        <div aria-hidden="true"
             class="absolute -bottom-32 -right-16 h-[28rem] w-[28rem] rounded-full bg-fuchsia-400/30 blur-3xl"></div>

        <div class="relative flex h-full flex-col justify-between p-12 xl:p-16">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2.5 text-white">
                <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/15 backdrop-blur-sm ring-1 ring-white/25">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2"/>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                </span>
                <span class="text-lg font-semibold tracking-tight">{{ config('app.name') }}</span>
            </a>

            <div class="max-w-md">
                <h2 class="text-4xl font-semibold leading-tight tracking-tight text-white xl:text-5xl">
                    @yield('brand-heading', 'Secure by default.')
                </h2>
                <p class="mt-5 text-lg leading-relaxed text-white/80">
                    @yield('brand-subheading', 'Hashed passwords, CSRF-protected forms and rate-limited logins — wired up from the ground.')
                </p>

                <ul class="mt-10 space-y-4">
                    @foreach ([
                        'Passwords hashed with bcrypt, never stored',
                        'Every form protected against CSRF',
                        'Logins throttled after 5 failed attempts',
                    ] as $point)
                        <li class="flex items-center gap-3 text-white/90">
                            <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-white/20">
                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 6 9 17l-5-5"/>
                                </svg>
                            </span>
                            <span class="text-sm">{{ $point }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <p class="text-sm text-white/50">&copy; {{ date('Y') }} {{ config('app.name') }}</p>
        </div>
    </div>

    {{-- Right: the form itself. --}}
    <div class="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
        <div class="mx-auto w-full max-w-sm lg:w-96">

            {{-- Small-screen brand mark; the panel above is hidden there. --}}
            <a href="{{ url('/') }}" class="mb-10 inline-flex items-center gap-2.5 lg:hidden">
                <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-600 text-white">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2"/>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                </span>
                <span class="text-lg font-semibold tracking-tight text-slate-900 dark:text-white">
                    {{ config('app.name') }}
                </span>
            </a>

            @if (session('status'))
                <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800
                            dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:text-emerald-300">
                    {{ session('status') }}
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</div>
</body>
</html>
