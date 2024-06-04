<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mov's - LAS</title>
    <style>
        .page-break {
            page-break-after: always;
        }
</style>
</head>
<body>
@foreach($images as $image)
    <img src="{{ storage_path('app/images/'.$image->title) }}" alt="{{ $image->title }}" style="max-width: 100%; height: auto;">
    <div class="page-break"></div>
@endforeach
</body>
</html>