<x-filament-panels::page>
    {{-- Pending Visits Section --}}
    <x-filament::section icon="heroicon-o-clock" icon-color="warning" :heading="__('Pending Visits (Arrived)')" :description="__('Patients who have arrived and are waiting for assignment')" class="mb-8">
        <x-slot:headerActions>
            <x-filament::badge color="warning" size="lg">
                {{ trans_choice(':count arrived patient|:count arrived patients', $this->getPendingVisits()->count()) }}
            </x-filament::badge>
        </x-slot:headerActions>

        @if ($this->getPendingVisits()->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach ($this->getPendingVisits() as $visit)
                    <x-filament::card
                        class="bg-gradient-to-br from-white to-amber-50 dark:from-gray-800 dark:to-amber-900/10 border-amber-200 dark:border-amber-800/50 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="flex items-center gap-3 mb-4">
                            {{-- <x-filament::avatar :initials="strtoupper(substr($visit->patient->name ?? 'P', 0, 1))" color="warning" size="lg" /> --}}

                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-gray-900 dark:text-white text-lg truncate">
                                    {{ $visit->patient->name ?? __('Unknown') }}
                                </p>
                                <div class="flex items-center gap-2 mt-1">
                                    <x-filament::badge color="warning" size="sm">
                                        {{ __('Visit') }} #{{ $visit->id }}
                                    </x-filament::badge>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('Waiting') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2 mb-4">
                            <div class="flex items-center gap-2 text-sm">
                                <x-filament::icon icon="heroicon-o-beaker" class="w-4 h-4 text-blue-500" />
                                <span class="text-gray-500 dark:text-gray-400">{{ __('Service') }}:</span>
                                <span class="font-medium text-gray-900 dark:text-white truncate">
                                    {{ $visit->service->name ?? __('N/A') }}
                                </span>
                            </div>
                            <div class="flex items-center gap-2 text-sm">
                                <x-filament::icon icon="heroicon-o-calendar" class="w-4 h-4 text-emerald-500" />
                                <span class="text-gray-500 dark:text-gray-400">{{ __('Arrival') }}:</span>
                                <span class="font-medium text-gray-900 dark:text-white">
                                    @if ($visit->arrival_time)
                                        {{ \Carbon\Carbon::parse($visit->arrival_time)->diffForHumans() }}
                                    @else
                                        {{ __('N/A') }}
                                    @endif
                                </span>
                            </div>
                        </div>

                        <x-filament::button wire:click="assignFirstRoom({{ $visit->id }})" color="warning"
                            icon="heroicon-o-arrow-right-circle" class="w-full">
                            {{ __('Assign to Room') }}
                        </x-filament::button>
                    </x-filament::card>
                @endforeach
            </div>
        @else
            <x-filament::empty-state icon="heroicon-o-inbox" :heading="__('All Clear!')" :description="__('No pending visits at the moment. All patients have been attended to.')" />
        @endif
    </x-filament::section>

    {{-- Rooms Status Section --}}
    <x-filament::section icon="heroicon-o-building-office-2" :heading="__('Rooms Status')" :description="__('Real-time room availability and patient assignments')">
        <x-slot:headerActions>
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></div>
                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('Available') }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-blue-500 animate-pulse"></div>
                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('With Assistant Dr.') }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-amber-500 animate-pulse"></div>
                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('With Main Dr.') }}</span>
                </div>
            </div>
        </x-slot:headerActions>

        @if ($this->getRooms()->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4" wire:poll.5s>
                @foreach ($this->getRooms() as $room)
                    @php
                        $statusColor = $room->getStatusColor();
                        $borderColor = match ($room->doctor_stage) {
                            'available' => 'border-emerald-200 dark:border-emerald-800/50',
                            'waiting_assistant' => 'border-blue-200 dark:border-blue-800/50',
                            'waiting_main' => 'border-amber-200 dark:border-amber-800/50',
                            default => 'border-gray-200 dark:border-gray-800/50',
                        };
                        $bgColor = match ($room->doctor_stage) {
                            'available' => 'from-white to-emerald-50 dark:from-gray-800 dark:to-emerald-900/10',
                            'waiting_assistant' => 'from-white to-blue-50 dark:from-gray-800 dark:to-blue-900/10',
                            'waiting_main' => 'from-white to-amber-50 dark:from-gray-800 dark:to-amber-900/10',
                            default => 'from-white to-gray-50 dark:from-gray-800 dark:to-gray-900/10',
                        };
                    @endphp

                    <x-filament::card
                        class="bg-gradient-to-br {{ $bgColor }} {{ $borderColor }} hover:shadow-xl transition-all duration-300 hover:-translate-y-1" style="margin-bottom: 10px;">
                        {{-- Room Header --}}
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-gray-900 dark:text-white text-lg truncate">{{ $room->name }}
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $room->code ?? __('No Code') }}
                                </p>
                            </div>
                            <x-filament::badge :color="$statusColor" size="sm">
                                {{ $room->getStatusLabel() }}
                            </x-filament::badge>
                        </div>

                        {{-- Patient Info Section --}}
                        @if ($room->currentVisit && $room->currentVisit->patient)
                            <div class="space-y-2 mb-4 p-3 bg-gray-50 dark:bg-gray-900/50 rounded-lg">
                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">
                                    {{ __('Current Patient') }}
                                </p>
                                <div class="flex items-center gap-2 text-sm">
                                    <x-filament::icon icon="heroicon-o-user" class="w-4 h-4 text-blue-500" />
                                    <span class="text-gray-500 dark:text-gray-400">{{ __('Name') }}:</span>
                                    <span class="font-medium text-gray-900 dark:text-white truncate">
                                        {{ $room->currentVisit->patient->name }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-2 text-sm">
                                    <x-filament::icon icon="heroicon-o-hashtag" class="w-4 h-4 text-blue-500" />
                                    <span class="text-gray-500 dark:text-gray-400">{{ __('Visit') }}:</span>
                                    <span class="font-medium text-gray-900 dark:text-white">
                                        #{{ $room->currentVisit->id }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-2 text-sm">
                                    <x-filament::icon icon="heroicon-o-beaker" class="w-4 h-4 text-blue-500" />
                                    <span class="text-gray-500 dark:text-gray-400">{{ __('Service') }}:</span>
                                    <span class="font-medium text-gray-900 dark:text-white truncate">
                                        {{ $room->currentVisit->service->name ?? __('N/A') }}
                                    </span>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-6 mb-4">
                                <x-filament::icon icon="heroicon-o-user" class="w-12 h-12 mx-auto text-gray-400 mb-2" />
                                <p class="font-medium text-gray-700 dark:text-gray-300">{{ __('No patient assigned') }}
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                    {{ __('Ready for next patient') }}</p>
                            </div>
                        @endif

                        {{-- Action Buttons --}}
                        <div class="space-y-2">
                            @if ($room->currentVisit)
                                <div class="grid grid-cols-2 gap-2">
                                    @if ($room->doctor_stage === 'waiting_assistant')
                                        <x-filament::button wire:click="markAssistantDone({{ $room->id }})"
                                            color="info" icon="heroicon-o-check-circle" size="sm"
                                            class="col-span-2">
                                            {{ __('Assistant Done') }}
                                        </x-filament::button>
                                    @elseif($room->doctor_stage === 'waiting_main')
                                        <x-filament::button wire:click="markMainDone({{ $room->id }})"
                                            color="success" icon="heroicon-o-check-badge" size="sm"
                                            class="col-span-2">
                                            {{ __('Main Dr. Done') }}
                                        </x-filament::button>
                                    @endif
                                </div>
                            @else
                                @if ($this->getPendingVisits()->count() > 0)
                                    <div x-data="{ open: false }" class="relative">
                                        <x-filament::button @click="open = !open" color="warning"
                                            icon="heroicon-o-user-plus" class="w-full" size="sm">
                                            {{ __('Assign Patient') }}
                                        </x-filament::button>

                                        <div x-show="open" @click.away="open = false"
                                            x-transition:enter="transition ease-out duration-200"
                                            x-transition:enter-start="opacity-0 scale-95"
                                            x-transition:enter-end="opacity-100 scale-100"
                                            x-transition:leave="transition ease-in duration-150"
                                            x-transition:leave-start="opacity-100 scale-100"
                                            x-transition:leave-end="opacity-0 scale-95"
                                            class="absolute bottom-full left-0 right-0 mb-2 z-50">
                                            <div
                                                class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700 overflow-hidden max-h-72 flex flex-col">
                                                {{-- Header --}}
                                                <div
                                                    class="p-4 bg-gradient-to-r from-amber-500 to-orange-500 text-white">
                                                    <div class="flex items-center justify-between">
                                                        <div>
                                                            <h3 class="font-bold text-sm">
                                                                {{ __('Select Patient to Assign') }}</h3>
                                                            <p class="text-xs text-white/80 mt-0.5">
                                                                {{ $this->getPendingVisits()->count() }}
                                                                {{ trans_choice('patient waiting|patients waiting', $this->getPendingVisits()->count()) }}
                                                            </p>
                                                        </div>
                                                        <button @click="open = false"
                                                            class="text-white/80 hover:text-white transition-colors">
                                                            <x-filament::icon icon="heroicon-o-x-mark"
                                                                class="w-5 h-5" />
                                                        </button>
                                                    </div>
                                                </div>

                                                {{-- Patient List --}}
                                                <div class="overflow-y-auto flex-1">
                                                    @foreach ($this->getPendingVisits() as $index => $visit)
                                                        <button
                                                            wire:click="assignVisitToRoom({{ $room->id }}, {{ $visit->id }})"
                                                            @click="open = false"
                                                            class="w-full p-4 text-left hover:bg-gradient-to-r hover:from-amber-50 hover:to-orange-50 dark:hover:from-amber-900/20 dark:hover:to-orange-900/20 border-b border-gray-100 dark:border-gray-700 last:border-0 transition-all duration-200 group">
                                                            <div class="flex items-center gap-3">
                                                                {{-- Avatar --}}
                                                                <div class="relative flex-shrink-0">
                                                                    <div
                                                                        class="w-10 h-10 rounded-full bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-white font-bold shadow-md group-hover:shadow-lg transition-shadow">
                                                                        {{ strtoupper(substr($visit->patient->name ?? 'P', 0, 1)) }}
                                                                    </div>
                                                                    <div
                                                                        class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-emerald-500 rounded-full border-2 border-white dark:border-gray-800">
                                                                    </div>
                                                                </div>

                                                                {{-- Patient Info --}}
                                                                <div class="flex-1 min-w-0">
                                                                    <div class="flex items-center gap-2 mb-1">
                                                                        <p
                                                                            class="font-semibold text-gray-900 dark:text-white truncate">
                                                                            {{ $visit->patient->name ?? __('Unknown Patient') }}
                                                                        </p>
                                                                        <x-filament::badge color="warning"
                                                                            size="xs">
                                                                            #{{ $visit->id }}
                                                                        </x-filament::badge>
                                                                    </div>
                                                                    <div
                                                                        class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                                                                        <x-filament::icon icon="heroicon-o-beaker"
                                                                            class="w-3.5 h-3.5" />
                                                                        <span
                                                                            class="truncate">{{ $visit->service->name ?? __('No service') }}</span>
                                                                    </div>
                                                                    @if ($visit->arrival_time)
                                                                        <div
                                                                            class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                                            <x-filament::icon icon="heroicon-o-clock"
                                                                                class="w-3.5 h-3.5" />
                                                                            <span>{{ \Carbon\Carbon::parse($visit->arrival_time)->diffForHumans() }}</span>
                                                                        </div>
                                                                    @endif
                                                                </div>

                                                                {{-- Arrow Icon --}}
                                                                <x-filament::icon icon="heroicon-o-arrow-right-circle"
                                                                    class="w-5 h-5 text-gray-300 group-hover:text-amber-500 transition-colors flex-shrink-0" />
                                                            </div>
                                                        </button>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <x-filament::badge color="gray" class="w-full justify-center">
                                        {{ __('No pending visits') }}
                                    </x-filament::badge>
                                @endif
                            @endif

                            {{-- View Details Button --}}
                            <x-filament::button tag="a" :href="route('filament.admin.pages.room-view', ['roomId' => $room->id])" color="gray" icon="heroicon-o-eye"
                                outlined class="w-full" size="sm" style="margin-top: 5px;">
                                {{ __('View Details') }}
                            </x-filament::button>
                        </div>
                    </x-filament::card>
                @endforeach
            </div>
        @else
            <x-filament::empty-state icon="heroicon-o-building-office-2" :heading="__('No Rooms Created Yet')" :description="__('Create treatment rooms to start managing patient flow and appointments efficiently.')">
                <x-slot:actions>
                    <x-filament::button tag="a" :href="\Modules\Room\Filament\Resources\Rooms\RoomResource::getUrl('create')" icon="heroicon-o-plus-circle"
                        color="primary">
                        {{ __('Create First Room') }}
                    </x-filament::button>
                </x-slot:actions>
            </x-filament::empty-state>
        @endif
    </x-filament::section>
</x-filament-panels::page>
