@php
    use Illuminate\Support\Facades\Storage;
@endphp

<x-layouts.app :title="isset($ebook) ? __('Edit Ebook') : __('Create Ebook')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div>
            <flux:heading>{{ isset($ebook) ? __('Edit Ebook') : __('Create Ebook') }}</flux:heading>
            <flux:subheading>{{ isset($ebook) ? __('Update ebook information') : __('Add a new digital product') }}</flux:subheading>
        </div>

        <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white p-6 dark:bg-neutral-800">
            <form action="{{ isset($ebook) ? route('core.ebooks.update', $ebook) : route('core.ebooks.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @if(isset($ebook))
                    @method('PUT')
                @endif

                <div>
                    <flux:input
                        name="name"
                        :label="__('Name')"
                        type="text"
                        :value="old('name', $ebook->name ?? '')"
                        required
                        autofocus
                        :error="$errors->first('name')"
                    />
                </div>

                <div>
                    <flux:textarea
                        name="description"
                        :label="__('Description')"
                        rows="4"
                        :error="$errors->first('description')"
                    >{{ old('description', $ebook->description ?? '') }}</flux:textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        {{ __('Category') }}
                    </label>
                    <select
                        name="category_id"
                        required
                        class="w-full rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-3 py-2 text-sm text-neutral-900 dark:text-neutral-100 focus:border-accent focus:ring-2 focus:ring-accent focus:ring-offset-2 focus:ring-offset-neutral-50 dark:focus:ring-offset-neutral-800"
                    >
                        <option value="">{{ __('Select a category') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $ebook->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <flux:input
                        name="price"
                        :label="__('Price')"
                        type="number"
                        step="0.01"
                        min="0"
                        :value="old('price', $ebook->price ?? '')"
                        required
                        :error="$errors->first('price')"
                    />
                </div>

                <div>
                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        {{ __('File') }}
                        @if(!isset($ebook))
                            <span class="text-red-600 dark:text-red-400">*</span>
                        @endif
                    </label>
                    <input
                        type="file"
                        name="file"
                        accept=".pdf"
                        class="w-full rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-3 py-2 text-sm text-neutral-900 dark:text-neutral-100 focus:border-accent focus:ring-2 focus:ring-accent focus:ring-offset-2 focus:ring-offset-neutral-50 dark:focus:ring-offset-neutral-800"
                        @if(!isset($ebook)) required @endif
                    >
                    @if(isset($ebook) && $ebook->file)
                        <p class="mt-2 text-sm text-neutral-600 dark:text-neutral-400">
                            {{ __('Current file:') }}
                            <a href="{{ route('core.ebooks.download', $ebook) }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                                {{ __('Download current file') }}
                            </a>
                        </p>
                    @endif
                    @error('file')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-4">
                    <flux:button type="submit" variant="primary">
                        {{ isset($ebook) ? __('Update') : __('Create') }}
                    </flux:button>
                    <flux:button :href="route('core.ebooks.index')" variant="ghost" wire:navigate>
                        {{ __('Cancel') }}
                    </flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>

