@php
    $locales = Modules\AdvancedLanguage\Models\Language::query()->get();
    $isProfileLayout = request()->routeIs('patient.*');
@endphp

<header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md shadow-sm border-b border-gray-100">
    <nav class="py-3 {{ $isProfileLayout ? 'px-4' : 'container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8' }}">
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="/" class="block">
                    <img class="w-16 h-16 object-contain transition-transform duration-200 hover:scale-105"
                        src="{{ asset(setting('site_logo')) }}" alt="{{ setting('site_name') }}">
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center gap-2">
                <a href="/"
                    class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 
                          @if (Route::currentRouteName() == 'home') bg-primary text-white shadow-md
                          @else
                              text-gray-700 hover:bg-gray-100 hover:text-primary @endif">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    {{ __('Home') }}
                </a>

                <a href="{{ route('services') }}"
                    class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 
                          @if (Route::currentRouteName() == 'services') bg-primary text-white shadow-md
                          @else
                              text-gray-700 hover:bg-gray-100 hover:text-primary @endif">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19 11H5m14-7l-2 2m0 0l-2-2m2 2V3m2 4H5m14 10l-2-2m0 0l-2 2m2-2v2M9 3v2m3 0v2m3 0v2" />
                    </svg>
                    {{ __('services') }}
                </a>

                <a href="{{ route('posts') }}"
                    class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 
                          @if (Route::currentRouteName() == 'posts') bg-primary text-white shadow-md
                          @else
                              text-gray-700 hover:bg-gray-100 hover:text-primary @endif">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                    {{ __('Blogs') }}
                </a>

                <!-- Language Switcher -->
                <div class="relative group">
                    <button
                        class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 hover:text-primary transition-all duration-200 border border-gray-200">
                        <img class="w-5 h-4 object-cover rounded shadow-sm"
                            src="https://cdn.jsdelivr.net/gh/hampusborgos/country-flags@main/svg/{{ $locales->where('lang_code', App::getLocale())->first()->lang_flag ?? 'us' }}.svg"
                            alt="{{ App::getLocale() }}">
                        <span>{{ App::getLocale() == 'ar' ? 'العربية' : $locales->where('lang_code', App::getLocale())->first()->lang_name ?? App::getLocale() }}</span>
                        <svg class="w-4 h-4 transition-transform duration-200 group-hover:rotate-180" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <ul
                        class="absolute bg-white py-2 w-56 ltr:right-0 rtl:left-0 top-full transform scale-0 group-hover:scale-100 transition duration-200 ease-out origin-top shadow-2xl rounded-xl border border-gray-200 z-50">
                        @foreach ($locales as $localeCode => $local)
                            <li>
                                <a class="px-4 py-2 text-sm hover:bg-gray-50 leading-6 flex items-center gap-3 rounded-lg mx-2 transition-colors duration-150"
                                    href="{{ LaravelLocalization::getLocalizedURL($local->lang_code, null, [], true) }}">
                                    <img class="w-5 h-4 object-cover rounded shadow-sm"
                                        src="https://cdn.jsdelivr.net/gh/hampusborgos/country-flags@main/svg/{{ $local->lang_flag }}.svg"
                                        alt="{{ $local->lang_name }}">
                                    {{ $local->lang_name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- User Menu -->
                @auth('patient')
                    <div class="relative group">
                        <button
                            class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 hover:text-primary transition-all duration-200">
                            <div
                                class="w-8 h-8 rounded-full bg-gradient-to-br from-primary/10 to-primary/20 flex items-center justify-center">
                                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <span class="hidden xl:inline font-semibold">{{ auth('patient')->user()->name }}</span>
                            <svg class="w-4 h-4 transition-transform duration-200 group-hover:rotate-180" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <ul
                            class="absolute bg-white py-2 w-56 ltr:right-0 rtl:left-0 top-full transform scale-0 group-hover:scale-100 transition duration-200 ease-out origin-top shadow-2xl rounded-xl border border-gray-200 z-50">
                            <li>
                                <a class="px-4 py-2 text-sm hover:bg-gray-50 leading-6 flex items-center gap-3 rounded-lg mx-2 transition-colors duration-150"
                                    href="{{ route('patient.dashboard') }}">
                                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 3h18v18H3V3zm4 4v10h10V7H7z" />
                                    </svg>
                                    {{ __('Profile') }}
                                </a>
                            </li>
                            <li>
                                <button onclick="event.preventDefault(); confirmLogout()"
                                    class="w-full text-left px-4 py-2 text-sm hover:bg-red-50 leading-6 flex items-center gap-3 rounded-lg mx-2 transition-colors duration-150 text-red-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    {{ __('Logout') }}
                                </button>
                                <form id="logout-form" action="{{ route('patient.logout') }}" method="POST"
                                    class="hidden">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('patient.login') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold text-white bg-gradient-to-r from-primary to-primary/80 shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        {{ __('Sign in') }}
                    </a>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <div class="lg:hidden flex items-center gap-2">
                <!-- Mobile Language Switcher -->
                <div class="relative" id="mobile-lang-switcher">
                    <button type="button" id="mobile-lang-btn"
                        class="p-2 text-gray-600 rounded-lg hover:bg-gray-100 transition-colors duration-300 flex items-center gap-2">
                        <img class="w-5 h-4 object-cover rounded shadow-sm"
                            src="https://cdn.jsdelivr.net/gh/hampusborgos/country-flags@main/svg/{{ $locales->where('lang_code', App::getLocale())->first()->lang_flag ?? 'us' }}.svg"
                            alt="{{ App::getLocale() }}">
                        <span class="text-sm">{{ App::getLocale() }}</span>
                        <svg class="w-3 h-3 transition-transform duration-200" id="mobile-lang-arrow" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <ul id="mobile-lang-dropdown"
                        class="absolute bg-white py-2 w-48 ltr:right-0 rtl:left-0 top-full transform scale-0 opacity-0 transition duration-200 ease-out origin-top shadow-xl rounded-lg border border-gray-200 z-50 pointer-events-none">
                        @foreach ($locales as $localeCode => $local)
                            <li>
                                <a class="px-3 py-2 text-sm hover:bg-gray-50 leading-5 flex items-center gap-2 rounded-md mx-1 transition-colors duration-150"
                                    href="{{ LaravelLocalization::getLocalizedURL($local->lang_code, null, [], true) }}">
                                    <img class="w-5 h-4 object-cover rounded shadow-sm"
                                        src="https://cdn.jsdelivr.net/gh/hampusborgos/country-flags@main/svg/{{ $local->lang_flag }}.svg"
                                        alt="{{ $local->lang_name }}">
                                    {{ $local->lang_name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <button
                    class="p-2 rounded-lg text-gray-600 hover:bg-gray-100 transition-colors duration-300 border border-gray-200 show_mobile_sidemenu">
                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

    </nav>
</header>

<!-- Mobile Menu -->
<div class="lg:hidden py-4 border-t border-gray-100 mobile_sidemenu">
    <div class="flex justify-end">
        <button class="close_mobile_sidemenu" type="button">
            <svg width="25px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M10.5859 12L2.79297 4.20706L4.20718 2.79285L12.0001 10.5857L19.793 2.79285L21.2072 4.20706L13.4143 12L21.2072 19.7928L19.793 21.2071L12.0001 13.4142L4.20718 21.2071L2.79297 19.7928L10.5859 12Z">
                </path>
            </svg>
        </button>
    </div>
    <div class="flex flex-col gap-2 mt-4 flex-grow max-h-[80vh] overflow-y-auto">
        <a href="/"
            class="px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 
                  @if (Route::currentRouteName() == 'home') bg-primary text-white
                  @else
                      text-gray-700 hover:bg-gray-100 hover:text-primary @endif">
            {{ __('Home') }}
        </a>
        <a href="{{ route('services') }}"
            class="px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 
                  @if (Route::currentRouteName() == 'services') bg-primary text-white
                  @else
                      text-gray-700 hover:bg-gray-100 hover:text-primary @endif">
            {{ __('Services') }}
        </a>
        <a href="{{ route('posts') }}"
            class="px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 
                  @if (Route::currentRouteName() == 'posts') bg-primary text-white
                  @else
                      text-gray-700 hover:bg-gray-100 hover:text-primary @endif">
            {{ __('Blogs') }}
        </a>

        @auth('patient')
            <div class="border-t border-gray-100 pt-2 mt-2">
                <a href="{{ route('patient.dashboard') }}"
                    class="px-4 py-3 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 hover:text-primary transition-all duration-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 000-7z" />
                    </svg>
                    {{ __('Profile') }}
                </a>
                <button onclick="confirmLogout()"
                    class="w-full text-left px-4 py-3 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50 transition-all duration-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    {{ __('Logout') }}
                </button>
                <form id="logout-form" action="{{ route('patient.logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        @else
            <a href="{{ route('patient.login') }}"
                class="mt-2 px-4 py-3 rounded-lg text-sm font-semibold text-white bg-gradient-to-r from-primary to-primary/80 shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                {{ __('Sign In') }}
            </a>
        @endauth
    </div>
</div>

<!-- Logout Confirmation Script -->
<script>
    function confirmLogout() {
        if (confirm('{{ __('Are you sure you want to logout?') }}')) {
            document.getElementById('logout-form').submit();
        }
    }

    // Mobile toggle functionality
    let show_mobile_sidemenu = document.querySelector(".show_mobile_sidemenu");
    let close_mobile_sidemenu = document.querySelector(".close_mobile_sidemenu");
    let mobile_sidemenu = document.querySelector(".mobile_sidemenu");

    show_mobile_sidemenu.onclick = () => {
        mobile_sidemenu.classList.add('menu_shown');
        document.body.style.overflow = 'hidden';
    };

    close_mobile_sidemenu.onclick = () => {
        mobile_sidemenu.classList.remove('menu_shown')
        document.body.style.overflow = 'visible';
    };

    // Close mobile menu on window resize
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 1024) {
            mobile_sidemenu.classList.remove('menu_shown')
            document.body.style.overflow = 'visible';
        }
    });

    // Mobile Language Switcher Toggle
    const mobileLangBtn = document.getElementById('mobile-lang-btn');
    const mobileLangDropdown = document.getElementById('mobile-lang-dropdown');
    const mobileLangArrow = document.getElementById('mobile-lang-arrow');
    let isLangDropdownOpen = false;

    function toggleMobileLangDropdown() {
        isLangDropdownOpen = !isLangDropdownOpen;
        if (isLangDropdownOpen) {
            mobileLangDropdown.classList.remove('scale-0', 'opacity-0', 'pointer-events-none');
            mobileLangDropdown.classList.add('scale-100', 'opacity-100', 'pointer-events-auto');
            mobileLangArrow.classList.add('rotate-180');
        } else {
            mobileLangDropdown.classList.add('scale-0', 'opacity-0', 'pointer-events-none');
            mobileLangDropdown.classList.remove('scale-100', 'opacity-100', 'pointer-events-auto');
            mobileLangArrow.classList.remove('rotate-180');
        }
    }

    function closeMobileLangDropdown() {
        if (isLangDropdownOpen) {
            isLangDropdownOpen = false;
            mobileLangDropdown.classList.add('scale-0', 'opacity-0', 'pointer-events-none');
            mobileLangDropdown.classList.remove('scale-100', 'opacity-100', 'pointer-events-auto');
            mobileLangArrow.classList.remove('rotate-180');
        }
    }

    mobileLangBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        toggleMobileLangDropdown();
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', (e) => {
        if (!document.getElementById('mobile-lang-switcher').contains(e.target)) {
            closeMobileLangDropdown();
        }
    });
</script>

<style>
    .mobile_sidemenu {
        position: fixed;
        background: white;
        width: 100%;
        left: 0;
        right: 0;
        top: 0;
        padding-inline: 20px;
        bottom: 0;
        z-index: 100;
        transition: 0.4s;
        transform: translateX(-100%);
    }

    body[dir="rtl"] .mobile_sidemenu {
        transform: translateX(100%);
    }

    .mobile_sidemenu.menu_shown {
        transform: translateX(0) !important;
    }
</style>
