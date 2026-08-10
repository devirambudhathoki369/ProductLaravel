@extends('layouts.dashboard')

@section('title', 'Products')
@section('heading', 'Products')

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
@php
    /*
    | FRONTEND ONLY — hard-coded rows.
    |
    | When the backend lands, delete this block and pass $products in from the
    | controller. Nothing below cares where the rows come from, as long as each
    | one has these keys.
    */
    $products = [
        ['id' => 1, 'name' => 'Mechanical Keyboard', 'sku' => 'KB-8801', 'category' => 'Peripherals', 'price' => 89.00,  'stock' => 42, 'status' => 'active'],
        ['id' => 2, 'name' => 'USB-C Hub 7-in-1',    'sku' => 'HB-2140', 'category' => 'Accessories', 'price' => 34.50,  'stock' => 8,  'status' => 'low'],
        ['id' => 3, 'name' => '27" 4K Monitor',      'sku' => 'MN-4027', 'category' => 'Displays',    'price' => 329.99, 'stock' => 15, 'status' => 'active'],
        ['id' => 4, 'name' => 'Ergonomic Mouse',     'sku' => 'MS-3312', 'category' => 'Peripherals', 'price' => 45.00,  'stock' => 0,  'status' => 'out'],
        ['id' => 5, 'name' => 'Laptop Stand',        'sku' => 'LS-7720', 'category' => 'Accessories', 'price' => 27.75,  'stock' => 63, 'status' => 'active'],
        ['id' => 6, 'name' => 'Noise-Cancel Headset','sku' => 'HD-5590', 'category' => 'Audio',       'price' => 149.00, 'stock' => 21, 'status' => 'draft'],
    ];

    // Maps a status string to its pill colour + label in one place.
    $statuses = [
        'active' => ['badge-green', 'Active'],
        'low'    => ['badge-amber', 'Low stock'],
        'out'    => ['badge-red',   'Out of stock'],
        'draft'  => ['badge-slate', 'Draft'],
    ];
@endphp

{{-- Filter bar. GET so the state ends up in the URL and stays shareable. --}}
<form method="GET" action="{{ route('products.index') }}" class="card mb-6 flex flex-wrap items-end gap-4 p-4">
    <div class="min-w-56 flex-1">
        <label for="search" class="form-label">Search</label>
        <input id="search" name="search" type="search" value="{{ request('search') }}"
               placeholder="Name or SKU…" class="form-input">
    </div>

    <div class="w-full sm:w-48">
        <label for="category" class="form-label">Category</label>
        <select id="category" name="category" class="form-select">
            <option value="">All categories</option>
            @foreach (['Peripherals', 'Accessories', 'Displays', 'Audio'] as $category)
                <option value="{{ $category }}" @selected(request('category') === $category)>{{ $category }}</option>
            @endforeach
        </select>
    </div>

    <div class="w-full sm:w-44">
        <label for="status" class="form-label">Status</label>
        <select id="status" name="status" class="form-select">
            <option value="">Any status</option>
            @foreach ($statuses as $value => [$class, $label])
                <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div class="flex gap-2">
        <button type="submit" class="btn-solid">Filter</button>
        <a href="{{ route('products.index') }}" class="btn-outline">Reset</a>
    </div>
</form>

{{-- Table --}}
<div class="card overflow-hidden">
    {{-- overflow-x-auto keeps the narrow-screen table scrollable instead of squashing columns. --}}
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="border-b border-slate-200 bg-slate-50 dark:border-slate-800 dark:bg-slate-950/40">
                <tr>
                    <th scope="col" class="table-head">Product</th>
                    <th scope="col" class="table-head">SKU</th>
                    <th scope="col" class="table-head">Category</th>
                    <th scope="col" class="table-head text-right">Price</th>
                    <th scope="col" class="table-head text-right">Stock</th>
                    <th scope="col" class="table-head">Status</th>
                    <th scope="col" class="table-head text-right">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                @forelse ($products as $product)
                    @php [$badgeClass, $badgeLabel] = $statuses[$product['status']] ?? $statuses['draft']; @endphp
                    <tr class="transition hover:bg-slate-50 dark:hover:bg-slate-800/40">
                        <td class="table-cell font-medium text-slate-900 dark:text-slate-100">
                            {{ $product['name'] }}
                        </td>
                        <td class="table-cell font-mono text-xs">{{ $product['sku'] }}</td>
                        <td class="table-cell">{{ $product['category'] }}</td>
                        <td class="table-cell text-right tabular-nums">
                            ${{ number_format($product['price'], 2) }}
                        </td>
                        <td class="table-cell text-right tabular-nums">{{ $product['stock'] }}</td>
                        <td class="table-cell">
                            <span class="badge {{ $badgeClass }}">{{ $badgeLabel }}</span>
                        </td>
                        <td class="table-cell text-right">
                            <div class="flex justify-end gap-1">
                                <a href="#" class="btn-ghost !px-2" aria-label="Edit {{ $product['name'] }}">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                        <path d="M18.5 2.5a2.12 2.12 0 0 1 3 3L12 15l-4 1 1-4Z"/>
                                    </svg>
                                </a>

                                {{--
                                    Deletes must be POST + @method('DELETE') + @csrf, never a
                                    plain link. Left as a disabled button until the route exists.
                                --}}
                                <button type="button" disabled
                                        class="btn-ghost !px-2 text-red-600 hover:bg-red-50 hover:text-red-700
                                               disabled:cursor-not-allowed disabled:opacity-40
                                               dark:text-red-400 dark:hover:bg-red-500/10"
                                        aria-label="Delete {{ $product['name'] }}">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M3 6h18M8 6V4a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2m3 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/>
                                        <path d="M10 11v6M14 11v6"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    {{-- Empty state. Worth writing now: an empty table with only headers looks broken. --}}
                    <tr>
                        <td colspan="7" class="px-4 py-16 text-center">
                            <p class="text-sm font-medium">No products yet</p>
                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                Add your first product to see it listed here.
                            </p>
                            <a href="{{ route('products.create') }}" class="btn-solid mt-5">Add product</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination placeholder — swap the whole block for {{ $products->links() }}. --}}
    <div class="flex items-center justify-between gap-4 border-t border-slate-200 px-4 py-3
                dark:border-slate-800">
        <p class="text-sm text-slate-600 dark:text-slate-400">
            Showing <span class="font-medium">{{ count($products) }}</span> of
            <span class="font-medium">{{ count($products) }}</span> products
        </p>
        <div class="flex gap-2">
            <button type="button" class="btn-outline !py-1.5 !text-xs" disabled>Previous</button>
            <button type="button" class="btn-outline !py-1.5 !text-xs" disabled>Next</button>
        </div>
    </div>
</div>
@endsection
