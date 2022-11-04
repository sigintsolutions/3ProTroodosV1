Highcharts.chart('variableradiuspie', {
    chart: {
        type: 'variablepie'
    },
    title: {
        text: 'Heading'
    },
    tooltip: {
        headerFormat: '',
        pointFormat: '<span style="color:{point.color}">\u25CF</span> <b> {point.name}</b><br/>' +
            'Area (square km): <b>{point.y}</b><br/>' +
            'Population density (people per square km): <b>{point.z}</b><br/>'
    },
    series: [{
        minPointSize: 10,
        innerSize: '20%',
        zMin: 0,
        name: 'countries',
        data: [{
            name: 'sensor1',
            y: 505370,
            z: 92.9
        }, {
            name: 'sensor2',
            y: 551500,
            z: 118.7
        }, {
            name: 'sensor3',
            y: 312685,
            z: 124.6
        }, {
            name: 'sensor4',
            y: 78867,
            z: 137.5
        }, {
            name: 'sensor5',
            y: 301340,
            z: 201.8
        },]
    }]
});
