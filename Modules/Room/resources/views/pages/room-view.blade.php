<x-filament-panels::page>
    <div class="space-y-6" wire:poll.5s>
        {{-- Room Header Card --}}
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

        <x-filament::card class="bg-gradient-to-br {{ $bgColor }} {{ $borderColor }}" style="margin-bottom: 10px;">
            <div class="flex items-start justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">{{ $room->name }}</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ $room->code ?? __('No Code') }}
                        @if ($room->description)
                            • {{ $room->description }}
                        @endif
                    </p>
                </div>
                <x-filament::badge :color="$statusColor" size="lg">
                    {{ $room->getStatusLabel() }}
                </x-filament::badge>
            </div>
        </x-filament::card>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Current Visit Information --}}
            <div class="lg:col-span-2" style="margin-bottom: 10px;">
                <x-filament::section icon="heroicon-o-clipboard-document-list" :heading="__('Current Visit Information')">
                    @if ($room->currentVisit)
                        <div class="space-y-6">
                            {{-- Patient Card --}}
                            <x-filament::card
                                class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border-blue-200 dark:border-blue-800/50">
                                <div class="flex items-center gap-4 mb-4">
                                    {{-- <div
                                        class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                                        {{ strtoupper(substr($room->currentVisit->patient->name ?? 'P', 0, 1)) }}
                                    </div> --}}
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-xl font-bold text-gray-900 dark:text-white truncate">
                                            {{ $room->currentVisit->patient->name ?? __('Unknown Patient') }}
                                        </h3>
                                        <div
                                            class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400 mt-1">
                                            <span class="flex items-center gap-1">
                                                <x-filament::icon icon="heroicon-o-calendar" class="w-4 h-4" />
                                                {{ $room->currentVisit->patient->age ?? '-' }} {{ __('yrs') }}
                                            </span>
                                            <span>•</span>
                                            <span class="flex items-center gap-1 truncate">
                                                <x-filament::icon icon="heroicon-o-phone" class="w-4 h-4" />
                                                {{ $room->currentVisit->patient->phone ?? '-' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </x-filament::card>

                            {{-- Visit Details Grid --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div class="p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg">
                                    <div class="flex items-center gap-2 mb-2">
                                        <x-filament::icon icon="heroicon-o-hashtag" class="w-4 h-4 text-blue-500" />
                                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                                            {{ __('Visit ID') }}</p>
                                    </div>
                                    <p class="text-lg font-bold text-gray-900 dark:text-white">
                                        #{{ $room->currentVisit->id }}</p>
                                </div>

                                <div class="p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg">
                                    <div class="flex items-center gap-2 mb-2">
                                        <x-filament::icon icon="heroicon-o-beaker" class="w-4 h-4 text-purple-500" />
                                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                                            {{ __('Service') }}</p>
                                    </div>
                                    <p class="text-lg font-bold text-gray-900 dark:text-white truncate">
                                        {{ $room->currentVisit->service->name ?? '-' }}</p>
                                </div>

                                <div class="p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg">
                                    <div class="flex items-center gap-2 mb-2">
                                        <x-filament::icon icon="heroicon-o-clock" class="w-4 h-4 text-amber-500" />
                                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                                            {{ __('Arrival Time') }}</p>
                                    </div>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ $room->currentVisit->arrival_time ? \Carbon\Carbon::parse($room->currentVisit->arrival_time)->format('Y-m-d H:i') : '-' }}
                                    </p>
                                </div>

                                <div class="p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg">
                                    <div class="flex items-center gap-2 mb-2">
                                        <x-filament::icon icon="heroicon-o-information-circle"
                                            class="w-4 h-4 text-green-500" />
                                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                                            {{ __('Status') }}</p>
                                    </div>
                                    <x-filament::badge :color="$room->currentVisit->status === 'complete' ? 'success' : 'warning'">
                                        {{ ucfirst($room->currentVisit->status ?? '-') }}
                                    </x-filament::badge>
                                </div>
                            </div>

                            {{-- Chief Complaint --}}
                            @if ($room->currentVisit->chief_complaint)
                                <div class="p-4 bg-rose-50 dark:bg-rose-900/20 rounded-lg">
                                    <div class="flex items-center gap-2 mb-3">
                                        <x-filament::icon icon="heroicon-o-exclamation-triangle"
                                            class="w-4 h-4 text-rose-500" />
                                        <p
                                            class="text-xs text-rose-600 dark:text-rose-400 uppercase tracking-wide font-semibold">
                                            {{ __('Chief Complaint') }}</p>
                                    </div>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ((array) $room->currentVisit->chief_complaint as $complaint)
                                            <x-filament::badge color="danger"
                                                size="sm">{{ $complaint }}</x-filament::badge>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Medical History --}}
                            @if ($room->currentVisit->medical_history)
                                <div class="p-4 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg">
                                    <div class="flex items-center gap-2 mb-3">
                                        <x-filament::icon icon="heroicon-o-document-text"
                                            class="w-4 h-4 text-indigo-500" />
                                        <p
                                            class="text-xs text-indigo-600 dark:text-indigo-400 uppercase tracking-wide font-semibold">
                                            {{ __('Medical History') }}</p>
                                    </div>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ((array) $room->currentVisit->medical_history as $history)
                                            <x-filament::badge color="info"
                                                size="sm">{{ $history }}</x-filament::badge>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Notes --}}
                            @if ($room->currentVisit->notes || $room->currentVisit->secretary_description)
                                <div class="p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                                    <div class="flex items-center gap-2 mb-2">
                                        <x-filament::icon icon="heroicon-o-pencil-square"
                                            class="w-4 h-4 text-gray-600" />
                                        <p
                                            class="text-xs text-gray-600 dark:text-gray-400 uppercase tracking-wide font-semibold">
                                            {{ __('Notes') }}</p>
                                    </div>
                                    <p class="text-sm text-gray-700 dark:text-gray-300">
                                        {!! $room->currentVisit->notes ?? ($room->currentVisit->secretary_description ?? '-') !!}
                                    </p>
                                </div>
                            @endif
                        </div>
                    @else
                        <x-filament::empty-state icon="heroicon-o-user" :heading="__('No Patient Assigned')" :description="__('This room is currently empty. Assign a patient from the dashboard.')">
                            <x-slot:actions>
                                <x-filament::button tag="a" :href="\Modules\Room\Filament\Pages\RoomsDashboard::getUrl()" icon="heroicon-o-arrow-left"
                                    color="primary">
                                    {{ __('Back to Dashboard') }}
                                </x-filament::button>
                            </x-slot:actions>
                        </x-filament::empty-state>
                    @endif
                </x-filament::section>
            </div>

            {{-- Actions Panel --}}
            <div class="lg:col-span-1" style="margin-bottom: 5px;">
                <x-filament::section icon="heroicon-o-cog-6-tooth" :heading="__('Room Controls')">
                    <div class="space-y-4">
                        {{-- Ready Status --}}
                        <div class="p-3 bg-gray-50 dark:bg-gray-900/50 rounded-lg">
                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">
                                {{ __('Current Status') }}</p>
                            <div class="flex items-center justify-between">
                                <span class="font-semibold text-gray-900 dark:text-white text-sm">
                                    {{ $room->getStatusLabel() }}
                                </span>
                                <div
                                    class="w-3 h-3 rounded-full animate-pulse
                                    {{ $room->doctor_stage === 'available' ? 'bg-emerald-500' : ($room->doctor_stage === 'waiting_assistant' ? 'bg-blue-500' : 'bg-amber-500') }}">
                                </div>
                            </div>
                        </div>

                        @if ($room->currentVisit)
                            {{-- Visit Details Button --}}
                            <x-filament::button tag="a" :href="route('filament.admin.resources.visits.edit', [
                                'record' => $room->currentVisit->id,
                            ])" color="info" icon="heroicon-o-eye"
                                class="w-full" style="margin-bottom: 5px;">
                                {{ __('Go to Visit Details') }}
                            </x-filament::button>

                            {{-- Stage-specific Action Buttons --}}
                            @if ($room->doctor_stage === 'waiting_assistant')
                                <x-filament::button wire:click="markAssistantDone" color="info"
                                    icon="heroicon-o-check-circle" class="w-full" style="margin-bottom: 5px;">
                                    {{ __('Assistant Doctor Done') }}
                                </x-filament::button>
                            @elseif($room->doctor_stage === 'waiting_main')
                                <x-filament::button wire:click="markMainDone"
                                    wire:confirm="{{ __('Are you sure? This will complete the visit and free the room.') }}"
                                    color="success" icon="heroicon-o-check-badge" class="w-full"
                                    style="margin-bottom: 5px;">
                                    {{ __('Main Doctor Done & Free Room') }}
                                </x-filament::button>
                            @endif
                        @endif

                        {{-- Back to Dashboard --}}
                        <x-filament::button tag="a" :href="\Modules\Room\Filament\Pages\RoomsDashboard::getUrl()" color="gray"
                            icon="heroicon-o-arrow-left" outlined class="w-full">
                            {{ __('Back to Dashboard') }}
                        </x-filament::button>
                    </div>
                </x-filament::section>
            </div>
        </div>
    </div>
</x-filament-panels::page>
