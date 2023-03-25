@extends('adminlte::page')

@section('title', 'Plan')


@section('content')
    <div id="app">
        <!--<form-component></form-component>-->
        <plan-component></plan-component>
    </div>
@stop

@section('css')
   <!-- <link rel="stylesheet" href="/css/admin_custom.css">-->
   @vite('resources/css/app.css')
@stop

@section('js')
    <!--<script> console.log('Hi!'); </script>-->
    @vite('resources/js/app.js')
@stop