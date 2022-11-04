Highcharts.chart('columnnegative', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Heading'
    },
    xAxis: {
        categories: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']
    },
    credits: {
        enabled: false
    },
    series: [{
        name: 'sensor1',
        data: [5, 3, 4, 7, 2, 7, 2]
    }, {
        name: 'sensor1',
        data: [2, -2, -3, 2, 1, 7, 2]
    }, {
        name: 'sensor',
        data: [3, 4, 4, -2, 5, 7, 2]
    }]
});