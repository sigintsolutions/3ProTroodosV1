Highcharts.chart('invertedaxes', {
    chart: {
        type: 'area',
        inverted: true
    },
    title: {
        text: 'Heading'
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'top',
        x: -150,
        y: 100,
        floating: true,
        borderWidth: 1,
        backgroundColor:
            Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF'
    },
    xAxis: {
        categories: [
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
            'Sunday'
        ]
    },
    yAxis: {
        title: {
            text: 'Number of units'
        },
        allowDecimals: false,
        min: 0
    },
    plotOptions: {
        area: {
            fillOpacity: 0.5
        }
    },
    series: [{
        name: 'sensor1',
        data: [3, 4, 3, 5, 4, 10, 12]
    }, {
        name: 'sensor2',
        data: [1, 3, 4, 3, 3, 5, 4]
    }]
});