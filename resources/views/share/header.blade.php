<header>
    <nav class="bg-white py-2 tablet:py-4">
        <div class="container tablet:flex tablet:items-center">
            <div class="flex justify-between items-center">
                <a href="#" class="font-bold text-xl text-primary">
                    <img class="max-w-[200px]" src="{{ asset('images/logo.png') }}" alt="">
                </a>
                <button class="border border-solid border-primary px-2 py-1 rounded text-gray-600 opacity-50 hover:opacity-75 tablet:hidden" id="navbar-toggle">
                    <svg class="fill-primary" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/></svg>
                </button>
            </div>

            <div class="hidden tablet:flex flex-col tablet:flex-row tablet:ml-auto mt-3 tablet:mt-0" id="navbar-collapse">
                <a href="#" class="p-2 web:px-4 tablet:mx-2 text-white rounded bg-primary">Home</a>
                <a href="#" class="p-2 web:px-4 tablet:mx-2 text-gray-600 rounded hover:bg-gray-200 hover:text-gray-700 transition-colors duration-300">About</a>
                <a href="#" class="p-2 web:px-4 tablet:mx-2 text-gray-600 rounded hover:bg-gray-200 hover:text-gray-700 transition-colors duration-300">Services</a>
                <a href="#" class="p-2 web:px-4 tablet:mx-2 text-gray-600 rounded hover:bg-gray-200 hover:text-gray-700 transition-colors duration-300">Blogs</a>
            </div>
        </div>
    </nav>
</header>

<script>
    let toggleBtn = document.querySelector("#navbar-toggle");
    let collapse = document.querySelector("#navbar-collapse");

    toggleBtn.onclick = () => {
        collapse.classList.toggle("hidden");
        collapse.classList.toggle("flex");
    };
</script>