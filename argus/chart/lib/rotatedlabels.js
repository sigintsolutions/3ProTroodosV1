Highcharts.chart('rotatedlabels', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Heading'
    },
    xAxis: {
        type: 'category',
        labels: {
            rotation: -45,
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Left Label'
        }
    },
    legend: {
        enabled: false
    },
    tooltip: {
        pointFormat: 'Temperature: <b>{point.y:.1f}</b>'
    },
    series: [{
        name: 'Population',
        data: [
            ['Monday', 24.2],
            ['Tuesday', 20.8],
            ['Wednesday', 14.9],
            ['Thursday', 13.7],
            ['Friday', 13.1],
            ['Saturday', 12.7],
            ['Sunday', 12.4]
        ],
        dataLabels: {
            enabled: true,
            rotation: -90,
            color: '#FFFFFF',
            align: 'right',
            format: '{point.y:.1f}', // one decimal
            y: 10, // 10 pixels down from the top
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    }]
});