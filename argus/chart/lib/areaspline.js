Highcharts.chart('areaspline', {
    chart: {
        type: 'areaspline'
    },
    title: {
        text: 'Heading'
    },
    legend: {
        layout: 'vertical',
        align: 'left',
        verticalAlign: 'top',
        x: 150,
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
        ],
    },
    yAxis: {
        title: {
            text: 'Left Label'
        }
    },
    tooltip: {
        shared: true,
        valueSuffix: ' units'
    },
    credits: {
        enabled: false
    },
    plotOptions: {
        areaspline: {
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