@extends('layouts.admin')
@section('content')
<?php @$segment_posts = request()->segment(3); ?>
<div class="p-3 add_Algorithm_table">
	<div class="row">
		<div class="col-md-12 euz_bar">
			<i class="fas fa-file-alt euz_text_blue"></i> <small class="euz_b euz_text_blue">Report</small>
		</div>
		<div class="col-md-12 euz_border p-3 bg-white">
			<div class="row">
				<div class="col-md-12 mt-2">
					<ul class="nav nav-tabs euz_tab" role="tablist">
						<li class="nav-item">
							<a class="nav-link euz_tabtex <?php if($segment_posts=="") { ?>active<?php } ?>" data-toggle="tab" href="#senrepor"><i class="fas fa-file-alt"></i> Sensor Time Report</a>
						</li>
						<li class="nav-item">
							<a class="nav-link euz_tabtex" data-toggle="tab" href="#hubreportss"><i class="fas fa-broadcast-tower"></i> Hub Sensor Report</a>
						</li>
						<li class="nav-item">
							<a class="nav-link euz_tabtex <?php if($segment_posts==1) { ?>active<?php } ?>" data-toggle="tab" href="#PushNotification"><i class="fas fa-user-clock"></i> Push Notification</a>
						</li>
					</ul>
					<div class="tab-content px-3">
						<div id="senrepor" class="tab-pane <?php if($segment_posts=="") { ?>active<?php } ?>"><br>
							<form method="post" action="{{ url('/agent/export') }}" name="tmefrm" id="tmefrm">
								{{ csrf_field() }}
								<div class="row">
									<div class="col-md-12 mt-2 mb-3">
										<div class="shadow-sm">
											<div class="col-md-12 euz_box_head">
												<p class="text-white euz_b mb-0">Sensor Time Report</p>
											</div>												
											<div class="col-md-12 euz_border">
												<div class="row">
													<div class="form-group col-md-4 py-2 mb-0">
														<label for="" class="euz_b">Group</label>
														<select class="form-control group" name="group[]" id="group" multiple="multiple">
														<option value="">-Select-</option>
														@foreach($groups as $item)
														<option value="{{ @$item->id }}">{{ @$item->name }}</option>
														@endforeach
													</select>	
													</div>
													<div class="form-group col-md-5 py-2 mb-0">
														<label for="" class="euz_b">Sensor Hub</label>
														<div class="hub">
															<select class="form-control " id="hub" name="hub[]" multiple="multiple" ></select>	
														</div>
													</div>
													<div class="form-group col-md-3 py-2 mb-0">
														<label for="" class="euz_b">Unit</label>
														<select class="form-control unit" id="unit" name="unit"></select>	
													</div>
													<div class="form-group col-md-6 py-2 mb-0">
														<label for="" class="euz_b">Sensor</label>
														<div class="sensor2">
															<select class="form-control " id="sensor2" name="sensor[]"  multiple="multiple"></select>	
														</div>
													</div>		
													<div class="form-group col-md-3 py-2 mb-0">
														<label for="" class="euz_b">Sensor Chart</label>
														<div class="input-group mb-3">
															<select class="form-control" name="chartnam" required>
																<option>Select</option>
																<option value="datalable">DataTable</option>
																<option value="hourly">Hourly</option>
																<option value="basicarea">Basic Area</option>
																<option value="negativevalues">Negative Values</option>
																<option value="invertedaxes">Invertedaxes</option>
																<option value="areaspline">Areaspline</option>
																<option value="arearangeline">Area Range Line</option>
																<option value="basicbar">Basic Bar</option>
																<option value="stackedbar">Stacked Bar</option>
																<option value="basiccolumn">Basic Column</option>
															<select>
														</div>
													</div>
													<div class="form-group col-md-3 py-2 mb-0">
														<label for="" class="euz_b">Time Stamp</label>
														<select class="form-control" id="tme" name="tme">
															<?php /*?><option>--select--</option><?php */?>
															<option value="week">Last Week</option>
															<option value="day">Today</option>
															<option value="month">Last Month</option>
															<option value="one">Custom</option>
														</select>	
													</div>
													<div class="form-group col-md-4 py-2 mb-0 one box">
														<label for="" class="euz_b">From - To Date</label>
														<div class="input-group date" data-date-format="dd MM yyyy">
															<input type="text" class="form-control" placeholder="dd MM yyyy" id="txt_date2" name="from">
															<div class="input-group-addon" style="display:none;">
																<i class="fa fa-calendar"></i>
															</div>
															<input type="text" class="form-control" placeholder="dd MM yyyy" id="txt_date3" name="to">
															<div class="input-group-addon" style="display:none;">
																<i class="fa fa-calendar"></i>
															</div>
														</div>	
													</div>
												</div>	
												<div class="row bg-light">
													<div class="col-md-12 p-2">
														<button type="button" class="euz_inblue" id="butSen" name="butSen"><i class="fas fa-filter"></i> Search</button>
														&nbsp;&nbsp;
														<button type='reset' class="euz_inred"><i class="fas fa-redo-alt"></i> Reset</button>
													</div>
												</div>
											</div>
											
										</div>
									</div>
									
									<div class="col-md-12 mt-3">
										<div class="row">										
											<div class="col-md-12">
												<!-- Tab panes -->
												<div class="tab-content euz_border p-3 bg-white">													
													<div class="row">
														<div class="col-md-6">
															<button class="euz_btn_add euz_pointer" type="submit" id="exportsensor" target="_blank">EXPORT</button>
														</div>														
														<div class="col-md-6">
															<ul class="nav nav-pills float-right mx-3">
																<li class="nav-item">
																	<a class="nav-link active" data-toggle="pill" href="#cart"><i class="fas fa-chart-line"></i></a>
																</li>
																<li class="nav-item">
																	<a class="nav-link" data-toggle="pill" href="#sensorlist"><i class="fas fa-table"></i></a>
																</li>
															</ul>
														</div>													
													</div>												
													<div class="tab-pane active" id="cart">
														<div class="row mt-5">
															<div class="col-md-12 mt-3">
																<div class="shadow-sm">
																	<div class="col-md-12 euz_border chart1">
																		<div id="datalable"></div>
																	</div>
																	<div class="col-md-12 euz_border2 chart2">
																		<div id="hourly"></div>
																	</div>
																	<div class="col-md-12 euz_border chart3">
																		<div id="basicarea"></div>
																	</div>
																	<div class="col-md-12 euz_border chart4">
																		<div id="negativevalues"></div>
																	</div>
																	<div class="col-md-12 euz_border chart5">
																		<div id="invertedaxes"></div>
																	</div>
																	<div class="col-md-12 euz_border chart6">
																		<div id="areaspline"></div>
																	</div>
																	<div class="col-md-12 euz_border chart7">
																		<div id="arearangeline"></div>
																	</div>
																	<div class="col-md-12 euz_border chart8">
																		<div id="basicbar"></div>
																	</div>
																	<div class="col-md-12 euz_border chart9">
																		<div id="stackedbar"></div>
																	</div>
																	<div class="col-md-12 euz_border chart10">
																		<div id="basiccolumn"></div>
																	</div>																	
																</div>
															</div>
														</div>
													</div>
													<div class="tab-pane mt-5" id="sensorlist">
														<div id="table_data2">
															@include('admin/report/pagination_data2')
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>										
								</div>
							</form>
						</div>							
						<div id="hubreportss" class="tab-pane fade"><br>
							<div class="row">
								<div class="col-md-12 mt-2 mb-3">
									<div class="shadow-sm">
										<div class="col-md-12 euz_box_head">
											<p class="text-white euz_b mb-0">Hub Sensor Report</p>
										</div>
										<form method="post" action="/admin/export" name="tmefrm2" id="tmefrm2">
										{{ csrf_field() }}
										<div class="col-md-12 euz_border">
											<div class="row">
												<div class="form-group col-md-4 py-2 mb-0">
													<label for="" class="euz_b">Agent</label>
													<select class="form-control agent2" id="agent2" name="agent" disabled>
														<option value="">--select--</option>
														@foreach($agents as $item)
														<option value="{{ @$item->id }}" <?php if(session()->get('userid')==@$item->id) { ?> selected="selected"<?php } ?>>{{ @$item->fname }}</option>
														@endforeach
													</select>	
												</div>
												<div class="form-group col-md-4 py-2 mb-0">
													<label for="" class="euz_b">Gateway Group</label>
													<select class="form-control group2" name="group[]" multiple="multiple" id="group2">
														<option value="">-Select-</option>
														@foreach($groups as $item)
														<option value="{{ @$item->id }}">{{ @$item->name }}</option>
														@endforeach
													</select>	
												</div>
												<div class="form-group col-md-4 py-2 mb-0">
													<label for="" class="euz_b">Sensor Hub</label>
													<div class="hub2">
														<select class="form-control " id="hub2" name="hub[]" multiple="multiple" ></select>	
													</div>
												</div>
												<!-- <div class="form-group col-md-3 py-2 mb-0">
													<label for="" class="euz_b">Unit</label>
													<select class="form-control unit3" id="unit3" name="unit"></select>	
												</div> -->
												<div class="form-group col-md-3 py-2 mb-0">
													<label for="" class="euz_b">Time Stamp</label>
													<select class="form-control" id="tme3" name="tme">
														<?php /*?><option>--select--</option><?php */?>
														<option value="week">Last Week</option>
														<option value="day">Today</option>
														<option value="month">Last Month</option>
														<option value="one">Custom</option>
													</select>	
												</div>
												<div class="form-group col-md-4 py-2 mb-0 one box3">
													<label for="" class="euz_b">From - To Date</label>
													<div class="input-group date" data-date-format="dd MM yyyy">
														<input type="text" class="form-control" placeholder="dd MM yyyy" id="txt_date2" name="from">
														<div class="input-group-addon" style="display:none;">
															<i class="fa fa-calendar"></i>
														</div>
														<input type="text" class="form-control" placeholder="dd MM yyyy" id="txt_date3" name="to">
														<div class="input-group-addon" style="display:none;">
															<i class="fa fa-calendar"></i>
														</div>
													</div>	
												</div>
											</div>	
											<div class="row bg-light">
												<div class="col-md-12 p-2">
													<button type="button" name="butSen2" id="butSen2" class="euz_inblue"><i class="fas fa-filter"></i> Search</button>
													&nbsp;&nbsp;
													<button type="reset" class="euz_inred"><i class="fas fa-redo-alt"></i> Reset</abutton>
												</div>
											</div>
										</div>
										</form>
									</div>
								</div>
								
								<!-- <div class="col-md-12 mt-3" id="sensordata">
									
								</div> -->
								<div class="col-md-12 mt-3">
									<div class="row">
										<div class="col-md-12 mt-3">
											<!-- <div class="shadow-sm p-2 euz_border">
												<div class="col-md-12 euz_border">
													<div class="col-md-12 euz_border chart21">
														<div id="datalable2"></div>
													</div>
													<div class="col-md-12 euz_border chart22">
														<div id="hourly2"></div>
													</div>
													<div class="col-md-12 euz_border chart23">
														<div id="basicarea2"></div>
													</div>
													<div class="col-md-12 euz_border chart24">
														<div id="negativevalues2"></div>
													</div>
													<div class="col-md-12 euz_border chart25">
														<div id="invertedaxes2"></div>
													</div>
													<div class="col-md-12 euz_border chart26">
														<div id="areaspline2"></div>
													</div>
													<div class="col-md-12 euz_border chart27">
														<div id="arearangeline2"></div>
													</div>
													<div class="col-md-12 euz_border chart28">
														<div id="basicbar2"></div>
													</div>
													<div class="col-md-12 euz_border chart29">
														<div id="stackedbar2"></div>
													</div>
													<div class="col-md-12 euz_border chart30">
														<div id="basiccolumn2"></div>
													</div>
												</div>
											</div> -->
											<div class="tab-pane active mt-5 col-md-12" id="sensordata">
												<div id="table_data3">													
												<div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>							
						<div id="PushNotification" class="tab-pane fade">
							<form method="post" name="frmPush" id="frmPush">
								{{ csrf_field() }}
								<div class="row">
									<div class="form-group col-lg-3 col-md-5 py-2 mt-2 mb-3">
										<label for="" class="euz_b">From Date &amp; To Date</label>
										<div class="input-group date" data-date-format="dd MM yyyy">
											<input type="text" class="form-control" placeholder="dd MM yyyy" id="txt_date2" name="from">
											<div class="input-group-addon" style="display:none;">
												<i class="fa fa-calendar"></i>
											</div>
											<input type="text" class="form-control" placeholder="dd MM yyyy" id="txt_date3" name="to">
											<div class="input-group-addon" style="display:none;">
												<i class="fa fa-calendar"></i>
											</div>
										</div>
									</div>
									<div class="row bg-light">
										<div class="col-md-12 p-2">
											<button type="button" class="euz_inblue mt-5" name="butpush" id="butpush"><i class="fas fa-filter"></i> Search</button>
											&nbsp;&nbsp;
											<button type="reset" onclick="this.form.reset();" class="euz_inred mt-5"><i class="fas fa-redo-alt"></i> Reset</button>
										</div>
									</div>
								</div> 
								<div id="msglists">
									<?php /* @include('agent/report/pushmsg') */ ?>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>		
	</div>
</div>
@endsection
@section('scripts')
<script>
    
	$(function () {
        $(".euz_a").css({ "color": "#16313c" });
        $("#sensor").css({ "color": "#3990b3"});
    });
	
</script>
<script>

var perlogin={{ $perlogin }};
var perlogout={{ $perlogout }};

var perlogin2={{ $perlogin2 }};
var perlogout2={{ $perlogout2 }};
$('.box').hide();
$('.box3').hide();
$(document).ready(function(){
    $("#tme").change(function()
	{	
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");
			//alert(optionValue);
            if(optionValue == 'one')
			{
               // $(".box").not("." + optionValue).hide();
                //$("." + optionValue).show();
				$(".box").show();
            } 
			else
			{
                $(".box").hide();
            }
        });
    }).change();
});
$(document).ready(function(){
	$("#tme3").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");
            if(optionValue == 'one')
			{
        		$(".box3").show();
            } 
			else
			{
                $(".box3").hide();
            }
        });
    }).change();
});
</script>
<script type="text/javascript">

$('#antlevel, #Grouplevel123').selectpicker();
$('#agrouplevel').selectpicker();
$('#senlevel').selectpicker();
$('#group').selectpicker();
$('#group2').selectpicker();
</script>
<script>
    $('#txt_date').datepicker({ format: "dd MM yyyy" });
	$('#txt_date1, #txt_date2, #txt_date3').datepicker({ format: "dd MM yyyy" });
</script>

<script src="{{ url('js/kelly.js') }} "></script>
<script src="{{ url('chart/meter.js') }}"></script>
<script src="{{ url('chart/meter1.js') }}"></script>
<script src="{{ url('chart/meter2.js') }}"></script>
<script src="{{ url('chart/meter3.js') }}"></script>

<?php /*?><script src="{{ url('chart/week1.js') }}"></script><?php */?>

<script src="{{ url('chart/agenthistory.js') }}"></script>
<script src="{{ url('chart/agenthistory1.js') }}"></script>
<script src="{{ url('chart/agentleveschart.js') }}"></script>
<script src="{{ url('chart/sensors.js') }}"></script>

<script>
//$(document).ready(function(){
$("#log").change(function(){
    $.ajax({
        url: "{{ url('/admin/getlog') }}",
        type: "post",
        data: $('#frmlog').serialize(),
        success: function(data){
            $("#table_data").html(data);
        }
    });
});
	$("#butSen").click(function()
	{
		//getchart();
		$.ajax({
			url: "{{ url('/agent/getsensortime') }}",
			type: "post",
			data: $('#tmefrm').serialize(),
			success: function(data)
			{
				//alert(data);
				$("#table_data2").html(data);
			}
		});
	});
	$("#butSen2").click(function()
	{
		$.ajax({
			url: "{{ url('/agent/getsensordata') }}",
			type: "post",
			data: $('#tmefrm2').serialize(),
			success: function(data)
			{
				//alert(data);
				$("#sensordata").html(data);
			}
		});
		//getchart2();
	});
	$("#butSen3").click(function()
	{
		getchart3();
	});
	$("#butpush").click(function()
	{
		//alert();
		$.ajax({
			url: "{{ url('/agent/pushmsg') }}",
			type: "post",
			data: $('#frmPush').serialize(),
			success: function(data)
			{
				$("#msglists").html(data);
			}
		});
	});
</script>

<script>
 $('#table_data').on('click', '.pagination a', function(event){
  event.preventDefault(); 
  var page = $(this).attr('href').split('page=')[1];
  fetch_data(page);
 });

 function fetch_data(page)
 {
  $.ajax({
   url:"/admin/fetch_data?page="+page+"&log="+$('#log').val(),
   success:function(data)
   {
    $('#table_data').html(data);
   }
  });
 }
 
//});
</script>

<script>
//$(document).ready(function(){
 $('#table_data2').on('click', '.pagination a', function(event){
 
  event.preventDefault(); 
  var page = $(this).attr('href').split('page=')[1];
  fetch_data2(page);
 });

 function fetch_data2(page)
 {
 //	alert(123);
  $.ajax({
	url:"/argus/agent/fetch_data2?page="+page+"&agent="+$('#agent1').val()+"&group="+$('#group').val()+"&hub="+$('#hub').val()+"&sensor="+$('#sensor2').val()+"&unit="+$('#unit').val()+"&tme="+$('#tme').val(),
   success:function(data)
   {
    $('#table_data2').html(data);
   }
  });
 }
 
//});
</script>

<script>
	$(".group").change(function()
	{
		$.ajax({
			url: "{{ url('/agent/gethub') }}",
			type: "post",
			data: $('#tmefrm').serialize(),
			success: function(data)
			{
				$(".hub").html(data);
				$('#hub').selectpicker();
			}
		});
	});
	$(".hub").change(function()
	{
		$.ajax({
			url: "{{ url('/admin/getunit') }}",
			type: "post",
			data: $('#tmefrm').serialize(),
			success: function(data)
			{
				//alert(data);
				$(".unit").html(data);
			}
		});
	});
	$(".unit").change(function()
	{
		$.ajax(
		{
			url: "{{ url('/admin/getsensorreport') }}",
			type: "post",
			data: $('#tmefrm').serialize(),
			success: function(data)
			{
				$(".sensor2").html(data);
				$('#sensor2').selectpicker();
			}
		});
	});
</script>

<script>
getgrp();
//getgrp2();
// function getgrp2()
// {
//     $.ajax({
//         url: "agent/getgroup",
//         type: "post",
//         data: $('#tmefrm2').serialize(),
//         success: function(data){
//             $(".group2").html(data);
//         }
//     });
// }
//});
	$(".group2").change(function()
	{
		$.ajax({
			url: "{{ url('/agent/gethub2') }}",
			type: "post",
			data: $('#tmefrm2').serialize(),
			success: function(data)
			{
				//alert(data);
				$(".hub2").html(data);
				$('#hub2').selectpicker();
			}
		});

	});
	$(".hub2").change(function()
	{
		$.ajax({
			url: "{{ url('/admin/getunit3') }}",
			type: "post",
			data: $('#tmefrm2').serialize(),
			success: function(data)
			{
				//alert(data);
				$(".unit3").html(data);
			}
		});
	});

//$(".agent3").load(function(){
function getgrp()
{
//alert(1);
    $.ajax({
        url: "{{ url('/agent/getgroup') }}",
        type: "post",
        data: $('#tmefrm3').serialize(),
        success: function(data){
            //$(".group3").html('<select class="form-control " name="group[]" multiple="multiple" id="Grouplevel123">'+data+'</select>');
			$(".group3").html(data);
			$('#group3').selectpicker();
			$('#agrouplevel').selectpicker();
        }
    });
	}
//});
	$(".group3").change(function(){

		$.ajax({
			url: "{{ url('/agent/gethub3') }}",
			type: "post",
			data: $('#tmefrm3').serialize(),
			//data: { agent : $('.agent').val(),group : id,_token : $( "input[name='_token']" ).val() },
			success: function(data){
				$(".hub3").html(data);
				$('#hub3').selectpicker();
				$('#agrouplevel').multiselect('rebuild');
			}
		});

	});
	$(".hub3").change(function()
	{
		$.ajax(
		{
			url: "{{ url('/admin/getunit2') }}",
			type: "post",
			data: $('#tmefrm3').serialize(),
			success: function(data)
			{
				$(".unit2").html(data);
			}
		});
	});
	$(".unit2").change(function()
	{
		$.ajax(
		{
			url: "{{ url('/admin/getsensorreport3') }}",
			type: "post",
			data: $('#tmefrm3').serialize(),
			success: function(data)
			{
				$(".sensor3").html(data);
				$('#sensor3').selectpicker();
			}
		});
	});
	function getchart()
	{
		$.ajax(
		{
			url: "{{ url('/agent/getchart2') }}",
			type: "post",
			data: $('#tmefrm').serialize(),
			success: function(response)
			{
				data=JSON.parse(response);
				if(data!="")
				{	
					if(data['chart'] == 'datalable')
					{
						$('.chart1').show();
						$('.chart2').hide();	
						$('.chart3').hide();	
						$('.chart4').hide();	
						$('.chart5').hide();	
						$('.chart6').hide();	
						$('.chart7').hide();	
						$('.chart8').hide();	
						$('.chart9').hide();	
						$('.chart10').hide();
						Highcharts.chart('datalable', 
						{
							chart: {
								type: 'line',
								zoomType: 'xy',
								scrollablePlotArea: {
									minWidth: 600
								}
							},
							title: {
								text: 'Sensor Graph'
							},
							subtitle: {
								text: ''
							},
							xAxis: {
								categories: data['hour']
							},
							yAxis: {
								title: {
									text: 'Days'
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
							series: [
							{
								data: data['value']
							}]
						});
					}
					if(data['chart'] == 'hourly')
					{
						$('.chart1').hide();
						$('.chart2').show();	
						$('.chart3').hide();	
						$('.chart4').hide();	
						$('.chart5').hide();	
						$('.chart6').hide();	
						$('.chart7').hide();	
						$('.chart8').hide();	
						$('.chart9').hide();	
						$('.chart10').hide();
						Highcharts.chart('hourly', 
						{
							chart: {
								zoomType: 'xy'
							},

							title: {
								text: 'Sensor Graph'
							},


							tooltip: {
								valueDecimals: 2
							},

							xAxis: {
								type: data['hour']
							},

							series: [{
								data: data['value'],
								//lineWidth: 0.5,
								// name: 'Days'
							}]
						});
					}
					if(data['chart'] == 'basicarea')
					{
						$('.chart1').hide();
						$('.chart2').hide();	
						$('.chart3').show();	
						$('.chart4').hide();	
						$('.chart5').hide();	
						$('.chart6').hide();	
						$('.chart7').hide();	
						$('.chart8').hide();	
						$('.chart9').hide();	
						$('.chart10').hide();
						Highcharts.chart('basicarea', 
						{
							chart: {
								type: 'area',
								zoomType: 'xy'
							},
							title: {
								text: 'Sensor Graph'
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
									text: 'Values'
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
								name: '',
								data: data['value']
							}]
						});
					}
					if(data['chart'] == 'negativevalues')
					{
						$('.chart1').hide();
						$('.chart2').hide();	
						$('.chart3').hide();	
						$('.chart4').show();	
						$('.chart5').hide();	
						$('.chart6').hide();	
						$('.chart7').hide();	
						$('.chart8').hide();	
						$('.chart9').hide();	
						$('.chart10').hide();
						Highcharts.chart('negativevalues', 
						{
							chart: {
								type: 'area',
								zoomType: 'xy'
							},
							title: {
								text: 'Sensor Graph'
							},
							xAxis: {
								categories: data['hour']
							},
							credits: {
								enabled: false
							},
							series: [{
								name: 'Sensor',
								data: data['value']
							}]
						});
					}
					if(data['chart'] == 'invertedaxes')
					{
						$('.chart1').hide();
						$('.chart2').hide();	
						$('.chart3').hide();	
						$('.chart4').hide();	
						$('.chart5').show();	
						$('.chart6').hide();	
						$('.chart7').hide();	
						$('.chart8').hide();	
						$('.chart9').hide();	
						$('.chart10').hide();
						Highcharts.chart('invertedaxes', 
						{
							chart: {
								type: 'area',
								zoomType: 'xy',
								inverted: true
							},
							title: {
								text: 'Sensor Graph'
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
								categories: data['hour']
							},
							yAxis: {
								title: {
									text: 'Values'
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
								data: data['value']
							}]
						});
					}
					if(data['chart'] == 'areaspline')
					{
						$('.chart1').hide();
						$('.chart2').hide();	
						$('.chart3').hide();	
						$('.chart4').hide();	
						$('.chart5').hide();	
						$('.chart6').show();	
						$('.chart7').hide();	
						$('.chart8').hide();	
						$('.chart9').hide();	
						$('.chart10').hide();
						Highcharts.chart('areaspline', 
						{
							chart: {
								type: 'areaspline',
								zoomType: 'xy'
							},
							title: {
								text: 'Sensor Graph'
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
								categories: data['hour'],
							},
							yAxis: {
								title: {
									text: 'Values'
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
								data: data['value']
							}]
						});
					}
					if(data['chart'] == 'arearangeline')
					{
						$('.chart1').hide();
						$('.chart2').hide();	
						$('.chart3').hide();	
						$('.chart4').hide();	
						$('.chart5').hide();	
						$('.chart6').hide();	
						$('.chart7').show();	
						$('.chart8').hide();	
						$('.chart9').hide();	
						$('.chart10').hide();
						Highcharts.chart('arearangeline', 
						{
							chart: {
								zoomType: 'xy',
								scrollablePlotArea: {
									minWidth: 600
								}
							},
							title: {
								text: 'Sensor Graph'
							},

							xAxis: {
								type: data['hour'],
							},

							yAxis: {
								title: {
									text: 'Values'
								}
							},

							tooltip: {
								crosshairs: true,
								shared: true,
								valueSuffix: 'Â°C'
							},

							series: [{
								name: 'Sensors',
								data: data['value'],
								zIndex: 1,
								marker: {
									fillColor: 'white',
									lineWidth: 2,
									lineColor: Highcharts.getOptions().colors[0]
								}
							}]
						});
					}
					if(data['chart'] == 'basicbar')
					{
						$('.chart1').hide();
						$('.chart2').hide();	
						$('.chart3').hide();	
						$('.chart4').hide();	
						$('.chart5').hide();	
						$('.chart6').hide();	
						$('.chart7').hide();	
						$('.chart8').show();	
						$('.chart9').hide();	
						$('.chart10').hide();
						Highcharts.chart('basicbar', 
						{
							chart: {
								type: 'bar',
								zoomType: 'xy'
							},
							title: {
								text: 'Sensor Graph'
							},
							xAxis: {
								categories: data['hour'],
								title: {
									text: 'Days'
								}
							},
							yAxis: {
								min: -1000,
								title: {
									text: 'Values',
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
								data: data['value']
							}]
						});
					}
					if(data['chart'] == 'stackedbar')
					{
						$('.chart1').hide();
						$('.chart2').hide();	
						$('.chart3').hide();	
						$('.chart4').hide();	
						$('.chart5').hide();	
						$('.chart6').hide();	
						$('.chart7').hide();	
						$('.chart8').hide();	
						$('.chart9').show();	
						$('.chart10').hide();
						Highcharts.chart('stackedbar', 
						{
							chart: {
								type: 'bar',
								zoomType: 'xy'
							},
							title: {
								text: 'Sensor Graph'
							},
							xAxis: {
								categories: data['hour']
							},
							yAxis: {
								min: -1000,
								title: {
									text: 'Values'
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
								data: data['value']
							}]
						});
					}
					if(data['chart'] == 'basiccolumn')
					{
						$('.chart1').hide();
						$('.chart2').hide();	
						$('.chart3').hide();	
						$('.chart4').hide();	
						$('.chart5').hide();	
						$('.chart6').hide();	
						$('.chart7').hide();	
						$('.chart8').hide();	
						$('.chart9').hide();	
						$('.chart10').show();
						Highcharts.chart('basiccolumn', 
						{
							chart: {
								type: 'column',
								zoomType: 'xy'
							},
							title: {
								text: 'Sensor Graph'
							},
							xAxis: {
								categories: data['hour'],
								crosshair: true
							},
							yAxis: {
								min: -1000,
								title: {
									text: 'Values'
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
								data: data['value']
							}]
						});
					}
				}
			}
		});
	}
function getchart3()
{
//alert(1);
    $.ajax({
        url: "{{ url('/agent/getchart3') }}",
        type: "post",
        data: $('#tmefrm3').serialize(),
        success: function(response)
		{	
			data=JSON.parse(response);
			if(data!="")
			{
				if(data['chart'] == 'datalable')
				{
					$('.chart11').show();
					$('.chart12').hide();	
					$('.chart13').hide();	
					$('.chart14').hide();	
					$('.chart15').hide();	
					$('.chart16').hide();	
					$('.chart17').hide();	
					$('.chart18').hide();	
					$('.chart19').hide();	
					$('.chart20').hide();
					Highcharts.chart('datalable1', 
					{
						chart: {
							type: 'line',
							zoomType: 'xy',
							scrollablePlotArea: {
								minWidth: 600
							}
						},
						title: {
							text: 'Sensor Graph'
						},
						subtitle: {
							text: ''
						},
						xAxis: {
							categories: data['hour']
						},
						yAxis: {
							title: {
								text: 'Days'
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
						series: [
						{
							data: data['value']
						}]
					});
				}
				if(data['chart'] == 'hourly')
				{
					$('.chart11').hide();
					$('.chart12').show();	
					$('.chart13').hide();	
					$('.chart14').hide();	
					$('.chart15').hide();	
					$('.chart16').hide();	
					$('.chart17').hide();	
					$('.chart18').hide();	
					$('.chart19').hide();	
					$('.chart20').hide();
					Highcharts.chart('hourly1', 
					{
						chart: {
							zoomType: 'xy'
						},

						title: {
							text: 'Sensor Graph'
						},


						tooltip: {
							valueDecimals: 2
						},

						xAxis: {
							type: data['hour']
						},

						series: [{
							data: data['value'],
							//lineWidth: 0.5,
							// name: 'Days'
						}]
					});
				}
				if(data['chart'] == 'basicarea')
				{
					$('.chart11').hide();
					$('.chart12').hide();	
					$('.chart13').show();	
					$('.chart14').hide();	
					$('.chart15').hide();	
					$('.chart16').hide();	
					$('.chart17').hide();	
					$('.chart18').hide();	
					$('.chart19').hide();	
					$('.chart20').hide();
					Highcharts.chart('basicarea1', 
					{
						chart: {
							type: 'area',
							zoomType: 'xy'
						},
						title: {
							text: 'Sensor Graph'
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
								text: 'Values'
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
							name: '',
							data: data['value']
						}]
					});
				}
				if(data['chart'] == 'negativevalues')
				{
					$('.chart11').hide();
					$('.chart12').hide();	
					$('.chart13').hide();	
					$('.chart14').show();	
					$('.chart15').hide();	
					$('.chart16').hide();	
					$('.chart17').hide();	
					$('.chart18').hide();	
					$('.chart19').hide();	
					$('.chart20').hide();
					Highcharts.chart('negativevalues1', 
					{
						chart: {
							type: 'area',
							zoomType: 'xy'
						},
						title: {
							text: 'Sensor Graph'
						},
						xAxis: {
							categories: data['hour']
						},
						credits: {
							enabled: false
						},
						series: [{
							name: 'Sensor',
							data: data['value']
						}]
					});
				}
				if(data['chart'] == 'invertedaxes')
				{
					$('.chart11').hide();
					$('.chart12').hide();	
					$('.chart13').hide();	
					$('.chart14').hide();	
					$('.chart15').show();	
					$('.chart16').hide();	
					$('.chart17').hide();	
					$('.chart18').hide();	
					$('.chart19').hide();	
					$('.chart20').hide();
					Highcharts.chart('invertedaxes1', 
					{
						chart: {
							type: 'area',
							zoomType: 'xy',
							inverted: true
						},
						title: {
							text: 'Sensor Graph'
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
							categories: data['hour']
						},
						yAxis: {
							title: {
								text: 'Values'
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
							data: data['value']
						}]
					});
				}
				if(data['chart'] == 'areaspline')
				{
					$('.chart11').hide();
					$('.chart12').hide();	
					$('.chart13').hide();	
					$('.chart14').hide();	
					$('.chart15').hide();	
					$('.chart16').show();	
					$('.chart17').hide();	
					$('.chart18').hide();	
					$('.chart19').hide();	
					$('.chart20').hide();
					Highcharts.chart('areaspline1', 
					{
						chart: {
							type: 'areaspline',
							zoomType: 'xy'
						},
						title: {
							text: 'Sensor Graph'
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
							categories: data['hour'],
						},
						yAxis: {
							title: {
								text: 'Values'
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
							data: data['value']
						}]
					});
				}
				if(data['chart'] == 'arearangeline')
				{
					$('.chart11').hide();
					$('.chart12').hide();	
					$('.chart13').hide();	
					$('.chart14').hide();	
					$('.chart15').hide();	
					$('.chart16').hide();	
					$('.chart17').show();	
					$('.chart18').hide();	
					$('.chart19').hide();	
					$('.chart20').hide();
					Highcharts.chart('arearangeline1', 
					{
						chart: {
							zoomType: 'xy',
							scrollablePlotArea: {
								minWidth: 600
							}
						},
						title: {
							text: 'Sensor Graph'
						},

						xAxis: {
							type: data['hour'],
						},

						yAxis: {
							title: {
								text: 'Values'
							}
						},

						tooltip: {
							crosshairs: true,
							shared: true,
							valueSuffix: 'Â°C'
						},

						series: [{
							name: 'Sensors',
							data: data['value'],
							zIndex: 1,
							marker: {
								fillColor: 'white',
								lineWidth: 2,
								lineColor: Highcharts.getOptions().colors[0]
							}
						}]
					});
				}
				if(data['chart'] == 'basicbar')
				{
					$('.chart11').hide();
					$('.chart12').hide();	
					$('.chart13').hide();	
					$('.chart14').hide();	
					$('.chart15').hide();	
					$('.chart16').hide();	
					$('.chart17').hide();	
					$('.chart18').show();	
					$('.chart19').hide();	
					$('.chart20').hide();
					Highcharts.chart('basicbar1', 
					{
						chart: {
							type: 'bar',
							zoomType: 'xy'
						},
						title: {
							text: 'Sensor Graph'
						},
						xAxis: {
							categories: data['hour'],
							title: {
								text: 'Days'
							}
						},
						yAxis: {
							min: -1000,
							title: {
								text: 'Values',
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
							data: data['value']
						}]
					});
				}
				if(data['chart'] == 'stackedbar')
				{
					$('.chart11').hide();
					$('.chart12').hide();	
					$('.chart13').hide();	
					$('.chart14').hide();	
					$('.chart15').hide();	
					$('.chart16').hide();	
					$('.chart17').hide();	
					$('.chart18').hide();	
					$('.chart19').show();	
					$('.chart20').hide();
					Highcharts.chart('stackedbar1', 
					{
						chart: {
							type: 'bar',
							zoomType: 'xy'
						},
						title: {
							text: 'Sensor Graph'
						},
						xAxis: {
							categories: data['hour']
						},
						yAxis: {
							min: -1000,
							title: {
								text: 'Values'
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
							data: data['value']
						}]
					});
				}
				if(data['chart'] == 'basiccolumn')
				{
					$('.chart11').hide();
					$('.chart12').hide();	
					$('.chart13').hide();	
					$('.chart14').hide();	
					$('.chart15').hide();	
					$('.chart16').hide();	
					$('.chart17').hide();	
					$('.chart18').hide();	
					$('.chart19').hide();	
					$('.chart20').show();
					Highcharts.chart('basiccolumn1', 
					{
						chart: {
							type: 'column',
							zoomType: 'xy'
						},
						title: {
							text: 'Sensor Graph'
						},
						xAxis: {
							categories: data['hour'],
							crosshair: true
						},
						yAxis: {
							min: -1000,
							title: {
								text: 'Values'
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
							data: data['value']
						}]
					});
				}		
			}
        }
    });
	}
	function getchart2()
	{
		$.ajax(
		{
			url: "{{ url('/agent/getsensordata') }}",
			type: "post",
			data: $('#tmefrm2').serialize(),
			success: function(response)
			{	
				data=JSON.parse(response);
				if(data!="")
				{
					if(data['chart'] == 'datalable')
					{
						$('.chart21').show();
						$('.chart22').hide();	
						$('.chart23').hide();	
						$('.chart24').hide();	
						$('.chart25').hide();	
						$('.chart26').hide();	
						$('.chart27').hide();	
						$('.chart28').hide();	
						$('.chart29').hide();	
						$('.chart30').hide();
						Highcharts.chart('datalable2', 
						{
							chart: {
								type: 'line',
								zoomType: 'xy',
								scrollablePlotArea: {
									minWidth: 600
								}
							},
							title: {
								text: 'Sensor Graph'
							},
							subtitle: {
								text: ''
							},
							xAxis: {
								categories: data['hour']
							},
							yAxis: {
								title: {
									text: 'Days'
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
							series: [
							{
								data: data['value']
							}]
						});
					}
					if(data['chart'] == 'hourly')
					{
						$('.chart21').hide();
						$('.chart22').show();	
						$('.chart23').hide();	
						$('.chart24').hide();	
						$('.chart25').hide();	
						$('.chart26').hide();	
						$('.chart27').hide();	
						$('.chart28').hide();	
						$('.chart29').hide();	
						$('.chart30').hide();
						Highcharts.chart('hourly2', 
						{
							chart: {
								zoomType: 'xy'
							},

							title: {
								text: 'Sensor Graph'
							},


							tooltip: {
								valueDecimals: 2
							},

							xAxis: {
								type: data['hour']
							},

							series: [{
								data: data['value'],
								//lineWidth: 0.5,
								// name: 'Days'
							}]
						});
					}
					if(data['chart'] == 'basicarea')
					{
						$('.chart21').hide();
						$('.chart22').hide();	
						$('.chart23').show();	
						$('.chart24').hide();	
						$('.chart25').hide();	
						$('.chart26').hide();	
						$('.chart27').hide();	
						$('.chart28').hide();	
						$('.chart29').hide();	
						$('.chart30').hide();
						Highcharts.chart('basicarea2', 
						{
							chart: {
								type: 'area',
								zoomType: 'xy'
							},
							title: {
								text: 'Sensor Graph'
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
									text: 'Values'
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
								name: '',
								data: data['value']
							}]
						});
					}
					if(data['chart'] == 'negativevalues')
					{
						$('.chart21').hide();
						$('.chart22').hide();	
						$('.chart23').hide();	
						$('.chart24').show();	
						$('.chart25').hide();	
						$('.chart26').hide();	
						$('.chart27').hide();	
						$('.chart28').hide();	
						$('.chart29').hide();	
						$('.chart30').hide();
						Highcharts.chart('negativevalues2', 
						{
							chart: {
								type: 'area',
								zoomType: 'xy'
							},
							title: {
								text: 'Sensor Graph'
							},
							xAxis: {
								categories: data['hour']
							},
							credits: {
								enabled: false
							},
							series: [{
								name: 'Sensor',
								data: data['value']
							}]
						});
					}
					if(data['chart'] == 'invertedaxes')
					{
						$('.chart21').hide();
						$('.chart22').hide();	
						$('.chart23').hide();	
						$('.chart24').hide();	
						$('.chart25').show();	
						$('.chart26').hide();	
						$('.chart27').hide();	
						$('.chart28').hide();	
						$('.chart29').hide();	
						$('.chart30').hide();
						Highcharts.chart('invertedaxes2', 
						{
							chart: {
								type: 'area',
								zoomType: 'xy',
								inverted: true
							},
							title: {
								text: 'Sensor Graph'
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
								categories: data['hour']
							},
							yAxis: {
								title: {
									text: 'Values'
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
								data: data['value']
							}]
						});
					}
					if(data['chart'] == 'areaspline')
					{
						$('.chart21').hide();
						$('.chart22').hide();	
						$('.chart23').hide();	
						$('.chart24').hide();	
						$('.chart25').hide();	
						$('.chart26').show();	
						$('.chart27').hide();	
						$('.chart28').hide();	
						$('.chart29').hide();	
						$('.chart20').hide();
						Highcharts.chart('areaspline2', 
						{
							chart: {
								type: 'areaspline',
								zoomType: 'xy'
							},
							title: {
								text: 'Sensor Graph'
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
								categories: data['hour'],
							},
							yAxis: {
								title: {
									text: 'Values'
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
								data: data['value']
							}]
						});
					}
					if(data['chart'] == 'arearangeline')
					{
						$('.chart21').hide();
						$('.chart22').hide();	
						$('.chart23').hide();	
						$('.chart24').hide();	
						$('.chart25').hide();	
						$('.chart26').hide();	
						$('.chart27').show();	
						$('.chart28').hide();	
						$('.chart29').hide();	
						$('.chart30').hide();
						Highcharts.chart('arearangeline2', 
						{
							chart: {
								zoomType: 'xy',
								scrollablePlotArea: {
									minWidth: 600
								}
							},
							title: {
								text: 'Sensor Graph'
							},

							xAxis: {
								type: data['hour'],
							},

							yAxis: {
								title: {
									text: 'Values'
								}
							},

							tooltip: {
								crosshairs: true,
								shared: true,
								valueSuffix: 'Â°C'
							},

							series: [{
								name: 'Sensors',
								data: data['value'],
								zIndex: 1,
								marker: {
									fillColor: 'white',
									lineWidth: 2,
									lineColor: Highcharts.getOptions().colors[0]
								}
							}]
						});
					}
					if(data['chart'] == 'basicbar')
					{
						$('.chart21').hide();
						$('.chart22').hide();	
						$('.chart23').hide();	
						$('.chart24').hide();	
						$('.chart25').hide();	
						$('.chart26').hide();	
						$('.chart27').hide();	
						$('.chart28').show();	
						$('.chart29').hide();	
						$('.chart30').hide();
						Highcharts.chart('basicbar2', 
						{
							chart: {
								type: 'bar',
								zoomType: 'xy'
							},
							title: {
								text: 'Sensor Graph'
							},
							xAxis: {
								categories: data['hour'],
								title: {
									text: 'Days'
								}
							},
							yAxis: {
								min: -1000,
								title: {
									text: 'Values',
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
								data: data['value']
							}]
						});
					}
					if(data['chart'] == 'stackedbar')
					{
						$('.chart21').hide();
						$('.chart22').hide();	
						$('.chart23').hide();	
						$('.chart24').hide();	
						$('.chart25').hide();	
						$('.chart26').hide();	
						$('.chart27').hide();	
						$('.chart28').hide();	
						$('.chart29').show();	
						$('.chart30').hide();
						Highcharts.chart('stackedbar2', 
						{
							chart: {
								type: 'bar',
								zoomType: 'xy'
							},
							title: {
								text: 'Sensor Graph'
							},
							xAxis: {
								categories: data['hour']
							},
							yAxis: {
								min: -1000,
								title: {
									text: 'Values'
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
								data: data['value']
							}]
						});
					}
					if(data['chart'] == 'basiccolumn')
					{
						$('.chart21').hide();
						$('.chart22').hide();	
						$('.chart23').hide();	
						$('.chart24').hide();	
						$('.chart25').hide();	
						$('.chart26').hide();	
						$('.chart27').hide();	
						$('.chart28').hide();	
						$('.chart29').hide();	
						$('.chart30').show();
						Highcharts.chart('basiccolumn2', 
						{
							chart: {
								type: 'column',
								zoomType: 'xy'
							},
							title: {
								text: 'Sensor Graph'
							},
							xAxis: {
								categories: data['hour'],
								crosshair: true
							},
							yAxis: {
								min: -1000,
								title: {
									text: 'Values'
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
								data: data['value']
							}]
						});
					}	
				}
			}
		});
	}
</script>


@parent

@endsection

