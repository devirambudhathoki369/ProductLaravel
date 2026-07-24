@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mx-auto w-full max-w-6xl px-4 py-10 sm:px-6">

    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight">
                Welcome back, {{ Str::before(auth()->user()->name, ' ') }}
            </h1>
            <p class="mt-1.5 text-sm text-slate-600 dark:text-slate-400">
                You're signed in as {{ auth()->user()->email }}
            </p>
        </div>
        <span class="inline-flex items-center gap-1.5 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1
                     text-xs font-medium text-emerald-700
                     dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:text-emerald-400">
            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
            Session active
        </span>
    </div>

    {{-- Account summary --}}
    <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ([
            ['label' => 'Account name',  'value' => auth()->user()->name],
            ['label' => 'Email address', 'value' => auth()->user()->email],
            ['label' => 'Member since',  'value' => auth()->user()->created_at?->format('M j, Y') ?? '—'],
        ] as $item)
            <div class="card p-5">
                <p class="text-xs font-medium tracking-wide text-slate-500 uppercase dark:text-slate-500">
                    {{ $item['label'] }}
                </p>
                <p class="mt-2 truncate text-lg font-semibold">{{ $item['value'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- What is protecting this page right now --}}
    <div class="card mt-8 p-6 sm:p-8">
        <h2 class="text-lg font-semibold">What's protecting this page</h2>
        <p class="mt-1.5 text-sm text-slate-600 dark:text-slate-400">
            Each item below is active on this request.
        </p>

        <div class="mt-6 grid gap-x-8 gap-y-6 sm:grid-cols-2">
            @foreach ([
                ['auth middleware', 'Visiting this URL while logged out redirects you to the login form.'],
                ['Hashed passwords', 'The users table stores a bcrypt hash. The plain password is never written.'],
                ['CSRF tokens', 'The log out button posts a one-time token, so no other site can trigger it.'],
                ['Session regeneration', 'Your session ID was replaced at login, defeating session fixation.'],
                ['Rate limiting', 'Five failed logins for this email locks further attempts for a minute.'],
                ['No user enumeration', 'A wrong password and an unknown email return the same message.'],
            ] as [$title, $body])
                <div class="flex gap-3">
                    <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full
                                 bg-indigo-100 text-indigo-600 dark:bg-indigo-500/15 dark:text-indigo-400">
                        <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 6 9 17l-5-5"/>
                        </svg>
                    </span>
                    <div>
                        <p class="text-sm font-medium">{{ $title }}</p>
                        <p class="mt-0.5 text-sm text-slate-600 dark:text-slate-400">{{ $body }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
