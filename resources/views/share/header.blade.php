@php
    $locales = Modules\AdvancedLanguage\Models\Language::query()->get();

@endphp

<header>
    <nav class="bg-white py-2 tablet:py-4">
        <div class="container tablet:flex tablet:items-center">
            <div class="flex justify-between items-center">
                <a href="#" class="font-bold text-xl text-primary">
                    <img class="max-w-[200px]" src="{{ asset('images/logo.png') }}" alt="">
                </a>
                <button
                    class="border border-solid border-primary px-2 py-1 rounded text-gray-600 opacity-50 hover:opacity-75 tablet:hidden"
                    id="navbar-toggle">
                    <svg class="fill-primary" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                        width="24px">
                        <path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z" />
                    </svg>
                </button>
            </div>

            <div class="hidden tablet:flex flex-col tablet:flex-row tablet:ml-auto mt-3 tablet:mt-0"
                id="navbar-collapse">
                <a href="#" class="p-2 web:px-4 tablet:mx-2 text-white rounded bg-primary">Home</a>
                <a href="#"
                    class="p-2 web:px-4 tablet:mx-2 text-gray-600 rounded hover:bg-gray-200 hover:text-gray-700 transition-colors duration-300">About</a>
                <a href="#"
                    class="p-2 web:px-4 tablet:mx-2 text-gray-600 rounded hover:bg-gray-200 hover:text-gray-700 transition-colors duration-300">Services</a>
                <a href="#"
                    class="p-2 web:px-4 tablet:mx-2 text-gray-600 rounded hover:bg-gray-200 hover:text-gray-700 transition-colors duration-300">Blogs</a>


                @foreach ($locales as $localeCode => $local)
                    <a class="dropdown-item" rel="alternate" hreflang="{{ $local->lang_code }}"
                        href="{{ LaravelLocalization::getLocalizedURL($local->lang_code, null, [], true) }}">
                        {{ $local->lang_name }}
                    </a>

                    <div class="dropdown-divider"></div>
                @endforeach

                @auth('patient')
                    <div class="p-2 web:px-4 tablet:mx-2 text-gray-600 rounded hover:bg-gray-200 hover:text-gray-700 transition-colors duration-300 relative group">
                        Salem
                        <ul class="absolute bg-white py-2 w-52 ltr:left-0 rtl:right-0 top-full transform scale-0 group-hover:scale-100 transition duration-150 ease-in-out origin-top shadow-lg">
                            <li class="px-3 text-sm hover:bg-slate-100 leading-8">
                                <a href="#">Profile</a>
                            </li>
                            <li class="px-3 text-sm hover:bg-slate-100 leading-8">
                                <a href="{{ route('patient.logout') }}" onclick="event.preventDefault();document.getElementById('logout.form').submit();">{{ __('logout') }}</a>
                                <form id="logout.form" action="{{ route('patient.logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('patient.login') }}" class="p-2 web:px-4 tablet:mx-2 text-gray-600 rounded hover:bg-gray-200 hover:text-gray-700 transition-colors duration-300">
                        {{ __('sign in') }}
                    </a>
                @endauth
            </div>
        </div>
    </nav>


    <script>
        let toggleBtn = document.querySelector("#navbar-toggle");
        let collapse = document.querySelector("#navbar-collapse");

        toggleBtn.onclick = () => {
            collapse.classList.toggle("hidden");
            collapse.classList.toggle("flex");
        };
    </script>
