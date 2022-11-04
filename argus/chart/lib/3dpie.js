Highcharts.chart('3dpie', {
    chart: {
        type: 'pie',
        options3d: {
            enabled: true,
            alpha: 45,
            beta: 0
        }
    },
    title: {
        text: 'Heading'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            depth: 35,
            dataLabels: {
                enabled: true,
                format: '{point.name}'
            }
        }
    },
    series: [{
        type: 'pie',
        name: 'Unit',
        data: [
            ['Sensor1', 45.0],
            ['Sensor2', 26.8],
            ['Sensor3', 8.5],
            ['Sensor4', 6.2],
            ['Sensor5', 0.7]
        ]
    }]
});