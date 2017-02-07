@section('title', 'About Me')
@section('content')

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        {!! Html::style('/../bootstrap/css/bootstrap.min.css') !!}     
    </head>
    <body>

        {!! Html::script('/../jquery/jquery.min.js') !!} 
        {!! Html::script('/../bootstrap/js/bootstrap.min.js') !!}

        <h1>About Me : {{$first}} {{$last}}</h1>


        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    My Skills
                </h3>
            </div>
        </div>
        <div class="panel-body">
            <ul class="list-group">
                @foreach($skills as $skill)
                <li class="list-group-item">
                    {{$skill}}
                </li>
                @endforeach
            </ul>
            
        </div>

        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                  <a class="navbar-brand" href="#">Brand</a>
                </div>
            </div>
        </div>
    </body>
</html>
