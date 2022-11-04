Highcharts.chart('agentleveschart', {
    chart: {
        type: 'column',
        plotBorderWidth: 1,
    },
    title: {
        text: ''
    },
    xAxis: {
        type: 'category',
        crosshair: true,       
    },
    yAxis: {
        title: {
            text: 'TEMPERATURE',
        }

    },
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            color: '#48a9d3',
            dataLabels: {
                enabled: true,
                color: '#969696',
                format: '{point.y:f}°C'
            }
        }
    },

    tooltip: {
        headerFormat: '<span style="font-size:11px">{point.name}</span><br>',
       // pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
    },

    series: [
        {
            name: "Sensor ID",
           // colorByPoint: true,
            
            data: [
                {
                    name: "SR00156",
                    y: 13
                },
                {
                    name: "SR00698",
                    y: 50
                },
                {
                    name: "SR00315",
                    y:45
                },
                {
                    name: "SR00486",
                    y: 31
                },
                {
                    name: "SR00133",
                    y: 34
                },
                {
                    name: "SR22156",
                    y: 30
                },
                {
                    name: "SR01556",
                    y: 45
                },
                {
                    name: "SR03156",
                    y: 44
                }
            ]
        }
    ]
});