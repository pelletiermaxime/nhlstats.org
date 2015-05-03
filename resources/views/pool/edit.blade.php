@extends('layouts.base')
@section('body')

@if(Session::has('success'))
<div class="alert-success text-center">
<h3>{{ Session::get('success') }}</h3>
</div>
@endif

<div align="center">
{!! $view !!}
</div>

@stop
