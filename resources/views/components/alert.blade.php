@props(['title', 'content', 'color', 'session'])

@if($session ?? '')
    @if ($session ?? '' && Session::get('error'))
        <?php
            $color = 'red';
            $title = 'Error! ';
            $content = Session::get('error');
        ?>
    @endif
    @if ($session ?? '' && Session::get('warning'))
        <?php
            $color = 'orange';
            $title = 'Warning! ';
            $content = Session::get('warning');
        ?>
    @endif
    @if ($session ?? '' && Session::get('success'))
        <?php
            $color = 'green';
            $title = 'Success! ';
            $content = Session::get('success');
        ?>
    @endif
@endif

@if($content ?? '' && $color)
        <div class='bg-{{$color}}-100 border border-{{$color}}-400 text-{{$color}}-700 px-4 py-3 rounded relative' role="alert">
            <strong class="font-bold">{{$title}}</strong>
            <span class="block sm:inline">{{$content ?? '' ?? ''}}</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <button class="absolute bg-transparent text-2xl font-semibold leading-none right-0 top-0 mt-4 mr-6 outline-none focus:outline-none" onclick="closeAlert(event)">
                <span>×</span>
            </button>
        </div>
<script>
    function closeAlert(event){
      let element = event.target;
      console.log(element);
      while(element.nodeName !== "BUTTON"){
        element = element.parentNode;
      }
      element.parentNode.parentNode.parentNode.removeChild(element.parentNode.parentNode);
    }
  </script>
@endif
