@extends('layout.defult')
@section('content')
    <section class="profile_layout">
        <div class="flex gap-4 relative">
            <!-- Sidebar -->
            <aside id="sidebarMenu" class="sidebarMenu">
                <nav>
                    <ul class="space-y-6">
                        <li>
                            <a href="{{ route('patient.profile') }}" class="sidebarMenu_item">
                                <svg class="me-2" width="20px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path
                                        d="M4 22C4 17.5817 7.58172 14 12 14C16.4183 14 20 17.5817 20 22H4ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13Z">
                                    </path>
                                </svg>
                                {{ __('Profile') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('patient.dashboard') }}" class="sidebarMenu_item active">
                                <svg class="me-2" width="20px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path
                                        d="M5 3V19H21V21H3V3H5ZM20.2929 6.29289L21.7071 7.70711L16 13.4142L13 10.415L8.70711 14.7071L7.29289 13.2929L13 7.58579L16 10.585L20.2929 6.29289Z">
                                    </path>
                                </svg>
                                {{ __('Stats') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('patient.visits') }}" class="sidebarMenu_item">
                                <svg class="me-2" width="20px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path
                                        d="M9 1V3H15V1H17V3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H7V1H9ZM20 11H4V19H20V11ZM7 5H4V9H20V5H17V7H15V5H9V7H7V5Z">
                                    </path>
                                </svg>
                                {{ __('Visits') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('patient.history') }}" class="sidebarMenu_item">
                                <svg class="me-2" width="20px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path
                                        d="M12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12H4C4 16.4183 7.58172 20 12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C9.25022 4 6.82447 5.38734 5.38451 7.50024L8 7.5V9.5H2V3.5H4L3.99989 5.99918C5.82434 3.57075 8.72873 2 12 2ZM13 7L12.9998 11.585L16.2426 14.8284L14.8284 16.2426L10.9998 12.413L11 7H13Z">
                                    </path>
                                </svg>
                                {{ __('History') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('patient.feedback') }}" class="sidebarMenu_item">
                                <svg class="me-2" width="20px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path
                                        d="M12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12H4C4 16.4183 7.58172 20 12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C9.25022 4 6.82447 5.38734 5.38451 7.50024L8 7.5V9.5H2V3.5H4L3.99989 5.99918C5.82434 3.57075 8.72873 2 12 2ZM13 7L12.9998 11.585L16.2426 14.8284L14.8284 16.2426L10.9998 12.413L11 7H13Z">
                                    </path>
                                </svg>
                                {{ __('Feedback') }}
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- Mobile Sidebar Toggle Button -->
                <button class="sidebarToggleBtn" id="sidebarToggleBtn" aria-label="Toggle sidebar" type="button">
                    <svg width="25px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M3 4.99509C3 3.89323 3.89262 3 4.99509 3H19.0049C20.1068 3 21 3.89262 21 4.99509V19.0049C21 20.1068 20.1074 21 19.0049 21H4.99509C3.89323 21 3 20.1074 3 19.0049V4.99509ZM6.35687 18H17.8475C16.5825 16.1865 14.4809 15 12.1022 15C9.72344 15 7.62182 16.1865 6.35687 18ZM12 13C13.933 13 15.5 11.433 15.5 9.5C15.5 7.567 13.933 6 12 6C10.067 6 8.5 7.567 8.5 9.5C8.5 11.433 10.067 13 12 13Z">
                        </path>
                    </svg>
                </button>
            </aside>
            @yield('patient_content')
        </div>
    </section>
    <script>
        // Close sidebar when clicking outside of it on mobile
        const aside = document.getElementById('sidebarMenu');
        const btn = document.getElementById('sidebarToggleBtn');

        btn.addEventListener('click', function(e) {
            btn.classList.toggle('menuShown')
            aside.classList.toggle('menuOpened')
        })
    </script>
@endsection
