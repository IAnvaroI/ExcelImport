<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Import products</title>
    </head>
    <body>
       <form method="POST" action="{{ route('importFile') }}" enctype="multipart/form-data">
           @csrf
           <input type="file" name="importProductsFile" required/>
           <input type="submit"/>
       </form>
       @if ($errors->any())
           <div style="color:red;">
               <ul>
                   @foreach ($errors->all() as $error)
                       <li>{{ $error }}</li>
                   @endforeach
               </ul>
           </div>
       @endif
    </body>
</html>
