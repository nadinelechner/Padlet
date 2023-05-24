<!DOCTYPE html>
<html>
<head>
    <title>Nadines Padlet <3</title>
</head>
<body>
<ul>
    @foreach($padlets as $padlet)
        <li><a href="/padlets/{{$padlet->id}}">{{$padlet->name}}</a></li>
    @endforeach
</ul>
</body>
</html>
