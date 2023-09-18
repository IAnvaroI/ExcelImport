<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Import results</title>
    </head>
    <body>
        <div>
            Imported records counter: {{ $counter }}
        </div>
        <div>
            @foreach($refusedArray as $reason => $amount)
                <p>{{ $reason . ': ' . $amount }}</p>
            @endforeach
        </div>
    </body>
</html>
