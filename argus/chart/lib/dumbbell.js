var data = [{
    name: 'Sensor',
    low: 69,
    high: 82
}, {
    name: 'Sensor1',
    low: 70,
    high: 81
}, {
    name: 'Sensor2',
    low: 69,
    high: 75
}, {
    name: 'Sensor3',
    low: 65,
    high: 78
}, {
    name: 'Sensor4',
    low: 70,
    high: 81
}, {
    name: 'Sensor5',
    low: 70,
    high: 79
}, {
    name: 'Sensor6',
    low: 72,
    high: 81
}, {
    name: 'Sensor7',
    low: 68,
    high: 78
}, {
    name: 'Sensor8',
    low: 69,
    high: 81
}, {
    name: 'Sensor9',
    low: 70,
    high: 83
}, {
    name: 'Sensor10',
    low: 68,
    high: 81
}];

Highcharts.chart('dumbbell', {

    chart: {
        type: 'dumbbell',
        inverted: true
    },

    legend: {
        enabled: true
    },

    title: {
        text: 'Heading'
    },

    tooltip: {
        shared: true
    },

    xAxis: {
        type: 'category'
    },

    yAxis: {
        title: {
            text: 'Units'
        }
    },

    series: [{
        name: 'Unit',
        data: data,
		color: {
			radialGradient: { cx: 0.5, cy: 0.5, r: 0.5 },
    stops: [
       [0, '#003399'],
       [1, '#3366AA']
    ]
		},
    }]

});