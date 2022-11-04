Highcharts.chart('combo', {
    title: {
        text: 'Heading'
    },
    xAxis: {
        categories: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']
    },
    labels: {
        items: [{
            html: 'Total',
            style: {
                left: '50px',
                top: '18px',
                color: ( // theme
                    Highcharts.defaultOptions.title.style &&
                    Highcharts.defaultOptions.title.style.color
                ) || 'black'
            }
        }]
    },
    series: [{
        type: 'column',
        name: 'Sensor1',
        data: [3, 2, 1, 3, 4]
    }, {
        type: 'column',
        name: 'Sensor2',
        data: [2, 3, 5, 7, 6]
    }, {
        type: 'column',
        name: 'Sensor3',
        data: [4, 3, 3, 9, 0]
    }, {
        type: 'spline',
        name: 'Average',
        data: [3, 2.67, 3, 6.33, 3.33],
        marker: {
            lineWidth: 2,
            lineColor: Highcharts.getOptions().colors[3],
            fillColor: 'white'
        }
    }, {
        type: 'pie',
        name: 'Total',
        data: [{
            name: 'Sensor1',
            y: 13,
            color: Highcharts.getOptions().colors[0] // Jane's color
        }, {
            name: 'Sensor2',
            y: 23,
            color: Highcharts.getOptions().colors[1] // John's color
        }, {
            name: 'Sensor3',
            y: 19,
            color: Highcharts.getOptions().colors[2] // Joe's color
        }],
        center: [100, 80],
        size: 100,
        showInLegend: false,
        dataLabels: {
            enabled: false
        }
    }]
});
