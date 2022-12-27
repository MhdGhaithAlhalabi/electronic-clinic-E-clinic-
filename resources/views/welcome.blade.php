<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

            <script src="https://cdn.tailwindcss.com"></script>

    </head>

    <body style="background-color: #1a202c">
        <div class="grid h-screen place-items-center">
            @auth('admin')
                <form action="/logout" method="post">
                    @csrf
                    <button type="submit" class="sm:rounded-lg">logout</button>
                </form>
                @else
                <a href="/login" type="button" class="sm:rounded-lg">login</a>
                 @endauth


        </div>








    </body>
</html>
