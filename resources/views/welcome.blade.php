@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="relative overflow-hidden">
    {{-- Decorative background wash. --}}
    <div aria-hidden="true"
         class="pointer-events-none absolute inset-x-0 -top-40 -z-10 flex justify-center blur-3xl">
        <div class="h-[32rem] w-[64rem] bg-gradient-to-tr from-indigo-400/25 via-violet-400/20 to-fuchsia-400/25"></div>
    </div>

    <div class="mx-auto max-w-3xl px-4 py-24 text-center sm:px-6 sm:py-32">
        <span class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-3 py-1
                     text-xs font-medium text-slate-600 shadow-xs
                     dark:border-slate-800 dark:bg-slate-900 dark:text-slate-400">
            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
            Laravel {{ Illuminate\Foundation\Application::VERSION }}
        </span>

        <h1 class="mt-6 text-4xl font-semibold tracking-tight text-balance sm:text-6xl">
            Authentication,
            <span class="bg-gradient-to-r from-indigo-600 to-violet-600 bg-clip-text text-transparent
                         dark:from-indigo-400 dark:to-violet-400">done right</span>
        </h1>

        <p class="mx-auto mt-6 max-w-xl text-lg leading-relaxed text-slate-600 text-pretty dark:text-slate-400">
            A small, readable login and registration system — hashed passwords, CSRF-protected
            forms, throttled logins and regenerated sessions. No package to learn.
        </p>

        <div class="mt-10 flex flex-wrap items-center justify-center gap-3">
            @auth
                <a href="{{ route('dashboard') }}"
                   class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold
                          text-white shadow-sm transition hover:bg-indigo-500">
                    Go to dashboard
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            @else
                <a href="{{ route('register') }}"
                   class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold
                          text-white shadow-sm transition hover:bg-indigo-500">
                    Create an account
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
                <a href="{{ route('login') }}"
                   class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm
                          font-semibold text-slate-700 shadow-xs transition hover:bg-slate-50
                          dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800">
                    Log in
                </a>
            @endauth
            <a href="{{ route('docs') }}"
               class="inline-flex items-center gap-1.5 px-2 py-2.5 text-sm font-semibold text-slate-600
                      transition hover:text-slate-900 dark:text-slate-400 dark:hover:text-white">
                Read the docs
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>

    <div class="mx-auto max-w-5xl px-4 pb-24 sm:px-6">
        <div class="grid gap-4 sm:grid-cols-3">
            @foreach ([
                ['Hashed passwords', 'Bcrypt at 12 rounds. The plain password is never written to disk.'],
                ['CSRF protected', 'Every form carries a one-time token, so no other site can post as your user.'],
                ['Rate limited', 'Five failed logins per email and IP, then a cooldown.'],
            ] as [$title, $body])
                <div class="card p-6">
                    <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600
                                 dark:bg-indigo-500/15 dark:text-indigo-400">
                        <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/>
                        </svg>
                    </span>
                    <h3 class="mt-4 font-semibold">{{ $title }}</h3>
                    <p class="mt-1.5 text-sm leading-relaxed text-slate-600 dark:text-slate-400">{{ $body }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
