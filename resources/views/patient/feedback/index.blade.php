@extends('patient.share.sidbar')
@section('patient_content')
    <!-- Main Content -->
    <main class="flex-1 px-4 sm:px-6 lg:px-8 py-6 md:py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345l2.125-5.111z" />
                </svg>
                {{ __('My Feedback History') }}
            </h2>
            <p class="text-gray-600 mt-2">{{ __('All your service ratings and comments') }}</p>
        </div>

        <!-- Feedback Table -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-start">
                    <thead class="text-xs font-semibold text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th scope="col" class="px-6 py-4">{{ __('Service Name') }}</th>
                            <th scope="col" class="px-6 py-4">{{ __('Comments') }}</th>
                            <th scope="col" class="px-6 py-4 text-center">{{ __('Rating') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @if (isset($feedbacks) && $feedbacks->count() > 0)
                            @foreach ($feedbacks as $feedback)
                                <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 transition-colors duration-150">
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap text-center">
                                        {{ $feedback->visit->service->name ?? __('General Service') }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-700 max-w-md truncate text-center">
                                        {{ $feedback->comments ?: __('No comments provided') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-center">
                                            @php
                                                $rating = $feedback->rating;
                                                $ratingClass = '';
                                                $icon = '';
                                                
                                                if ($rating >= 1 && $rating <= 3) {
                                                    $ratingClass = 'bg-rose-50 border-rose-200 text-rose-600';
                                                    $icon = '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>';
                                                } elseif ($rating >= 5 && $rating <= 7) {
                                                    $ratingClass = 'bg-amber-50 border-amber-200 text-amber-600';
                                                    $icon = '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>';
                                                } elseif ($rating >= 8 && $rating <= 10) {
                                                    $ratingClass = 'bg-emerald-50 border-emerald-200 text-emerald-600';
                                                    $icon = '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>';
                                                } else {
                                                    // rating === 4 (neutral)
                                                    $ratingClass = 'bg-gray-50 border-gray-200 text-gray-600';
                                                    $icon = '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>';
                                                }
                                            @endphp
                                            
                                            <div class="flex items-center gap-2 px-3 py-2 rounded-full border {{ $ratingClass }}">
                                                {!! $icon !!}
                                                <span class="text-sm font-semibold">{{ $rating }}/10</span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center gap-4">
                                        <svg class="w-16 h-16 text-gray-300" xmlns="http://www.w3.org/2000/svg "
                                            viewBox="0 0 24 24" fill="currentColor">
                                            <path
                                                d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM12 10.5858L14.8284 7.75736L16.2426 9.17157L13.4142 12L16.2426 14.8284L14.8284 16.2426L12 13.4142L9.17157 16.2426L7.75736 14.8284L10.5858 12L7.75736 9.17157L9.17157 7.75736L12 10.5858Z" />
                                        </svg>
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-700">
                                                {{ __('No Feedback Found') }}
                                            </h3>
                                            <p class="text-gray-500 text-sm">
                                                {{ __('Your feedback will appear here after you rate services') }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if (isset($feedbacks) && $feedbacks->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    {{ $feedbacks->links() }}
                </div>
            @endif
        </div>
    </main>
@endsection