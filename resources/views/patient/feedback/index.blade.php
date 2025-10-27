@extends('patient.share.sidbar')
@section('patient_content')
    <!-- Main Content -->
    <main class="flex-1 px-4 py-8 md:ml-0 ml-0 overflow-x-auto">
        <h2 class="text-xl font-bold mb-6">{{ __('feedbacks list') }}</h2>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50  ">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            {{ __('Service name') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('Comments') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('Rating') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($feedbacks) && $feedbacks->count() > 0)
                        @foreach ($feedbacks as $feedback)
                            <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $feedback->visit->service->name }}
                                </th>

                                <td class="px-6 py-4">
                                    {{ $feedback->comments }}
                                </td>

                                <td class="px-6 py-4">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $feedback->rating)
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="w-5 h-5 inline text-yellow-400 fill-current" viewBox="0 0 24 24">
                                                <path
                                                    d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.873 1.48 8.321L12 18.896l-7.416 4.604 1.48-8.321L0 9.306l8.332-1.151z" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="w-5 h-5 inline text-gray-300 fill-current" viewBox="0 0 24 24">
                                                <path
                                                    d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.873 1.48 8.321L12 18.896l-7.416 4.604 1.48-8.321L0 9.306l8.332-1.151z" />
                                            </svg>
                                        @endif
                                    @endfor
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
                                {{ __('No feedbacks found') }}
                            </td>
                        </tr>
                    @endif

                </tbody>
            </table>
        </div>
    </main>
@endsection
