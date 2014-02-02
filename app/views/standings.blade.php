@extends('layouts.base')
@section('body')

<script type="text/javascript">
$(document).ready(function(){
	tableOverall = $('#tableOverall').dataTable({
		"bPaginate": false,
		"bFilter": false,
		"bInfo": false,
		"sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
		"aoColumnDefs": [
			{ "bVisible": false, "aTargets": [ 3 ] },
		],
	});
	$('#division_sort').click(function(){
		tableOverall.fnSort( [ [3,'asc'], [2,'asc'], [8,'desc'], [4,'asc'], [5,'desc'] ] );
	});
	$('#overall_sort').click(function(){
		tableOverall.fnSort( [ [8,'desc'], [4,'asc'], [5,'desc'] ] );
	});
});
$.extend( $.fn.dataTableExt.oStdClasses, {
	"sWrapper": "dataTables_wrapper form-inline table-responsive"
} );
</script>

@include('standingsOverall')

@stop