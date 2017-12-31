@if(session('flash_notification'))
<div class="flash-wrap">
@foreach ((array) session('flash_notification') as $message)
@php $message = (array)$message[0]; @endphp
    @if ($message['overlay'])
        @include('flash::modal', [
            'modalClass' => 'flash-modal',
            'title'      => $message['title'],
            'body'       => $message['message']
        ])
    @else
        <div class="flash flash-{{ $message['level'] }} {{ $message['important'] ? 'flash-important' : '' }}">
            @if ($message['important'])
                <button type="button"
                        class="close"
                ><i class="fa fa-close"></i></button>
            @endif

            {!! $message['message'] !!}
        </div>
    @endif
@endforeach
</div>
@endif
{{ session()->forget('flash_notification') }}