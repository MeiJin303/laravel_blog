@props(['posts'])

<div class="container mx-auto px-8">
    <div class="border-t border-gray">
        @if (count($posts) == 0)
            <x-alert color="blue" title="Woops!" content="We haven't got any posts."></x-alert>
        @else
            @foreach($posts as $data)
            <div class="max-w py-4 px-8 bg-white shadow-lg rounded-lg my-5">
                <div>
                <h2 class="text-gray-800 text-3xl">{{ $data->title }}</h2>
                <p class="mt-2 text-gray-600">{{ $data->description }}</p>
                </div>
                <div class="flex justify-end mt-4">
                <a href="#" class="text">{{ $data->datetimeForHuman()}}</a>
                </div>
            </div>
            @endforeach
        @endif
    </div>
</div>
