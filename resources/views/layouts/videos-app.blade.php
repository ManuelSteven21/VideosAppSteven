<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Videos App' }}</title>
    @vite('resources/css/app.css') {{-- Tailwind CSS --}}
</head>
<body class="flex flex-col min-h-screen bg-gray-300 text-gray-800 font-sans">

<!-- Main Content -->
<main class="flex-grow container mx-auto px-4 py-6">
    {{ $slot }}
</main>
</body>
</html>
