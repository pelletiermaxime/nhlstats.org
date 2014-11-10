<script type="text/javascript">
$(function () {
	$('#tablePlayersStatsDay').dataTable({
		"bPaginate": false,
		"bFilter": false,
		"bInfo": false,
		"sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
		"aaSorting": []
	});
	$.extend( $.fn.dataTableExt.oStdClasses, {
		"sWrapper": "dataTables_wrapper form-inline table-responsive"
	});
});
</script>
<table id="tablePlayersStatsDay" class="table table-condensed">
<thead>
<tr>
	<th>Name</th>
	<th>Team</th>
	<th>Goals</th>
	<th>Assists</th>
	<th>Points</th>
	<th>Plus/Minus</th>
</tr>
</thead>
<tbody>
@foreach ($playersStatsDay as $position => $p)
<tr>
	<td>{{ $p->full_name }}</td>
	<td>
		<a href="{{ route('players_filtered') }}?team={{ $p->short_name }}&amp;count=all">
		<img height="35" src="{{ $asset_path }}/images/SVG/{{ $p->short_name }}.svg" alt="{{ $p->city }} {{ $p->team_name }}"
			title="{{ $p->city }} {{ $p->team_name }}" />
		</a>
	</td>
	<td>{{ $p->goals }}</td>
	<td>{{ $p->assists }}</td>
	<td>{{ $p->points }}</td>
	<td>{{ $p->plusminus }}</td>
</tr>
@endforeach
</tbody>
</table>
