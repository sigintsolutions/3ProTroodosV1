Highcharts.chart('container', {

    chart: {

        type: 'areaspline'

    },

    title: {

        text: ''

    },

    legend: {

        layout: 'vertical',

        align: 'left',

        verticalAlign: 'top',

        x: 150,

        y: 100,

        

        floating: true,

        borderWidth: 1,

        backgroundColor:

           Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF'

    },

    xAxis: {

        categories: [
					 
			'Sunday',

            'Monday',

            'Tuesday',

            'Wednesday',

            'Thursday',

            'Friday',

            'Saturday'

        ],

    },

    yAxis: {

        title: {

            text: ''

        }

    },

    tooltip: {

        shared: true,

        valueSuffix: ' units'

    },

    credits: {

        enabled: false

    },

    plotOptions: {

        areaspline: {

            fillOpacity: 1,

            color: '#bbbbbb',

        		lineColor:'#41008a',

        }

    },

    series: [{

        name: 'Sensor',

        data: dataweek

    }]

});