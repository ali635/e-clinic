  {{-- Medical Hero Section --}}
  <section class="relative h-[600px] overflow-hidden">
      {{-- Background Image --}}
      <div class="absolute inset-0">
          <img src="{{ asset('storage/' . setting_lang('hero_banner')) }}" alt="{{ setting_lang('banner_title') }}" class="w-full h-full object-cover">
          {{-- Gradient Overlay --}}
          <div class="absolute inset-0 bg-gradient-to-r from-blue-900/90 via-blue-800/80 to-transparent"></div>
      </div>

      {{-- Content --}}
      <div class="container relative h-full flex items-center">
          <div class="max-w-2xl text-white">
              <h1 class="text-5xl tablet:text-6xl font-bold mb-6 leading-tight">
                  {{ setting_lang('banner_title') }}
              </h1>
              <p class="text-xl tablet:text-2xl mb-8 text-blue-50 leading-relaxed">
                  {{ setting_lang('banner_description') }}
              </p>
              <a href="{{ route('services') }}"
                  class="inline-flex items-center px-8 py-4 bg-white text-blue-900 font-semibold rounded-full hover:bg-blue-50 transform hover:scale-105 transition-all duration-300 shadow-xl hover:shadow-2xl">
                  <span>{{ __('Book an Appointment') }}</span>
                  <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                  </svg>
              </a>
          </div>
      </div>
  </section>