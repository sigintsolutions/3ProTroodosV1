Highcharts.chart('3dpiedonut', {
    chart: {
        type: 'pie',
        options3d: {
            enabled: true,
            alpha: 45
        }
    },
    title: {
        text: 'Heading'
    },
    plotOptions: {
        pie: {
            innerSize: 100,
            depth: 45
        }
    },
    series: [{
        name: 'Sensor',
        data: [
            ['Monday', 8],
            ['Tuesday', 3],
            ['Wednesday', 1],
            ['Thursday', 6],
            ['Friday', 8],
            ['Saturday', 4],
            ['Sunday', 4],
        ]
    }]
});