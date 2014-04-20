@extends('layouts.base')
@section('body')

<?php $lastUsername = '' ?>
@foreach ($playoffChoices as $choice)
	@if ($choice->username != $lastUsername)
		{{ $choice->username }}
	@endif
	<img height="35" src="/images/SVG/{{ $choice->short_name }}.svg"
				alt="{{ $choice->city }} {{ $choice->name }}" />
	in {{ $choice->games }}
	<?php $lastUsername = $choice->username ?>
@endforeach


@stop