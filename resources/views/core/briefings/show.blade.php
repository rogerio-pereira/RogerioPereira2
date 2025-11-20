<x-layouts.app :title="__('Briefing Details')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="flex items-center justify-between">
            <div>
                <flux:heading>{{ __('Briefing Details') }}</flux:heading>
                <flux:subheading>{{ $briefing->name }} - {{ $briefing->email }}</flux:subheading>
            </div>
            <div class="flex items-center gap-2">
                <flux:button :href="route('core.briefings.index')" variant="ghost" wire:navigate>
                    {{ __('Back to List') }}
                </flux:button>
                @if($briefing->status !== 'done')
                    <form action="{{ route('core.briefings.mark-as-done', $briefing) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <flux:button type="submit" variant="primary">
                            {{ __('Mark as Done') }}
                        </flux:button>
                    </form>
                @endif
            </div>
        </div>

        @if (session('success'))
            <flux:callout variant="success" icon="check-circle" heading="{{ session('success') }}" />
        @endif

        <div class="grid gap-4">
            <!-- Contact Information -->
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
                <h3 class="mb-4 text-lg font-semibold text-neutral-900 dark:text-neutral-100">{{ __('Contact Information') }}</h3>
                <div class="grid gap-3 md:grid-cols-2">
                    <div>
                        <span class="text-sm font-medium text-neutral-500 dark:text-neutral-400">{{ __('Name') }}:</span>
                        <p class="text-neutral-900 dark:text-neutral-100">{{ $briefing->name }}</p>
                    </div>
                    <div>
                        <span class="text-sm font-medium text-neutral-500 dark:text-neutral-400">{{ __('Email') }}:</span>
                        <p class="text-neutral-900 dark:text-neutral-100">{{ $briefing->email }}</p>
                    </div>
                    @if($briefing->phone)
                        <div>
                            <span class="text-sm font-medium text-neutral-500 dark:text-neutral-400">{{ __('Phone') }}:</span>
                            <p class="text-neutral-900 dark:text-neutral-100">{{ $briefing->phone }}</p>
                        </div>
                    @endif
                    <div>
                        <span class="text-sm font-medium text-neutral-500 dark:text-neutral-400">{{ __('Status') }}:</span>
                        <p class="text-neutral-900 dark:text-neutral-100">
                            @if($briefing->status === 'done')
                                <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-200">
                                    {{ __('Done') }}
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    {{ __('New') }}
                                </span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <span class="text-sm font-medium text-neutral-500 dark:text-neutral-400">{{ __('Created At') }}:</span>
                        <p class="text-neutral-900 dark:text-neutral-100">{{ $briefing->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Briefing Sections -->
            @if(isset($briefing->briefing['sections']))
                @foreach($briefing->briefing['sections'] as $sectionName => $questions)
                    <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
                        <h3 class="mb-4 text-lg font-semibold text-neutral-900 dark:text-neutral-100">
                            {{ ucfirst(str_replace('_', ' ', $sectionName)) }}
                        </h3>
                        <div class="space-y-4">
                            @foreach($questions as $question)
                                @if(is_array($question) && count($question) >= 2)
                                    @php
                                        $value = $question[1];
                                        $isEmpty = empty($value) || $value === '' || $value === null;
                                        $isNo = $value === 'No' || $value === '0' || $value === 0;
                                        $shouldHide = $isEmpty || ($isNo && in_array($question[0], ['Logo', 'Visual identity', 'Domain', 'Hosting', 'Texts and images', 'None']));
                                    @endphp
                                    @if(!$shouldHide)
                                        <div>
                                            <span class="text-sm font-medium text-neutral-500 dark:text-neutral-400">{{ $question[0] }}:</span>
                                            @if(is_array($value))
                                                <p class="mt-1 text-neutral-900 dark:text-neutral-100">{{ implode(', ', $value) }}</p>
                                            @else
                                                <p class="mt-1 whitespace-pre-wrap text-neutral-900 dark:text-neutral-100">{{ $value }}</p>
                                            @endif
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</x-layouts.app>

