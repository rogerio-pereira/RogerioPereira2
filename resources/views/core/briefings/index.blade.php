<x-layouts.app :title="__('Briefings')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="flex items-center justify-between">
            <div>
                <flux:heading>{{ __('Briefings') }}</flux:heading>
                <flux:subheading>{{ __('Manage service briefings') }}</flux:subheading>
            </div>
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
                                {{ __('Name') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                                {{ __('Email') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                                {{ __('Phone') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                                {{ __('Status') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                                {{ __('Created At') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                                {{ __('Actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-200 bg-white dark:divide-neutral-700 dark:bg-neutral-800">
                        @forelse ($briefings as $briefing)
                            <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-700/50">
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-neutral-900 dark:text-neutral-100">
                                    {{ $briefing->name }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-neutral-900 dark:text-neutral-100">
                                    {{ $briefing->email }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-neutral-900 dark:text-neutral-100">
                                    {{ $briefing->phone ?? '-' }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm">
                                    @if($briefing->status === 'done')
                                        <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-200">
                                            {{ __('Done') }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                            {{ __('New') }}
                                        </span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-neutral-900 dark:text-neutral-100">
                                    {{ $briefing->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-left text-sm font-medium">
                                    <div class="flex items-center gap-2">
                                        <flux:button :href="route('core.briefings.show', $briefing)" variant="ghost" size="sm" icon="magnifying-glass" wire:navigate class="!text-blue-600 dark:!text-blue-400 hover:!text-blue-700 dark:hover:!text-blue-300">
                                            <span class="sr-only">{{ __('View Briefing') }}</span>
                                        </flux:button>
                                        @if($briefing->status !== 'done')
                                            <form action="{{ route('core.briefings.mark-as-done', $briefing) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <flux:button type="submit" variant="ghost" size="sm" icon="check" class="!text-green-600 dark:!text-green-400 hover:!text-green-700 dark:hover:!text-green-300">
                                                    <span class="sr-only">{{ __('Mark as Done') }}</span>
                                                </flux:button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-sm text-neutral-500 dark:text-neutral-400">
                                    {{ __('No briefings found.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($briefings->hasPages())
            <div class="flex items-center justify-center">
                {{ $briefings->links() }}
            </div>
        @endif
    </div>
</x-layouts.app>

