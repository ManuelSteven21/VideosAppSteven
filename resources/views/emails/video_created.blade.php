<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9fafb;
            padding: 2rem;
            color: #1f2937;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        h1 {
            color: #dc2626;
        }
        a.button {
            display: inline-block;
            margin-top: 1rem;
            background: #dc2626;
            color: white;
            padding: 0.75rem 1.5rem;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }
        a.button:hover {
            background: #b91c1c;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Nou vídeo creat</h1>

    <p><strong>Títol:</strong> {{ $video->title }}</p>
    <p><strong>Descripció:</strong> {{ $video->description }}</p>

    <a href="{{ route('videos.show', $video->id) }}" class="button">🔗 Veure vídeo</a>
</div>
</body>
</html>
