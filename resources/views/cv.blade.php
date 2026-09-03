<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>CV — {{ $data->profile->name }}</title>
    <style>
        body { font-family: Georgia, serif; max-width: 720px; margin: 2rem auto; padding: 0 1rem; color: #222; }
        a { color: #1c1917; }
        h1 { margin-bottom: 0; }
        .muted { color: #555; }
    </style>
</head>
<body>
    <p class="muted">Printable HTML preview. <a href="{{ route('cv.pdf') }}">Download PDF</a></p>
    @include('cv-pdf', ['data' => $data])
</body>
</html>
