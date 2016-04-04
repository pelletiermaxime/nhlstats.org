@extends('layouts.base')
@section('body')

<div class="row">
    @for ($i = 1; $i <= 3; $i++)
        <div class="playoff_bracket col-xs-2">
        @if (isset($games_east[$i]))
        @foreach ($games_east[$i] as $game)
            @include('playoffBracket.box', ['conference' => 'East', 'g' => $game])
        @endforeach
        @endif
        </div>
    @endfor
    @for ($i = 3; $i >= 1; $i--)
        <div class="playoff_bracket col-xs-2">
        @if (isset($games_west[$i]))
        @foreach ($games_west[$i] as $game)
            @include('playoffBracket.box', ['conference' => 'West', 'g' => $game])
        @endforeach
        @endif
        </div>
    @endfor
</div>

@stop
