<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Home') — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-slate-50 text-slate-900 antialiased dark:bg-slate-950 dark:text-slate-100">
<div class="flex min-h-full flex-col">

    <header class="sticky top-0 z-10 border-b border-slate-200 bg-white/80 backdrop-blur-md
                   dark:border-slate-800 dark:bg-slate-950/80">
        <nav class="mx-auto flex h-16 max-w-6xl items-center justify-between px-4 sm:px-6">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2.5">
                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-600 text-white">
                    <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2"/>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                </span>
                <span class="font-semibold tracking-tight">{{ config('app.name') }}</span>
            </a>

            <div class="flex items-center gap-2">
                <a href="{{ route('docs') }}" class="btn-ghost hidden sm:inline-flex">Docs</a>
                @auth
                    <div class="mr-1 hidden items-center gap-2.5 sm:flex">
                        {{-- Initials avatar: no upload, no external gravatar request. --}}
                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-br
                                     from-indigo-500 to-violet-600 text-xs font-semibold text-white">
                            {{ Str::of(auth()->user()->name)->explode(' ')->take(2)->map(fn ($w) => Str::substr($w, 0, 1))->implode('') }}
                        </span>
                        <span class="text-sm font-medium">{{ auth()->user()->name }}</span>
                    </div>

                    {{--
                        Logout is a POST form, never a link. A GET logout URL can be
                        fired by any <img src="..."> on a hostile page.
                    --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn-ghost">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/>
                            </svg>
                            Log out
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn-ghost">Log in</a>
                    <a href="{{ route('register') }}"
                       class="inline-flex items-center rounded-lg bg-indigo-600 px-3.5 py-2 text-sm font-semibold
                              text-white shadow-sm transition hover:bg-indigo-500">
                        Get started
                    </a>
                @endauth
            </div>
        </nav>
    </header>

    <main class="flex-1">
        @if (session('status'))
            <div class="mx-auto mt-6 max-w-6xl px-4 sm:px-6">
                <div class="flex items-center gap-2.5 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3
                            text-sm text-emerald-800
                            dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:text-emerald-300">
                    <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 6 9 17l-5-5"/>
                    </svg>
                    {{ session('status') }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="border-t border-slate-200 py-6 dark:border-slate-800">
        <div class="mx-auto max-w-6xl px-4 text-sm text-slate-500 sm:px-6 dark:text-slate-500">
            &copy; {{ date('Y') }} {{ config('app.name') }}
        </div>
    </footer>
</div>
</body>
</html>
