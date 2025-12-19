<div class="space-y-6" wire:poll.5s>
    {{-- Room Header --}}
    <div
        class="rounded-2xl overflow-hidden shadow-lg
        {{ $room->is_ready ? 'bg-gradient-to-r from-emerald-500 to-teal-600' : 'bg-gradient-to-r from-rose-500 to-pink-600' }}">
        <div class="p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">{{ $room->name }}</h1>
                    <p class="text-white/80">{{ $room->code ?? __('No Code') }} •
                        {{ $room->description ?? __('No Description') }}</p>
                </div>
                <div class="flex items-center gap-4">
                    {{-- Status Indicator --}}
                    <div class="flex items-center gap-2">
                        <div class="relative">
                            <div
                                class="w-6 h-6 rounded-full {{ $room->is_ready ? 'bg-white' : 'bg-white' }} animate-pulse">
                            </div>
                        </div>
                        <span class="text-lg font-semibold">
                            {{ $room->is_ready ? __('Ready') : __('Occupied') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Current Visit Information --}}
        <div class="lg:col-span-2">
            @if ($room->currentVisit)
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-primary-500 to-primary-600 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center gap-2">
                            <x-heroicon-o-clipboard-document-list class="w-6 h-6" />
                            {{ __('Current Visit Information') }}
                        </h2>
                    </div>


                    <div class="p-6 space-y-6">
                        {{-- Patient Card --}}
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-16 h-16 rounded-full bg-primary-500 flex items-center justify-center text-white text-2xl font-bold">
                                    {{ substr($room->currentVisit->patient->name ?? 'P', 0, 1) }}
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                                        {{ $room->currentVisit->patient->name ?? __('Unknown Patient') }}
                                    </h3>
                                    <div class="flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400">
                                        <span class="flex items-center gap-1">
                                            <x-heroicon-o-calendar class="w-4 h-4" />
                                            {{ $room->currentVisit->patient->age ?? '-' }} {{ __('years old') }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <x-heroicon-o-phone class="w-4 h-4" />
                                            {{ $room->currentVisit->patient->phone ?? '-' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Visit Details Grid --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-4">
                                <p class="text-xs text-blue-600 dark:text-blue-400 uppercase tracking-wide mb-1">
                                    {{ __('Visit ID') }}</p>
                                <p class="text-lg font-bold text-gray-900 dark:text-white">
                                    #{{ $room->currentVisit->id }}</p>
                            </div>

                            <div class="bg-purple-50 dark:bg-purple-900/20 rounded-xl p-4">
                                <p class="text-xs text-purple-600 dark:text-purple-400 uppercase tracking-wide mb-1">
                                    {{ __('Service') }}</p>
                                <p class="text-lg font-bold text-gray-900 dark:text-white">
                                    {{ $room->currentVisit->service->name ?? '-' }}</p>
                            </div>

                            <div class="bg-amber-50 dark:bg-amber-900/20 rounded-xl p-4">
                                <p class="text-xs text-amber-600 dark:text-amber-400 uppercase tracking-wide mb-1">
                                    {{ __('Arrival Time') }}</p>
                                <p class="text-lg font-bold text-gray-900 dark:text-white">
                                    {{ $room->currentVisit->arrival_time ?? '-' }}</p>
                            </div>

                            <div class="bg-green-50 dark:bg-green-900/20 rounded-xl p-4">
                                <p class="text-xs text-green-600 dark:text-green-400 uppercase tracking-wide mb-1">
                                    {{ __('Status') }}</p>
                                <p class="text-lg font-bold text-gray-900 dark:text-white">
                                    {{ ucfirst($room->currentVisit->status ?? '-') }}</p>
                            </div>
                        </div>

                        {{-- Chief Complaint --}}
                        @if ($room->currentVisit->chief_complaint)
                            <div class="bg-rose-50 dark:bg-rose-900/20 rounded-xl p-4">
                                <p class="text-xs text-rose-600 dark:text-rose-400 uppercase tracking-wide mb-2">
                                    {{ __('Chief Complaint') }}</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ((array) $room->currentVisit->chief_complaint as $complaint)
                                        <span
                                            class="px-3 py-1 bg-rose-100 dark:bg-rose-800 text-rose-700 dark:text-rose-200 rounded-full text-sm">
                                            {{ $complaint }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Medical History --}}
                        @if ($room->currentVisit->medical_history)
                            <div class="bg-indigo-50 dark:bg-indigo-900/20 rounded-xl p-4">
                                <p class="text-xs text-indigo-600 dark:text-indigo-400 uppercase tracking-wide mb-2">
                                    {{ __('Medical History') }}</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ((array) $room->currentVisit->medical_history as $history)
                                        <span
                                            class="px-3 py-1 bg-indigo-100 dark:bg-indigo-800 text-indigo-700 dark:text-indigo-200 rounded-full text-sm">
                                            {{ $history }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Notes --}}
                        @if ($room->currentVisit->notes || $room->currentVisit->secretary_description)
                            <div class="bg-gray-100 dark:bg-gray-700 rounded-xl p-4">
                                <p class="text-xs text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">
                                    {{ __('Notes') }}</p>
                                <p class="text-gray-700 dark:text-gray-300">
                                    {{ $room->currentVisit->notes ?? ($room->currentVisit->secretary_description ?? '-') }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-12 text-center">
                    <x-heroicon-o-user class="w-20 h-20 mx-auto mb-4 text-gray-300 dark:text-gray-600" />
                    <h3 class="text-xl font-semibold text-gray-600 dark:text-gray-300 mb-2">
                        {{ __('No Patient Assigned') }}</h3>
                    <p class="text-gray-500 dark:text-gray-400">
                        {{ __('This room is currently empty. Assign a patient from the dashboard.') }}</p>
                    <a href="{{ \Modules\Room\Filament\Pages\RoomsDashboard::getUrl() }}"
                        class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors">
                        <x-heroicon-o-arrow-left class="w-5 h-5" />
                        {{ __('Back to Dashboard') }}
                    </a>
                </div>
            @endif
        </div>

        {{-- Actions Panel --}}
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden sticky top-4">
                <div class="bg-gradient-to-r from-gray-700 to-gray-800 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center gap-2">
                        <x-heroicon-o-cog-6-tooth class="w-6 h-6" />
                        {{ __('Room Controls') }}
                    </h2>
                </div>

                <div class="p-6 space-y-4">
                    {{-- Ready Status Toggle --}}
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">{{ __('Current Status') }}</p>
                        <div class="flex items-center justify-between">
                            <span class="font-semibold text-gray-900 dark:text-white">
                                {{ $room->is_ready ? __('Ready for Patient') : __('Patient Being Seen') }}
                            </span>
                            <div class="w-4 h-4 rounded-full {{ $room->is_ready ? 'bg-emerald-500' : 'bg-rose-500' }}">
                            </div>
                        </div>
                    </div>

                    @if ($room->currentVisit)
                        @if ($room->is_ready)
                            <button wire:click="markNotReady"
                                class="w-full py-3 px-4 bg-amber-500 hover:bg-amber-600 text-white rounded-xl font-semibold transition-colors flex items-center justify-center gap-2">
                                <x-heroicon-o-pause-circle class="w-5 h-5" />
                                {{ __('Mark as Not Ready') }}
                            </button>
                        @else
                            <button wire:click="markReady"
                                class="w-full py-3 px-4 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl font-semibold transition-colors flex items-center justify-center gap-2">
                                <x-heroicon-o-check-circle class="w-5 h-5" />
                                {{ __('Mark as Ready') }}
                            </button>
                        @endif

                        <hr class="border-gray-200 dark:border-gray-600">

                        <button wire:click="completeVisit"
                            wire:confirm="{{ __('Are you sure you want to complete this visit and free the room?') }}"
                            class="w-full py-3 px-4 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white rounded-xl font-semibold transition-all flex items-center justify-center gap-2 shadow-lg">
                            <x-heroicon-o-check-badge class="w-5 h-5" />
                            {{ __('Complete Visit & Free Room') }}
                        </button>
                    @endif

                    <hr class="border-gray-200 dark:border-gray-600">

                    <a href="{{ \Modules\Room\Filament\Pages\RoomsDashboard::getUrl() }}"
                        class="w-full py-3 px-4 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl font-semibold transition-colors flex items-center justify-center gap-2">
                        <x-heroicon-o-arrow-left class="w-5 h-5" />
                        {{ __('Back to Dashboard') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
