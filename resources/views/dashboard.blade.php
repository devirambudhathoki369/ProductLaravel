@extends('layouts.dashboard')

@section('title', 'Dashboard')
@section('heading', 'Dashboard')

@section('actions')
    <a href="{{ route('products.create') }}" class="btn-solid !py-2">
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
             stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 5v14M5 12h14"/>
        </svg>
        <span class="hidden sm:inline">Add product</span>
    </a>
@endsection

@section('content')
<div class="flex flex-wrap items-end justify-between gap-4">
    <div>
        <h2 class="text-2xl font-semibold tracking-tight">
            Welcome back, {{ Str::before(auth()->user()->name, ' ') }}
        </h2>
        <p class="mt-1.5 text-sm text-slate-600 dark:text-slate-400">
            You're signed in as {{ auth()->user()->email }}
        </p>
    </div>
    <span class="badge badge-green">
        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
        Session active
    </span>
</div>

{{-- Stat tiles. Placeholder numbers — feed these from the controller later. --}}
<div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
    @foreach ([
        ['label' => 'Total products', 'value' => '6',      'note' => 'in the catalog'],
        ['label' => 'Low stock',      'value' => '1',      'note' => 'needs restocking'],
        ['label' => 'Out of stock',   'value' => '1',      'note' => 'not sellable'],
        ['label' => 'Inventory value','value' => '$9,847', 'note' => 'price × stock'],
    ] as $stat)
        <div class="card p-5">
            <p class="text-xs font-medium tracking-wide text-slate-500 uppercase dark:text-slate-500">
                {{ $stat['label'] }}
            </p>
            <p class="mt-2 text-2xl font-semibold tabular-nums">{{ $stat['value'] }}</p>
            <p class="mt-1 text-xs text-slate-500 dark:text-slate-500">{{ $stat['note'] }}</p>
        </div>
    @endforeach
</div>

{{-- Recent products: same table styling as the full listing, trimmed to 4 columns. --}}
<div class="card mt-8 overflow-hidden">
    <div class="flex items-center justify-between gap-4 border-b border-slate-200 px-5 py-4 dark:border-slate-800">
        <h3 class="font-semibold">Recently added</h3>
        <a href="{{ route('products.index') }}"
           class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">
            View all
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50 dark:bg-slate-950/40">
                <tr>
                    <th scope="col" class="table-head">Product</th>
                    <th scope="col" class="table-head">Category</th>
                    <th scope="col" class="table-head text-right">Price</th>
                    <th scope="col" class="table-head">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                @foreach ([
                    ['Mechanical Keyboard', 'Peripherals', 89.00,  'badge-green', 'Active'],
                    ['USB-C Hub 7-in-1',    'Accessories', 34.50,  'badge-amber', 'Low stock'],
                    ['27" 4K Monitor',      'Displays',    329.99, 'badge-green', 'Active'],
                    ['Ergonomic Mouse',     'Peripherals', 45.00,  'badge-red',   'Out of stock'],
                ] as [$name, $category, $price, $badgeClass, $badgeLabel])
                    <tr class="transition hover:bg-slate-50 dark:hover:bg-slate-800/40">
                        <td class="table-cell font-medium text-slate-900 dark:text-slate-100">{{ $name }}</td>
                        <td class="table-cell">{{ $category }}</td>
                        <td class="table-cell text-right tabular-nums">${{ number_format($price, 2) }}</td>
                        <td class="table-cell"><span class="badge {{ $badgeClass }}">{{ $badgeLabel }}</span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- What is protecting this page right now --}}
<div class="card mt-8 p-6 sm:p-8">
    <h3 class="text-lg font-semibold">What's protecting this page</h3>
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
@endsection
