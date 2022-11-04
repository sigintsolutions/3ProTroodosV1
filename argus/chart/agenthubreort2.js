Highcharts.setOptions({
     colors: ['#67b7dc', '#6894dd']
    });
Highcharts.chart('agenthubreort2', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: 0,
        plotShadow: false
    },
    title: {
        text: '',
        //align: 'center',
        //verticalAlign: 'middle',
       // y: 60
    },
    tooltip: {
        pointFormat: '{point.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
        	allowPointSelect: true,
          //cursor: 'pointer',
            dataLabels: {
            		 enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                connectorColor: 'silver',
				verticalAlign: 'middle',
            },
            startAngle: -90,
            endAngle: 90,
            center: ['60%', '75%'],
            size: '90%',
            cornerRadius : '10',
        }
    },
    series: [{
        type: 'pie',
        name: 'Agent Sensor',
        innerSize: '50%',
        data: [
            ['Inactive', 25],
            ['Active', 75],
        ]
    }]
});