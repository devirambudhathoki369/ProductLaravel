@extends('layouts.dashboard')

@section('title', 'Add product')
@section('heading', 'Add product')

@section('content')
<div class="mx-auto max-w-3xl">

    <p class="mb-6 text-sm text-slate-600 dark:text-slate-400">
        Fields marked <span class="text-red-600 dark:text-red-400">*</span> are required.
    </p>

    {{--
    | The action points at products.store, which does not exist yet — add the
    | POST route and controller and this form starts working as-is.
    |
    | Every field uses old('field') so a failed validation round-trip refills
    | the form instead of blanking it, and @error adds the red state. That is
    | the whole Laravel form contract: name, old(), @error.
    --}}
    <form method="POST" action="{{ route('products.store') }}" class="card p-6 sm:p-8">
        @csrf

        <div class="grid gap-5 sm:grid-cols-2">

            <div class="sm:col-span-2">
                <label for="name" class="form-label">
                    Product name <span class="text-red-600 dark:text-red-400">*</span>
                </label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                       placeholder="Mechanical Keyboard"
                       class="form-input @error('name') form-input-error @enderror">
                @error('name')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="sku" class="form-label">
                    SKU <span class="text-red-600 dark:text-red-400">*</span>
                </label>
                <input id="sku" name="sku" type="text" value="{{ old('sku') }}" required
                       placeholder="KB-8801"
                       class="form-input @error('sku') form-input-error @enderror">
                <p class="form-hint">Unique stock keeping unit.</p>
                @error('sku')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="category" class="form-label">
                    Category <span class="text-red-600 dark:text-red-400">*</span>
                </label>
                <select id="category" name="category" required
                        class="form-select @error('category') form-input-error @enderror">
                    <option value="" disabled @selected(! old('category'))>Choose a category…</option>
                    @foreach (['Peripherals', 'Accessories', 'Displays', 'Audio'] as $category)
                        <option value="{{ $category }}" @selected(old('category') === $category)>{{ $category }}</option>
                    @endforeach
                </select>
                @error('category')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="price" class="form-label">
                    Price <span class="text-red-600 dark:text-red-400">*</span>
                </label>
                {{-- step="0.01" so the browser accepts cents; inputmode gets a numeric keypad on phones. --}}
                <input id="price" name="price" type="number" step="0.01" min="0" inputmode="decimal"
                       value="{{ old('price') }}" required placeholder="0.00"
                       class="form-input @error('price') form-input-error @enderror">
                @error('price')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="stock" class="form-label">
                    Stock quantity <span class="text-red-600 dark:text-red-400">*</span>
                </label>
                <input id="stock" name="stock" type="number" step="1" min="0" inputmode="numeric"
                       value="{{ old('stock', 0) }}" required
                       class="form-input @error('stock') form-input-error @enderror">
                @error('stock')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="sm:col-span-2">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description" rows="4"
                          placeholder="What is this product, in a sentence or two?"
                          class="form-textarea @error('description') form-input-error @enderror">{{ old('description') }}</textarea>
                <p class="form-hint">Optional. Shown on the product detail page.</p>
                @error('description')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="sm:col-span-2">
                <span class="form-label">Status</span>
                <div class="mt-2 flex flex-wrap gap-x-6 gap-y-2">
                    @foreach ([['active', 'Active'], ['draft', 'Draft']] as [$value, $label])
                        <label class="flex items-center gap-2 text-sm">
                            <input type="radio" name="status" value="{{ $value }}"
                                   @checked(old('status', 'active') === $value)
                                   class="h-4 w-4 border-slate-300 text-indigo-600 focus:ring-indigo-500/25
                                          dark:border-slate-600 dark:bg-slate-900">
                            {{ $label }}
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="sm:col-span-2">
                <label class="flex items-start gap-2.5 text-sm">
                    {{-- A checkbox sends nothing when unchecked, so back-end code reads $request->boolean('featured'). --}}
                    <input type="checkbox" name="featured" value="1" @checked(old('featured'))
                           class="mt-0.5 h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500/25
                                  dark:border-slate-600 dark:bg-slate-900">
                    <span>
                        Feature this product
                        <span class="block text-xs text-slate-500 dark:text-slate-500">
                            Featured products appear at the top of the catalog.
                        </span>
                    </span>
                </label>
            </div>
        </div>

        <div class="mt-8 flex flex-wrap justify-end gap-3 border-t border-slate-200 pt-6 dark:border-slate-800">
            <a href="{{ route('products.index') }}" class="btn-outline">Cancel</a>
            <button type="submit" class="btn-solid">Save product</button>
        </div>
    </form>
</div>
@endsection
