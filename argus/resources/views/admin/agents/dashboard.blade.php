@extends('layouts.admin')
@section('content')
    <!---- euz_bar ----->
    <script type="text/javascript">
        $( document ).ready(function() {
    //console.log( "ready!" );
    var agentid=$("#agentid").val();
    //alert("hai"+agentid);
$.ajax(
        {
           //Admin-agent dashboard
           url:"{{url('admin/dashsensedetails')}}",
            method:"GET",
            data:{agentid:agentid},
            
            success:function(data)
            {    
                      //$("#name").val('');
                $(".sensdata").html(data);
                
            }
        });         




});


    </script>
    <div class="p-3">
        <input type="hidden" id="agentid" name="agentid" value="<?php echo $agentid;?>" />
        <div class="row">
            <label style="position: absolute;top: 50px;padding-right: 25px;right: 0;">
                <a class="btn btn-primary float-right euz_bt rounded-0 ml-2" href="<?php echo url('/admin/agents'); ?>" ><i class="far fa-arrow-alt-circle-left"></i> Back To Agent</a>
            </label>
            <div class="col-md-12 euz_bar">
                <i class="fas fa-user euz_text_blue"></i>  <small class="euz_b euz_text_blue"><?php echo $user[0]->fname.' '.$user[0]->lname; ?></small>
            </div>
            <div class="col-md-12 euz_border p-3">
                <div class="row">
                    <!----weather----->
				    <div class="col-md-12 mb-3"><?php if(!empty($list->template)) { echo $list->template; } ?></div>
                    <!----Count----->
                    <!----dashboard 1----->
                    <div class="col-md-3">
                        <div class="card euz_dashboard_blue text-white">
                            <div class="card-body">
                               <div id="MyClockDisplay" class="clock" onload="showTime()"></div>
                            </div>
                        </div>
                    </div>
                    <!----dashboard 2----->
                    <div class="col-md-3">
                        <div class="card euz_dashboard_red text-white">
                            <div class="card-body text-center">
                                <h1><?php echo $groups_count; ?></h1>
								<hr class="p-0" style="border-top:#fff solid 1px;">
                                <h4>Gateway Groups</h4>
                            </div>
                        </div>
                    </div>
                    <!----dashboard 3----->
                    <div class="col-md-3">
                        <div class="card euz_dashboard_green text-white">
                            <div class="card-body text-center">
                                <h1><?php echo $hubs_count; ?></h1>
								<hr class="p-0" style="border-top:#fff solid 1px;">
                                <h4>Sensor Hubs</h4>
                            </div>
                        </div>
                    </div>
                    <!----dashboard 4----->
                    <div class="col-md-3">
                        <div class="card euz_dashboard_yellow text-white">
                            <div class="card-body text-center">
                                <h1><?php echo $sensors_count; ?></h1>
								<hr class="p-0" style="border-top:#fff solid 1px;">
                                <h4>Sensors</h4>
                            </div>
                        </div>
                    </div>              
                    <!----Agent Log----->
                    <div class="col-md-5 mt-3">
                        <div class="shadow-sm">
                            <div class="col-md-12 euz_header">
                                <p class="text-white euz_b">Log History</p>
                            </div>
                            <div class="col-md-12 euz_border" style="max-height: 400px;background-color: #ebf2f9;overflow-y:scroll; ">
                                <div class="table-responsive-sm py-3">
                                    <table class="table table-bordered table-striped">
                                        <thead class="euz_agent_table">
                                            <tr>
                                                <!--<th class="euz_agent_222">Sl.No</th>-->
                                                <th class="euz_agent_222">Date</th>
                                                <th class="euz_agent_222">Login Time</th>
                                                <th class="euz_agent_222">Logout Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $i = 1;
                                                foreach($logs as $logdetail) { 
                                                date_default_timezone_set('Europe/Athens');
                                                $logintime = $logdetail->created_at;
                                                $logouttime = $logdetail->updated_at;
                                            ?>
                                            <tr>
                                                <!--<td><?php //echo $i; ?></td>-->
                                                <td><?php echo date('d-m-Y', $logintime); ?></td>
                                                <td><?php echo date('h:i a', $logintime); ?></td>
                                                <?php if($logdetail->logout_status == '0') { ?>
                                                <td><?php echo date('h:i a', $logouttime); ?></td>
                                                <?php } ?>
                                            </tr>
                                            <?php $i++; } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>             
                    <!----Sensor Report----->
					<div class="col-md-7 mt-3">
						<div class="shadow-sm">
							<div class="col-md-12 bg-white border" style="height: 35px;padding: 5px 10px;">
								<p class="text-dark ">Console: Latest Sensors Data</p>
							</div>
							<div class="sensdata col-md-12 euz_border text-white euz_db_style">
								<table style="width:100%;">
									<tr>
										<td>
											<span style="border-bottom: #fff dashed 1px;">UTC</span>
										</td>
										<td>
											<span style="border-bottom: #fff dashed 1px;">Hub</span>
										</td>
										<td >
											<span style="border-bottom: #fff dashed 1px;">Sensor Id</span>
										</td>
										<td>
											<span style="border-bottom: #fff dashed 1px;">Value</span>
                                        </td>
									</tr>
									<?php 
//DB::table('users')->orderBy('id')->chunk(100, function ($users) {
    //foreach ($users as $user) {
        //
    //}
                                    //$sensorlists = DB::table('dbo_payloader')->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')->take(100)->where('sensor_hubs.agent',$agentid)->orderby('dbo_payloader.id', 'desc')->select('time','dbo_payloader.hub','sensor_id','value')->get();


                                    foreach($sensorlists as $sensorlist) { ?>
                                    <tr>
                                        <td><?php echo $sensorlist->time; ?></td>
                                        <td><?php echo $sensorlist->hub; ?></td>
                                        <td><?php echo $sensorlist->sensor_id; ?></td>
                                        <td><?php echo $sensorlist->value; ?></td>
                                    </tr>
                                    <?php } 

//});
                                    ?>
								</table>    
							</div>
						</div>
					</div>
                    <!--<div class="col-md-7 mt-3">
                        <div class="shadow-sm">
                            <div class="col-md-12 euz_header">
                                <p class="text-white euz_b">Last Week Sensor Report</p>
                            </div>
                            <div class="col-md-12 euz_border">
                                <form method="post" name="frmlog" id="frmlog">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="agent" value="<?php echo request()->id; ?>" />
                                    <div class="row bg-light">
                                        <div class="form-group col-md-4 py-2 mb-0">
                                            <label for="" class="euz_b">Gateway Group</label>
                                            <select class="form-control group" name="group">
                                                <option value="">Select Group</option>
                                                <?php foreach($groups as $group) { ?>
                                                <option value="<?php echo $group->groupid; ?>"><?php echo $group->name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4 py-2 mb-0">
                                            <label for="" class="euz_b">Sensor Hub</label>
                                            <select class="form-control hub" name="hub"></select>
                                        </div>
                                        <div class="form-group col-md-4 py-2 mb-0">
                                            <label for="" class="euz_b">Sensors</label>
                                            <select class="form-control sensor" name="sensor" id="sensor10" onchange="getchart();"></select>
                                        </div>
                                    </div>	
                                </form>									
                                
                                <div id="container2" style="min-width: 100%; height: 400px; margin: 0 auto"></div>
                            </div>
                        </div>
                    </div>--->
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')  
    <script>
        var data=[0,0,0,0,0,0,0];
        var options = 
        {
            chart: 
            {
                renderTo: 'container2',
                defaultSeriesType: 'areaspline'
            },
            title: 
            {
                text: 'Sensor Results'
            },
            xAxis: 
            {
                categories: ['Sunday','Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']
            },
            yAxis: 
            {
                title: 
                {
                    text: ''
                }
            },
            tooltip: 
            {
                shared: true,
                valueSuffix: ' units'
            },
            credits: 
            {
                enabled: false
            },
            plotOptions: 
            {
                areaspline: 
                {
                    fillOpacity: '',
                    color: '#bbbbbb',
                    lineColor:'#41008a',
                }
            },    
            series: [{}]
        };
        function showTime()
        {
            var date = new Date();
            var h = date.getHours(); 
            var m = date.getMinutes(); 
            var s = date.getSeconds(); 
            var session = "AM";       
            if(h == 0)
            {
                h = 12;
            }     
            if(h > 12)
            {
                h = h - 12;
                session = "PM";
            }
            h = (h < 10) ? "0" + h : h;
            m = (m < 10) ? "0" + m : m;
            s = (s < 10) ? "0" + s : s;
            var time = h + ":" + m + ":" + s + " " + session;
            document.getElementById("MyClockDisplay").innerText = time;
            document.getElementById("MyClockDisplay").textContent = time;      
            setTimeout(showTime, 1000);          
        }
        showTime();
        $(".group").change(function()
        {
            $.ajax(
            {
                url: "{{ url('/admin/gethublist') }}",
                type: "post",
                data: $('#frmlog').serialize(),
                success: function(data)
                {                  
                    $(".hub").html(data);
                }
            });
        });
        $(".hub").change(function()
        {
            $.ajax(
            {
                url: "{{ url('/admin/getsensorlist') }}",
                type: "post",
                data: $('#frmlog').serialize(),
                success: function(data)
                {
                   // alert(data);
                    $(".sensor").html(data);
                }
            });
        });
        function getchart()
        {
            $.ajax(
            {
                url: "{{ url('/admin/getchartlist') }}",
                type: "post",
                data: $('#frmlog').serialize(),
                success: function(data)
                {
                    options.series[0].data = JSON.parse(data);
                    var chart = new Highcharts.Chart(options);
                }
            });
        }
    </script>
@parent
@endsection