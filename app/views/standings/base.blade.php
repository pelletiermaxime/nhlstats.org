@extends('layouts.base')
@section('body')

<?php
$standingPages = [
	route('standings')  => 'Overall',
	route('standings_division') => 'Division',
	route('standings_wildcard') => 'Wildcard',
];
$currentPage = URL::current();
$routeName = Route::currentRouteName();
?>
@if ($routeName == 'standings')
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
		"aaSorting": []
	});
});
$.extend( $.fn.dataTableExt.oStdClasses, {
	"sWrapper": "dataTables_wrapper form-inline table-responsive"
} );
</script>
@endif
<div style="width:80%; margin:auto;">
<ul class="nav nav-tabs">
@foreach ($standingPages as $page => $pageName)
	@if ($page == $currentPage )
	<li class="active">
	@else
	<li>
	@endif
		<a href="{{ $page }}">{{ $pageName }}</a>
	</li>
@endforeach
</ul>
</div>

@yield('standings')

@stop