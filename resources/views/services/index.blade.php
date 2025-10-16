@extends('layout.defult')
@section('content')
    <section class="py-12 bg-white">
        <div class="container">
            <h2 class="text-3xl tablet:text-4xl font-bold text-center text-primary mb-4">
                {{ __('Our Services') }}
            </h2>
            <p class="text-center text-gray-600 mb-12 text-lg">
                {{ __('Here are our services choose from them') }}
            </p>
            <div class="grid grid-cols-1 tablet:grid-cols-2 web:grid-cols-4 gap-4">
                @foreach ($services as $service)
                    <div
                        class="bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 ease-in-out">
                        <div class="h-52 tablet:h-64 overflow-hidden">
                            <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}"
                                class="w-full h-full object-cover transition-transform duration-300 ease-in-out hover:scale-105">
                        </div>
                        <div class="p-5 tablet:p-6">
                            <h2 class="text-xl tablet:text-2xl font-bold mb-2 tablet:mb-3 text-gray-800">
                                {{ $service->name }}</h2>
                            <p class="text-sm tablet:text-base text-gray-600 mb-5">{!! $service->short_description !!}</p>
                            <div class="flex items-center justify-between">
                                <h2 class="text-xl tablet:text-2xl font-bold text-gray-800">
                                    {{ $service->price }}
                                    <span class="text-md tablet:text-lg text-primary">د.ع</span>
                                </h2>
                                @if ($service->slug)
                                <a href="{{ route('service.show', $service->slug) }}"
                                    class="px-4 py-1 rounded-full hover:bg-primary text-white transition duration-300 ease-in-out bg-primary/60">{{ __('Book the service') }}
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
@endsection
