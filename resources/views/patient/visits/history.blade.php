@extends('patient.share.sidbar')
@section('patient_content')
    <!-- Main Content -->
    <main class="flex-1 px-4 py-8 md:ml-0 ml-0">
        <h2 class="text-xl font-bold mb-6">{{ _(' History') }}</h2>
        <ol class="relative border-s border-primary">
            @foreach ($histories as $history)
                @if ($history)
                    <li class="ms-4 mb-4">
                        <span class="absolute w-3 h-3 bg-white rounded-full mt-1.5 -start-1.5 border border-primary"></span>
                        <time
                            class="mb-1 text-sm font-normal leading-none text-primary">{{ Carbon\Carbon::parse($history->created_at)->format('M d, Y') }}</time>
                        <h3 class="text-lg font-semibold text-gray-900">{{ __('Doctor Description') }}</h3>
                        <p class="text-base font-normal text-gray-400">{!! $history->doctor_description !!}</p>
                    </li>
                @endforeach
            @endif

        </ol>
    </main>
@endsection
