Highcharts.chart('windbarbseries', {
	chart: {
        scrollablePlotArea: {
            minWidth: 600
        }
    },
    title: {
        text: 'Heading'
    },

    xAxis: {
        type: 'datetime',
        offset: 40
    },

    plotOptions: {
        series: {
            pointStart: Date.UTC(2017, 0, 29),
            pointInterval: 36e5
        }
    },

    series: [{
        type: 'windbarb',
        data: [
            [9.8, 177.9],
            [10.1, 177.2],
            [11.3, 179.7],
            [10.9, 175.5],
            [9.3, 159.9],
            [8.8, 159.6],
            [7.8, 162.6],
            [5.6, 186.2],
            [6.8, 146.0],
            [6.4, 139.9],
            [3.1, 180.2],
            [4.3, 177.6],
            [5.3, 191.8],
            [6.3, 173.1],
            [7.7, 140.2],
            [8.5, 136.1],
            [9.4, 142.9],
            [10.0, 140.4],
            [5.3, 142.1],
            [3.8, 141.0],
            [3.3, 116.5],
            [1.5, 327.5],
            [0.1, 1.1],
            [1.2, 11.1]
        ],
        name: 'Wind',
        color: Highcharts.getOptions().colors[1],
        showInLegend: false,
        tooltip: {
            valueSuffix: ' m/s'
        }
    }, {
        type: 'area',
        keys: ['y', 'rotation'], // rotation is not used here
        data: [
            [9.8, 177.9],
            [10.1, 177.2],
            [11.3, 179.7],
            [10.9, 175.5],
            [9.3, 159.9],
            [8.8, 159.6],
            [7.8, 162.6],
            [5.6, 186.2],
            [6.8, 146.0],
            [6.4, 139.9],
            [3.1, 180.2],
            [4.3, 177.6],
            [5.3, 191.8],
            [6.3, 173.1],
            [7.7, 140.2],
            [8.5, 136.1],
            [9.4, 142.9],
            [10.0, 140.4],
            [5.3, 142.1],
            [3.8, 141.0],
            [3.3, 116.5],
            [1.5, 327.5],
            [0.1, 1.1],
            [1.2, 11.1]
        ],
        color: Highcharts.getOptions().colors[0],
        fillColor: {
            linearGradient: { x1: 0, x2: 0, y1: 0, y2: 1 },
            stops: [
                [0, Highcharts.getOptions().colors[0]],
                [
                    1,
                    Highcharts.color(Highcharts.getOptions().colors[0])
                        .setOpacity(1).get()
                ]
            ]
        },
        name: 'Wind speed',
        tooltip: {
            valueSuffix: ' m/s'
        },
        states: {
            inactive: {
                opacity: 1
            }
        }
    }]

});