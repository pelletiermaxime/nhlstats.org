@extends('layouts.base')
@section('body')

<table class="table table-condensed dataTable" width="80%" style="width: 80%;">
<thead>
	<tr>
		<th>User</th>
	</tr>
</thead>
<tbody>
@foreach ($choicesByUsers as $username => $userChoices)
<tr>
	<td>{{ $username }}</td>
	@foreach ($userChoices as $choice)
	<td>
		<img height="35" src="/images/SVG/{{ $choice->short_name }}.svg"
					alt="{{ $choice->city }} {{ $choice->name }}" />
		<br />
		in {{ $choice->games }}
	</td>
	@endforeach
</tr>
@endforeach
</tbody>
</table>

@stop