<x-guest-layout>
    <div class="relative flex items-top bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
        <div class="flex flex-row px-8">
            <div class="w-12 h-12 py-2">
                <x-application-logo></x-application-logo>
            </div>
            <div class="pt-6 px-4"><h3>Blog</h3></div>
        </div>
        @if (Route::has('login'))
            <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 underline">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
                    @endif
                @endauth
            </div>
        @endif

    </div>
    <div class="py-12">
        <x-post-list :posts="$posts"></x-post-list>
        <x-pagination :total="$total" :currentPage="$currentPage" :startPage="$startPage" :url="route('home')"></x-pagination>
    </div>
</x-guest-layout>
