@extends('layouts.guest')

@section('title', 'Register')
@section('brand-heading', 'Start in seconds.')
@section('brand-subheading', 'Create an account and your password is hashed before it ever touches the database.')

@section('content')
    <div>
        <h1 class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-white">
            Create your account
        </h1>
        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
            Already registered?
            <a href="{{ route('login') }}"
               class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">
                Log in instead
            </a>
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-5">
        {{-- Without this token, any other website could submit this form as your user. --}}
        @csrf

        <div>
            <label for="name" class="form-label">Full name</label>
            <input id="name" name="name" type="text" required autofocus autocomplete="name"
                   value="{{ old('name') }}" placeholder="Ada Lovelace"
                   @error('name') aria-invalid="true" aria-describedby="name-error" @enderror
                   class="form-input @error('name') form-input-error @enderror">
            @error('name')
                <p id="name-error" class="form-error">
                    <svg class="mt-0.5 h-4 w-4 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10A8 8 0 1 1 2 10a8 8 0 0 1 16 0Zm-9 3a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm1-8a1 1 0 0 0-1 1v3a1 1 0 0 0 2 0V6a1 1 0 0 0-1-1Z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ $message }}</span>
                </p>
            @enderror
        </div>

        <div>
            <label for="email" class="form-label">Email address</label>
            <input id="email" name="email" type="email" required autocomplete="email"
                   value="{{ old('email') }}" placeholder="you@example.com"
                   @error('email') aria-invalid="true" aria-describedby="email-error" @enderror
                   class="form-input @error('email') form-input-error @enderror">
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
            <input id="password" name="password" type="password" required autocomplete="new-password"
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
            @else
                <p class="mt-1.5 text-xs text-slate-500 dark:text-slate-500">
                    At least 8 characters, with letters and numbers.
                </p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="form-label">Confirm password</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required
                   autocomplete="new-password" placeholder="••••••••"
                   class="form-input">
        </div>

        <button type="submit" class="btn-primary">
            Create account
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
        Your password is hashed with bcrypt before it is stored
    </p>
@endsection
