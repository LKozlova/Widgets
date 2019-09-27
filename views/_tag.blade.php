<{{$tag}}
    @if(isset($params))
        @foreach($params as $param => $method)
            @if(isset($method))
                {{$param}} = "{!!$method!!}"
            @endif
        @endforeach
    @endif
>
