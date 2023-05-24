<!DOCTYPE html>
    <html>
    <head>
        <title>Nadines Padlet <3</title>
    </head>
    <body>
    <ul>
        <!--das wär in php sehr kompliziert, aber mit template sprache ist das easy. die doppelten
        klammern heißen "etwas ausgeben"-->
        @foreach($padlets as $padlet)
            <li>{{$padlet->name}}</li>
        @endforeach
    </ul>
    </body>
    </html>
