Highcharts.chart('stackedbar', {
    chart: {
        type: 'bar'
    },
    title: {
        text: 'Heading'
    },
    xAxis: {
        categories: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Week report'
        }
    },
    legend: {
        reversed: true
    },
    plotOptions: {
        series: {
            stacking: 'normal'
        }
    },
    series: [{
        name: 'sensor1',
        data: [5, 3, 4, 7, 2]
    }, {
        name: 'sensor1',
        data: [2, 2, 3, 2, 1]
    }, {
        name: 'sensor1',
        data: [3, 4, 4, 2, 5]
    }]
});