<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ url('add_post') }}" class="container mx-auto">
                        @csrf

                        <!-- Title -->
                        <div>
                            <x-label for="title" :value="__('Title')" />
                            <input id="title" class="form-input px-4 py-3 w-full" type="text" name="title" :value="old('title')" required autofocus />
                        </div>

                        <!-- Description -->
                        <div>
                            <x-label for="description" :value="__('Description')" />
                            <textarea id="description" class="form-textarea px-4 py-3 w-full" type="description" name="description" required autofocus></textarea>
                        </div>


                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-3">
                                {{ __('Save') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
