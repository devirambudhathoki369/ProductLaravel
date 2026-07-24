@extends('layouts.guest')

@section('title', 'Log in')
@section('brand-heading', 'Welcome back.')
@section('brand-subheading', 'Sign in to pick up where you left off.')

@section('content')
    <div>
        <h1 class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-white">
            Log in to your account
        </h1>
        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
            New here?
            <a href="{{ route('register') }}"
               class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">
                Create an account
            </a>
        </p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-5">
        @csrf

        <div>
            <label for="email" class="form-label">Email address</label>
            <input id="email" name="email" type="email" required autofocus autocomplete="email"
                   value="{{ old('email') }}" placeholder="you@example.com"
                   @error('email') aria-invalid="true" aria-describedby="email-error" @enderror
                   class="form-input @error('email') form-input-error @enderror">
            {{--
                A wrong password and an unknown email both surface here with the
                same wording. If they differed, this form would tell an attacker
                which addresses have accounts.
            --}}
            @error('email')
                <p id="email-error" class="form-error">
                    <svg class="mt-0.5 h-4 w-4 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10A8 8 0 1 1 2 10a8 8 0 0 1 16 0Zm-9 3a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm1-8a1 1 0 0 0-1 1v3a1 1 0 0 0 2 0V6a1 1 0 0 0-1-1Z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ $message }}</span>
                </p>
            @enderror
        </div>

        <div>
            <label for="password" class="form-label">Password</label>
            <input id="password" name="password" type="password" required autocomplete="current-password"
                   placeholder="••••••••"
                   @error('password') aria-invalid="true" aria-describedby="password-error" @enderror
                   class="form-input @error('password') form-input-error @enderror">
            @error('password')
                <p id="password-error" class="form-error">
                    <svg class="mt-0.5 h-4 w-4 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10A8 8 0 1 1 2 10a8 8 0 0 1 16 0Zm-9 3a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm1-8a1 1 0 0 0-1 1v3a1 1 0 0 0 2 0V6a1 1 0 0 0-1-1Z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ $message }}</span>
                </p>
            @enderror
        </div>

        <label class="flex cursor-pointer items-center gap-2.5 text-sm text-slate-700 select-none dark:text-slate-300">
            <input type="checkbox" name="remember" value="1"
                   class="h-4 w-4 rounded border border-slate-300 text-indigo-600
                          focus:ring-2 focus:ring-indigo-500/25 dark:border-slate-600 dark:bg-slate-900">
            Remember me for 30 days
        </label>

        <button type="submit" class="btn-primary">
            Log in
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 12h14M12 5l7 7-7 7"/>
            </svg>
        </button>
    </form>

    <p class="mt-8 flex items-center justify-center gap-1.5 text-xs text-slate-500 dark:text-slate-500">
        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
             stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="11" width="18" height="11" rx="2"/>
            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
        </svg>
        Protected by CSRF tokens and login rate limiting
    </p>
@endsection
