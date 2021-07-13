<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Posts') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <x-post-list :posts="$posts"></x-post-list>
                <x-pagination :total="$total" :currentPage="$currentPage" :startPage="$startPage" :url="route('dashboard')"></x-pagination>
            </div>
        </div>
    </div>
</x-app-layout>
