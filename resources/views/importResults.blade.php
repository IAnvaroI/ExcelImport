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
            Failed to import records counter: {{ count($refusedToImport) }}
        </div>
        <div style="color:red;">
            @foreach($refusedToImport as $row => $failures)
                <p>Row {{ $row }}</p>
                @foreach($failures as $failure)
                    <ul>
                        @foreach ($failure->errors() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endforeach
            @endforeach
{{--            I know that 3 nested loops is not good solution. It is just for output convenience --}}
        </div>
    </body>
</html>
