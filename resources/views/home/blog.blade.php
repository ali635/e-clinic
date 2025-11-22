<section class="py-12">
    <div class="container">
        <div class="flex flex-col tablet:flex-row tablet:justify-between tablet:items-center gap-2 mb-8">
            <h2 class="text-3xl tablet:text-4xl font-bold text-primary">
                {{ __('Blogs') }}
            </h2>
            <a href="{{ route('posts') }}"
                class="text-primary self-end tablet:self-center border border-primary text-center px-3 py-1.5 rounded-lg hover:bg-primary hover:text-white transition duration-300 ease-in-out">{{ __('All Blogs') }}</a>
        </div>
        <div class="grid grid-cols-1 tablet:grid-cols-2 web:grid-cols-4 gap-4">
            @foreach ($posts as $post)
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
            @endforeach

        </div>
    </div>
</section>
