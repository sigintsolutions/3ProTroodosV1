Highcharts.chart('basicarea', {
    chart: {
        type: 'area'
    },
    title: {
        text: 'Head'
    },
    xAxis: {
        allowDecimals: false,
        labels: {
            formatter: function () {
                return this.value; // clean, unformatted number for year
            }
        },
    },
    yAxis: {
        title: {
            text: 'left Label'
        },
        labels: {
            formatter: function () {
                return this.value / 1000 + 'k';
            }
        }
    },
    tooltip: {
        pointFormat: 'Value <b>{point.y:,.0f}</b><br/> Year {point.x}'
    },
    plotOptions: {
        area: {
            pointStart: 2020,
            marker: {
                enabled: false,
                symbol: 'circle',
                radius: 2,
                states: {
                    hover: {
                        enabled: true
                    }
                }
            }
        }
    },
    series: [{
        name: 'sensor1',
        data: [ 6, 11, 32, 110, 235, 369, 640, 1005, 1436]
    }, {
        name: 'sensor2',
        data: [5, 25, 50, 120, 150, 200, 426, 660, 869, 1060]
    }]
});