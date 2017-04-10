@extends('layouts.base')
@section('body')

<div class="col-xs-offset-4su ">
<ul>
    <li>5 pts for right team</li>
    <li>bonus of 3 pts for exact number of games</li>
    <li>1 pt for +- 1 game</li>
</ul>
</div>
<table class="table table-condensed dataTable" width="80%" style="width: 80%;">
<thead>
    <tr>
        <th>User</th>
        <th colspan="{{ $choicesByUsernameAndRounds->first()->first()['choices']->count() }}">Choices</th>
        <th>Total</th>
    </tr>
</thead>
<tbody>
@foreach ($choicesByUsernameAndRounds as $username => $rounds)
<tr>
    <td>{{ $username }}</td>
    <? $total = 0; ?>
    @foreach ($rounds as $noRound => $userChoices)
        @foreach ($userChoices['choices'] as $choice)
        <td>
            <img height="35" src="/images/SVG/{{ $choice->short_name }}.svg"
                alt="{{ $choice->city }} {{ $choice->name }}" />
            <br />
            in {{ $choice->games }}
        </td>
        @endforeach
        <td style="border:1px solid red;width:30px;text-align:center;">
            <? $total += $userChoices['points'] ?>
            {{ $userChoices['points'] }}
        </td>
    @endforeach
    <td style="border:1px solid red;width:30px;text-align:center;">
        {{ $total }}
    </td>
</tr>
@endforeach
</tbody>
</table>
@stop
