@if($errors->any())
    @foreach ($errors->toArray() as $name => $message)
        <p class="text-center font-semibold text-danger my-3">
            {{ $message[0] }}
        </p>
    @endforeach
@endif
