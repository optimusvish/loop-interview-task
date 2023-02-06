<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loop</title>
</head>

<body>
    <h1>Follow the Below Instructions to Test Below API's</h1>
    {{ Illuminate\Mail\Markdown::parse(file_get_contents(base_path() . '/README.md')) }}
</body>

</html>