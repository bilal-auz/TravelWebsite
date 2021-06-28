<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <p>{{ $res['name'] }}</p>
    <p>{{ $res['capital'] }}</p>
    <p>{{ $res['language'] }}</p>
    <p>{{ $res['currencyName'] }}</p>
    <p>{{ $res['currencyRate'] }}</p>
    <p>{{ $res['regionalOrg'] }}</p>
    <p>{{ $res['timeZone'] }}</p>
    <p>{{ $res['continent'] }}</p>
    <p>{{ $res['alphaCode'] }}</p>
    <br>
    <br>
    <p>News:</p>
    @foreach ($res['news'] as $new)
    <p>{{ $new->title }}</p>
    @endforeach
</body>
</html>