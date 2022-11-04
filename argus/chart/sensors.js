// Create the chart
Highcharts.chart('container', {
    chart: {
        type: 'column',
        plotBorderWidth: 1,
    },
    title: {
        text: 'Sensor'
    },
    xAxis: {
        type: 'category',
        crosshair: true,
        
    },
    yAxis: {
        title: {
            text: 'Total Reading in Precentage',
        }

    },
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            color: '#abb947',
            dataLabels: {
                enabled: true,
                color: '#abb947',
                format: '{point.y:f}%'
            }
        }
    },

    tooltip: {
        headerFormat: '<span style="font-size:11px">{point.name}</span><br>',
       // pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
    },

    series: [
        {
            name: "Sensor",
           // colorByPoint: true,
            
            data: [
                {
                    name: "Water Soil (%)",
                    y: 5
                },
                {
                    name: "Temp Air (°C)",
                    y: 10
                },
                {
                    name: "Co2 (%)",
                    y:12
                },
                {
                    name: "O2 (mg/L)",
                    y: 14
                },
                {
                    name: "Wind (mph)",
                    y: 17
                },
                {
                    name: "Pressure (bar)",
                    y: 13
                },
                {
                    name: "Flow (°C)",
                    y: 10
                },
                {
                    name: "Level (°C)",
                    y: 20
                }
            ]
        }
    ]
});





