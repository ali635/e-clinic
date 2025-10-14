@extends('layout.defult')
@section('content')

<section class="py-12 bg-white">
    <div class="container">
        <div class="grid grid-cols-1 tablet:grid-cols-2 web:grid-cols-3 gap-4">
            <div class="bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 ease-in-out">
                <div class="h-52 tablet:h-64 overflow-hidden">
                    <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}"
                        class="w-full h-full object-cover transition-transform duration-300 ease-in-out hover:scale-105">
                </div>
                <div class="p-5 tablet:p-6">
                    <h2 class="text-xl tablet:text-2xl font-bold mb-2 tablet:mb-3 text-gray-800">
                        {{ $service->name }}</h2>
                    <p class="text-sm tablet:text-base text-gray-600 mb-5">
                        {{ $service->description }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
