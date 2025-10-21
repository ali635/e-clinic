@php
    $locales = Modules\AdvancedLanguage\Models\Language::query()->get();

@endphp

<header>
    <nav class="bg-white py-2 tablet:py-4">
        <div class="container tablet:flex tablet:items-center tablet:justify-between">
            <div class="flex justify-between items-center">
                <a href="/" class="font-bold text-xl text-primary">
                    <img class="max-w-[200px]"  src="{{ asset('storage/' . setting('site_logo')) }}"
                        alt="{{ setting('site_name') }}">
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

            <div class="hidden tablet:flex flex-col tablet:flex-row mt-3 tablet:mt-0"
                id="navbar-collapse">
                <a href="/"
                    class="p-2 web:px-4 tablet:mx-2  @if (Route::currentRouteName() == 'home') text-white rounded bg-primary @else text-gray-600 rounded hover:bg-gray-200 hover:text-gray-700 transition-colors duration-300 @endif">{{ __('Home') }}</a>
                {{-- <a href="{{ route('about') }}"
                    class="p-2 web:px-4 tablet:mx-2 @if (Route::currentRouteName() == 'about') text-white rounded bg-primary @else text-gray-600 rounded hover:bg-gray-200 hover:text-gray-700 transition-colors duration-300 @endif ">{{ __('About') }}</a> --}}
                <a href="{{ route('services') }}"
                    class="p-2 web:px-4 tablet:mx-2 @if (Route::currentRouteName() == 'services') text-white rounded bg-primary @else text-gray-600 rounded hover:bg-gray-200 hover:text-gray-700 transition-colors duration-300 @endif">{{ __('Services') }}</a>
                <a href="{{ route('posts') }}"
                    class="p-2 web:px-4 tablet:mx-2 @if (Route::currentRouteName() == 'posts') text-white rounded bg-primary @else text-gray-600 rounded hover:bg-gray-200 hover:text-gray-700 transition-colors duration-300 @endif">{{ __('Blogs') }}</a>
                
                <div class="p-2 web:px-4 tablet:mx-2 text-gray-600 rounded hover:bg-gray-200 hover:text-gray-700 transition-colors duration-300 relative group border border-gray-200">
                    <span class="capitalize">{{ App::getLocale() == 'ar' ? 'العربية' : ($locales->where('lang_code', App::getLocale())->first()->lang_name ?? App::getLocale()) }}</span>
                    <ul class="absolute bg-white py-2 w-52 ltr:right-0 rtl:left-0 top-full transform scale-0 group-hover:scale-100 hover:scale-100 transition duration-150 ease-in-out origin-top shadow-lg z-[9]">
                        @foreach ($locales as $localeCode => $local)
                        <li>
                            <a class="px-3 text-sm hover:bg-slate-100 leading-8 flex items-center gap-2" href="{{ LaravelLocalization::getLocalizedURL($local->lang_code, null, [], true) }}">
                                <img width="25px" src="https://cdn.jsdelivr.net/gh/hampusborgos/country-flags@main/svg/{{$local->lang_flag}}.svg" />
                                {{ $local->lang_name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                @auth('patient')
                    <div class="p-2 web:px-4 tablet:mx-2 text-gray-600 rounded hover:bg-gray-200 hover:text-gray-700 transition-colors duration-300 relative group">
                        <span class="flex items-center gap-1">
                            <svg width="20px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M4 22C4 17.5817 7.58172 14 12 14C16.4183 14 20 17.5817 20 22H4ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13Z"></path></svg>
                            <span>{{auth('patient')->user()->name }}</span>
                        </span>
                        <ul class="absolute bg-white py-2 w-52 ltr:right-0 rtl:left-0 top-full transform scale-0 group-hover:scale-100 transition duration-150 ease-in-out origin-top shadow-lg z-[1]">
                            <li>
                                <a class="px-3 text-sm hover:bg-slate-100 leading-8 block" href="{{ route('patient.dashboard') }}">{{__('Profile')}}</a>
                            </li>
                            <li>
                                <a class="px-3 text-sm hover:bg-slate-100 leading-8 block" href="{{ route('patient.logout') }}" onclick="event.preventDefault();document.getElementById('logout.form').submit();">{{ __('logout') }}</a>
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


{{-- {{ __('Blogs') }}
{{ __('Posts') }}
{{ __('Post') }}
{{ __('Group Services') }}
{{ __('Services') }}
{{ __('Service') }}
{{ __('Related Service') }}
{{ __('Related Services') }}
{{ __('Patient Information') }}
{{ __('Patients') }}
{{ __('Patient') }}
{{ __('Diseases') }}
{{ __('Disease') }}

{{ __('Locations') }}
{{ __('Countries') }}
{{ __('Country') }}
{{ __('Cities') }}
{{ __('City') }}
{{ __('Visits') }}
{{ __('Visit') }}
{{ __('Feedbacks') }}
{{ __('Feedback') }}
{{ __('Users') }}
{{ __('User') }} --}}
