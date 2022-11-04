@extends('layouts.admin')
@section('content')


<style type="text/css">
    .grcolor{
        /*color:green;*/
        color:#1f3db3 !important;
    }
td{
    color:green;
}

</style>
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
								<!--<a class="nav-link euz_tabtex active" data-toggle="tab" href="#senrepor"><i class="fas fa-file-alt"></i> Sensor Time Report</a>-->
								<a class="nav-link euz_tabtex active" data-toggle="tab" href="#senrepor"><i class="fas fa-file-alt"></i> Sensor Time Report</a>
							</li>
							<li class="nav-item">
								<a class="nav-link euz_tabtex" data-toggle="tab" href="#hubreportss"><i class="fas fa-broadcast-tower"></i> Hub Sensor Report</a>
							</li>								
							<li class="nav-item">
								<a id="push" class="pn nav-link euz_tabtex" data-toggle="tab" href="#PushNotification"><i class="fas fa-user-clock"></i> Push Notification 

									<!--<span class="badge badge-danger cmsg">New:<?php //echo $countmsg;?></span></a>-->

<?php if ($countmsg==0){?>

<span style="display:none;float: right;margin-top: 3px;margin-left: 5px;" class="badge cmsg badge-danger">New:<?php echo $countmsg;?></span>
<?php } else {?>
<!--<span style="" class="badge cmsg badge-danger">New:<?php //echo $countmsg;?></span>-->
<span class="badge badge-danger cmsg" style="float: right;margin-top: 3px;margin-left: 5px;">New:<?php echo $countmsg;?></span>



 <?php } ?>


</a>
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
															<select class="form-control agent1" id="agent1" required name="agent">
																<option value="">--select--</option>
																@foreach($agents as $item)
																<option value="{{ @$item->id }}">{{ @$item->fname }} {{ @$item->lname }}</option>
																@endforeach
															</select>	
														</div>
														<div class="form-group col-md-3 py-2 mb-0">
															<label class="euz_b">Gateway Group</label>
															<div class="group">
																<select class="form-control grpfirst" id="group" name="group[]" multiple="multiple" required></select>												
															</div>
														</div>
														<div class="form-group col-md-3 py-2 mb-0">
															<label for="" class="euz_b">Sensor Hub</label>
															<div class="hub">
																<select class="form-control " id="hub" name="hub[]" multiple="multiple" required></select>	
															</div>
														</div>
														<div class="form-group col-md-3 py-2 mb-0">
															<label for="" class="euz_b">Unit</label>
															<select class="form-control unit" id="unit" name="unit" required></select>	
														</div>
														<div class="form-group col-md-5 py-2 mb-0">
															<label for="" class="euz_b">Sensor</label>
															<div class="sensor2">
																<select class="form-control " id="sensor2" name="sensor[]" required multiple="multiple"></select>	
															</div>
														</div>	
														<!--<div class="form-group col-md-3 py-2 mb-0">
															<label for="" class="euz_b">Sensor Chart</label>
															<div class="input-group mb-3">
																<select class="form-control" name="chartnam" required id="chartnam">
																	<option value="">Select</option>
																	<option value="AreaChart">AreaChart</option>
																	<option value="BarChart">BarChart</option>
																	<option value="PieChart">PieChart</option>
																	<option value="ColumnChart">ColumnChart</option>
																	<option value="ComboChart">ComboChart</option>
																	<option value="ScatterChart">ScatterChart</option>
																	<option value="SteppedAreaChart">SteppedAreaChart</option>
																	
																	<option value="LineChart">LineChart</option>
																<select>
															</div>
														</div>	-->													
														<div class="form-group col-md-4 py-2 mb-0">
															<label for="" class="euz_b">Time Stamp</label>
															<select class="form-control" id="tme" name="tme">
																<?php /*?><option>--select--</option><?php */?>
																<option value="day">Today</option>
																<option value="week">Last 7 days</option>
																<option value="month">Last 30 days</option>
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
															<button type='reset' class="res euz_btn_add euz_pointer bg-danger border-0 text-white"><i class="fas fa-redo-alt"></i> Reset</button>
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
															<div class="col-md-5">
																<ul class="nav nav-pills">
																	<li class="nav-item euz_b" style="min-width: 150px;">
																		<a class="nav-link active" data-toggle="pill" href="#sensorlist"><i class="fas fa-table"></i> Report</a>
																	</li>
																	<li class="nav-item euz_b" style="min-width: 150px;">
																		<!--<a onclick="graph()" class="nav-link" data-toggle="pill" href="#cart"><i class="fas fa-chart-line"></i> Graphical Report</a>-->
				
<a  class="nav-link" data-toggle="pill" href="#cart"><i class="fas fa-chart-line"></i> <button disabled="disabled" style="background-color:#d6d6d6;border:none" id="gr" type="button" onclick="graph()" class="euz_btn_add euz_pointer float-right" >Graphical Report</button></a>

													</li>
																</ul>
															</div>
															<div class="col-md-7">
																<div class="input-group float-right w-50">
																	<select name="chartname" class="form-control float-right w-50" id="typegraph">
																		<option>Select</option>
																		<option value="AreaChart">AreaChart</option>
																		<!-- <option value="BarChart">BarChart</option> -->
																		<option value="PieChart">PieChart</option>
																		<option value="ColumnChart">ColumnChart</option>
																		<option value="ComboChart">ComboChart</option>
																		<option value="ScatterChart">ScatterChart</option>
																		<option value="SteppedAreaChart">SteppedAreaChart</option>
																		<option value="LineChart">LineChart</option>
																	</select>
			
<button  class="exportsensorfirst euz_btn_add euz_pointer float-right ml-3" type="submit" id="exportsensor" target="_blank">EXPORT</button>
														<!--<button disabled="disabled" style="background-color:#d6d6d6;border:none" class="euz_btn_add euz_pointer float-right ml-3" type="submit" id="exportsensor" target="_blank">EXPORT</button>-->
																</div>
															</div>														
															
															
														</div>
														
														<div class="tab-pane fade" id="cart">
															<div class="row">
																<!-- <div class="col-md-12">
																	<div id="weeksenrepo" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
																</div> -->
																<div class="col-md-12 mt-3">
																	<div class="">
																		<div class="col-md-12 px-0 chart1">
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
														
														<div class="tab-pane mt-5 active" id="sensorlist">
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
				<input type="hidden" name="currentoffsethub" id="currentoffsethub" value="<?php echo $currentoffsethub;?>"  class="cur" />				<input type="hidden" name="pagenohub" class="pg" id="pagenohub" value="<?php echo $pagenohub;?>" />								<div class="col-md-12 euz_border">
													<div class="row">
														<div class="form-group col-md-3 py-2 mb-0">
															<label for="" class="euz_b">Agent</label>
															<select class="form-control agent2" id="agent2" name="agent" required>
																<option value="">--select--</option>
																@foreach($agents as $item)
																<option value="{{ @$item->id }}">{{ @$item->fname }} {{ @$item->lname }}</option>
																@endforeach
															</select>	
														</div>
														<div class="form-group col-md-4 py-2 mb-0">
															<label class="euz_b">Gateway Group</label>
															<div class="group2">
																<select class="form-control" id="group2" name="group" required></select>												
															</div>
														</div>	
														<div class="form-group col-md-5 py-2 mb-0">
															<label for="" class="euz_b">Sensor Hub</label>
															<div class="hub2">
																<select class="form-control " id="hub2" name="hub" required></select>	
															</div>
														</div>
														<div class="form-group col-md-3 py-2 mb-0">
															<label for="" class="euz_b">Time Stamp</label>
															<select class="form-control" id="tme3" name="tme">
																<?php /*?><option>--select--</option><?php */?>
																<option value="day">Today</option>
																<option value="week">Last 7 days</option>
																<option value="month">Last 30 days</option>
																<option value="one">Custom</option>
															</select>	
														</div>
														<div class="form-group col-md-4 py-2 mb-0 one box3">
															<label for="" class="euz_b">From - To Date</label>
															<div class="input-group date" data-date-format="dd MM yyyy">
																<input type="text" class="form-control" placeholder="dd MM yyyy" id="txt_date2" name="from" required>
																<div class="input-group-addon" style="display:none;">
																	<i class="fa fa-calendar"></i>
																</div>
																<input type="text" class="form-control" placeholder="dd MM yyyy" id="txt_date3" name="to" required>
																<div class="input-group-addon" style="display:none;">
																	<i class="fa fa-calendar"></i>
																</div>
															</div>	
														</div>
													</div>	
													<div class="row bg-light">
														<div class="col-md-6 p-2">
															<button type="button" name="butSen2" id="butSen2" class="euz_btn_add euz_pointer text-white"><i class="fas fa-search"></i> Search</button>
															&nbsp;&nbsp;
															<button type="reset" class="resethub euz_btn_add euz_pointer bg-danger border-0 text-white"><i class="fas fa-redo-alt"></i> Reset</button>
														</div>
														<div class="col-md-6 p-2">
															<button class="euz_btn_add euz_pointer float-right" type="submit" id="exportsensor" target="_blank">EXPORT </button>
														</div>
													</div>
													
												</div>
											</form>
										</div>
									</div></div>									
									<div class="col-md-12 mt-3">
										<div class="row">													
											<div class="col-md-12 px-0">
												<!-- Tab panes -->
												<div class="tab-content euz_border p-3 bg-white">
													<div class="row">				
														<div class="col-md-12">
															<ul class="nav nav-pills">
																<li class="nav-item euz_b" style="min-width: 150px;">
																	<a class="nav-link active" data-toggle="pill" href="#sensordata"><i class="fas fa-table"></i> Report</a>
																</li>
																<li class="nav-item euz_b" style="min-width: 150px;">
																	<a class="nav-link" data-toggle="pill" href="#carthub"><i class="fas fa-chart-line"></i> Graphical Report</a>
																</li>
															</ul>
														</div>	
														
													</div>
													<div class="tab-pane fade" id="carthub">
														<div class="row">
															<div class="col-md-12 mt-3">
																<div class="">
																	<div class="loaderhub" style="display: none; text-align: center;"><img src="{{ url('/loader/2.gif') }}" /></div>
																	<div class="col-md-12 px-0 chart1">
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
											<div class="col-lg-9 col-md-7 p-2">
												<button type="button" class="btn btn-info euz_bt rounded-0" style="margin-top: 40px;" name="butpush" id="butpush"><i class="fas fa-search"></i> Search</button>
												&nbsp;&nbsp;
												<button type="reset" onclick="this.form.reset();" class="btn res btn-danger euz_bt rounded-0" style="margin-top: 40px;"><i class="fas fa-redo-alt"></i> Reset</button>
												
												<button type="button" onclick="updatereadall();" class="btn res btn-dark euz_bt rounded-0 float-right" style="margin-top: 40px;"><i class="fas fa-check"></i> Read All</button>
											</div>
									</div> 
									<div id="msglists" class="msgld px-0 euz_re">
										
									</div>
									<div id="msgload" class="px-0 euz_re">&nbsp;
	 @include('admin/report/pushmsg')

</div>
								</form>
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
<?php
error_reporting(0);
$page="";
$page=$_GET['page'];
if ($page!=''){?>
//$(".pn").addClass('active');
//$('a[href="#PushNotification"]').tab('show');
//$("#PushNotification").show();
$("#push")[0].click();
<?php }?>

$(".exportsensorfirst").attr("disabled",true);
$(".exportsensorfirst").css("background-color","#d6d6d6");
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

$.ajax({
			url: "{{ url('/admin/getallrecords') }}",
			type: "get",
			data:{},
			success: function(data)
			{
				alert(data);
				//$(".loader").hide();
				//$("#table_data2").html(data);
			}
		});







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

	var xhr="";
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
		if($("#agent1").val() == '' || !($("#group").val()) || !($("#hub").val()) || !($("#sensor2").val()) || !($("#unit").val()) || $("#chartnam").val() == '')
		{
		 	$(".loader").hide();

		}
		else
		{
			$(".loader").show();
		}
		$("#butSen").hide();
$("#gr").attr("disabled",true);
$("#gr").css("background-color","#d6d6d6");
$("#exportsensor").attr("disabled",true);
$("#exportsensor").css("background-color","#d6d6d6");
		var selectData = encodeURIComponent($('#sensor2').val());
		var url1 = "{{ url('/admin/getchartcount?val') }}";
		var docurl = url1 + "=" + selectData;
		$.ajax(
		{
			url: docurl,
			type: "GET",
			success: function(datas)
			{
										
				$('#chartajax').html(datas);
/*sumi comm*/
				//getchart();

				//$(".loader").hide();
			}
		});
		$.ajax({
			url: "{{ url('/admin/getsensortime') }}",
			type: "post",
			data: $('#tmefrm').serialize(),
			success: function(data)
			{
				$(".loader").hide();
				$("#table_data2").html(data);
			}
		});
xhr=$.ajax({
			url: "{{ url('/admin/savecharttempdata') }}",
			type: "post",
			data: $('#tmefrm').serialize(),
			success: function(data)
			{
$("#gr").attr("disabled",false);
$("#exportsensor").attr("disabled",false);
$("#exportsensor").css("background-color",'#1a9fd8');
alert("Chart data generated");
				$(".loader").hide();
				
			}
		});






	});
	$("#butSen2").click(function()
	{
		if($("#agent2").val() == '' || !($("#group2").val()) || !($("#hub2").val()))
		{
		 	$(".loader").hide();
		}
		else
		{
			$(".loader").show();
		}
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
				$(".loader").hide();	
				var jsonData = $.parseJSON(data1);
				//alert(jsonData.count);
				var count = jsonData.count;
				alert(count);
				var data=[];
				for (k=0;k<count;k++)
				{
					data[k] = new google.visualization.DataTable();
					data[k].addColumn('string', 'Date');
					data[k].addColumn('number', 'Value');
					var title =  'Hub/SensorID - ' + jsonData.hub[k] + '/' + jsonData.sensor_id[k];
					var unit =  jsonData.unit[k];
					var options = 
					{
						title : title,
						vAxis: {title: unit},
						hAxis: {
							title: 'TIME', 
							direction:-1, slantedText:true, slantedTextAngle:90,
						},
						width: 1200,
						height: 700,
						chartArea: {
						bottom: 100,
						left : 50,
						},
						pieSliceText: 'value',
						//pieHole: 0.4,
						axes: {
							x: {
								0: {side: 'bottom'} 
							}
						}
					};
					if(jsonData.chart == 'PieChart')
					{
						for (var i = 0; i < jsonData.value[k].length; i++) 
						{
							data[k].addRow([jsonData.value[k][i] + ' - ' + jsonData.hour[k][i],parseInt(jsonData.value[k][i])]);
						}
					}
					else
					{
						for (var i = 0; i < jsonData.value[k].length; i++) 
						{
							data[k].addRow([jsonData.hour[k][i],parseInt(jsonData.value[k][i])]);
						}
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
			}
		});
	}
	$('#typegraph').on('change', function () 
	{
		$(".loader").show();
		var val = $('#typegraph').val();
		selectchrt(val);
	});
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(selectchrt);			
	function selectchrt(val)
	{	
		$.ajax(
		{
			url: "{{ url('/admin/getchart2') }}",
			type: "post",
			data: $('#tmefrm').serialize(),
			success: function(data1)
			{	
				$(".loader").hide();
				var jsonData = $.parseJSON(data1);
				var count = jsonData.count;
				var data=[];
				alert('onc'+count);
				for (k=0;k<count;k++)
				{
					data[k] = new google.visualization.DataTable();
					data[k].addColumn('string', 'Date');
					data[k].addColumn('number', 'Value');
					var title =  'Hub/SensorID - ' + jsonData.hub[k] + '/' + jsonData.sensor_id[k];
					var unit =  jsonData.unit[k];
					var options = 
					{
						title : title,

						vAxis: {title: unit},hAxis: {
							title: 'TIME', 
							direction:-1, slantedText:true, slantedTextAngle:90
						},
						hAxis: {
							title: 'TIME', 
							direction:-1, slantedText:true, slantedTextAngle:90,
						},
explorer: { 
            actions: ['dragToZoom', 'rightClickToReset'],
            axis: 'horizontal',
            keepInBounds: true,
            maxZoomIn: 4.0},
						width: 1200,
						height: 700,
						chartArea: {
						top: 28,
						height: '40%',
						},
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
						data[k].addRow([jsonData.hour[k][i],parseInt(jsonData.value[k][i])]);
					}
					if(val == 'AreaChart')
					{
						var chart = new google.visualization.AreaChart(document.getElementById('datalable'+k))
					}
					if(val == 'BarChart')
					{
						var chart = new google.visualization.BarChart(document.getElementById('datalable'+k));
					}
					if(val == 'PieChart')
					{
						var chart = new google.visualization.PieChart(document.getElementById('datalable'+k));
					}
					if(val == 'ColumnChart')
					{
						var chart = new google.visualization.ColumnChart(document.getElementById('datalable'+k));
					}
					if(val == 'ComboChart')
					{
						var chart = new google.visualization.ComboChart(document.getElementById('datalable'+k));
					}
					if(val == 'ScatterChart')
					{
						var chart = new google.visualization.ScatterChart(document.getElementById('datalable'+k));
					}
					if(val == 'SteppedAreaChart')
					{
						var chart = new google.visualization.SteppedAreaChart(document.getElementById('datalable'+k));
					}
					if(val == 'Histogram')
					{
						var chart = new google.visualization.Histogram(document.getElementById('datalable'+k));
					}
					if(val == 'LineChart')
					{
						var chart = new google.visualization.LineChart(document.getElementById('datalable'+k));
					}
					chart.draw(data[k], options);
				}
			}
		});
	}
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
alert("count"+count);
						for (k=0;k<count;k++)
						{
							data[k] = new google.visualization.DataTable();
							data[k].addColumn('string', 'Date');
							data[k].addColumn('number', 'Value');
							var title =  'Hub/SensorID - ' + jsonData.hub[k] + '/' + jsonData.sensor_id[k];
							var unit =  jsonData.unit[k];
							var options = 
							{
								title : title,
								vAxis: {title: unit},
								hAxis: {
									title: 'TIME', 
									direction:-1, slantedText:true, slantedTextAngle:90,
								},
								width: 1200,
								height: 700,
								chartArea: {
								bottom: 200,
								left : 100,
								},
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
								//data[k].addRow([jsonData.hour[k][i],parseInt(jsonData.value[k][i])]);	
								var charttype="";				
								if(jsonData.chart[k][i] == 'AreaChart')
									charttype=jsonData.chart[k][i];
								{
																	data[k].addRow([jsonData.hour[k][i],parseInt(jsonData.value[k][i])]);
									var chart = new google.visualization.AreaChart(document.getElementById('hubchart'+k))
								}
								if(jsonData.chart[k][i] == 'BarChart')
								{
charttype=jsonData.chart[k][i];

									data[k].addRow([jsonData.hour[k][i],parseInt(jsonData.value[k][i])]);
									var chart = new google.visualization.BarChart(document.getElementById('hubchart'+k));
								}
								if(jsonData.chart[k][i] == 'PieChart')
								{
									
									data[k].addRow([jsonData.value[k][i] + ' - ' + jsonData.hour[k][i],parseInt(jsonData.value[k][i])]);
									var chart = new google.visualization.PieChart(document.getElementById('hubchart'+k));
								}
								if(jsonData.chart[k][i] == 'ColumnChart')
								{
									charttype=jsonData.chart[k][i];
									
									data[k].addRow([jsonData.hour[k][i],parseInt(jsonData.value[k][i])]);
									var chart = new google.visualization.ColumnChart(document.getElementById('hubchart'+k));
								}
								if(jsonData.chart[k][i] == 'ComboChart')
								{
									charttype=jsonData.chart[k][i];
									data[k].addRow([jsonData.hour[k][i],parseInt(jsonData.value[k][i])]);
									var chart = new google.visualization.ComboChart(document.getElementById('hubchart'+k));
								}
								if(jsonData.chart[k][i] == 'ScatterChart')
								{
									charttype=jsonData.chart[k][i];
									
									data[k].addRow([jsonData.hour[k][i],parseInt(jsonData.value[k][i])]);

//data[k].addRow([parseInt(jsonData.value[k][i]),jsonData.hour[k][i]]);

									var chart = new google.visualization.ScatterChart(document.getElementById('hubchart'+k));
								}
								if(jsonData.chart[k][i] == 'SteppedAreaChart')
								{
									charttype=jsonData.chart[k][i];
									
									data[k].addRow([jsonData.hour[k][i],parseInt(jsonData.value[k][i])]);
									var chart = new google.visualization.SteppedAreaChart(document.getElementById('hubchart'+k));
								}
								if(jsonData.chart[k][i] == 'Histogram')
								{
									charttype=jsonData.chart[k][i];
									
									data[k].addRow([jsonData.hour[k][i],parseInt(jsonData.value[k][i])]);
									var chart = new google.visualization.Histogram(document.getElementById('hubchart'+k));
								}
								if(jsonData.chart[k][i] == 'LineChart')
								{
									charttype=jsonData.chart[k][i];
									data[k].addRow([jsonData.hour[k][i],parseInt(jsonData.value[k][i])]);
//data[k].addRow([parseInt(jsonData.value[k][i]),jsonData.hour[k][i]]);


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
	$("#butpush").click(function()
	{
		$('#msgload').hide();
		$(".msgld").show();
		$.ajax(
		{
			url: "{{ url('/admin/pushmsg') }}",
			type: "post",
			data: $('#frmPush').serialize(),
			success: function(data)
			{
				$("#msglists").html(data);
			}
		});
	});

$( document ).ready(function() {

/*setInterval(function(){

	
$.ajax(
        {
            url: "{{ url('/admin/getpushnotmsg') }}",
            type: "get",
            data:{msgid:0},
            success: function(data1)
            {

            }});

},3000);*/

/*setInterval(function(){

	
$.ajax(
        {
            url: "{{ url('/admin/getpushnotmsgandor') }}",
            type: "get",
            data:{msgid:0},
            success: function(data1)
            {

            }});

},3000);*/




    	var url = "{{ url('/admin/getpushmsg') }}";
        setInterval(function(){
$('#msgload').load(url);


$.ajax(
        {
            url: "{{ url('/admin/uppushmsgreadflagcount') }}",
            type: "get",
            data:{msgid:0},
            success: function(data)
            {
                $(".cmsg").html("New "+data);



                if (data==0){
                    $(".cmsg").hide();
                     $(".adminmsgc").hide();
                }
                else{
                    
                    $(".cmsg").css("display","block");
                    $(".adminmsgc").css("display","block");
                }
            }});







//$('.msgld').load(url);
}, 20000)
$(".msgld").hide();
    });

$(".res").click(function () 
{
	$("#group").val('default');
	$("#group").selectpicker("refresh");
$("#agent1").val('default');
	$("#agent1").selectpicker("refresh");

$("#hub").val('default');
	$("#hub").selectpicker("refresh");
$("#sensor2").val('default');
	$("#sensor2").selectpicker("refresh");
	xhr.abort();
$.ajax(
        {
            url: "{{ url('/admin/deletetempdata') }}",
             type: "get",
             data:{},
            success: function(data)
             {
				
 $("#butSen").show();
 }});

});
$(".resethub").click(function()
	{
		
$("#group2").val('default');
	$("#group2").selectpicker("refresh");

$("#agent2").val('default');
	$("#agent2").selectpicker("refresh");
$("#hub2").val('default');
	$("#hub2").selectpicker("refresh");




	});


// $(".res").click(function()
// 	{
// 		alert("enres---");
// 		$('#msgload').show();
// 		$(".msgld").html('');
// 		$(".msgld").hide();
		//$('#agent1').empty();

//document.getElementById('tmefrm').reset()

		//$("#agent1")
		//$('#agent1').val('');
		//$('#tmefrm')[0].reset();
		//$('#agent1 option:eq(0)').attr('selected','selected'); 
//$('#agent1').prop('selectedIndex','');
//$('#agent1').selectpicker();
//$("#agent1").multiselect('refresh'); 
//$("#agent1").selectedIndex = -1; 
// $(".grpfirst").html(''); 
// $.ajax(
//         {
//             url: "{{ url('/admin/deletetempdata') }}",
//             type: "get",
//             data:{},
//             success: function(data)
//             {
				
// $("#butSen").show();
// }});

	//});
	function updatereadall()
	{
		var msgid = 'all';
		$('td').removeClass("grcolor");
		$.ajax(
        {
            url: "{{ url('/admin/uppushmsgreadflag') }}",
            type: "get",
            data:{msgid:msgid},
            success: function(data)
            {
				$.ajax(
        		{
					url: "{{ url('/admin/uppushmsgreadflagcount') }}",
					type: "get",
					data:{msgid:msgid},
					success: function(data)
					{
						if (data==0)
						{
							$(".cmsg").hide();
							$(".adminmsgc").hide();
						}
						else
						{
							$(".cmsg").html("New "+data);
							$(".cmsg").css("display","block");
							$(".adminmsgc").css("display","block");
						}
					}
				});
			}
		});
	}


function graph(){
//alert("en");
$("#gr").css("background-color",'#1a9fd8');
$.ajax(
		{
			url: "{{ url('/admin/getchartpage') }}",
			type: "post",
			data: $('#tmefrm').serialize(),
			success: function(data1)
			{	
//alert(data1);
}
});

}

</script>
	<style>
		/* .loaderhub 
		{
			background: url({{ url('/loader/2.gif') }}) 50% 50% no-repeat rgb(0, 0, 32);
		} */
	</style>
	<style>
		.modal-backdrop.show 
		{
			z-index: 0 !important;
			display:none;
		}
	</style>
@parent
@endsection

