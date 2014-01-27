@extends('layouts.base')
@section('body')
@include('playersForm')
<div style="float:left">
@include('playersStats')
</div>
<div style="float:left">
@include('playersStatsDay')
</div>
@stop