<div class="bg-indigo-500 px-4 py-1 sm:py-5">
    <nav class="flex flex-col sm:flex-row justify-end sm:justify-between flex-wrap">
        <div class="w-full sm:w-1/2 text-white  mb-2 sm:mb-0 ">
            <h1 class="text-lg inline-block mr-4">M2K</h1>
            <small class="text-sm text-zinc-100">The missing kindle ebook uploader.</small>
        </div>
        @if (Route::has('login'))
            @auth
            <div class="text-sm text-center sm:text-right">
                <a href="#" class="inline-block  px-0 py-2 leading-none  rounded text-white border-white hover:border-blue-800 hover:text-white">
                    {{ Auth::user()->name }}
                </a>

                <livewire:auth.logout />

            </div>
            @else
            <div class="text-sm align-right">

                <a href="{{ route('login') }}" class="inline-block  px-0 py-2 leading-none  rounded text-white border-white hover:border-blue-800 hover:text-white">
                    Login
                </a>
                <a href="{{ route('register') }}" class="inline-block  px-4 py-2 leading-none  rounded text-white border-white hover:border-blue-800 hover:text-white">
                    Register
                </a>
            </div>
            @endauth
        @endif
    </nav>
</div>
