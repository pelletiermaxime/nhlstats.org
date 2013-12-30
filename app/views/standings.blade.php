@extends('layouts.base')
@section('body')

<script type="text/javascript">
$(document).ready(function(){
	$('#tableOverall').dataTable({
		"bPaginate": false,
		"bFilter": false,
		"bInfo": false,
	});
});
</script>

@include('standingsOverall')

@stop