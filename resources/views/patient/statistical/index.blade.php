@extends('patient.share.sidbar')
@section('patient_content')
<!-- Main Content -->
<main class="flex-1 px-4 py-8 md:ml-0 ml-0">
    <h2 class="text-xl font-bold mb-6">Statistics</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Card 1: Number of Visits -->
        <div class="bg-white rounded-xl shadow p-6 flex items-center space-x-4 animate-fade-in">
            <div class="bg-primary/10 rounded-full p-3 text-3xl">
                <svg class="fill-primary" width="20px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M4 3H20C20.5523 3 21 3.44772 21 4V20C21 20.5523 20.5523 21 20 21H4C3.44772 21 3 20.5523 3 20V4C3 3.44772 3.44772 3 4 3ZM11 11H7V13H11V17H13V13H17V11H13V7H11V11Z"></path></svg>
            </div>
            <div>
                <div class="text-3xl font-bold">14</div>
                <div class="text-gray-500 text-sm">Number of Visits</div>
            </div>
        </div>
        <!-- Card 2: Number of Services Used -->
        <div class="bg-white rounded-xl shadow p-6 flex items-center space-x-4 animate-fade-in">
            <div class="bg-blue-100 rounded-full p-3 text-3xl">
                <svg class="fill-blue-600" width="20px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M16 1C16.5523 1 17 1.44772 17 2V5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V6C2 5.44772 2.44772 5 3 5H7V2C7 1.44772 7.44772 1 8 1H16ZM13 9H11V12H8V14H10.999L11 17H13L12.999 14H16V12H13V9ZM15 3H9V5H15V3Z"></path></svg>
            </div>
            <div>
                <div class="text-3xl font-bold">7</div>
                <div class="text-gray-500 text-sm">Services Used</div>
            </div>
        </div>
    </div>
    <div class="mt-8">
        <h3 class="text-lg font-semibold mb-4">Quick Insights</h3>
        <ul class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <li class="bg-white rounded shadow p-4 flex items-center">
                <svg class="me-3 fill-yellow-300" width="20px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M9 1V3H15V1H17V3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H7V1H9ZM20 8H4V19H20V8ZM15.0355 10.136L16.4497 11.5503L11.5 16.5L7.96447 12.9645L9.37868 11.5503L11.5 13.6716L15.0355 10.136Z"></path></svg>
                Last visit: <span class="font-semibold ms-2">2024-05-10</span>
            </li>
        </ul>
    </div>
</main>
@endsection