Highcharts.chart('basicbar', {
    chart: {
        type: 'bar'
    },
    title: {
        text: 'Heading'
    },
    xAxis: {
        categories: ['sensor1', 'sensor2', 'sensor3', 'sensor4', 'sensor5'],
        title: {
            text: null
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Population (millions)',
            align: 'high'
        },
        labels: {
            overflow: 'justify'
        }
    },
    tooltip: {
        valueSuffix: ' millions'
    },
    plotOptions: {
        bar: {
            dataLabels: {
                enabled: true
            }
        }
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'top',
        x: -40,
        y: 80,
        floating: true,
        borderWidth: 1,
        backgroundColor:
            Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
        shadow: true
    },
    credits: {
        enabled: false
    },
    series: [{
        name: 'Year 2017',
        data: [10.1, 5.1, 0.10, 20.3, 2]
    }, {
        name: 'Year 2018',
        data: [13.3, 7.6, 9.47, 30.8, 0.6]
    }, {
        name: 'Year 2019',
        data: [8.14, 4.21, 7.14, 17.7, 3.1]
    }, {
        name: 'Year 2020',
        data: [12.6, 10.1, 4.36, 13.8, 4.0]
    }]
});