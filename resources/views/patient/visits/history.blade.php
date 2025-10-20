@extends('patient.share.sidbar')
@section('patient_content')
<!-- Main Content -->
<main class="flex-1 px-4 py-8 md:ml-0 ml-0">
    <h2 class="text-xl font-bold mb-6">History</h2>
    <ol class="relative border-s border-primary">
        <li class="ms-4 mb-4">
            <span class="absolute w-3 h-3 bg-white rounded-full mt-1.5 -start-1.5 border border-primary"></span>
            <time class="mb-1 text-sm font-normal leading-none text-primary">April 2022</time>
            <h3 class="text-lg font-semibold text-gray-900">E-Commerce UI code in Tailwind CSS</h3>
            <p class="text-base font-normal text-gray-400">Get started with dozens of web components and interactive elements built on top of Tailwind CSS.</p>
        </li>
        <li class="ms-4 mb-4">
            <span class="absolute w-3 h-3 bg-white rounded-full mt-1.5 -start-1.5 border border-primary"></span>
            <time class="mb-1 text-sm font-normal leading-none text-primary">April 2022</time>
            <h3 class="text-lg font-semibold text-gray-900">E-Commerce UI code in Tailwind CSS</h3>
            <p class="text-base font-normal text-gray-400">Get started with dozens of web components and interactive elements built on top of Tailwind CSS.</p>
        </li>
    </ol>
</main>
@endsection