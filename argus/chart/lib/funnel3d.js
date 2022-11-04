// Set up the chart
Highcharts.chart('funnel3d', {
    chart: {
        type: 'funnel3d',
        options3d: {
            enabled: true,
            alpha: 10,
            depth: 50,
            viewDistance: 50
        }
    },
    title: {
        text: 'Heading'
    },
    plotOptions: {
        series: {
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b> ({point.y:,.0f})',
                allowOverlap: true,
                y: 10
            },
            neckWidth: '30%',
            neckHeight: '25%',
            width: '80%',
            height: '80%'
        }
    },
    series: [{
        name: 'Value',
        data: [
            ['Sensor1', 15654],
            ['Sensor2', 4064],
            ['Sensor3', 1987],
            ['Sensor4', 976],
            ['Sensor5', 846]
        ]
    }]
});