<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        img {
            display: block;
            max-width: 100%;
            height: auto;
            margin: 20px auto;
        }
        </style>
</head>
<body>
    <img src="{{ asset('storage/jaket_images/' . $filename) }}" alt="">
</body>
</html>
