<script type="text/javascript">
$(function () {
    $('#graphPieAvD').highcharts(
    {
        title:
        {
            text: 'Points by position',
            style: {
                color: '#fff',
            }
        },
        credits: {
            enabled: false
        },
        chart: {
            backgroundColor: null,
        },
        tooltip:
        {
            pointFormat: '{series.name}: <b>{point.y}</b>',
        },
        plotOptions:
        {
            pie:
            {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels:
                {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    color: 'white',
                }
            }
        },
        series: [
        {
            name: 'Points',
            type: 'pie',
            data: [
                @foreach ($pointsByPosition as $points)
                    ['{{ $points->position }}', {{ $points->points }}],
                @endforeach
            ],
            point:
            {
                events:
                {
                    select: function (event)
                    {
                        // Search position column in DT for the clicked point
                        var position = this.name;
                        $('#tableOverall').DataTable().column(2).search(position).draw();
                        History.pushState(null, null, '?position=' + position)
                    },
                    unselect: function (event)
                    {
                        var p = this.series.chart.getSelectedPoints();
                        // Reset search if unselected point was the one previously selected
                        if(p.length > 0 && p[0].x == this.x) {
                            $('#tableOverall').DataTable().column(2).search('').draw();
                            History.pushState(null, null, '?position=all')
                        }
                    }
                }
            }
        }]
    });
});
</script>
