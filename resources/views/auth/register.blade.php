@extends('layout.defult')
@section('content')

<link rel="stylesheet" href="{{ asset('css/intelTelInput.css') }}">

<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Create your account
            </h2>
        </div>
        
        <form class="mt-8 space-y-6" method="POST" action="">
            @csrf
            
            <!-- Full Name Field -->
            <div class="space-y-2">
                <label for="full_name" class="block text-sm font-medium text-gray-700">
                    Full Name
                </label>
                <input 
                    id="full_name" 
                    name="full_name" 
                    type="text"
                    required 
                    class="form-input"
                    placeholder="Enter your full name"
                >
                <div class="text-red-600 text-sm mt-1 hiddens">
                    Please enter your full name
                </div>
            </div>

            <!-- Email Field -->
            <div class="space-y-2">
                <label for="email" class="block text-sm font-medium text-gray-700">
                    Email Address
                </label>
                <input 
                    id="email" 
                    name="email" 
                    type="email"
                    required 
                    class="form-input"
                    placeholder="Enter your email"
                >
                <div class="text-red-600 text-sm mt-1 hidden">
                    Please enter a valid email address
                </div>
            </div>

            <!-- Phone Number Field -->
            <div class="space-y-2">
                <label for="phone" class="block text-sm font-medium text-gray-700">
                    Phone Number
                </label>
                <input 
                    id="phone" 
                    name="phone" 
                    type="tel" 
                    class="form-input"
                    placeholder="Enter your phone number"
                >
                <div class="text-red-600 text-sm mt-1 hidden">
                    Please enter a valid phone number
                </div>
            </div>

            <!-- Date Field -->
            <div class="space-y-2">
                <label for="date" class="block text-sm font-medium text-gray-700">
                    Date of Birth
                </label>
                <input 
                    id="date" 
                    name="date" 
                    type="date" 
                    class="form-input"
                >
                <div class="text-red-600 text-sm mt-1 hidden">
                    Please select a valid date
                </div>
            </div>

            <!-- City Select Field -->
            <div class="space-y-2">
                <label for="city" class="block text-sm font-medium text-gray-700">
                    City
                </label>
                <select 
                    id="city" 
                    name="city" 
                    class="form-input"
                >
                    <option value="">Select your city</option>
                    <option value="new-york">New York</option>
                    <option value="los-angeles">Los Angeles</option>
                    <option value="chicago">Chicago</option>
                    <option value="houston">Houston</option>
                    <option value="phoenix">Phoenix</option>
                    <option value="philadelphia">Philadelphia</option>
                    <option value="san-antonio">San Antonio</option>
                    <option value="san-diego">San Diego</option>
                    <option value="dallas">Dallas</option>
                    <option value="san-jose">San Jose</option>
                    <option value="austin">Austin</option>
                    <option value="jacksonville">Jacksonville</option>
                    <option value="fort-worth">Fort Worth</option>
                    <option value="columbus">Columbus</option>
                    <option value="charlotte">Charlotte</option>
                    <option value="san-francisco">San Francisco</option>
                    <option value="indianapolis">Indianapolis</option>
                    <option value="seattle">Seattle</option>
                    <option value="denver">Denver</option>
                    <option value="washington">Washington</option>
                    <option value="boston">Boston</option>
                    <option value="el-paso">El Paso</option>
                    <option value="nashville">Nashville</option>
                    <option value="detroit">Detroit</option>
                    <option value="oklahoma-city">Oklahoma City</option>
                    <option value="portland">Portland</option>
                    <option value="las-vegas">Las Vegas</option>
                    <option value="memphis">Memphis</option>
                    <option value="louisville">Louisville</option>
                    <option value="baltimore">Baltimore</option>
                    <option value="milwaukee">Milwaukee</option>
                    <option value="albuquerque">Albuquerque</option>
                    <option value="tucson">Tucson</option>
                    <option value="fresno">Fresno</option>
                    <option value="sacramento">Sacramento</option>
                    <option value="mesa">Mesa</option>
                    <option value="kansas-city">Kansas City</option>
                    <option value="atlanta">Atlanta</option>
                    <option value="long-beach">Long Beach</option>
                    <option value="colorado-springs">Colorado Springs</option>
                    <option value="raleigh">Raleigh</option>
                    <option value="miami">Miami</option>
                    <option value="virginia-beach">Virginia Beach</option>
                    <option value="omaha">Omaha</option>
                    <option value="oakland">Oakland</option>
                    <option value="minneapolis">Minneapolis</option>
                    <option value="tulsa">Tulsa</option>
                    <option value="arlington">Arlington</option>
                    <option value="tampa">Tampa</option>
                    <option value="new-orleans">New Orleans</option>
                </select>
                <div class="text-red-600 text-sm mt-1 hidden">
                    Please select a city
                </div>
            </div>

            <!-- Street Field -->
            <div class="space-y-2">
                <label for="street" class="block text-sm font-medium text-gray-700">
                    Street
                </label>
                <input 
                    id="street" 
                    name="street" 
                    required 
                    class="form-input"
                    placeholder="Enter your street"
                >
                <div class="text-red-600 text-sm mt-1 hidden">
                    Please enter a street
                </div>
            </div>

            <!-- Password Field -->
            <div class="space-y-2">
                <label for="password" class="block text-sm font-medium text-gray-700">
                    Password
                </label>
                <input 
                    id="password" 
                    name="password" 
                    type="password" 
                    required 
                    class="form-input"
                    placeholder="Enter your password"
                >
                <div class="text-red-600 text-sm mt-1 hidden">
                    Please enter a password
                </div>
            </div>

            <!-- Confirm Password Field -->
            <div class="space-y-2">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                    Confirm Password
                </label>
                <input 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    type="password" 
                    required 
                    class="form-input"
                    placeholder="Confirm your password"
                >
                <div class="text-red-600 text-sm mt-1 hidden">
                    Passwords do not match
                </div>
            </div>

            <!-- Submit Button -->
            <div>
                <button 
                    type="submit" 
                    class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors duration-200"
                >
                    Create Account
                </button>
            </div>
            
            <p class="mt-2 text-center text-sm text-gray-600">
                Already have an account? 
                <a href="/login" class="font-medium text-primary hover:text-primary/80">
                    Sign in
                </a>
            </p>
        </form>
    </div>
</div>
<script src="{{ asset('js/intelTelInput.js') }}"></script>
<script>
  const input = document.querySelector("#phone");
  window.intlTelInput(input, {
    loadUtils: () => import("{{ asset('js/intelUtilities.js') }}"),
  });
</script>
<style>
    .iti {
        width: 100%;
    }
</style>
@endsection