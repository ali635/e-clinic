        <div class="flex items-center justify-between mb-6">

             <h2 class="text-xl font-bold flex items-center gap-2">
                {{ __('Profile') }}
                <span class="text-gray-600 text-sm">
                    ({{ $stars }}
                    @for ($i = 0; $i < $stars; $i++)
                        <span class="text-[#ffd700] text-2xl">★</span>
                    @endfor
                    {{ __('Stars Member') }})
                </span>
            </h2> 

            <a href="{{ route('patient.profile.data') }}"
                class="inline-flex items-center px-4 py-2 bg-primary text-white text-sm font-medium rounded hover:bg-primary/80 focus:outline-none @if (Route::is('patient.profile.data')) active @endif">
                <svg class="w-4 h-4 me-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.232 5.232l3.536 3.536m-2.036-5.036A2.5 2.5 0 1118.5 7.5L7 19H3v-4L15.732 3.732z" />
                </svg>
                {{ __('Profile information') }}
            </a>

              <a href="{{ route('patient.profile.show.form') }}"
                class="inline-flex items-center px-4 py-2 bg-primary text-white text-sm font-medium rounded hover:bg-primary/80 focus:outline-none @if (Route::is('patient.profile.show.form')) active @endif">
                <svg class="w-4 h-4 me-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.232 5.232l3.536 3.536m-2.036-5.036A2.5 2.5 0 1118.5 7.5L7 19H3v-4L15.732 3.732z" />
                </svg>
                {{ __('Edit Profile information') }}
            </a>

              <a href="{{ route('patient.profile.show.form.password') }}"
                class="inline-flex items-center px-4 py-2 bg-primary text-white text-sm font-medium rounded hover:bg-primary/80 focus:outline-none @if (Route::is('patient.profile.show.form.password')) active @endif">
                <svg class="w-4 h-4 me-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.232 5.232l3.536 3.536m-2.036-5.036A2.5 2.5 0 1118.5 7.5L7 19H3v-4L15.732 3.732z" />
                </svg>
                {{ __('Edit Password') }}
            </a>
        </div>