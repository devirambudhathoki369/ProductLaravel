@extends('layouts.app')

@section('title', 'Documentation')

@php
    // A single source of truth for the page's navigation and content.
    // Each section renders both a sidebar link and a <section> below.
    $sections = [
        'overview'   => 'Overview',
        'files'      => 'The files',
        'flow'       => 'How a request flows',
        'security'   => 'Security decisions',
        'database'   => 'Database & environment',
        'testing'    => 'Testing',
        'extending'  => 'Extending it',
    ];
@endphp

@section('content')
<div class="mx-auto max-w-6xl px-4 py-10 sm:px-6">

    {{-- Page header --}}
    <div class="border-b border-slate-200 pb-8 dark:border-slate-800">
        <p class="text-sm font-medium text-indigo-600 dark:text-indigo-400">Documentation</p>
        <h1 class="mt-2 text-3xl font-semibold tracking-tight">Authentication system</h1>
        <p class="mt-3 max-w-2xl text-slate-600 dark:text-slate-400">
            A hand-written login and registration system for Laravel {{ Illuminate\Foundation\Application::VERSION }} —
            no Breeze, no Jetstream. Every file is small enough to read in one sitting. This page explains
            what each piece does and, more importantly, <em>why</em> it is there.
        </p>
    </div>

    <div class="mt-8 gap-10 lg:flex">

        {{-- Sidebar navigation --}}
        <aside class="mb-8 lg:mb-0 lg:w-56 lg:shrink-0">
            <nav class="lg:sticky lg:top-24 space-y-1">
                @foreach ($sections as $id => $label)
                    <a href="#{{ $id }}"
                       class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-600 transition
                              hover:bg-slate-100 hover:text-slate-900
                              dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-white">
                        {{ $label }}
                    </a>
                @endforeach
            </nav>
        </aside>

        {{-- Content --}}
        <div class="min-w-0 flex-1 space-y-12">

            {{-- ---------------------------------------------------------------- --}}
            <section id="overview" class="scroll-mt-24">
                <h2 class="text-xl font-semibold tracking-tight">Overview</h2>
                <p class="mt-3 text-slate-600 dark:text-slate-400">
                    The system does four things: register a user, log them in, protect pages behind
                    login, and log them out. It leans entirely on Laravel's built-in session guard —
                    there is no third-party auth package to learn or keep updated.
                </p>

                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                    @foreach ([
                        ['Register', 'A visitor creates an account. The password is hashed, they are logged in, and the session id is rotated.'],
                        ['Log in', 'Credentials are checked against the stored hash. Failures are counted and throttled.'],
                        ['Protect', 'The auth middleware guards the dashboard; guests are bounced to the login form.'],
                        ['Log out', 'The session is invalidated and its token regenerated, via a POST-only route.'],
                    ] as [$t, $b])
                        <div class="card p-5">
                            <h3 class="font-semibold">{{ $t }}</h3>
                            <p class="mt-1.5 text-sm text-slate-600 dark:text-slate-400">{{ $b }}</p>
                        </div>
                    @endforeach
                </div>
            </section>

            {{-- ---------------------------------------------------------------- --}}
            <section id="files" class="scroll-mt-24">
                <h2 class="text-xl font-semibold tracking-tight">The files</h2>
                <p class="mt-3 text-slate-600 dark:text-slate-400">
                    Everything that was added or changed, and what each file is responsible for.
                </p>

                <div class="mt-6 overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="border-b border-slate-200 text-slate-500 dark:border-slate-800 dark:text-slate-400">
                                <th class="py-2 pr-4 font-medium">File</th>
                                <th class="py-2 font-medium">Responsibility</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800/70">
                            @foreach ([
                                ['app/Http/Controllers/Auth/RegisteredUserController.php', 'Shows the register form, validates input, creates the user and logs them in.'],
                                ['app/Http/Controllers/Auth/AuthenticatedSessionController.php', 'Shows the login form, logs the user in, and handles logout.'],
                                ['app/Http/Requests/Auth/LoginRequest.php', 'Login validation plus the brute-force rate limiter.'],
                                ['routes/web.php', 'Wires URLs to controllers behind guest / auth middleware.'],
                                ['bootstrap/app.php', 'Sets where guests and logged-in users are redirected.'],
                                ['app/Providers/AppServiceProvider.php', 'Defines the app-wide password policy and forces HTTPS in production.'],
                                ['resources/views/layouts/guest.blade.php', 'Split-screen layout for the login / register pages.'],
                                ['resources/views/layouts/app.blade.php', 'Header + footer shell for signed-in pages.'],
                                ['resources/views/auth/*.blade.php', 'The login and register forms.'],
                                ['resources/views/dashboard.blade.php', 'The protected landing page after login.'],
                                ['resources/css/app.css', 'Shared .form-input / .btn-primary / .card component styles.'],
                                ['tests/Feature/Auth/*.php', '17 tests covering the whole flow.'],
                            ] as [$file, $role])
                                <tr>
                                    <td class="py-2.5 pr-4 align-top">
                                        <code class="rounded bg-slate-100 px-1.5 py-0.5 text-xs text-slate-800
                                                     dark:bg-slate-800 dark:text-slate-200">{{ $file }}</code>
                                    </td>
                                    <td class="py-2.5 align-top text-slate-600 dark:text-slate-400">{{ $role }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            {{-- ---------------------------------------------------------------- --}}
            <section id="flow" class="scroll-mt-24">
                <h2 class="text-xl font-semibold tracking-tight">How a request flows</h2>

                <h3 class="mt-6 font-semibold">Registration</h3>
                <ol class="mt-3 space-y-3">
                    @foreach ([
                        'GET /register renders the form. The guest middleware first checks you are not already logged in.',
                        'You submit. The controller validates name, email (must be unique) and a confirmed password.',
                        'User::create() runs. The model\'s "hashed" cast bcrypts the password automatically.',
                        'Auth::login() signs you in, then session()->regenerate() issues a fresh session id.',
                        'You are redirected to the dashboard.',
                    ] as $i => $step)
                        <li class="flex gap-3">
                            <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-indigo-600
                                         text-xs font-semibold text-white">{{ $i + 1 }}</span>
                            <span class="text-sm text-slate-600 dark:text-slate-400">{{ $step }}</span>
                        </li>
                    @endforeach
                </ol>

                <h3 class="mt-8 font-semibold">Login</h3>
                <ol class="mt-3 space-y-3">
                    @foreach ([
                        'GET /login renders the form (guests only).',
                        'You submit. LoginRequest first checks you are not rate-limited.',
                        'Auth::attempt() compares the password to the stored hash.',
                        'On failure: the attempt is counted and the same generic error is shown.',
                        'On success: the counter is cleared, the session id is regenerated, and you reach the dashboard.',
                    ] as $i => $step)
                        <li class="flex gap-3">
                            <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-indigo-600
                                         text-xs font-semibold text-white">{{ $i + 1 }}</span>
                            <span class="text-sm text-slate-600 dark:text-slate-400">{{ $step }}</span>
                        </li>
                    @endforeach
                </ol>
            </section>

            {{-- ---------------------------------------------------------------- --}}
            <section id="security" class="scroll-mt-24">
                <h2 class="text-xl font-semibold tracking-tight">Security decisions</h2>
                <p class="mt-3 text-slate-600 dark:text-slate-400">
                    Each of these is a deliberate choice. The middle column is the attack it prevents.
                </p>

                <div class="mt-6 space-y-4">
                    @foreach ([
                        ['Password hashing', 'Database leak → stolen passwords', 'Passwords are stored as a bcrypt hash (12 rounds). The plain value is never written. Handled by the model\'s "hashed" cast, so no controller ever calls Hash::make() by hand.'],
                        ['CSRF tokens', 'Another site posting as your user', 'Every form includes @csrf. A POST without a valid token is rejected with HTTP 419. Verified live.'],
                        ['POST-only logout', 'Forced logout via a stray <img> tag', 'Logout is a form submit, not a link. A GET to /logout returns 405 Method Not Allowed.'],
                        ['Session regeneration', 'Session fixation', 'The session id is replaced on both login and registration, so an id an attacker planted beforehand becomes useless.'],
                        ['Login throttling', 'Password brute-forcing', 'Five failed attempts per email+IP triggers a one-minute lockout, plus a route-level limit on raw request volume.'],
                        ['Generic error message', 'User (email) enumeration', 'A wrong password and an unknown email produce the exact same message, so the form cannot be used to discover which emails have accounts.'],
                        ['Password policy', 'Weak passwords', 'Centralised in AppServiceProvider: 8 chars in dev; 12 chars with mixed case, numbers, symbols and a breach-database check (uncompromised) in production.'],
                        ['Forced HTTPS', 'Credentials sent in clear text', 'In production, all generated URLs use https so passwords never cross plain HTTP.'],
                    ] as [$title, $attack, $body])
                        <div class="card p-5">
                            <div class="flex flex-wrap items-center gap-3">
                                <h3 class="font-semibold">{{ $title }}</h3>
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-2.5 py-0.5
                                             text-xs font-medium text-red-700
                                             dark:bg-red-500/10 dark:text-red-400">
                                    prevents: {{ $attack }}
                                </span>
                            </div>
                            <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">{{ $body }}</p>
                        </div>
                    @endforeach
                </div>
            </section>

            {{-- ---------------------------------------------------------------- --}}
            <section id="database" class="scroll-mt-24">
                <h2 class="text-xl font-semibold tracking-tight">Database &amp; environment</h2>
                <p class="mt-3 text-slate-600 dark:text-slate-400">
                    The app runs on MySQL (<code class="rounded bg-slate-100 px-1 dark:bg-slate-800">product_db</code>).
                    The <code class="rounded bg-slate-100 px-1 dark:bg-slate-800">users</code>,
                    <code class="rounded bg-slate-100 px-1 dark:bg-slate-800">sessions</code> and
                    <code class="rounded bg-slate-100 px-1 dark:bg-slate-800">password_reset_tokens</code>
                    tables come from Laravel's default migration — no schema changes were needed.
                </p>

                <div class="card mt-6 border-amber-200 bg-amber-50 p-5 dark:border-amber-500/30 dark:bg-amber-500/10">
                    <h3 class="flex items-center gap-2 font-semibold text-amber-900 dark:text-amber-300">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 9v4M12 17h.01M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z"/>
                        </svg>
                        Tests need their own database
                    </h3>
                    <p class="mt-2 text-sm text-amber-800 dark:text-amber-200/90">
                        The tests use Laravel's <code class="rounded bg-amber-100 px-1 dark:bg-amber-500/20">RefreshDatabase</code>,
                        which wipes every table between tests. This machine has no
                        <code class="rounded bg-amber-100 px-1 dark:bg-amber-500/20">pdo_sqlite</code>, so tests run against a
                        separate MySQL database, <code class="rounded bg-amber-100 px-1 dark:bg-amber-500/20">product_db_test</code>,
                        configured in <code class="rounded bg-amber-100 px-1 dark:bg-amber-500/20">phpunit.xml</code>.
                        Keep <code class="rounded bg-amber-100 px-1 dark:bg-amber-500/20">DB_DATABASE=product_db</code>
                        in your <code class="rounded bg-amber-100 px-1 dark:bg-amber-500/20">.env</code> — never point it at the test
                        database, or a test run would empty your real data.
                    </p>
                </div>
            </section>

            {{-- ---------------------------------------------------------------- --}}
            <section id="testing" class="scroll-mt-24">
                <h2 class="text-xl font-semibold tracking-tight">Testing</h2>
                <p class="mt-3 text-slate-600 dark:text-slate-400">
                    17 feature tests cover the whole flow — registration, hashing, login, wrong passwords,
                    throttling, session regeneration, route protection and logout. Run them with:
                </p>
                <pre class="mt-4 overflow-x-auto rounded-lg bg-slate-900 p-4 text-sm text-slate-100
                            dark:border dark:border-slate-800"><code>./vendor/bin/pest</code></pre>
                <p class="mt-3 text-sm text-slate-500 dark:text-slate-500">
                    Expected: <span class="font-medium text-emerald-600 dark:text-emerald-400">17 passed, 38 assertions</span>.
                </p>
            </section>

            {{-- ---------------------------------------------------------------- --}}
            <section id="extending" class="scroll-mt-24">
                <h2 class="text-xl font-semibold tracking-tight">Extending it</h2>
                <p class="mt-3 text-slate-600 dark:text-slate-400">
                    Deliberately left out, so the core stays small. Each is a natural next step:
                </p>
                <ul class="mt-4 space-y-2.5">
                    @foreach ([
                        'Email verification — Laravel ships MustVerifyEmail; the User model is already set up to opt in.',
                        'Password reset — the password_reset_tokens table already exists.',
                        'Two-factor authentication.',
                        '"Forgot password" and "resend verification" links on the forms.',
                    ] as $item)
                        <li class="flex gap-2.5 text-sm text-slate-600 dark:text-slate-400">
                            <svg class="mt-0.5 h-4 w-4 shrink-0 text-indigo-500" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                            <span>{{ $item }}</span>
                        </li>
                    @endforeach
                </ul>

                <div class="card mt-6 p-5">
                    <h3 class="font-semibold">Before deploying</h3>
                    <ul class="mt-3 space-y-2 text-sm text-slate-600 dark:text-slate-400">
                        <li>Set <code class="rounded bg-slate-100 px-1 dark:bg-slate-800">APP_DEBUG=false</code> and <code class="rounded bg-slate-100 px-1 dark:bg-slate-800">APP_ENV=production</code>.</li>
                        <li>Set <code class="rounded bg-slate-100 px-1 dark:bg-slate-800">SESSION_ENCRYPT=true</code>.</li>
                        <li>Serve strictly over HTTPS (already forced when <code class="rounded bg-slate-100 px-1 dark:bg-slate-800">APP_ENV=production</code>).</li>
                        <li>Run <code class="rounded bg-slate-100 px-1 dark:bg-slate-800">php artisan config:cache</code> and <code class="rounded bg-slate-100 px-1 dark:bg-slate-800">npm run build</code>.</li>
                    </ul>
                </div>
            </section>

        </div>
    </div>
</div>
@endsection
