Highcharts.chart('polarradialbar', {
    colors: ['#FFD700', '#C0C0C0', '#CD7F32'],
    chart: {
        type: 'column',
        inverted: true,
        polar: true
    },
    title: {
        text: 'Heading'
    },
    tooltip: {
        outside: true
    },
    pane: {
        size: '85%',
        innerSize: '20%',
        endAngle: 270
    },
    xAxis: {
        tickInterval: 1,
        labels: {
            align: 'right',
            useHTML: true,
            allowOverlap: true,
            step: 1,
            y: 3,
            style: {
                fontSize: '13px'
            }
        },
        lineWidth: 0,
        categories: [
            'Sensor1 ' +
            '</span></span>',
            'Sensor2' +
            '</span></span>',
            'Sensor3' +
            '</span></span>',
            'Sensor4' +
            '</span></span>',
            'Sensor5' +
            '</span></span>'
        ]
    },
    yAxis: {
        crosshair: {
            enabled: true,
            color: '#333'
        },
        lineWidth: 0,
        tickInterval: 25,
        reversedStacks: false,
        endOnTick: true,
        showLastLabel: true
    },
    plotOptions: {
        column: {
            stacking: 'normal',
            borderWidth: 0,
            pointPadding: 0,
            groupPadding: 0.15
        }
    },
    series: [{
        name: 'Low',
        data: [132, 105, 92, 73, 64]
    }, {
        name: 'Medium',
        data: [125, 110, 86, 64, 81]
    }, {
        name: 'High',
        data: [111, 90, 60, 62, 87]
    }]
});