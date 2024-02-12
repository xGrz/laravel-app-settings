<!doctype html>
<html lang="en" class="bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Settings</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body style="max-width: 1000px; margin: 0 auto;">
<header>
    <h1 class="text-3xl py-4">{{ $title ?? 'Page title' }}</h1>
</header>
<main>
    @yield('content')
</main>
</body>
</html>
