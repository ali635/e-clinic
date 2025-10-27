@extends('patient.share.sidbar')
@section('patient_content')
    <!-- Main Content -->
    <main class="flex-1 px-4 py-8 md:ml-0 ml-0 overflow-x-auto">
        <h2 class="text-xl font-bold mb-6">{{ __('Visits list') }}</h2>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50  ">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            {{ __('Service name') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('Total Price') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('Is Arrival') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('Arrival Time') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('Action') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($visits) && $visits->count() > 0)
                        @foreach ($visits as $visit)
                            <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">

                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $visit->service->name }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $visit->total_price ?? $visit->price }}

                                </td>
                                <td class="px-6 py-4">
                                    {{ $visit->is_arrival ? __('Yes') : __('No') }}

                                </td>
                                <td class="px-6 py-4">
                                    {{ $visit->arrival_time }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="flex gap-2">
                                        <a href="{{ route('patient.visits.show', $visit->id) }}"
                                            class="font-medium text-primary hover:opacity-60">
                                            <svg width="25px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor">
                                                <path
                                                    d="M1.18164 12C2.12215 6.87976 6.60812 3 12.0003 3C17.3924 3 21.8784 6.87976 22.8189 12C21.8784 17.1202 17.3924 21 12.0003 21C6.60812 21 2.12215 17.1202 1.18164 12ZM12.0003 17C14.7617 17 17.0003 14.7614 17.0003 12C17.0003 9.23858 14.7617 7 12.0003 7C9.23884 7 7.00026 9.23858 7.00026 12C7.00026 14.7614 9.23884 17 12.0003 17ZM12.0003 15C10.3434 15 9.00026 13.6569 9.00026 12C9.00026 10.3431 10.3434 9 12.0003 9C13.6571 9 15.0003 10.3431 15.0003 12C15.0003 13.6569 13.6571 15 12.0003 15Z">
                                                </path>
                                            </svg>
                                        </a>
                                        @if ($visit->is_arrival && $visit->feedback == null)
                                            <a data-visit-id="{{ $visit->id }}" data-modal-target="feedback-modal" data-modal-toggle="feedback-modal" href="javascript:;"
                                                class="showFeedbackModalBtn font-medium text-primary hover:opacity-60">
                                                <svg width="25px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M6.45455 19L2 22.5V4C2 3.44772 2.44772 3 3 3H21C21.5523 3 22 3.44772 22 4V18C22 18.5523 21.5523 19 21 19H6.45455ZM11 13V15H13V13H11ZM11 7V12H13V7H11Z"></path></svg>
                                            </a>
                                        @endif
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-xl">
                                <svg class="inline-block" width="20px" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM12 10.5858L14.8284 7.75736L16.2426 9.17157L13.4142 12L16.2426 14.8284L14.8284 16.2426L12 13.4142L9.17157 16.2426L7.75736 14.8284L10.5858 12L7.75736 9.17157L9.17157 7.75736L12 10.5858Z">
                                    </path>
                                </svg>
                                {{ __('No visits found') }}
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <div id="feedback-modal" tabindex="-1" aria-hidden="true" class="feedbackModalWrapper hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-2xl max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow-sm p-4">
                        <h3 class="text-xl text-primary">Rate the Visit</h3>
                        <!-- Modal body -->
                        <form class="space-y-6" method="POST" action="">
                            <div class="flex justify-end !mb-0">
                                <button type="button" class="cursor-pointer text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="feedback-modal">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                            <div class="grid grid-cols-1 gap-3">
                                <!-- Services Field -->
                                <input id="visitId" name="visitId" type="hidden" class="form-input" value="">
                                <input id="rating" name="rating" type="hidden" class="form-input" value="">
                                <div class="space-y-2">
                                    <div class="rating">
                                        <span class="rating-item cursor-pointer text-[#ddd] transition-all">★</span>
                                        <span class="rating-item cursor-pointer text-[#ddd] transition-all">★</span>
                                        <span class="rating-item cursor-pointer text-[#ddd] transition-all">★</span>
                                        <span class="rating-item cursor-pointer text-[#ddd] transition-all">★</span>
                                        <span class="rating-item cursor-pointer text-[#ddd] transition-all">★</span>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <label for="feedback" class="block text-sm font-medium text-gray-700">
                                        {{ __('Feedback') }}
                                    </label>
                                    <textarea class="form-input" placeholder="Write Your Feedback" name="feedback" id="feedback" rows="4"></textarea>
                                </div>
                            </div>

                            <div>
                                <button type="submit"
                                    class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors duration-200 cursor-pointer max-w-sm mx-auto">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function(){
        const ratingItems = document.querySelectorAll('.rating-item');
        const ratingInput = document.querySelector('#rating');
        const visitIdInput = document.querySelector('#visitId');
        const showFeedbackModal = document.querySelectorAll('.showFeedbackModalBtn');
        let selectedRating = 0;
    
        ratingItems.forEach((item, index) => {
            item.addEventListener('click', () => {
                selectedRating = index + 1;
                ratingInput.value = selectedRating;
                ratingItems.forEach((star, idx) => {
                    star.classList.toggle('active', idx < selectedRating);
                });
            });
    
            item.addEventListener('mouseover', () => {
                ratingItems.forEach((star, idx) => {
                    star.classList.toggle('active', idx <= index);
                });
            });
    
            item.addEventListener('mouseout', () => {
                ratingItems.forEach((star, idx) => {
                    star.classList.toggle('active', idx < selectedRating);
                });
            });
        });

        showFeedbackModal.forEach(item => {
            item.addEventListener('click', function(){
                const visitId = this.getAttribute('data-visit-id');
                visitIdInput.value = visitId;
            })
        })
    })
</script>