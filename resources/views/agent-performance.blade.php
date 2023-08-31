<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ Str::title($title) }}</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="h-screen bg-gray-100">

<div class="container px-4 mx-auto">
    <div class="m-10 flex justify-center">
        <a href="{{ URL::to('/agent-commisions') }}" class="px-5 py-2 bg-green-500 text-sm text-white font-medium">Back to CRM</a>
    </div>
    <div class="p-6 m-10 bg-white rounded shadow">
        {!! $chart->container() !!}
    </div>
</div>

<script src="{{ $chart->cdn() }}"></script>

{{ $chart->script() }}
</body>
</html>