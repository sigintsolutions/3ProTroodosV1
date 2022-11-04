@extends('layouts.admin')
@section('content')
<div class="loader" style="display:none"></div>
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
									<a class="nav-link euz_tabtex active" data-toggle="tab" href="#senrepor"><i class="fas fa-file-alt"></i> Sensor Time Report</a>
								</li>
								<li class="nav-item">
									<a class="nav-link euz_tabtex" data-toggle="tab" href="#hubreportss"><i class="fas fa-broadcast-tower"></i> Hub Sensor Report</a>
								</li>
							</ul>		
							<!-- Tab panes -->
							<div class="tab-content px-3">								
								<div id="senrepor" class="tab-pane active"><br>
									<form method="post" action="{{ url('/admin/export') }}" name="tmefrm" id="tmefrm">
										{{ csrf_field() }}
										<div class="row">
											<div class="col-md-12 mt-2 mb-3">
												<div class="shadow-sm">
													<div class="col-md-12 euz_box_head">
														<p class="text-white euz_b mb-0">Sensor Time Report</p>
													</div>		
													<div class="col-md-12 euz_border">
														<div class="row">
															<div class="form-group col-md-3 py-2 mb-0">
																<label for="" class="euz_b">Agent</label>
																<select class="form-control agent1" id="agent1" name="agent">
																	<option value="">--select--</option>
																	@foreach($agents as $item)
																	<option value="{{ @$item->id }}">{{ @$item->fname }}</option>
																	@endforeach
																</select>	
															</div>
															<div class="form-group col-md-3 py-2 mb-0">
																<label class="euz_b">Gateway Group</label>
																<div class="group">
																	<select class="form-control" id="group" name="group[]" multiple="multiple" ></select>												
																</div>
															</div>
															<div class="form-group col-md-3 py-2 mb-0">
																<label for="" class="euz_b">Sensor Hub</label>
																<div class="hub">
																	<select class="form-control " id="hub" name="hub[]" multiple="multiple" ></select>	
																</div>
															</div>
															<div class="form-group col-md-3 py-2 mb-0">
																<label for="" class="euz_b">Unit</label>
																<select class="form-control unit" id="unit" name="unit"></select>	
															</div>
															<div class="form-group col-md-5 py-2 mb-0">
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
																		<option value="AreaChart">AreaChart</option>
																		<option value="BarChart">BarChart</option>
																		<option value="PieChart">PieChart</option>
																		<option value="ColumnChart">ColumnChart</option>
																		<option value="ComboChart">ComboChart</option>
																		<option value="ScatterChart">ScatterChart</option>
																		<option value="SteppedAreaChart">SteppedAreaChart</option>
																		<option value="Histogram">Histogram</option>
																		<option value="LineChart">LineChart</option>
																	<select>
																</div>
															</div>														
															<div class="form-group col-md-4 py-2 mb-0">
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
																<button type="button" class="euz_btn_add euz_pointer text-white" id="butSen" name="butSen"><i class="fas fa-search"></i> Search</button>
																&nbsp;&nbsp;
																<button type='reset' class="euz_btn_add euz_pointer bg-danger border-0 text-white"><i class="fas fa-redo-alt"></i> Reset</button>
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
																	<!-- <div class="col-md-12">
																		<div id="weeksenrepo" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
																	</div> -->
																	<div class="col-md-12 mt-3">
																		<div class="shadow-sm">
																			<div class="col-md-12 euz_border chart1">
																				<div id="chartajax"></div>
																				<!-- <div id="datalable"></div> -->
																				
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
															
															<div class="tab-pane fade mt-5" id="sensorlist">
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
												<form method="post" action="{{ url('/admin/exporthub') }}" name="tmefrm2" id="tmefrm2">
												{{ csrf_field() }}
												<div class="col-md-12 euz_border">
													<div class="row">
														<div class="form-group col-md-3 py-2 mb-0">
															<label for="" class="euz_b">Agent</label>
															<select class="form-control agent2" id="agent2" name="agent">
																<option value="">--select--</option>
																@foreach($agents as $item)
																<option value="{{ @$item->id }}">{{ @$item->fname }}</option>
																@endforeach
															</select>	
														</div>
														<div class="form-group col-md-4 py-2 mb-0">
															<label class="euz_b">Gateway Group</label>
															<div class="group2">
																<select class="form-control" id="group2" name="group" ></select>												
															</div>
														</div>	
														<!-- <div class="form-group col-md-4 py-2 mb-0">
															<label for="" class="euz_b">Sensor Hub</label>
															<select class="form-control hub2" name="hub" onchange="getsensor(this.value,$(this).closest('.items').attr('id'))">
														<option value="">-Select-</option>
														</select>
														</div> -->
														<div class="form-group col-md-5 py-2 mb-0">
															<label for="" class="euz_b">Sensor Hub</label>
															<div class="hub2">
																<select class="form-control " id="hub2" name="hub"></select>	
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
															<button type="button" name="butSen2" id="butSen2" class="euz_btn_add euz_pointer text-white"><i class="fas fa-search"></i> Search</button>
															&nbsp;&nbsp;
															<button type="reset" class="euz_btn_add euz_pointer bg-danger border-0 text-white"><i class="fas fa-redo-alt"></i> Reset</button>
														</div>
													</div>
													<button class="euz_btn_add euz_pointer" type="submit" id="exportsensor" target="_blank">EXPORT</button>
												</div>
												</form>
											</div>
										</div>									
										<!-- <div class="col-md-12 mt-3" id="sensordata">											
										</div> -->
										<!-- <div class="col-md-12 mt-3">
											<div class="row">
												<div class="col-md-12 mt-3">
													<div class="shadow-sm p-2 euz_border">
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
												</div>
											</div>
										</div>	
																			 -->
										<div class="col-md-12 mt-3">
											<div class="row">													
												<div class="col-md-12">
													<!-- Tab panes -->
													<div class="tab-content euz_border p-3 bg-white">
															
														<div class="row">																											<div class="col-md-6">
																


															</div>				
															<div class="col-md-6">
																<ul class="nav nav-pills float-right mx-3">
																	<li class="nav-item">
																		<a class="nav-link" data-toggle="pill" href="#carthub"><i class="fas fa-chart-line"></i></a>
																	</li>
																	<li class="nav-item">
																		<a class="nav-link active" data-toggle="pill" href="#sensordata"><i class="fas fa-table"></i></a>
																	</li>
																</ul>
															</div>												
														</div>
														<div class="tab-pane fade" id="carthub">
															<div class="row mt-5">
																<div class="col-md-12 mt-3">
																	<div class="shadow-sm">
																		<div class="loaderhub" style="display: none;"></div>
																		<div class="col-md-12 euz_border chart1">
																			<div id="chartajaxhub"></div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
															
														<div class="tab-pane active mt-5 col-md-12" id="sensordata">
															<div id="table_data3"><div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
			</div>
        </div>
		
<div onclick="scrollToTop()" class="btn_in_top text-center text-white"><i class="fas fa-caret-up" style="font-size: 45px;"></i></div>
		
@endsection
@section('scripts')

<script>
    $('.btn_in_top').hide();
		function scrollToTop() { 
            $(window).scrollTop(0); 
        }
		
	$(document).scroll(function() {
		var y = $(this).scrollTop();
		if (y > 700) {
			$('.btn_in_top').fadeIn();
		} else {
			$('.btn_in_top').fadeOut();
		}
	});
	
	
	$(function () {
        $(".euz_a").css({ "color": "#16313c" });
        $("#sensor").css({ "color": "#3990b3"});
    });
	
</script>


<!-- <script src="{{ url('/js/highcharts.js') }}"></script>
<script src="{{ url('/js/highcharts-more.js') }}"></script> -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
<script type="text/javascript" src="{{ url('/js/jquery.form.min.js') }}"></script>
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
	$('#agent1').selectpicker();
	$('#agent2').selectpicker();
	$('#agent3').selectpicker();
</script>
<script>
    $('#txt_date').datepicker({ format: "dd MM yyyy" });
	$('#txt_date1, #txt_date2, #txt_date3').datepicker({ format: "dd MM yyyy" });
</script>

<script src="{{ url('js/kelly.js') }} "></script>
<?php /*?><script src="{{ url('chart/meter.js') }}"></script><?php */?>
<script src="{{ url('chart/meter1.js') }}"></script>
<script src="{{ url('chart/meter2.js') }}"></script>
<script src="{{ url('chart/meter3.js') }}"></script>

<?php /*?><script src="{{ url('chart/week1.js') }}"></script><?php */?>

<script src="{{ url('chart/agenthistory.js') }}"></script>
<script src="{{ url('chart/agenthistory1.js') }}"></script>
<script src="{{ url('chart/agentleveschart.js') }}"></script>
<script src="{{ url('chart/sensors.js') }}"></script>

<script>
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
$(".loader").show();
		var selectData = $('#sensor2').val();
		//alert(selectData);
		var url = "{{ url('/admin/getchartcount') }}";
		var docurl = url + "/" + selectData;
		$.ajax(
		{
			url: docurl,
			type: "GET",
			success: function(datas)
			{
				//alert(datas);						
				$('#chartajax').html(datas);
				getchart();
//$(".loader").hide();
			}
		});
		$.ajax({
			url: "{{ url('/admin/getsensortime') }}",
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
		$(".loader").show();
		getchart2();
		$.ajax({
			url: "{{ url('/admin/getsensordata') }}",
			type: "post",
			data: $('#tmefrm2').serialize(),
			success: function(data)
			{
				//alert(data);
				$("#sensordata").html(data);
				$(".loader").hide();
			}
		});
	});
	$("#butSen3").click(function()
	{
		getchart3();
	});
</script>

<script>
//$(document).ready(function(){

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
	//alert($('#tme').val());
	$.ajax(
	{
		url:"/argus/admin/fetch_data2?page="+page+"&agent="+$('#agent1').val()+"&group="+$('#group').val()+"&hub="+$('#hub').val()+"&sensor="+$('#sensor2').val()+"&unit="+$('#unit').val()+"&tme="+$('#tme').val(),
		success:function(data)
		{
			$('#table_data2').html(data);
		}
	});
}
</script>
<script>
	$(".agent1").change(function(){
		$.ajax(
		{
			url: "{{ url('/admin/getgroup') }}",
			type: "post",
			data: $('#tmefrm').serialize(),
			success: function(data)
			{
				$(".group").html(data);
				$('#group').selectpicker();
			}
		});
	});
	$(".group").change(function()
	{
		$.ajax({
			url: "{{ url('/admin/gethub') }}",
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
		//alert();
		$.ajax(
		{
			url: "{{ url('/admin/getunit') }}",
			type: "post",
			data: $('#tmefrm').serialize(),
			success: function(data)
			{
				//alert(data);
				//$(".sensor2").html(data);
				//$('#sensor2').selectpicker();
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
	$(".agent2").change(function(){
		$.ajax(
		{
			url: "{{ url('/admin/getgroup2') }}",
			type: "post",
			data: $('#tmefrm2').serialize(),
			success: function(data)
			{
				$(".group2").html(data);
				$('#group2').selectpicker();
			}
		});
	});
	$(".group2").change(function()
	{
		$.ajax(
		{
			url: "{{ url('/admin/gethub2') }}",
			type: "post",
			data: $('#tmefrm2').serialize(),
			success: function(data)
			{
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
	$(".agent3").change(function(){
		$.ajax(
		{
			url: "{{ url('/admin/getgroup3') }}",
			type: "post",
			data: $('#tmefrm3').serialize(),
			success: function(data)
			{
				$(".group3").html(data);
				$('.group3').selectpicker();
				$('#group3').selectpicker();
				$('#agrouplevel').selectpicker();
			}
		});
	});
	$(".group3").change(function()
	{
		$.ajax(
		{
			url: "{{ url('/admin/gethub3') }}",
			type: "post",
			data: $('#tmefrm3').serialize(),
			success: function(data)
			{
				$(".hub3").html(data);
				$('#hub3').selectpicker();
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
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(getchart);	
	function getchart()
	{	
		$.ajax(
		{
			url: "{{ url('/admin/getchart2') }}",
			type: "post",
			data: $('#tmefrm').serialize(),
			//dataType:'JSON',
			success: function(data1)
			{		
				var jsonData = $.parseJSON(data1);
				//alert(jsonData.count);
				var count = jsonData.count;
				var data=[];
				for (k=0;k<count;k++)
				{
					data[k] = new google.visualization.DataTable();
					data[k].addColumn('string', 'Date');
					data[k].addColumn('number', 'Value');
					var title =  jsonData.hub[k] + '/' + jsonData.sensor_id[k];
					var options = 
					{
						title : title,
						vAxis: {title: 'Values'},
						hAxis: {title: 'Date'},
						width: 1200,
						height: 500,
						pieSliceText: 'value',
						//pieHole: 0.4,
						axes: {
							x: {
								0: {side: 'bottom'} 
							}
						}
					};
					for (var i = 0; i < jsonData.value[k].length; i++) 
					{
						//alert('hi');
						//alert(parseInt(jsonData.value[k][i]));			
						data[k].addRow([jsonData.hour[k][i],parseInt(jsonData.value[k][i])]);
					}
					if(jsonData.chart == 'AreaChart')
					{
						var chart = new google.visualization.AreaChart(document.getElementById('datalable'+k))
					}
					if(jsonData.chart == 'BarChart')
					{
						var chart = new google.visualization.BarChart(document.getElementById('datalable'+k));
					}
					if(jsonData.chart == 'PieChart')
					{
						var chart = new google.visualization.PieChart(document.getElementById('datalable'+k));
					}
					if(jsonData.chart == 'ColumnChart')
					{
						var chart = new google.visualization.ColumnChart(document.getElementById('datalable'+k));
					}
					if(jsonData.chart == 'ComboChart')
					{
						var chart = new google.visualization.ComboChart(document.getElementById('datalable'+k));
					}
					if(jsonData.chart == 'ScatterChart')
					{
						var chart = new google.visualization.ScatterChart(document.getElementById('datalable'+k));
					}
					if(jsonData.chart == 'SteppedAreaChart')
					{
						var chart = new google.visualization.SteppedAreaChart(document.getElementById('datalable'+k));
					}
					if(jsonData.chart == 'Histogram')
					{
						var chart = new google.visualization.Histogram(document.getElementById('datalable'+k));
					}
					if(jsonData.chart == 'LineChart')
					{
						var chart = new google.visualization.LineChart(document.getElementById('datalable'+k));
					}
					chart.draw(data[k], options);
				}
				$(".loader").hide();
			}
		});
	}
	// function getchart3()
	// {		
		
	// 			data=JSON.parse(response);
	// 			if(data!="")
	// 			{
	// 				// Highcharts.chart('agentleveschart2', 
	// 				// {
	// 				// 	chart: 
	// 				// 	{
	// 				// 		defaultSeriesType: 'column',
	// 				// 		zoomType: 'x',
	// 				// 		panning: true,
	// 				// 		panKey: 'shift',
	// 				// 		scrollablePlotArea: 
	// 				// 		{
	// 				// 			minWidth: 600
	// 				// 		}
	// 				// 	},
	// 				// 	title: 
	// 				// 	{
	// 				// 		text: 'Sensor Graph'
	// 				// 	},					
	// 				// 	subtitle: 
	// 				// 	{
	// 				// 		text: ''
	// 				// 	},					
	// 				// 	xAxis: 
	// 				// 	{
	// 				// 		categories: data['hour']
	// 				// 	},						
	// 				// 	plotOptions: 
	// 				// 	{
	// 				// 		series: 
	// 				// 		{
	// 				// 			borderWidth: 0,
	// 				// 			color: '#48a9d3',
	// 				// 			dataLabels: 
	// 				// 			{
	// 				// 				enabled: true,
	// 				// 				color: '#969696',
	// 				// 				format: '{point.y:f}°C'
	// 				// 			}
	// 				// 		}
	// 				// 	},			
	// 				// 	tooltip: 
	// 				// 	{
	// 				// 		headerFormat: '<span style="font-size:11px">{point.name}</span><br>',
	// 				// 	},
	// 				// 	series: [
	// 				// 	{
	// 				// 		data: data['value']
	// 				// 	}]
	// 				// });	
	// 				//alert(data['chart']);
					
	// 				if(data['chart'] == 'datalable')
	// 				{
	// 					$('.chart11').show();
	// 					$('.chart12').hide();	
	// 					$('.chart13').hide();	
	// 					$('.chart14').hide();	
	// 					$('.chart15').hide();	
	// 					$('.chart16').hide();	
	// 					$('.chart17').hide();	
	// 					$('.chart18').hide();	
	// 					$('.chart19').hide();	
	// 					$('.chart20').hide();
	// 					Highcharts.chart('datalable1', 
	// 					{
	// 						chart: {
	// 							type: 'line',
	// 							zoomType: 'xy',
	// 							scrollablePlotArea: {
	// 								minWidth: 600
	// 							}
	// 						},
	// 						title: {
	// 							text: 'Sensor Graph'
	// 						},
	// 						subtitle: {
	// 							text: ''
	// 						},
	// 						xAxis: {
	// 							categories: data['hour']
	// 						},
	// 						yAxis: {
	// 							title: {
	// 								text: 'Days'
	// 							}
	// 						},
	// 						plotOptions: {
	// 							line: {
	// 								dataLabels: {
	// 									enabled: true
	// 								},
	// 								enableMouseTracking: false
	// 							}
	// 						},
	// 						series: [
	// 						{
	// 							data: data['value']
	// 						}]
	// 					});
	// 				}
	// 				if(data['chart'] == 'hourly')
	// 				{
	// 					$('.chart11').hide();
	// 					$('.chart12').show();	
	// 					$('.chart13').hide();	
	// 					$('.chart14').hide();	
	// 					$('.chart15').hide();	
	// 					$('.chart16').hide();	
	// 					$('.chart17').hide();	
	// 					$('.chart18').hide();	
	// 					$('.chart19').hide();	
	// 					$('.chart20').hide();
	// 					Highcharts.chart('hourly1', 
	// 					{
	// 						chart: {
	// 							zoomType: 'xy'
	// 						},

	// 						title: {
	// 							text: 'Sensor Graph'
	// 						},


	// 						tooltip: {
	// 							valueDecimals: 2
	// 						},

	// 						xAxis: {
	// 							type: data['hour']
	// 						},

	// 						series: [{
	// 							data: data['value'],
	// 							//lineWidth: 0.5,
	// 							// name: 'Days'
	// 						}]
	// 					});
	// 				}
	// 				if(data['chart'] == 'basicarea')
	// 				{
	// 					$('.chart11').hide();
	// 					$('.chart12').hide();	
	// 					$('.chart13').show();	
	// 					$('.chart14').hide();	
	// 					$('.chart15').hide();	
	// 					$('.chart16').hide();	
	// 					$('.chart17').hide();	
	// 					$('.chart18').hide();	
	// 					$('.chart19').hide();	
	// 					$('.chart20').hide();
	// 					Highcharts.chart('basicarea1', 
	// 					{
	// 						chart: {
	// 							type: 'area',
	// 							zoomType: 'xy'
	// 						},
	// 						title: {
	// 							text: 'Sensor Graph'
	// 						},
	// 						xAxis: {
	// 							allowDecimals: false,
	// 							// labels: {
	// 							// 	formatter: function () {
	// 							// 		return this.value; // clean, unformatted number for year
	// 							// 	}
	// 							// },
	// 						},
	// 						yAxis: {
	// 							title: {
	// 								text: 'Values'
	// 							},
	// 							// labels: {
	// 							// 	formatter: function () {
	// 							// 		return this.value / 1000 + 'k';
	// 							// 	}
	// 							// }
	// 						},
	// 						tooltip: {
	// 							pointFormat: 'Value <b>{point.y:,.0f}</b>'
	// 						},
	// 						plotOptions: {
	// 							area: {
	// 								pointStart: 1,
	// 								marker: {
	// 									enabled: false,
	// 									symbol: 'circle',
	// 									radius: 2,
	// 									states: {
	// 										hover: {
	// 											enabled: true
	// 										}
	// 									}
	// 								}
	// 							}
	// 						},
	// 						series: [{
	// 							name: '',
	// 							data: data['value']
	// 						}]
	// 					});
	// 				}
	// 				if(data['chart'] == 'negativevalues')
	// 				{
	// 					$('.chart11').hide();
	// 					$('.chart12').hide();	
	// 					$('.chart13').hide();	
	// 					$('.chart14').show();	
	// 					$('.chart15').hide();	
	// 					$('.chart16').hide();	
	// 					$('.chart17').hide();	
	// 					$('.chart18').hide();	
	// 					$('.chart19').hide();	
	// 					$('.chart20').hide();
	// 					Highcharts.chart('negativevalues1', 
	// 					{
	// 						chart: {
	// 							type: 'area',
	// 							zoomType: 'xy'
	// 						},
	// 						title: {
	// 							text: 'Sensor Graph'
	// 						},
	// 						xAxis: {
	// 							categories: data['hour']
	// 						},
	// 						credits: {
	// 							enabled: false
	// 						},
	// 						series: [{
	// 							name: 'Sensor',
	// 							data: data['value']
	// 						}]
	// 					});
	// 				}
	// 				if(data['chart'] == 'invertedaxes')
	// 				{
	// 					$('.chart11').hide();
	// 					$('.chart12').hide();	
	// 					$('.chart13').hide();	
	// 					$('.chart14').hide();	
	// 					$('.chart15').show();	
	// 					$('.chart16').hide();	
	// 					$('.chart17').hide();	
	// 					$('.chart18').hide();	
	// 					$('.chart19').hide();	
	// 					$('.chart20').hide();
	// 					Highcharts.chart('invertedaxes1', 
	// 					{
	// 						chart: {
	// 							type: 'area',
	// 							zoomType: 'xy',
	// 							inverted: true
	// 						},
	// 						title: {
	// 							text: 'Sensor Graph'
	// 						},
	// 						legend: {
	// 							layout: 'vertical',
	// 							align: 'right',
	// 							verticalAlign: 'top',
	// 							x: -150,
	// 							y: 100,
	// 							floating: true,
	// 							borderWidth: 1,
	// 							backgroundColor:
	// 								Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF'
	// 						},
	// 						xAxis: {
	// 							categories: data['hour']
	// 						},
	// 						yAxis: {
	// 							title: {
	// 								text: 'Values'
	// 							},
	// 							allowDecimals: false,
	// 							min: -1000
	// 						},
	// 						plotOptions: {
	// 							area: {
	// 								fillOpacity: 0.5
	// 							}
	// 						},
	// 						series: [{
	// 							name: 'Sensors',
	// 							data: data['value']
	// 						}]
	// 					});
	// 				}
	// 				if(data['chart'] == 'areaspline')
	// 				{
	// 					$('.chart11').hide();
	// 					$('.chart12').hide();	
	// 					$('.chart13').hide();	
	// 					$('.chart14').hide();	
	// 					$('.chart15').hide();	
	// 					$('.chart16').show();	
	// 					$('.chart17').hide();	
	// 					$('.chart18').hide();	
	// 					$('.chart19').hide();	
	// 					$('.chart20').hide();
	// 					Highcharts.chart('areaspline1', 
	// 					{
	// 						chart: {
	// 							type: 'areaspline',
	// 							zoomType: 'xy'
	// 						},
	// 						title: {
	// 							text: 'Sensor Graph'
	// 						},
	// 						legend: {
	// 							layout: 'vertical',
	// 							align: 'left',
	// 							verticalAlign: 'top',
	// 							x: 150,
	// 							y: 100,
	// 							floating: true,
	// 							borderWidth: 1,
	// 							backgroundColor:
	// 								Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF'
	// 						},
	// 						xAxis: {
	// 							categories: data['hour'],
	// 						},
	// 						yAxis: {
	// 							title: {
	// 								text: 'Values'
	// 							}
	// 						},
	// 						tooltip: {
	// 							shared: true,
	// 							valueSuffix: ' units'
	// 						},
	// 						credits: {
	// 							enabled: false
	// 						},
	// 						plotOptions: {
	// 							areaspline: {
	// 								fillOpacity: 0.5
	// 							}
	// 						},
	// 						series: [{
	// 							name: 'Sensors',
	// 							data: data['value']
	// 						}]
	// 					});
	// 				}
	// 				if(data['chart'] == 'arearangeline')
	// 				{
	// 					$('.chart11').hide();
	// 					$('.chart12').hide();	
	// 					$('.chart13').hide();	
	// 					$('.chart14').hide();	
	// 					$('.chart15').hide();	
	// 					$('.chart16').hide();	
	// 					$('.chart17').show();	
	// 					$('.chart18').hide();	
	// 					$('.chart19').hide();	
	// 					$('.chart20').hide();
	// 					Highcharts.chart('arearangeline1', 
	// 					{
	// 						chart: {
	// 							zoomType: 'xy',
	// 							scrollablePlotArea: {
	// 								minWidth: 600
	// 							}
	// 						},
	// 						title: {
	// 							text: 'Sensor Graph'
	// 						},

	// 						xAxis: {
	// 							type: data['hour'],
	// 						},

	// 						yAxis: {
	// 							title: {
	// 								text: 'Values'
	// 							}
	// 						},

	// 						tooltip: {
	// 							crosshairs: true,
	// 							shared: true,
	// 							valueSuffix: 'Â°C'
	// 						},

	// 						series: [{
	// 							name: 'Sensors',
	// 							data: data['value'],
	// 							zIndex: 1,
	// 							marker: {
	// 								fillColor: 'white',
	// 								lineWidth: 2,
	// 								lineColor: Highcharts.getOptions().colors[0]
	// 							}
	// 						}]
	// 					});
	// 				}
	// 				if(data['chart'] == 'basicbar')
	// 				{
	// 					$('.chart11').hide();
	// 					$('.chart12').hide();	
	// 					$('.chart13').hide();	
	// 					$('.chart14').hide();	
	// 					$('.chart15').hide();	
	// 					$('.chart16').hide();	
	// 					$('.chart17').hide();	
	// 					$('.chart18').show();	
	// 					$('.chart19').hide();	
	// 					$('.chart20').hide();
	// 					Highcharts.chart('basicbar1', 
	// 					{
	// 						chart: {
	// 							type: 'bar',
	// 							zoomType: 'xy'
	// 						},
	// 						title: {
	// 							text: 'Sensor Graph'
	// 						},
	// 						xAxis: {
	// 							categories: data['hour'],
	// 							title: {
	// 								text: 'Days'
	// 							}
	// 						},
	// 						yAxis: {
	// 							min: -1000,
	// 							title: {
	// 								text: 'Values',
	// 								align: 'high'
	// 							},
	// 							labels: {
	// 								overflow: 'justify'
	// 							}
	// 						},
	// 						tooltip: {
	// 							valueSuffix: ''
	// 						},
	// 						plotOptions: {
	// 							bar: {
	// 								dataLabels: {
	// 									enabled: true
	// 								}
	// 							}
	// 						},
	// 						legend: {
	// 							layout: 'vertical',
	// 							align: 'right',
	// 							verticalAlign: 'top',
	// 							x: -40,
	// 							y: 80,
	// 							floating: true,
	// 							borderWidth: 1,
	// 							backgroundColor:
	// 								Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
	// 							shadow: true
	// 						},
	// 						credits: {
	// 							enabled: false
	// 						},
	// 						series: [{
	// 							name: 'Sensors',
	// 							data: data['value']
	// 						}]
	// 					});
	// 				}
	// 				if(data['chart'] == 'stackedbar')
	// 				{
	// 					$('.chart11').hide();
	// 					$('.chart12').hide();	
	// 					$('.chart13').hide();	
	// 					$('.chart14').hide();	
	// 					$('.chart15').hide();	
	// 					$('.chart16').hide();	
	// 					$('.chart17').hide();	
	// 					$('.chart18').hide();	
	// 					$('.chart19').show();	
	// 					$('.chart20').hide();
	// 					Highcharts.chart('stackedbar1', 
	// 					{
	// 						chart: {
	// 							type: 'bar',
	// 							zoomType: 'xy'
	// 						},
	// 						title: {
	// 							text: 'Sensor Graph'
	// 						},
	// 						xAxis: {
	// 							categories: data['hour']
	// 						},
	// 						yAxis: {
	// 							min: -1000,
	// 							title: {
	// 								text: 'Values'
	// 							}
	// 						},
	// 						legend: {
	// 							reversed: true
	// 						},
	// 						plotOptions: {
	// 							series: {
	// 								stacking: 'normal'
	// 							}
	// 						},
	// 						series: [{
	// 							name: 'Sensors',
	// 							data: data['value']
	// 						}]
	// 					});
	// 				}
	// 				if(data['chart'] == 'basiccolumn')
	// 				{
	// 					$('.chart11').hide();
	// 					$('.chart12').hide();	
	// 					$('.chart13').hide();	
	// 					$('.chart14').hide();	
	// 					$('.chart15').hide();	
	// 					$('.chart16').hide();	
	// 					$('.chart17').hide();	
	// 					$('.chart18').hide();	
	// 					$('.chart19').hide();	
	// 					$('.chart20').show();
	// 					Highcharts.chart('basiccolumn1', 
	// 					{
	// 						chart: {
	// 							type: 'column',
	// 							zoomType: 'xy'
	// 						},
	// 						title: {
	// 							text: 'Sensor Graph'
	// 						},
	// 						xAxis: {
	// 							categories: data['hour'],
	// 							crosshair: true
	// 						},
	// 						yAxis: {
	// 							min: -1000,
	// 							title: {
	// 								text: 'Values'
	// 							}
	// 						},
	// 						tooltip: {
	// 							headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
	// 							pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
	// 								'<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
	// 							footerFormat: '</table>',
	// 							shared: true,
	// 							useHTML: true
	// 						},
	// 						plotOptions: {
	// 							column: {
	// 								pointPadding: 0.2,
	// 								borderWidth: 0
	// 							}
	// 						},
	// 						series: [{
	// 							name: 'Sensors',
	// 							data: data['value']
	// 						}]
	// 					});
	// 				}		
	// 			}
	// 		}
	// 	});
	// }
	function getchart2()
	{
		$(".loaderhub").show();
		$.ajax(
		{
			url: "{{ url('/admin/getsensordatachart') }}",
			type: "post",
			data: $('#tmefrm2').serialize(),
			success: function(data1)
			{	
				var jsonData = $.parseJSON(data1);
				var count = jsonData.count;
				var url = "{{ url('/admin/getchartcounthub') }}";
				var docurl = url + "/" + count;
				$.ajax(
				{
					url: docurl,
					type: "GET",
					success: function(datas)
					{
						$(".loaderhub").hide();				
						$('#chartajaxhub').html(datas);							
						var data=[];
						for (k=0;k<count;k++)
						{
							data[k] = new google.visualization.DataTable();
							data[k].addColumn('string', 'Date');
							data[k].addColumn('number', 'Value');
							var title =  jsonData.hub[k] + '/' + jsonData.sensor_id[k];
							var options = 
							{
								title : title,
								vAxis: {title: 'Values'},
								hAxis: {title: 'Date'},
								width: 1200,
								height: 500,
								pieSliceText: 'value',
								explorer: {axis: 'horizontal', keepInBounds: true},
								axes: {
									x: {
										0: {side: 'bottom'} 
									}
								}
							};
							for (var i = 0; i < jsonData.value[k].length; i++) 
							{
								data[k].addRow([jsonData.hour[k][i],parseInt(jsonData.value[k][i])]);					
								if(jsonData.chart[k][i] == 'AreaChart')
								{
									var chart = new google.visualization.AreaChart(document.getElementById('hubchart'+k))
								}
								if(jsonData.chart[k][i] == 'BarChart')
								{
									var chart = new google.visualization.BarChart(document.getElementById('hubchart'+k));
								}
								if(jsonData.chart[k][i] == 'PieChart')
								{
									var chart = new google.visualization.PieChart(document.getElementById('hubchart'+k));
								}
								if(jsonData.chart[k][i] == 'ColumnChart')
								{
									var chart = new google.visualization.ColumnChart(document.getElementById('hubchart'+k));
								}
								if(jsonData.chart[k][i] == 'ComboChart')
								{
									var chart = new google.visualization.ComboChart(document.getElementById('hubchart'+k));
								}
								if(jsonData.chart[k][i] == 'ScatterChart')
								{
									var chart = new google.visualization.ScatterChart(document.getElementById('hubchart'+k));
								}
								if(jsonData.chart[k][i] == 'SteppedAreaChart')
								{
									var chart = new google.visualization.SteppedAreaChart(document.getElementById('hubchart'+k));
								}
								if(jsonData.chart[k][i] == 'Histogram')
								{
									var chart = new google.visualization.Histogram(document.getElementById('hubchart'+k));
								}
								if(jsonData.chart[k][i] == 'LineChart')
								{
									var chart = new google.visualization.LineChart(document.getElementById('hubchart'+k));
								}
							}
							chart.draw(data[k], options);

						}
					}
				});
			}
		});
	}
	function progress_bar_process(percentage, timer)
	{
		alert(percentage);
		$('.progress-bar').css('width', percentage + '%');
		if(percentage > 100)
		{
			clearInterval(timer);
			$('#sample_form')[0].reset();
			$('#process').css('display', 'none');
			$('.progress-bar').css('width', '0%');
			$('#save').attr('disabled', false);
			$('#success_message').html("<div class='alert alert-success'>Data Saved</div>");
			setTimeout(function(){
			$('#success_message').html('');
			}, 5000);
		}
	}
</script>
	<style>
		.loaderhub 
		{
			background: url({{ url('/loader/2.gif') }}) 50% 50% no-repeat rgb(0, 0, 32);
		}
	</style>
@parent
@endsection

