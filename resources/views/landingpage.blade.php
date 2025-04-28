<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
@vite(['resources/css/app.css','resources/js/app.js'])
<title>{{ $title ?? 'ItemFlow' }}</title>
</head>
<body>
<livewire:navbar />
<div class="flex justify-center p-5">
    <a href="{{ route('dashboard') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg px-6 py-3 text-md transition">Get Started</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>
</html>
