@extends('layouts.base')
@section('body')
@include('goalers/goalersForm')
@include('goalers/goalersStats')
@stop
@section('footer-scripts')
<script src="{{ asset('javascript/goalers.js') }}"></script>
@stop
