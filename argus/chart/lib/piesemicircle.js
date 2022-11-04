Highcharts.chart('piesemicircle', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: 0,
        plotShadow: false
    },
    title: {
        text: 'Heading',
        align: 'center',
        verticalAlign: 'middle',
        y: 60
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        pie: {
            dataLabels: {
                enabled: true,
                distance: -50,
                style: {
                    fontWeight: 'bold',
                    color: 'white'
                }
            },
            startAngle: -90,
            endAngle: 90,
            center: ['5', '75'],
            size: '110%'
        }
    },
    series: [{
        type: 'pie',
        name: 'Value',
        innerSize: '50%',
        data: [
            ['sensor1', 58.9],
            ['sensor2', 13.29],
            ['sensor3', 13],
            ['sensor4', 3.78],
            ['sensor5', 3.42],
            {
                name: 'Other',
                y: 7.61,
                dataLabels: {
                    enabled: false
                }
            }
        ]
    }]
});
