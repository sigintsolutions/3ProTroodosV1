Highcharts.chart('weeksenrepo', {

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

            'Monday',

            'Tuesday',

            'Wednesday',

            'Thursday',

            'Friday',

            'Saturday',

            'Sunday'

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

            color: '#f4c478',

        		lineColor:'#f37800',

        }

    },

    series: [{

        name: 'Sensor',

        data: [3, 4, 3, 5, 4, 10, 12]

    }]

});





Highcharts.chart('sentime', {

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

            'Monday',

            'Tuesday',

            'Wednesday',

            'Thursday',

            'Friday',

            'Saturday',

            'Sunday'

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

            color: '#aa8bcf',

        		lineColor:'#5501bb',

        }

    },

    series: [{

        name: 'Sensor',

        data: [3, 4, 3, 5, 4, 10, 12]

    }]

});