<x-layouts.app :title="isset($category) ? __('Edit Category') : __('Create Category')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div>
            <flux:heading>{{ isset($category) ? __('Edit Category') : __('Create Category') }}</flux:heading>
            <flux:subheading>{{ isset($category) ? __('Update category information') : __('Add a new product category') }}</flux:subheading>
        </div>

        <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white p-6 dark:bg-neutral-800">
            <form action="{{ isset($category) ? route('core.categories.update', $category) : route('core.categories.store') }}" method="POST" class="space-y-6">
                @csrf
                @if(isset($category))
                    @method('PUT')
                @endif

                <div>
                    <flux:input
                        name="name"
                        :label="__('Name')"
                        type="text"
                        :value="old('name', $category->name ?? '')"
                        required
                        autofocus
                        :error="$errors->first('name')"
                    />
                </div>

                <div>
                    <flux:input
                        name="color"
                        :label="__('Color')"
                        type="color"
                        :value="old('color', $category->color ?? '#3b82f6')"
                        :error="$errors->first('color')"
                    />
                </div>

                <div class="flex items-center gap-4">
                    <flux:button type="submit" variant="primary">
                        {{ isset($category) ? __('Update') : __('Create') }}
                    </flux:button>
                    <flux:button :href="route('core.categories.index')" variant="ghost" wire:navigate>
                        {{ __('Cancel') }}
                    </flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>

