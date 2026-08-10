<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-slate-50 text-slate-900 antialiased dark:bg-slate-950 dark:text-slate-100">

{{--
| Dashboard shell.
|
| The sidebar is one <aside> used at both sizes:
|   - lg and up: it sits in the flex row as a normal column (lg:static).
|   - below lg: it becomes a fixed off-canvas drawer that slides in when the
|     header's hamburger toggles the `-translate-x-full` class.
| That means one markup block instead of a desktop copy and a mobile copy.
--}}
<div class="flex min-h-full">

    {{-- Dim layer behind the mobile drawer. Clicking it closes the sidebar. --}}
    <div id="sidebar-overlay"
         class="fixed inset-0 z-30 hidden bg-slate-900/50 backdrop-blur-xs lg:hidden"></div>

    <aside id="sidebar"
           class="fixed inset-y-0 left-0 z-40 flex w-64 shrink-0 -translate-x-full flex-col
                  border-r border-slate-200 bg-white transition-transform duration-200
                  lg:static lg:translate-x-0
                  dark:border-slate-800 dark:bg-slate-900">

        {{-- Brand --}}
        <div class="flex h-16 items-center justify-between border-b border-slate-200 px-4 dark:border-slate-800">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2.5">
                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-600 text-white">
                    <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="m7.5 4.27 9 5.15M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/>
                        <path d="m3.3 7 8.7 5 8.7-5M12 22V12"/>
                    </svg>
                </span>
                <span class="font-semibold tracking-tight">{{ config('app.name') }}</span>
            </a>

            {{-- Close button, drawer mode only. --}}
            <button type="button" data-sidebar-close class="btn-ghost !px-2 lg:hidden" aria-label="Close sidebar">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 6 6 18M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 space-y-6 overflow-y-auto px-3 py-5">
            @php
                /*
                 | Nav is data, not markup. Adding a link is one array row.
                 | `route` feeds both the href and the active check, so the
                 | highlight can never drift out of sync with the link.
                 */
                $sections = [
                    'Overview' => [
                        ['route' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'grid'],
                    ],
                    'Catalog' => [
                        ['route' => 'products.index',  'label' => 'Products',    'icon' => 'box'],
                        ['route' => 'products.create', 'label' => 'Add product', 'icon' => 'plus'],
                    ],
                ];

                $icons = [
                    'grid' => '<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/>',
                    'box'  => '<path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5M12 22V12"/>',
                    'plus' => '<path d="M12 5v14M5 12h14"/>',
                ];
            @endphp

            @foreach ($sections as $heading => $links)
                <div>
                    <p class="px-3 pb-2 text-xs font-semibold tracking-wider text-slate-400 uppercase dark:text-slate-500">
                        {{ $heading }}
                    </p>

                    <ul class="space-y-1">
                        @foreach ($links as $link)
                            @php $active = request()->routeIs($link['route']); @endphp
                            <li>
                                <a href="{{ route($link['route']) }}"
                                   @if ($active) aria-current="page" @endif
                                   class="{{ $active ? 'nav-link-active' : 'nav-link' }}">
                                    <svg class="h-4.5 w-4.5 shrink-0" viewBox="0 0 24 24" fill="none"
                                         stroke="currentColor" stroke-width="2"
                                         stroke-linecap="round" stroke-linejoin="round">
                                        {!! $icons[$link['icon']] !!}
                                    </svg>
                                    {{ $link['label'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </nav>

        {{-- Signed-in user + log out --}}
        <div class="border-t border-slate-200 p-3 dark:border-slate-800">
            @auth
                <div class="flex items-center gap-2.5 px-2 py-1.5">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-gradient-to-br
                                 from-indigo-500 to-violet-600 text-xs font-semibold text-white">
                        {{ Str::of(auth()->user()->name)->explode(' ')->take(2)->map(fn ($w) => Str::substr($w, 0, 1))->implode('') }}
                    </span>
                    <div class="min-w-0">
                        <p class="truncate text-sm font-medium">{{ auth()->user()->name }}</p>
                        <p class="truncate text-xs text-slate-500 dark:text-slate-500">{{ auth()->user()->email }}</p>
                    </div>
                </div>

                {{-- POST, never a GET link: a GET logout URL can be fired by any <img> on a hostile page. --}}
                <form method="POST" action="{{ route('logout') }}" class="mt-1">
                    @csrf
                    <button type="submit" class="nav-link w-full">
                        <svg class="h-4.5 w-4.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/>
                        </svg>
                        Log out
                    </button>
                </form>
            @endauth
        </div>
    </aside>

    {{-- Main column --}}
    <div class="flex min-w-0 flex-1 flex-col">

        <header class="sticky top-0 z-20 flex h-16 items-center gap-3 border-b border-slate-200 bg-white/80 px-4
                       backdrop-blur-md sm:px-6 dark:border-slate-800 dark:bg-slate-950/80">
            <button type="button" data-sidebar-open class="btn-ghost !px-2 lg:hidden" aria-label="Open sidebar">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            <h1 class="truncate text-base font-semibold tracking-tight">@yield('heading', 'Dashboard')</h1>

            <div class="ml-auto flex items-center gap-2">
                @yield('actions')
            </div>
        </header>

        <main class="flex-1 px-4 py-6 sm:px-6 sm:py-8">
            @if (session('status'))
                <div class="mb-6 flex items-center gap-2.5 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3
                            text-sm text-emerald-800
                            dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:text-emerald-300">
                    <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 6 9 17l-5-5"/>
                    </svg>
                    {{ session('status') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<script>
    // Off-canvas sidebar. Nothing here runs at lg and up, where the aside is
    // static and the toggles are display:none.
    (() => {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        const open = () => {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        };

        const close = () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        };

        document.querySelector('[data-sidebar-open]')?.addEventListener('click', open);
        document.querySelectorAll('[data-sidebar-close]').forEach((el) => el.addEventListener('click', close));
        overlay.addEventListener('click', close);
        document.addEventListener('keydown', (e) => e.key === 'Escape' && close());
    })();
</script>
</body>
</html>
