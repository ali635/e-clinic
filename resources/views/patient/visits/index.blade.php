@extends('patient.share.sidbar')
@section('patient_content')
    <!-- Main Content -->
    <main class="flex-1 px-4 py-8 md:ml-0 ml-0 overflow-x-auto">
        <h2 class="text-xl font-bold mb-6">{{ __('Visits lisit') }}</h2>

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
                    @if(isset($visits) && $visits->count() > 0)
                        @foreach ($visits as $visit)
                            <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">

                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $visit->service->name }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $visit->total_price ?? $visit->price }}

                                </td>
                                <td class="px-6 py-4">
                                    {{ $visit->is_arrival }}

                                </td>
                                <td class="px-6 py-4">
                                    {{ $visit->arrival_time }}
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('patient.visits.show', $visit->id) }}" class="font-medium text-primary hover:opacity-60">
                                        <svg width="25px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                            fill="currentColor">
                                            <path
                                                d="M1.18164 12C2.12215 6.87976 6.60812 3 12.0003 3C17.3924 3 21.8784 6.87976 22.8189 12C21.8784 17.1202 17.3924 21 12.0003 21C6.60812 21 2.12215 17.1202 1.18164 12ZM12.0003 17C14.7617 17 17.0003 14.7614 17.0003 12C17.0003 9.23858 14.7617 7 12.0003 7C9.23884 7 7.00026 9.23858 7.00026 12C7.00026 14.7614 9.23884 17 12.0003 17ZM12.0003 15C10.3434 15 9.00026 13.6569 9.00026 12C9.00026 10.3431 10.3434 9 12.0003 9C13.6571 9 15.0003 10.3431 15.0003 12C15.0003 13.6569 13.6571 15 12.0003 15Z">
                                            </path>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-xl">
                                <svg class="inline-block" width="20px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM12 10.5858L14.8284 7.75736L16.2426 9.17157L13.4142 12L16.2426 14.8284L14.8284 16.2426L12 13.4142L9.17157 16.2426L7.75736 14.8284L10.5858 12L7.75736 9.17157L9.17157 7.75736L12 10.5858Z"></path></svg>
                                {{ __('No visits found') }}
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </main>
@endsection
