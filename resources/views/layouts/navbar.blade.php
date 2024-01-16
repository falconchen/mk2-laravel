<div class="bg-indigo-500 px-4 py-5">
    <nav class="flex items-center justify-between flex-wrap">
        <div class="flex items-center flex-shrink-0 text-white mr-6">
            <h1>M2K</h1>
        </div>
        @if (Route::has('login'))
            @auth
            <div class="text-sm">
                <a href="#" class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-blue-800 hover:text-white">
                    {{ Auth::user()->name }}
                </a>

                <livewire:auth.logout />

            </div>
            @else
            <div class="text-sm">

                <a href="{{ route('login') }}" class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-blue-800 hover:text-white">
                    Login
                </a>
                <a href="{{ route('register') }}" class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-blue-800 hover:text-white">
                    Register
                </a>
            </div>
            @endauth
        @endif
    </nav>
</div>
