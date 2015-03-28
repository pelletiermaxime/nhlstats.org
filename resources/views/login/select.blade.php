@extends('layouts.base')
@section('body')
<div class="container">
	<a href="{{ route('do_login', 'facebook') }}">
	<button type="button" class="btn btn-primary btn-lg btn-block">Facebook</button>
	</a>
	<a href="{{ route('do_login', 'github') }}">
	<button type="button" class="btn btn-primary btn-lg btn-block">Github</button>
	</a>
</div>
@stop

