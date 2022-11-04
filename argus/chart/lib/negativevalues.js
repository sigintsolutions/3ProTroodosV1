Highcharts.chart('negativevalues', {
    chart: {
        type: 'area'
    },
    title: {
        text: 'Heading'
    },
    xAxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May']
    },
    credits: {
        enabled: false
    },
    series: [{
        name: 'Sensor1',
        data: [5, 3, 4, 7, 2]
    }, {
        name: 'Sensor2',
        data: [2, -2, -3, 2, 1]
    }, {
        name: 'Sensor3',
        data: [3, 4, 4, -2, 5]
    }]
});