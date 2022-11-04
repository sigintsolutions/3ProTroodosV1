@extends('layouts.admin')
@section('content')
<!--Admin Home page--->


<div class="p-3">
	<div class="row">
		<div class="col-md-12 euz_bar">
			<i class="fas fa-tachometer-alt euz_text_blue"></i> <small class="euz_b euz_text_blue">Dashboard</small>
		</div>
		<div class="col-md-12 euz_border p-3">
			<div class="row">
				<!----weather----->
				<!-- <div class="col-md-12 mb-3">
					<a class="weatherwidget-io" href="https://forecast7.com/en/35d1933d38/nicosia/" data-label_1="NICOSIA" data-label_2="WEATHER" data-theme="mountains" >NICOSIA WEATHER</a>
					<script>
						!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js');
					</script>
				</div> -->
				<div class="col-md-12 mb-3"><?php if(!empty($list->template)) { echo $list->template; } ?></div>
				<!----Count----->
				<div class="col-md-1 "><div class="euz_header euz_ver">
					<p class="text-white euz_b">Total</p>
				</div></div>
						
				<div class="col-md-11">
					<div class="row">
						<!----dashboard 1----->
						<div class="col-md-3">
							<div class="card euz_dashboard_blue text-white">
								<div class="card-body text-center">
									<h1>{{ $agents_count }}</h1>
									<hr class="p-0" style="border-top:#fff solid 1px;">
									<h4>Agents</h4>
								</div>
							</div>
						</div>
						<!----dashboard 2----->
						<div class="col-md-3">
							<div class="card euz_dashboard_red text-white">
								<div class="card-body text-center">
									<h1>{{ $groups_count }}</h1>
									<hr class="p-0" style="border-top:#fff solid 1px;">
									<h4>Gateway Groups</h4>
								</div>
							</div>
						</div>
						<!----dashboard 3----->
						<div class="col-md-3">
							<div class="card euz_dashboard_green text-white">
								<div class="card-body text-center">
									<h1>{{ $hubs_count }}</h1>
									<hr class="p-0" style="border-top:#fff solid 1px;">
									<h4>Hubs</h4>
								</div>
							</div>
						</div>
						<!----dashboard 4----->
						<div class="col-md-3">
							<div class="card euz_dashboard_yellow text-white">
								<div class="card-body text-center">
									<h1>{{ $sensors_count }}</h1>
									<hr class="p-0" style="border-top:#fff solid 1px;">
									<h4>Sensors</h4>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!----Agent Log----->
				<div class="col-md-5 mt-3">
					<div class="shadow-sm">
						<div class="col-md-12 euz_header">
							<p class="text-white euz_b">Agent Log</p>
						</div>
						<?php /*<div class="col-md-12 euz_border">
							<!--<div id="euz_activelog"></div>-->
							<div id="agentlog"></div>
						</div>*/ ?>
						<div class="col-md-12 euz_border" style="min-height: 400px;background-color: #ebf2f9; ">
							<form method="post" action="{{ url('/admin/searchlog') }}" class="row">
								{{ csrf_field() }}
								<div class="col-md-6 mt-3">
									<input class="form-control" type="text" name="name" id="agent_name" required autocomplete="off" />
									<div id="agentList"></div>
								</div>
								<div class="col-md-3 mt-3"><input type="submit" name="submit" name="submit" class="btn euz_btn_add euz_pointer" value="Search" /></div>
							</form>
							<div class="table-responsive-sm py-3">
								<table class="table table-bordered table-striped">
									<thead class="euz_agent_table">
										<tr>
											<th class="euz_agent_222">Agent</th>
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
											<td><?php echo $logdetail->fname.' '.$logdetail->lname; ?></td>
											<td><?php echo date('d-m-Y', $logintime); ?></td>
											<td><?php echo date('h:i a', $logintime); ?></td>
											<?php if($logdetail->logout_status == '0') { ?>
											<td><?php echo date('h:i a', $logouttime); ?></td>
											<?php } //else { ?>
											<!--<td><?php //echo '11:00 pm'; ?></td>-->
											<?php //} ?>
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
						<div class="col-md-12 euz_border text-white euz_db_style sensdata" >
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
									<!-- <td>
										<span style="border-bottom: #fff dashed 1px;">Unit</span>
									</td> -->
								</tr>
								<?php 

//print_r($sensors);
								foreach($sensors as $sensor) { ?>
								<tr>
									<td><?php echo $sensor->utc; ?></td>
									<td><?php echo $sensor->hub; ?></td>
									<td><?php echo $sensor->sensor_id; ?></td>
									<td><?php echo $sensor->value; ?></td>
									<!-- <td><?php //echo $sensor->unit; ?></td> -->
								</tr>
								<?php } ?>
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
							<div class="row bg-light">
								<div class="form-group col-md-4 py-2 mb-0">
									<label for="" class="euz_b">Agent</label>
									<select class="form-control agent" name="agent" required id="agent">
												<option value="">-Select-</option>
												@foreach($agents as $item)
												<option value="{{ $item->id }}">{{ $item->fname }}</option>
												@endforeach
									</select>
								</div>
								<div class="form-group col-md-4 py-2 mb-0">
									<label for="" class="euz_b">Group</label>
									<select class="form-control group" name="group" onchange="gethub(this.value,$(this).closest('.items').attr('id'))">
															<option value="">-Select-</option>
														</select>
								</div>
								<div class="form-group col-md-4 py-2 mb-0">
									<label for="" class="euz_b">Hub</label>
									<select class="form-control hub" name="hub" onchange="getsensor(this.value,$(this).closest('.items').attr('id'))">
														<option value="">-Select-</option>
														</select>
								</div>
								<div class="form-group col-md-4 py-2 mb-0">
									<label for="" class="euz_b">Sensors</label>
									<select class="form-control sensor" name="sensor" id="sensor10" onchange="getchart();">
														<option value="">-Select-</option>
														</select>
								</div>
							</div>	
							</form>								
							<div id="container2" style="min-width: 100%; height: 400px; margin: 0 auto"></div>
						</div>
					</div>
				</div>-->
				
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
                    fillOpacity: 1,
                    color: '#bbbbbb',
            		lineColor:'#41008a',
                }
            },    
        	series: [{}]
        };
		function getchart()
		{
			$.ajax({
				url: "{{ url('/admin/getchart') }}",
				type: "post",
				data: $('#frmlog').serialize(),
				success: function(data){
				//alert(JSON.parse(data));
				options.series[0].data = JSON.parse(data);
				var chart = new Highcharts.Chart(options);
				}
			});
		}
		$(".agent").change(function(){
			$.ajax({
				url: "{{ url('/admin/getgroup') }}",
				type: "post",
				data: $('#frmlog').serialize(),
				success: function(data){
					$(".group").html(data);
				}
			});
		});
		$(".group").change(function(){
		
			$.ajax({
				url: "{{ url('/admin/gethub') }}",
				type: "post",
				data: $('#frmlog').serialize(),
				//data: { agent : $('.agent').val(),group : id,_token : $( "input[name='_token']" ).val() },
				success: function(data){
					$(".hub").html(data);
					//$("#"+vid+" .hub").html(data);
				}
			});
		
		});
		$(".hub").change(function(){
			$.ajax({
				url: "{{ url('/admin/getsensor') }}",
				type: "post",
				data: $('#frmlog').serialize(),
				//data: { hub : id,_token : $( "input[name='_token']" ).val() },
				success: function(data){
					$(".sensor").html(data);
					//$("#"+vid+" .sensor").html(data);
				}
			});
		
		});
		$('#agent_name').keyup(function()
		{ 
			var query = $(this).val();
			if(query != '')
			{
				var _token = "{{ csrf_token() }}";
				//alert(_token);
				$.ajax(
				{
					url:"{{ url('/admin/autocomplete/fetchagent') }}",
					method:"POST",
					data:{query:query, _token:_token},
					success:function(data)
					{
						$('#agentList').fadeIn();  
						$('#agentList').html(data);
					}
				});
			}
			else
			{
				$('#agentList').fadeOut();  
			}
		});
		$(document).on('click', 'li', function()
        {  
            $('#agent_name').val($(this).text());  
            $('#agentList').fadeOut();  
        });
	</script>
	<script src="{{ url('/chart/agentlognew.js') }}"></script>
@parent
@endsection