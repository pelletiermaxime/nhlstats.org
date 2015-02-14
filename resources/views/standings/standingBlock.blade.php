<tr align="left" style="background:grey; color:white; font-size: 18px;">
	<td colspan="22">{{ $titre }}</td>
</tr>
<?php $position = 1; ?>
@foreach ($standings as $s)
<tr>
	@if ($s->conference == 'EAST')
	<td style="background:#b9112d;color:white;font-size:1.8em;">{{ $position++ }}</td>
	@else
	<td style="background:#003872;color:white;font-size:1.8em;">{{ $position++ }}</td>
	@endif
	<td>
		<a href="{{ route('team', $s->short_name) }}">
		<img height="35" src="{{ asset('images/SVG') }}/{{ $s->short_name }}.svg"
			alt="{{ $s->city }} {{ $s->name }}" />
		</a>
	</td>
	<td>{{ $s->division }}</td>
	<td>{{ $s->conference }}</td>
	<td>{{ $s->gp }}</td>
	<td>{{ $s->w }}</td>
	<td>{{ $s->l }}</td>
	<td>{{ $s->otl }}</td>
	<td>{{ $s->pts }}</td>
	<td>{{ $s->gf }}</td>
	<td>{{ $s->ga }}</td>
	<td>{{ $s->diff }}</td>
	<td>{{ $s->ppg }}</td>
	<td>{{ $s->ppo }}</td>
	<td>{{ sprintf ("%6.2f", $s->ppp) }}</td>
	<td>{{ $s->ppga }}</td>
	<td>{{ $s->ppoa }}</td>
	<td>{{ sprintf ("%6.2f", $s->pkp) }}</td>
	<td>{{ $s->home }}</td>
	<td>{{ $s->away }}</td>
	<td>{{ $s->l10 }}</td>
	<td>{{ $s->streak }}</td>
</tr>
@endforeach
