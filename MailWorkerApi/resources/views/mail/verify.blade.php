<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verify Account</title>
</head>
<body>
    <b>Welcome, </b>
    <p>{{$user->firstName}} {{$user->lastName}}</p>

    <p>Account success created</p>

    <br>
    <a href="{{$url}}">Verify account</a>
</body>
</html>
