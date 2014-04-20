@foreach ($playoffChoices as $choice)
<img height="35" src="/images/SVG/{{ $choice->short_name }}.svg"
			alt="{{ $choice->city }} {{ $choice->name }}" />
in {{ $choice->games }}
<br />
@endforeach