<script type="text/javascript">
$(document).ready(function(){
	$('#tableOverall').dataTable({
		"bPaginate": false,
		"bFilter": false,
		"bInfo": false,
		"sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>"
	});
});
$.extend( $.fn.dataTableExt.oStdClasses, {
	"sWrapper": "dataTables_wrapper form-inline table-responsive"
} );
</script>
<table width="80%" id="tableOverall" class="table table-condensed">
<thead>
<tr>
	<th>#</th>
	<th>Name</th>
	<th>Pos</th>
	<th>Team</th>
	<th>Games</th>
	<th>Goals</th>
	<th>Assists</th>
	<th>Points</th>
	<th>Plus/Minus</th>
</tr>
</thead>
<tbody>
@foreach ($playersStatsYear as $position => $p)
<tr>
	@if ($p['player']['team']['division']['conference'] == 'EAST')
	<td style="background:#b9112d;color:white;font-size:1.8em;">{{ ++$position }}</td>
	@else
	<td style="background:#003872;color:white;font-size:1.8em;">{{ ++$position }}</td>
	@endif
	<td>{{ $p['player']['full_name'] }}</td>
	<td>{{ $p['player']['position'] }}</td>
	<td>
		<img height="35" src="images/SVG/{{ $p['player']['team']['short_name'] }}.svg"
			alt="{{ $p['player']['team']['city'] }} {{ $p['player']['team']['name'] }}" />
	</td>
	<td>{{ $p['games'] }}</td>
	<td>{{ $p['goals'] }}</td>
	<td>{{ $p['assists'] }}</td>
	<td>{{ $p['points'] }}</td>
	<td>{{ $p['plusminus'] }}</td>
</tr>
@endforeach
</tbody>
</table>