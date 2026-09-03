<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>CV — {{ $data->profile->name }}</title>
    <style>
        @page { margin: 18mm 16mm; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #222; line-height: 1.35; }
        h1 { font-size: 20px; margin: 0 0 2px; }
        h2 { font-size: 12px; margin: 14px 0 6px; border-bottom: 1px solid #bbb; padding-bottom: 3px; text-transform: uppercase; letter-spacing: 0.08em; }
        h3 { font-size: 11px; margin: 0; }
        p { margin: 0 0 6px; }
        table { width: 100%; border-collapse: collapse; }
        td { vertical-align: top; padding: 0 0 8px; }
        .meta { color: #444; font-size: 9px; }
        .dates { width: 95px; color: #555; white-space: nowrap; }
        ul { margin: 4px 0 0 16px; padding: 0; }
        li { margin-bottom: 2px; }
        .header td { padding-bottom: 10px; }
        img.photo { width: 72px; height: 72px; }
    </style>
</head>
<body>
    @include('partials.cv-content', ['data' => $data, 'forPdf' => true])
</body>
</html>
