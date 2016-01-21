<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>API routes list</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h3>Routes list</h3>

    <table class="table">
        <tr>
            <td>Path</td>
            <td>Methods</td>
        </tr>

        @foreach ($routes as $route)

            <tr>
                <td class="active">{{ $route['path'] }}</td>
                <td class="info">{{ implode(', ', $route['methods']) }}</td>
            </tr>

        @endforeach
    </table>

</div>

</body>
</html>
