var chart = Highcharts.chart('agentlog', {

    title: {
        text: 'Agent Log'
    },
    
    chart: {
            inverted: true,
            polar: false
        },

    xAxis: {
        categories: ['Active Login', 'Total Agents']
    },

    series: [{
    		name: ' ',
        type: 'column',
        colorByPoint: true,
        data: [loginagents, logoutagents],
    }]

});


