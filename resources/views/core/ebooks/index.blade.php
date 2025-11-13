@php
    use Illuminate\Support\Facades\Storage;
@endphp

<x-layouts.app :title="__('Ebooks')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="flex items-center justify-between">
            <div>
                <flux:heading>{{ __('Ebooks') }}</flux:heading>
                <flux:subheading>{{ __('Manage your digital products') }}</flux:subheading>
            </div>
            <flux:button :href="route('core.ebooks.create')" variant="primary" wire:navigate>
                {{ __('Create Ebook') }}
            </flux:button>
        </div>

        @if (session('success'))
            <flux:callout variant="success" icon="check-circle" heading="{{ session('success') }}" />
        @endif

        <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <div class="overflow-x-auto">
                <table class="w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                    <thead class="bg-neutral-50 dark:bg-neutral-900">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                                {{ __('ID') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                                {{ __('Name') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                                {{ __('Category') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                                {{ __('Price') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                                {{ __('File') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                                {{ __('Actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-200 bg-white dark:divide-neutral-700 dark:bg-neutral-800">
                        @forelse ($ebooks as $ebook)
                            <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-700/50">
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-neutral-900 dark:text-neutral-100">
                                    {{ $ebook->id }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-neutral-900 dark:text-neutral-100">
                                    {{ $ebook->name }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm">
                                    @if($ebook->category)
                                        <div class="flex items-center gap-2">
                                            <div class="h-4 w-4 rounded border border-neutral-300 dark:border-neutral-600" style="background-color: {{ $ebook->category->color }}"></div>
                                            <span class="text-neutral-900 dark:text-neutral-100">{{ $ebook->category->name }}</span>
                                        </div>
                                    @else
                                        <span class="text-neutral-500 dark:text-neutral-400">-</span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-neutral-900 dark:text-neutral-100">
                                    R$ {{ number_format($ebook->price, 2, ',', '.') }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm">
                                    @if($ebook->file)
                                        <a href="{{ route('core.ebooks.download', $ebook) }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                                            {{ __('Download') }}
                                        </a>
                                    @else
                                        <span class="text-neutral-500 dark:text-neutral-400">-</span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        <flux:button :href="route('core.ebooks.edit', $ebook)" variant="ghost" size="sm" wire:navigate>
                                            {{ __('Edit') }}
                                        </flux:button>
                                        <form action="{{ route('core.ebooks.destroy', $ebook) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this ebook?') }}');">
                                            @csrf
                                            @method('DELETE')
                                            <flux:button type="submit" variant="ghost" size="sm" class="!text-red-600 dark:!text-red-400">
                                                {{ __('Delete') }}
                                            </flux:button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-sm text-neutral-500 dark:text-neutral-400">
                                    {{ __('No ebooks found.') }}
                                    <flux:link :href="route('core.ebooks.create')" class="mt-2 block" wire:navigate>
                                        {{ __('Create your first ebook') }}
                                    </flux:link>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($ebooks->hasPages())
            <div class="flex items-center justify-center">
                {{ $ebooks->links() }}
            </div>
        @endif
    </div>
</x-layouts.app>

