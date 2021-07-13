@props(['total', 'currentPage', 'url', 'startPage'])

@php
    $lastPage = intdiv($total, 10) + ($total%10 ? 1 : 0);
@endphp
<div class="container mx-auto px-8">
	<ul class="flex pl-0 list-none rounded my-2">
        @if ($currentPage>1)
		<li class="relative block py-2 px-3 leading-tight bg-white border border-gray-300 text-blue-700 border-r-0 ml-0 rounded-l hover:bg-gray-200"><a class="page-link" href="{{$url."?page=".($currentPage-1)."&start=".$startPage}}">Previous</a></li>
        @endif

        @for ($i=$startPage; $i<min($startPage+6, $lastPage+1); $i++)
		<li class="relative block py-2 px-3 leading-tight bg-{{$currentPage==$i ? 'blue-300' : 'white'}} border border-gray-300 text-blue-700  hover:bg-gray-200"><a class="page-link" href="{{$url."?page=".$i."&start=".$startPage }}">{{$i}}</a></li>
        @endfor

        @if ($currentPage < $lastPage)
        @if ($i < $lastPage)
        <li class="relative block py-2 px-3 leading-tight bg-white border border-gray-300 text-blue-700 border-r-0 hover:bg-gray-200"><a class="page-link" href="{{$url."?page=".($lastPage+1)."&start=".($lastPage+1)}}">...</a></li>
        @endif
		<li class="relative block py-2 px-3 leading-tight bg-white border border-gray-300 text-blue-700 rounded-r hover:bg-gray-200"><a class="page-link" href="{{$url."?page=".($currentPage+1)."&start=".$startPage}}">Next</a></li>
        @endif
	</ul>
</div>
