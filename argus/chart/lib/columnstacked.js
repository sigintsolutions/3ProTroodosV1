Highcharts.chart('columnstacked', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Heading'
    },
    xAxis: {
        categories: ['Sensor1', 'Sensor2', 'Sensor3', 'Sensor4', 'Sensor5']
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Left label'
        },
        stackLabels: {
            enabled: true,
            style: {
                fontWeight: 'bold',
                color: ( // theme
                    Highcharts.defaultOptions.title.style &&
                    Highcharts.defaultOptions.title.style.color
                ) || 'gray'
            }
        }
    },
    legend: {
        align: 'right',
        x: -30,
        verticalAlign: 'top',
        y: 25,
        floating: true,
        backgroundColor:
            Highcharts.defaultOptions.legend.backgroundColor || 'white',
        borderColor: '#CCC',
        borderWidth: 1,
        shadow: false
    },
    tooltip: {
        headerFormat: '<b>{point.x}</b><br/>',
        pointFormat: '{series.name}: {point.y}'
    },
    plotOptions: {
        column: {
            stacking: 'normal',
            dataLabels: {
                enabled: true
            }
        }
    },
    series: [{
        name: 'user1',
        data: [5, 3, 4, 7, 2]
    }, {
        name: 'user2',
        data: [2, 2, 3, 2, 1]
    }, {
        name: 'user3',
        data: [3, 4, 4, 2, 5]
    }]
});