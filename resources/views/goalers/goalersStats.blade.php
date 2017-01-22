<table width="80%" id="tableOverall" class="table table-condensed table-striped">
<thead>
<tr>
    <th>#</th>
    <th>Name</th>
    <th>Team</th>
    <th>GP</th>
    <th>SA</th>
    <th>GA</th>
    <th>W</th>
    <th>L</th>
    <th>SO</th>
    <th>Saves</th>
    <th>Saves %</th>
    <th>GAA</th>
</tr>
</thead>
<tbody>
@foreach ($goalersStatsYear as $position => $p)
<tr>
    @if ($p->conference == 'EAST')
    <td style="background:#b9112d;color:white;font-size:1.8em;">{{ ++$position }}</td>
    @else
    <td style="background:#003872;color:white;font-size:1.8em;">{{ ++$position }}</td>
    @endif
    <td>{{ $p->full_name }}</td>
    <td>
    <a href="{{ route('team', $p->short_name) }}">
        <img height="35" src="{{ asset('images/SVG') }}/{{ $p->short_name }}.svg" alt="{{ $p->city }} {{ $p->team_name }}"
            title="{{ $p->city }} {{ $p->team_name }}" />
        </a>
    </td>
    <td>{{ $p->games }}</td>
    <td>{{ $p->shots_against }}</td>
    <td>{{ $p->goals_against }}</td>
    <td>{{ $p->win }}</td>
    <td>{{ $p->lose }}</td>
    <td>{{ $p->shootouts }}</td>
    <td>{{ $p->saves }}</td>
    <td>{{ $p->roundedPourcent }}</td>
    <td>{{ $p->goals_against_average }}</td>
</tr>
@endforeach
</tbody>
</table>
