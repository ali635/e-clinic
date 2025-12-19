<div>
    {{-- Pending Visits Section --}}
    <div class="mb-8">
        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
            <x-heroicon-o-clock class="w-6 h-6 text-amber-500" />
            {{ __('Pending Visits (Arrived)') }}
        </h2>

        @if ($this->getPendingVisits()->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ($this->getPendingVisits() as $visit)
                    <div
                        class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-700 rounded-xl p-4 shadow-sm">
                        <div class="flex items-center gap-3 mb-3">
                            <div
                                class="w-10 h-10 rounded-full bg-amber-500 flex items-center justify-center text-white font-bold">
                                {{ substr($visit->patient->name ?? 'P', 0, 1) }}
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-white">
                                    {{ $visit->patient->name ?? __('Unknown') }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ __('Visit #') }}{{ $visit->id }}</p>
                            </div>
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-300 mb-3">
                            <p><strong>{{ __('Service') }}:</strong> {{ $visit->service->name ?? '-' }}</p>
                            <p><strong>{{ __('Arrival') }}:</strong> {{ $visit->arrival_time ?? '-' }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-gray-100 dark:bg-gray-800 rounded-xl p-6 text-center text-gray-500 dark:text-gray-400">
                <x-heroicon-o-inbox class="w-12 h-12 mx-auto mb-2 opacity-50" />
                <p>{{ __('No pending visits at the moment') }}</p>
            </div>
        @endif
    </div>

    {{-- Rooms Grid --}}
    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
        <x-heroicon-o-building-office-2 class="w-6 h-6 text-primary-500" />
        {{ __('Rooms Status') }}
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" wire:poll.5s>
        @foreach ($this->getRooms() as $room)
            <div
                class="relative overflow-hidden rounded-2xl shadow-lg transition-all duration-300 hover:shadow-xl
                {{ $room->is_ready ? 'bg-gradient-to-br from-emerald-400 to-emerald-600' : 'bg-gradient-to-br from-rose-400 to-rose-600' }}">

                {{-- Status Indicator Light --}}
                <div class="absolute top-4 right-4">
                    <div class="relative">
                        <div
                            class="w-4 h-4 rounded-full {{ $room->is_ready ? 'bg-emerald-200' : 'bg-rose-200' }} animate-ping absolute">
                        </div>
                        <div class="w-4 h-4 rounded-full {{ $room->is_ready ? 'bg-white' : 'bg-white' }} relative">
                        </div>
                    </div>
                </div>

                <div class="p-6 text-white">
                    {{-- Room Header --}}
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold mb-1">{{ $room->name }}</h3>
                        <p class="text-white/80 text-sm">{{ $room->code ?? __('No Code') }}</p>
                    </div>

                    {{-- Status Badge --}}
                    <div class="mb-4">
                        <span
                            class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm font-medium
                            {{ $room->is_ready ? 'bg-white/20 text-white' : 'bg-white/20 text-white' }}">
                            @if ($room->is_ready)
                                <x-heroicon-s-check-circle class="w-4 h-4" />
                                {{ __('Ready') }}
                            @else
                                <x-heroicon-s-clock class="w-4 h-4" />
                                {{ __('Occupied') }}
                            @endif
                        </span>
                    </div>

                    {{-- Current Patient Info --}}
                    @if ($room->currentVisit && $room->currentVisit->patient)
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 mb-4">
                            <p class="text-white/70 text-xs uppercase tracking-wide mb-2">{{ __('Current Patient') }}
                            </p>
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center text-xl font-bold">
                                    {{ substr($room->currentVisit->patient->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-lg">{{ $room->currentVisit->patient->name }}</p>
                                    <p class="text-white/70 text-sm">{{ $room->currentVisit->patient->age ?? '-' }}
                                        {{ __('years') }}</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 mb-4 text-center">
                            <x-heroicon-o-user class="w-8 h-8 mx-auto mb-2 text-white/50" />
                            <p class="text-white/70">{{ __('No patient assigned') }}</p>
                        </div>
                    @endif

                    {{-- Action Buttons --}}
                    <div class="flex flex-col gap-2">
                        @if ($room->currentVisit)
                            {{-- Toggle Ready/Not Ready --}}
                            @if ($room->is_ready)
                                <button wire:click="markRoomNotReady({{ $room->id }})"
                                    class="w-full py-2 px-4 bg-white/20 hover:bg-white/30 rounded-lg font-medium transition-colors flex items-center justify-center gap-2">
                                    <x-heroicon-o-pause-circle class="w-5 h-5" />
                                    {{ __('Mark Not Ready') }}
                                </button>
                            @else
                                <button wire:click="markRoomReady({{ $room->id }})"
                                    class="w-full py-2 px-4 bg-white/20 hover:bg-white/30 rounded-lg font-medium transition-colors flex items-center justify-center gap-2">
                                    <x-heroicon-o-check-circle class="w-5 h-5" />
                                    {{ __('Mark Ready') }}
                                </button>
                            @endif

                            {{-- Complete Visit Button --}}
                            <button wire:click="completeVisit({{ $room->id }})"
                                wire:confirm="{{ __('Are you sure you want to complete this visit?') }}"
                                class="w-full py-2 px-4 bg-white text-gray-800 hover:bg-gray-100 rounded-lg font-medium transition-colors flex items-center justify-center gap-2">
                                <x-heroicon-o-check-badge class="w-5 h-5" />
                                {{ __('Complete & Free Room') }}
                            </button>
                        @else
                            {{-- Assign Patient Dropdown --}}
                            @if ($this->getPendingVisits()->count() > 0)
                                <div x-data="{ open: false }" class="relative">
                                    <button @click="open = !open"
                                        class="w-full py-2 px-4 bg-white text-gray-800 hover:bg-gray-100 rounded-lg font-medium transition-colors flex items-center justify-center gap-2">
                                        <x-heroicon-o-user-plus class="w-5 h-5" />
                                        {{ __('Assign Patient') }}
                                    </button>
                                    <div x-show="open" @click.away="open = false" x-transition
                                        class="absolute bottom-full left-0 right-0 mb-2 bg-white rounded-lg shadow-xl overflow-hidden z-10">
                                        @foreach ($this->getPendingVisits() as $visit)
                                            <button
                                                wire:click="assignVisitToRoom({{ $room->id }}, {{ $visit->id }})"
                                                @click="open = false"
                                                class="w-full px-4 py-3 text-left text-gray-700 hover:bg-gray-100 flex items-center gap-3 border-b border-gray-100 last:border-0">
                                                <div
                                                    class="w-8 h-8 rounded-full bg-amber-500 flex items-center justify-center text-white text-sm font-bold">
                                                    {{ substr($visit->patient->name ?? 'P', 0, 1) }}
                                                </div>
                                                <div>
                                                    <p class="font-medium">{{ $visit->patient->name ?? __('Unknown') }}
                                                    </p>
                                                    <p class="text-xs text-gray-500">
                                                        {{ __('Visit #') }}{{ $visit->id }}</p>
                                                </div>
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <p class="text-center text-white/70 text-sm py-2">
                                    {{ __('No pending visits to assign') }}</p>
                            @endif
                        @endif

                        {{-- View Room Details Link --}}
                        <a href="{{ route('filament.admin.pages.room-view', ['roomId' => $room->id]) }}"
                            class="w-full py-2 px-4 border border-white/30 hover:bg-white/10 rounded-lg font-medium transition-colors flex items-center justify-center gap-2 text-center">
                            <x-heroicon-o-eye class="w-5 h-5" />
                            {{ __('View Details') }}
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if ($this->getRooms()->count() === 0)
        <div class="bg-gray-100 dark:bg-gray-800 rounded-xl p-12 text-center">
            <x-heroicon-o-building-office-2 class="w-16 h-16 mx-auto mb-4 text-gray-400" />
            <h3 class="text-xl font-semibold text-gray-600 dark:text-gray-300 mb-2">{{ __('No Rooms Created Yet') }}
            </h3>
            <p class="text-gray-500 dark:text-gray-400 mb-4">{{ __('Create rooms to start managing patient flow') }}
            </p>
            <a href="{{ \Modules\Room\Filament\Resources\Rooms\RoomResource::getUrl('create') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors">
                <x-heroicon-o-plus class="w-5 h-5" />
                {{ __('Create Room') }}
            </a>
        </div>
    @endif
</div>
