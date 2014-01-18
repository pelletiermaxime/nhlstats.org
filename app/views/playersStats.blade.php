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
	@if ($p->conference == 'EAST')
	<td style="background:#b9112d;color:white;font-size:1.8em;">{{ ++$position }}</td>
	@else
	<td style="background:#003872;color:white;font-size:1.8em;">{{ ++$position }}</td>
	@endif
	<td>{{ $p->full_name }}</td>
	<td>{{ $p->position }}</td>
	<td>
		<img height="35" src="images/SVG/{{ $p->short_name }}.svg" alt="{{ $p->city }} {{ $p->name }}"
			title="{{ $p->city }} {{ $p->name }}" />
	</td>
	<td>{{ $p->games }}</td>
	<td>{{ $p->goals }}</td>
	<td>{{ $p->assists }}</td>
	<td>{{ $p->points }}</td>
	<td>{{ $p->plusminus }}</td>
</tr>
@endforeach
</tbody>
</table>