<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Your Name - @yeild('title')</title>

        {!! Html::style('/../bootstrap/css/bootstrap.min.css') !!} 
        {!! Html::script('/../jquery/jquery.min.js') !!} 
        {!! Html::script('/../bootstrap/js/bootstrap.min.js') !!}    
    </head>
    <body>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <dir class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapsed" data-target="#">                    
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </dir>
            <a href="{{ url('articles') }}" class="navbar-brand">Breaking News</a>
        </div>

        <div class="collapsed navbar-nav navbar-right">
            <li>
                <a href="{{ url('articles/create') }}">New Article</a>
            </li>
        </div>
    </nav>