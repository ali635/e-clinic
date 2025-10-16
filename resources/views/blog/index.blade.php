@extends('layout.defult')
@section('content')
    <section class="py-12">
        <div class="container">
            <h2 class="text-3xl tablet:text-4xl font-bold text-center text-primary mb-12">
                {{ __('Blogs') }}
            </h2>
            <div class="grid grid-cols-1 tablet:grid-cols-2 web:grid-cols-4 gap-4">
                @foreach ($posts as $post)
                    @if ($post->slug)
                        <a href="{{ route('post.show', $post->slug) }}"
                            class="bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 ease-in-out">
                            <div class="h-52 tablet:h-64 overflow-hidden">
                                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->name }}"
                                    class="w-full h-full object-cover transition-transform duration-300 ease-in-out hover:scale-115">
                            </div>
                            <div class="p-5 tablet:p-6">
                                <h2 class="text-xl tablet:text-2xl font-bold mb-2 tablet:mb-3 text-gray-800">
                                    {{ $post->name }}
                                </h2>
                            </div>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </section>
@endsection
