Highcharts.setOptions({
     colors: ['#f37800', '#f5bd5e']
    });
Highcharts.chart('agenthistory', {
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
                connectorColor: 'silver'
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
        name: 'Agent Log',
        innerSize: '50%',
        data: [
            ['Inactive', perlogout],
            ['Active', perlogin],
        ]
    }]
});


Highcharts.chart('agenthistory0', {
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
                connectorColor: 'silver'
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
        name: 'Agent Log',
        innerSize: '50%',
        data: [
            ['Inactive', 28],
            ['Active', 72],
        ]
    }]
});