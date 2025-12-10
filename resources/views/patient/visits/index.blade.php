@extends('patient.share.sidbar')
@section('patient_content')
    <!-- Main Content -->
    <main class="flex-1 px-4 sm:px-6 lg:px-8 py-6 md:py-8">
        <!-- Rewards Level Card -->
        <div class="mb-8">
            <div class="bg-gradient-to-r from-yellow-50 to-orange-50 border border-yellow-200 rounded-2xl p-6 shadow-sm">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <!-- Current Level -->
                    <div class="flex items-center gap-4">
                        <div class="flex-shrink-0">
                            @if ($stars > 0)
                                <div class="flex items-center gap-2">
                                    <span class="text-3xl">🏆</span>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">{{ __('Your Reward Level') }}:</p>
                                        <div class="flex items-center gap-1">
                                            @for ($i = 0; $i < $stars; $i++)
                                                <span class="text-yellow-400 text-2xl animate-pulse">★</span>
                                            @endfor
                                            <span class="text-sm text-gray-600 ml-2">({{ $stars }}
                                                {{ __('Stars') }})</span>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="flex items-center gap-3">
                                    <span class="text-3xl">⭐</span>
                                    <p class="text-sm font-medium text-gray-700">
                                        {{ __('You haven’t earned a star yet. Keep going!') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Next Goal -->
                    <div class="flex-shrink-0">
                        @if ($nextGoal)
                            <div class="bg-white rounded-xl px-4 py-3 shadow-sm border border-gray-200">
                                <p class="text-sm font-medium text-gray-700">
                                    <span class="font-bold text-primary">{{ $nextGoal - $totalVisits }}</span>
                                    {{ __('more visit') }}{{ $nextGoal - $totalVisits > 1 ? 's' : '' }}
                                    {{ __('to earn your next') }} <span
                                        class="text-yellow-400 text-xl align-middle">★</span>
                                </p>
                            </div>
                        @else
                            <div
                                class="bg-gradient-to-r from-green-100 to-emerald-100 rounded-xl px-4 py-3 shadow-sm border border-green-200">
                                <p class="text-sm font-semibold text-green-800 flex items-center gap-2">
                                    <span class="text-xl">🎉</span> {{ __('You reached the top level (4 stars)!') }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
            <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-3">
                <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                {{ __('Visits list') }}
            </h2>

            <div class="text-sm text-gray-600 bg-gray-100 rounded-lg px-3 py-2">
                <span class="font-semibold">{{ $totalVisits ?? 0 }}</span> {{ __('Total Visits') }}
            </div>
        </div>

        <!-- Visits Table -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs font-semibold text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th scope="col" class="px-6 py-4">{{ __('Service name') }}</th>
                            <th scope="col" class="px-6 py-4">{{ __('Status') }}</th>
                            <th scope="col" class="px-6 py-4">{{ __('Total Price') }}</th>
                            <th scope="col" class="px-6 py-4">{{ __('Price After Discount') }}</th>
                            <th scope="col" class="px-6 py-4">{{ __('Is Arrival') }}</th>
                            <th scope="col" class="px-6 py-4">{{ __('Arrival Time') }}</th>
                            <th scope="col" class="px-6 py-4 text-center">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @if (isset($visits) && $visits->count() > 0)
                            @foreach ($visits as $visit)
                                <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 transition-colors duration-150">
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="w-2 h-2 rounded-full bg-primary/60"></div>
                                            {{ $visit->service->name }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full
                                            @if ($visit->status == 'complete') bg-green-100 text-green-800
                                            @elseif($visit->status == 'pending') bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($visit->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ __('IQD') }}{{ number_format($visit->total_price ?? $visit->price, 2) }}
                                    </td>
                                    <td class="px-6 py-4 font-medium text-primary">
                                        @if ($visit->total_after_discount || $visit->total_after_discount == 0)
                                            {{ __('IQD') }}{{ number_format($visit->total_after_discount, 2) }}
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($visit->is_arrival)
                                            <span class="inline-flex items-center gap-1 text-green-600 font-medium">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M5 13l4 4L19 7" />
                                                </svg>
                                                {{ __('Yes') }}
                                            </span>
                                        @else
                                            <span class="text-gray-500">{{ __('No') }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">
                                        {{ $visit->arrival_time ? \Carbon\Carbon::parse($visit->arrival_time)->format('Y-m-d H:i') : '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('patient.visits.show', $visit->id) }}"
                                                class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-primary/10 text-primary hover:bg-primary/20 transition-all duration-200"
                                                title="{{ __('View Details') }}">
                                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                    fill="currentColor">
                                                    <path
                                                        d="M1.18164 12C2.12215 6.87976 6.60812 3 12.0003 3C17.3924 3 21.8784 6.87976 22.8189 12C21.8784 17.1202 17.3924 21 12.0003 21C6.60812 21 2.12215 17.1202 1.18164 12ZM12.0003 17C14.7617 17 17.0003 14.7614 17.0003 12C17.0003 9.23858 14.7617 7 12.0003 7C9.23884 7 7.00026 9.23858 7.00026 12C7.00026 14.7614 9.23884 17 12.0003 17ZM12.0003 15C10.3434 15 9.00026 13.6569 9.00026 12C9.00026 10.3431 10.3434 9 12.0003 9C13.6571 9 15.0003 10.3431 15.0003 12C15.0003 13.6569 13.6571 15 12.0003 15Z" />
                                                </svg>
                                            </a>

                                            @if ($visit->is_arrival && $visit->feedback == null && $visit->status == 'complete')
                                                <button data-visit-id="{{ $visit->id }}"
                                                    data-modal-target="feedback-modal" data-modal-toggle="feedback-modal"
                                                    class="showFeedbackModalBtn inline-flex items-center justify-center w-9 h-9 rounded-lg bg-yellow-100 text-yellow-700 hover:bg-yellow-200 transition-all duration-200"
                                                    title="{{ __('Leave Feedback') }}">
                                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24" fill="currentColor">
                                                        <path
                                                            d="M6.45455 19L2 22.5V4C2 3.44772 2.44772 3 3 3H21C21.5523 3 22 3.44772 22 4V18C22 18.5523 21.5523 19 21 19H6.45455ZM11 13V15H13V13H11ZM11 7V12H13V7H11Z" />
                                                    </svg>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center gap-4">
                                        <svg class="w-16 h-16 text-gray-300" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24" fill="currentColor">
                                            <path
                                                d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM12 10.5858L14.8284 7.75736L16.2426 9.17157L13.4142 12L16.2426 14.8284L14.8284 16.2426L12 13.4142L9.17157 16.2426L7.75736 14.8284L10.5858 12L7.75736 9.17157L9.17157 7.75736L12 10.5858Z" />
                                        </svg>
                                        <h3 class="text-lg font-semibold text-gray-700">{{ __('No visits found') }}</h3>
                                        <p class="text-sm text-gray-500">{{ __('Your visit history will appear here') }}
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if (isset($visits) && $visits->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    {{ $visits->links() }}
                </div>
            @endif
        </div>

        <!-- Feedback Modal -->
        <div id="feedback-modal" tabindex="-1" aria-hidden="true"
            class="feedbackModalWrapper hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
            <div class="relative p-4 w-full max-w-2xl mx-4">
                <div class="relative bg-white rounded-2xl shadow-xl p-6 sm:p-8">

                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-bold text-primary flex items-center gap-3">
                            Rate the Visit
                        </h3>
                        <button type="button" data-modal-hide="feedback-modal"
                            class="w-9 h-9 rounded-lg bg-gray-100 text-gray-500 hover:bg-gray-200 hover:text-gray-700 transition-all duration-200 flex items-center justify-center">
                            ✕
                        </button>
                    </div>

                    <form class="space-y-6 genericForm" method="POST" action="{{ route('patient.feedback.store') }}">
                        @csrf
                        <input id="visitId" name="visit_id" type="hidden">
                        <input id="rating" name="rating" type="hidden">

                        <div class="flex flex-col items-center gap-4">
                            <p class="text-sm font-medium text-gray-700">How was your experience?</p>

                            <div class="rating flex gap-2 text-4xl">
                                @for ($i = 1; $i <= 5; $i++)
                                    <button type="button"
                                        class="rating-item cursor-pointer text-gray-300 transition-colors duration-150"
                                        data-rating="{{ $i }}">★</button>
                                @endfor
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label for="feedback" class="block text-sm font-semibold text-gray-800">Your Feedback</label>
                            <textarea id="feedback" name="comments" rows="5"
                                class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 px-4 py-3"
                                placeholder="Share your thoughts..."></textarea>
                        </div>

                        <div class="pt-4 border-t border-gray-200">
                            <button type="submit"
                                class="w-full px-8 py-3 bg-primary text-white font-semibold rounded-lg hover:bg-primary/90 transition-all">
                                Submit Feedback
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const ratingItems = document.querySelectorAll('.rating-item');
            const ratingInput = document.querySelector('#rating');
            const visitIdInput = document.querySelector('#visitId');
            const showButtons = document.querySelectorAll('.showFeedbackModalBtn');
            const modal = document.getElementById('feedback-modal');
            const closeBtn = document.querySelector('[data-modal-hide="feedback-modal"]');

            let selectedRating = 0;

            // ⭐ Highlight stars properly
            function highlightStars(count) {
                ratingItems.forEach((star, i) => {
                    if (i < count) {
                        star.classList.add('!text-[#ffd700]');
                        star.classList.remove('text-gray-300');
                    } else {
                        star.classList.add('text-gray-300');
                        star.classList.remove('!text-[#ffd700]');
                    }
                });
            }

            function updateRatingDisplay() {
                highlightStars(selectedRating);
            }

            // ⭐ On Click - Select rating
            ratingItems.forEach((item, index) => {
                item.addEventListener('click', () => {
                    selectedRating = index + 1;
                    ratingInput.value = selectedRating;
                    updateRatingDisplay();
                });

                item.addEventListener('mouseenter', () => {
                    highlightStars(index + 1);
                });
            });

            // ⭐ On mouse leave return to selected rating
            document.querySelector('.rating').addEventListener('mouseleave', updateRatingDisplay);

            // ⭐ Open Modal
            showButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    visitIdInput.value = this.dataset.visitId;
                    modal.classList.remove('hidden');
                });
            });

            // ⭐ Close Modal Button
            if (closeBtn) {
                closeBtn.addEventListener('click', closeModal);
            }

            // ⭐ Close Modal on overlay click
            modal.addEventListener('click', e => {
                if (e.target === modal) {
                    closeModal();
                }
            });

            function closeModal() {
                modal.classList.add('hidden');
                selectedRating = 0;
                ratingInput.value = "";
                updateRatingDisplay();
                document.querySelector('#feedback').value = "";
            }

        });
    </script>

@endsection
