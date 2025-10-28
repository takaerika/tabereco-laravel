<!doctype html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>{{ $title ?? 'Meals' }}</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="p-6 max-w-3xl mx-auto">
  @if(session('success')) <div class="mb-4 text-green-700">{{ session('success') }}</div> @endif
  {{ $slot ?? '' }}
  @yield('content')
</body>
</html>