@extends('layouts.admin')
@section('content')
<!---- euz_div ----->

<!--Displaying sensors-->
    <div class="p-3">
        <div class="row">
            <div class="col-md-12 euz_bar euz_b">
                <a href="{{ url('/agent/gateway') }}"><i class="fas fa-user euz_text_blue"></i> <?php echo $user[0]->fname.' '.$user[0]->lname; ?></a> / <a href="<?php echo  url('/agent/gateway'); ?>"><?php echo $groupname[0]->name; ?></a> / <a href="<?php echo  url('/agent/sensorhubs/'.$user[0]->id.'/'.$group[0]->id); ?>"><?php echo $hubname[0]->hub_id; ?></a> / <span class="euz_ac_bl">Sensor</span>
            </div>
            @if(Session::has('flash_message'))
            <div class="alert alert-success w-100"><button type="button" class="close" data-dismiss="alert">&times;</button>{{ Session::get('flash_message') }}</div>
            @endif
            <div class="col-md-12 euz_border p-3 bg-white">
                <div class="row">
                    <div class="col-md-12 my-2">
                        <a class="btn btn-primary float-right rounded-0 ml-2 euz_bt" href="<?php echo url('/agent/sensorhubs/'.request()->agentid.'/'.request()->groupid); ?>"><i class="far fa-arrow-alt-circle-left"></i> Back To Sensor Hub</a>
                    </div>
                    @foreach($sensors as $index =>$item)
                    <div class="col-md-4 mt-2">
                        <div class="card">
                            <div class="card-header">
                                <div class="custom-checkbox">
                                    <label class="euz_check_box euz_b pl-0">{{ $item->sensor_id }}</label>
                                </div>
                            </div>
                            <div class="card-body pb-0 euz_b">
                                <p class="mb-2">Type : {{ $item->typename }}</p>
                                <p class="mb-2">Brand : {{ $item->brand }}</p>
                            </div> 
                            <?php 
                                $graph = DB::select('select * from sensor_graph where sensor_id ='.$item->sensorid);
                            ?>
                            <div class="card-footer text-right bg-white euz_card_fo px-2">
                                <a href="javascript:void(0)" class="ml-2" data-toggle="tooltip" data-placement="top" title="Sensor Info" onclick="profileopen(<?php echo $item->sensorid.','.$item->hub_id.','.request()->agentid.','.request()->groupid; ?>)"><i class="fas fa-eye euz_a_icon"></i></a>
                                <?php if(!empty($graph[0]->id)) { ?>
                                <!--<a href="javascript:void(0)" class="ml-2 chartedit"  data-id="{{ $item->sensorid }}" data-toggle="modal" data-target="#chartedit" title="Graph"><i class="fas fa-chart-bar euz_a_icon"></i></a>-->
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>			
        </div>
    </div>
    <!---profile---->
	<div id="agentprofile" class="euz_agent_profile" ></div>
    <!---End Profile---->
    <!--editchart--->   
    <div class="modal fade" id="chartedit">
		<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable euz_w_90">
			<div class="modal-content">
                <div class="modal-header euz_carb p-0">
                    <p class="modal-title p-2 text-white">Sensor Graph</p>
                </div>
                <div class="modal-body">
                    <form  method="POST" enctype="multipart/form-data" action="{{ url('/admin/updategraph') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="grapheid" value="" id="editgrapheid" />
                        <input type="hidden" name="agent" value="<?php echo $user[0]->id; ?>" id="" />                                  
                        <div class="row">
                            <div class="form-group col-md-3 my-2">
                                <label class="euz_b" for="">Sensor Name</label>
                                <input type="text" class="form-control" id="snameedit" name="" disabled="disabled" value="" />
                            </div>
                            <div class="form-group col-md-3 my-2">
                                <label class="euz_b" for="">Modal</label>
                                <input type="text" class="form-control" id="modaledit" name="" disabled="disabled" value="" />
                            </div>
                            <div class="form-group col-md-3 my-2">
                                <label class="euz_b" for="">Type</label>
                                <input type="text" class="form-control" id="typenameedit" name="" disabled="disabled" />
                            </div>
                            <div class="form-group col-md-3 my-2">
                                <label class="euz_b" for="">Brand</label>
                                <input type="text" class="form-control" id="sensorbrandedit" name="" disabled="disabled" />
                            </div>
                            <div class="form-group col-md-3 my-2">
                                <label class="euz_b" for="">Measurement Unit</label>
                                <input type="text" class="form-control" id="sensorunitedit" name="" disabled="disabled" />
                            </div>
                            <!-- <div class="form-group col-md-3 my-2">
                                <label class="euz_b" for="">Type</label>
                                <select class="form-control disname" id="typegraph" name="type" required disabled="disabled" >
                                    <option value="">Select Type</option>
                                    <option value="line">Line</option>
                                    <option value="area">Area</option>
                                    <option value="column">Column</option>
                                    <option value="bar">Bar</option>
                                    <option value="pie">Pie</option>
                                    <option value="scatter">Scatter</option>
                                    <option value="spline">Spline</option>
                                </select>
                            </div> -->
                            <div class="form-group col-md-9 my-2">
                                <label class="euz_b" for="">Title</label>
                                <input type="text" class="form-control disname" id="title" name="title" required disabled="disabled" />
                            </div>
                            <div class="form-group col-md-3 my-2">
                                <label class="euz_b" for="">Y Axis Label</label>
                                <input type="text" class="form-control disname" id="edityaxis" name="yaxis" required disabled="disabled" />
                            </div>
                            <div class="form-group col-md-3 my-2">
                                <label class="euz_b" for="">Min Value</label>
                                <input type="text" class="form-control disname" id="min" name="min" disabled="disabled" />
                            </div>
                            <div class="form-group col-md-3 my-2">
                                <label class="euz_b" for="">Max Value</label>
                                <input type="text" class="form-control disname" id="max" name="max" disabled="disabled" />
                            </div>
                            <div class="form-group col-md-3 my-2">
                                <label class="euz_b" for="">Fake Value</label>
                                <input type="text" class="form-control disname" id="fake" name="fake" disabled="disabled" />
                            </div>                      
                            <div class="col-md-12 my-2">
                                <div class="shadow-sm">
                                    <div class="col-md-12 euz_header">
                                        <p class="text-white euz_b">Sensor Graph View</p>
                                    </div>
                                    <div class="col-md-12 euz_border">
                                        <div id="datalable1"></div>
                                    </div>
                                    <div class="col-md-12 euz_border">
                                        <div id="hourly1"></div>
                                    </div>
                                    <div class="col-md-12 euz_border">
                                        <div id="basicarea1"></div>
                                    </div>
                                    <div class="col-md-12 euz_border">
                                        <div id="negativevalues1"></div>
                                    </div>
                                    <div class="col-md-12 euz_border">
                                        <div id="invertedaxes1"></div>
                                    </div>
                                    <div class="col-md-12 euz_border">
                                        <div id="areaspline1"></div>
                                    </div>
                                    <div class="col-md-12 euz_border">
                                        <div id="arearangeline1"></div>
                                    </div>
                                    <div class="col-md-12 euz_border">
                                        <div id="basicbar1"></div>
                                    </div>
                                    <div class="col-md-12 euz_border">
                                        <div id="stackedbar1"></div>
                                    </div>
                                    <div class="col-md-12 euz_border">
                                        <div id="basiccolumn1"></div>
                                    </div>
                                </div>
                            </div>                 
                        </div>              
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger rounded-0" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
			</div>
		</div>
    </div> 
    <!--End editchart---->
@endsection
@section('scripts')
    <script>
        function profileopen(sensorid, hubid, agentid, groupid) 
        {


            //Edit sensor
            var url = "{{ url('/agent/editSensor') }}";
            var docurl = url + "/" + sensorid + "/" + hubid+ "/" + agentid+ "/" + groupid;
            $.ajax({
                url : docurl,
                method : "GET",
                success:function(response)
                {
                    $('#agentprofile').html(response);
                }
            });	
            document.getElementById("agentprofile").style.width = "80%";
        }	
        function profileclose() 
        {
            document.getElementById("agentprofile").style.width = "0";
        }
        $(document).on("click", ".graphpop", function () 
        {
            var passedID = $(this).data('id'); 
            var type = $(this).data('type'); 
            $("#grapheid").val(passedID);
            var url = "{{ url('/admin/addgraph') }}";
            var docurl = url + "/" + type;
            $.ajax(
            {
                url : docurl,
                method : "GET",
                dataType: 'json',
                success:function(data)
                {
                    $("#sname").val(data.sname);
                    $("#modal").val(data.modal);
                    $("#typename").val(data.name);
					$("#sensorbrand").val(data.brand);					
					$("#sensorunit").val(data.unit);
                    $("#maxadd").val(data.max);
                    $("#minadd").val(data.min);
                }
            });
        });
        /* sensor graph */
        $('#my_select').on('change', function () 
        {
            var selectData = $(this).val();
            if(selectData == 'line')
            {
                var typegraph = 'line';
            }
            if(selectData == 'area')
            {
                var typegraph = 'area';
            }
            if(selectData == 'column')
            {
                var typegraph = 'column';
            }
            if(selectData == 'bar')
            {
                var typegraph = 'bar';
            }
            if(selectData == 'pie') 
            {
                var typegraph = 'pie';
            }
            if(selectData == 'scatter') 
            {
                var typegraph = 'scatter';
            }
            if(selectData == 'spline') 
            {
                var typegraph = 'spline';
            }
            $("#txt_name").keyup(function()
            {
                var txt_name = $(this).val();
                $("#yaxis").keyup(function()
                {
                    var yaxisval = $(this).val();         
                    Highcharts.chart('sensorgraph', 
                    {
                        chart: 
                        {                 
                            type: typegraph,
                        },
                        title: 
                        {
                            text: txt_name
                        },
                        tooltip: 
                        {
                            pointFormat: '{series.name}: <b>{point.percentage:.1f}</b>'
                        },
                        xAxis: 
                        {
                            categories: ['1/4/2020', '2/4/2020', '3/4/2020', '4/4/2020', '5/4/2020', '6/4/2020', '7/4/2020', '8/4/2020', '9/4/2020'],
                        },
                        yAxis: 
                        {
                            title: 
                            {
                                text: yaxisval
                            },
                        },
                        plotOptions: 
                        {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: true,
                                    format: '<b>{point.name}</b>: {point.percentage:.1f} '
                                }
                            }
                        },
                        series: [
                        {
                            name: 'Date',
                            color: '#6abd3f',
                            data: [{
                                name: '1/4/2020',
                                y: 61.41,
                            }, {
                                name: '2/4/2020',
                                y: 11.84
                            }, {
                                name: '3/4/2020',
                                y: 10.85
                            }, {
                                name: '4/4/2020',
                                y: 4.67
                            }, {
                                name: '5/4/2020',
                                y: 4.18
                            }, {
                                name: '6/4/2020',
                                y: 1.64
                            }, {
                                name: '7/4/2020',
                                y: 1.6
                            }, {
                                name: '8/4/2020',
                                y: 1.2
                            }, {
                                name: '9/4/2020',
                                y: 2.61
                            }]
                        }]
                    });
                });
            });
        });
        $('#typegraph').on('change', function () 
        {
            var selectData = $(this).val();
            if(selectData == 'line')
            {
                var typegraph = 'line';
            }
            if(selectData == 'area')
            {
                var typegraph = 'area';
            }
            if(selectData == 'column')
            {
                var typegraph = 'column';
            }
            if(selectData == 'bar')
            {
                var typegraph = 'bar';
            }
            if(selectData == 'pie') 
            {
                var typegraph = 'pie';
            }
            if(selectData == 'scatter') 
            {
                var typegraph = 'scatter';
            }
            if(selectData == 'spline') 
            {
                var typegraph = 'spline';
            }
            var title = $('#title').val();
            var edityaxis = $('#edityaxis').val();
            Highcharts.chart('sensorgraphupdate', 
            {
                chart: 
                {                 
                    type: typegraph,
                },
                title: 
                {
                    text: title
                },
                tooltip: 
                {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}</b>'
                },
                xAxis: 
                {
                    categories: ['1/4/2020', '2/4/2020', '3/4/2020', '4/4/2020', '5/4/2020', '6/4/2020', '7/4/2020', '8/4/2020', '9/4/2020'],
                },
                yAxis: 
                {
                    title: 
                    {
                        text: edityaxis
                    },
                },
                plotOptions: 
                {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} '
                        }
                    }
                },
                series: [
                {
                    name: 'Date',
                    color: '#6abd3f',
                    data: [{
                        name: '1/4/2020',
                        y: 61.41,
                    }, {
                        name: '2/4/2020',
                        y: 11.84
                    }, {
                        name: '3/4/2020',
                        y: 10.85
                    }, {
                        name: '4/4/2020',
                        y: 4.67
                    }, {
                        name: '5/4/2020',
                        y: 4.18
                    }, {
                        name: '6/4/2020',
                        y: 1.64
                    }, {
                        name: '7/4/2020',
                        y: 1.6
                    }, {
                        name: '8/4/2020',
                        y: 1.2
                    }, {
                        name: '9/4/2020',
                        y: 2.61
                    }]
                }]
            });
        });
        /* sensor graph */
        $('#createsensorgraph').on('submit', function(event)
        {
            event.preventDefault();					
            $.ajax(
            {
                url:"{{  url('/admin/createsensorgraph') }}",
                method:"POST",
                data:new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                //dataType: 'json',
                success:function(data)
                {    
                    alert('Success'); 
                    location.reload();
                }
            });
        });
        $(".btnupdate").hide();	
        $(".btnenable").click(function() 
        {
            $(".disname").removeAttr("disabled");
            $(".btnupdate").show(); 
            $(".btnenable").hide();
            $("#sensorgraphupdate").show();
            $("#sensorgraphedit").hide();
        });
        $('#sensortype').on('change', function () 
        {
            var selectData = $(this).val();
           // alert(selectData);
            var url = "{{ url('/admin/sensortype') }}";
            var docurl = url + "/" + selectData;
            //alert(docurl);
            $.ajax(
            {
                url : docurl,
                method : "GET",
                dataType: 'json',
                success:function(data)
                {
                    $("#brandsensor").val(data.min);
                    $("#brandunit").val(data.max);
                    $("#remark").val(data.remark);
                }
            });
        });
        $('#sensortypeedit').on('change', function () 
        {


            //Fetching Sensor Type
            var selectData = $(this).val();
            var url = "{{ url('/admin/sensortype') }}";
            var docurl = url + "/" + selectData;
            $.ajax(
            {
                url : docurl,
                method : "GET",
                dataType: 'json',
                success:function(data)
                {
                    $("#brandsensoredit").val(data.min);
                    $("#brandunitedit").val(data.max);
                    $("#remarkedit").val(data.remark);
                }
            });
        });
        $(document).on("click", ".chartedit", function () 
        {
            var passedID = $(this).data('id'); 
            //alert(passedID);
            var url = "{{ url('/admin/editgraph') }}";
            var docurl = url + "/" + passedID;
            $.ajax({
                url : docurl,
                method : "GET",
                dataType: 'json',
                success:function(data)
                {
                    $("#editgrapheid").val(data.graphid);
                    $("#typegraph").val(data.type);
                    $("#title").val(data.title);
					$("#edityaxis").val(data.yaxis);					
					$("#min").val(data.mingraph);
                    $("#max").val(data.maxgraph);
                    $("#fake").val(data.fake);
                    $("#snameedit").val(data.sname);
                    $("#modaledit").val(data.modal);
                    $("#typenameedit").val(data.sensor_type);
					$("#sensorbrandedit").val(data.brand);					
					$("#sensorunitedit").val(data.sensorunit);
                    var chartname = data.name;
                    if(chartname == 'datalable')
                    {
                        Highcharts.chart('datalable1', 
                        {
                            chart: {
                                type: 'line',
                                scrollablePlotArea: {
                                    minWidth: 600
                                }
                            },
                            title: {
                                text: data.title
                            },
                            subtitle: {
                                text: ''
                            },
                            xAxis: {
                                categories: ['1','2','3','4','5','6','7','8','9']
                            },
                            yAxis: {
                                title: {
                                    text: data.yaxis
                                }
                            },
                            plotOptions: {
                                line: {
                                    dataLabels: {
                                        enabled: true
                                    },
                                    enableMouseTracking: false
                                }
                            },
                            series: [{
                                name: 'Sensor 1',
                                data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
                            }, {
                                name: 'Sensor 2',
                                data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
                            }]
                        });
                    }
                    if(chartname == 'hourly')
                    {
                        Highcharts.chart('hourly1', 
                        {
                            chart: {
                                zoomType: 'x'
                            },

                            title: {
                                text: data.title
                            },


                            tooltip: {
                                valueDecimals: 2
                            },

                            xAxis: {
                                type: ['1','2','3','4','5','6','7','8','9']
                            },

                            series: [{
                                data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6],
                                lineWidth: 0.5,
                                name: data.yaxis
                            }]
                        });
                    }
                    if(chartname == 'basicarea')
                    {
                        Highcharts.chart('basicarea1', 
                        {
                            chart: {
                                type: 'area'
                            },
                            title: {
                                text: data.title
                            },
                            xAxis: {
                                allowDecimals: false,
                                // labels: {
                                // 	formatter: function () {
                                // 		return this.value; // clean, unformatted number for year
                                // 	}
                                // },
                            },
                            yAxis: {
                                title: {
                                    text: data.yaxis
                                },
                                // labels: {
                                // 	formatter: function () {
                                // 		return this.value / 1000 + 'k';
                                // 	}
                                // }
                            },
                            tooltip: {
                                pointFormat: 'Value <b>{point.y:,.0f}</b>'
                            },
                            plotOptions: {
                                area: {
                                    pointStart: 1,
                                    marker: {
                                        enabled: false,
                                        symbol: 'circle',
                                        radius: 2,
                                        states: {
                                            hover: {
                                                enabled: true
                                            }
                                        }
                                    }
                                }
                            },
                            series: [{
                                name: 'sensor1',
                                data: [ 6, 11, 32, 110, 235, 369, 640, 1005, 1436]
                            }, {
                                name: 'sensor2',
                                data: [5, 25, 50, 120, 150, 200, 426, 660, 869, 1060]
                            }]
                        });
                    }
                    if(chartname == 'negativevalues')
                    {
                        Highcharts.chart('negativevalues1', 
                        {
                            chart: {
                                type: 'area'
                            },
                            title: {
                                text: data.title
                            },
                            xAxis: {
                                categories: ['1','2','3','4','5','6','7','8','9']
                            },
                            credits: {
                                enabled: false
                            },
                            series: [{
                                name: 'Sensor',
                                data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
                            }]
                        });
                    }
                    if(chartname == 'invertedaxes')
                    {
                        Highcharts.chart('invertedaxes1', 
                        {
                            chart: {
                                type: 'area',
                                inverted: true
                            },
                            title: {
                                text: data.title
                            },
                            legend: {
                                layout: 'vertical',
                                align: 'right',
                                verticalAlign: 'top',
                                x: -150,
                                y: 100,
                                floating: true,
                                borderWidth: 1,
                                backgroundColor:
                                    Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF'
                            },
                            xAxis: {
                                categories: ['1','2','3','4','5','6','7','8','9']
                            },
                            yAxis: {
                                title: {
                                    text: data.yaxis
                                },
                                allowDecimals: false,
                                min: -1000
                            },
                            plotOptions: {
                                area: {
                                    fillOpacity: 0.5
                                }
                            },
                            series: [{
                                name: 'Sensors',
                                data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
                            }]
                        });
                    }
                    if(chartname == 'areaspline')
                    {
                        Highcharts.chart('areaspline1', 
                        {
                            chart: {
                                type: 'areaspline'
                            },
                            title: {
                                text: data.title
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
                                categories: ['1','2','3','4','5','6','7','8','9'],
                            },
                            yAxis: {
                                title: {
                                    text: data.yaxis
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
                                    fillOpacity: 0.5
                                }
                            },
                            series: [{
                                name: 'Sensors',
                                data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
                            }]
                        });
                    }
                    if(chartname == 'arearangeline')
                    {
                        Highcharts.chart('arearangeline1', 
                        {
                            chart: {
                                scrollablePlotArea: {
                                    minWidth: 600
                                }
                            },
                            title: {
                                text: data.title
                            },

                            xAxis: {
                                type: ['1','2','3','4','5','6','7','8','9'],
                            },

                            yAxis: {
                                title: {
                                    text: data.yaxis
                                }
                            },

                            tooltip: {
                                crosshairs: true,
                                shared: true,
                                valueSuffix: 'Â°C'
                            },

                            series: [{
                                name: 'Sensors',
                                data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6],
                                zIndex: 1,
                                marker: {
                                    fillColor: 'white',
                                    lineWidth: 2,
                                    lineColor: Highcharts.getOptions().colors[0]
                                }
                            }]
                        });
                    }
                    if(chartname == 'basicbar')
                    {
                        Highcharts.chart('basicbar1', 
                        {
                            chart: {
                                type: 'bar'
                            },
                            title: {
                                text: data.title
                            },
                            xAxis: {
                                categories: ['1','2','3','4','5','6','7','8','9'],
                                title: {
                                    text: ''
                                }
                            },
                            yAxis: {
                                min: -1000,
                                title: {
                                    text: data.yaxis,
                                    align: 'high'
                                },
                                labels: {
                                    overflow: 'justify'
                                }
                            },
                            tooltip: {
                                valueSuffix: ''
                            },
                            plotOptions: {
                                bar: {
                                    dataLabels: {
                                        enabled: true
                                    }
                                }
                            },
                            legend: {
                                layout: 'vertical',
                                align: 'right',
                                verticalAlign: 'top',
                                x: -40,
                                y: 80,
                                floating: true,
                                borderWidth: 1,
                                backgroundColor:
                                    Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
                                shadow: true
                            },
                            credits: {
                                enabled: false
                            },
                            series: [{
                                name: 'Sensors',
                                data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
                            }]
                        });
                    }
                    if(chartname == 'stackedbar')
                    {
                        Highcharts.chart('stackedbar1', 
                        {
                            chart: {
                                type: 'bar'
                            },
                            title: {
                                text: data.title
                            },
                            xAxis: {
                                categories: ['1','2','3','4','5','6','7','8','9']
                            },
                            yAxis: {
                                min: -1000,
                                title: {
                                    text: data.yaxis
                                }
                            },
                            legend: {
                                reversed: true
                            },
                            plotOptions: {
                                series: {
                                    stacking: 'normal'
                                }
                            },
                            series: [{
                                name: 'Sensors',
                                data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
                            }]
                        });
                    }
                    if(chartname == 'basiccolumn')
                    {
                        Highcharts.chart('basiccolumn1', 
                        {
                            chart: {
                                type: 'column'
                            },
                            title: {
                                text: data.title
                            },
                            xAxis: {
                                categories: ['1','2','3','4','5','6','7','8','9'],
                                crosshair: true
                            },
                            yAxis: {
                                min: -1000,
                                title: {
                                    text: data.yaxis
                                }
                            },
                            tooltip: {
                                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                    '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                                footerFormat: '</table>',
                                shared: true,
                                useHTML: true
                            },
                            plotOptions: {
                                column: {
                                    pointPadding: 0.2,
                                    borderWidth: 0
                                }
                            },
                            series: [{
                                name: 'Sensors',
                                data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
                            }]
                        });
                    }
                }
            });
        });
    </script>
@parent
@endsection