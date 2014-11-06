@extends('layouts.base')
@section('body')
@include('goalersForm')
@include('goalersStats')
@stop
@section('footer-scripts')
<script src="{{ asset('javascript/goalers.js') }}"></script>
@stop
