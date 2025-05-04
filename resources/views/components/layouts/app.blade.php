<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @vite(['resources/css/app.css','resources/js/app.js'])
        <title>{{ $title ?? 'ItemFlow' }}</title>
    </head>
    <body>
        {{ $slot }}
        <script>
            window.addEventListener('open-loan-modal', () => {
                document.getElementById('add-loan-modal').classList.remove('hidden');
            });

            window.addEventListener('close-loan-modal', () => {
                document.getElementById('add-loan-modal').classList.add('hidden');
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    </body>
</html>
