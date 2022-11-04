Highcharts.chart('piebasic', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Heading'
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
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %'
            }
        }
    },
    series: [{
        name: 'Brands',
        colorByPoint: true,
        data: [{
            name: 'sensor1',
            y: 61.41,
            sliced: true,
            selected: true
        }, {
            name: 'sensor2',
            y: 11.84
        }, {
            name: 'sensor3',
            y: 10.85
        }, {
            name: 'sensor4',
            y: 4.67
        }, {
            name: 'sensor5',
            y: 4.18
        }, {
            name: 'sensor6',
            y: 1.64
        }, {
            name: 'sensor7',
            y: 1.6
        }]
    }]
});