Highcharts.chart('polar', {

    chart: {
        polar: true
    },

    title: {
        text: 'Heading'
    },

    pane: {
        startAngle: 0,
        endAngle: 360
    },

    xAxis: {
        tickInterval: 45,
        min: 0,
        max: 360,
        labels: {
            format: '{value}°'
        }
    },

    yAxis: {
        min: 0
    },

    plotOptions: {
        series: {
            pointStart: 0,
            pointInterval: 45
        },
        column: {
            pointPadding: 0,
            groupPadding: 0
        }
    },

    series: [{
        type: 'column',
        name: 'Sensor1',
        data: [8, 7, 6, 5, 4, 3, 2, 1],
        pointPlacement: 'between'
    }, {
        type: 'line',
        name: 'Sensor2',
        data: [1, 2, 3, 4, 5, 6, 7, 8]
    }, {
        type: 'area',
        name: 'Sensor3',
        data: [1, 8, 2, 7, 3, 6, 4, 5]
    }]
});