<!DOCTYPE html>
<html lang="en" data-theme="cupcake">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{config('app.name', 'Nuwang')}}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="bg-gray-100">
    <div id="app">
        {{$slot}}
    </div>
    <script src="/js/app.js"></script>
</body>
</html>
