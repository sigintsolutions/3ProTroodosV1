@extends('layouts.admin')
@section('content')

<script src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
  	
google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(selectchrtarea);


  </script>
<style type="text/css">
    .grcolor{
        /*color:green;*/
        color:#1f3db3 !important;
    }
td{
    color:green;
}

</style>
<style>
		

	</style>


<script>
//google.charts.load('current', {'packages':['corechart']});</script>


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
																<input type="text" class="form-control txt_date2ag" placeholder="dd MM yyyy" id="" name="from">
																<div class="input-group-addon" style="display:none;">
																	<i class="fa fa-calendar"></i>
																</div>
																<input type="text" class="form-control txt_date3ag" placeholder="dd MM yyyy" id="" name="to">
																<div class="input-group-addon" style="display:none;">
																	<i class="fa fa-calendar"></i>
																</div>
															</div>	
														</div>
													</div>	




													<div class="row bg-light">
														<div class="col-md-12 p-2">

<input type="hidden" name="senscalendar" id="senscalendar" value="0">

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
																		<a class="fe nav-link active" data-toggle="pill" href="#sensorlist"><i class="fas fa-table"></i> Report</a>
																	</li>

<span id="chdtp" style="display:none;" class="blink">Generating Graphical Data.....</span>
																	<li class="nav-item euz_b" style="min-width: 150px;">
																		<!--<a onclick="graph()" class="nav-link" data-toggle="pill" href="#cart"><i class="fas fa-chart-line"></i> Graphical Report</a>-->
				
<!--<a  class="nav-link" data-toggle="pill" href="#cart"><i class="fas fa-chart-line"></i> <button disabled="disabled" style="background-color:#d6d6d6;border:none" id="gr" type="button" onclick="graph()" class="euz_btn_add euz_pointer float-right" >Graphical Report</button></a>-->

<button id="gr" disabled="disabled" class="greport w-100 border-0 nav-link" data-toggle="pill" href="#cart" style="display:none">
<i class="fas fa-chart-line"></i> Graphical Report</button>
</button>


													</li>
																</ul>



															</div>
															<div class="col-md-7">
																<div class="input-group float-right w-50">
																	<select style="display:none" name="chartname" class="form-control float-right w-50" id="typegraph">
																		<option>Select</option>
																		<option value="AreaChart" selected>AreaChart</option>
																		<!-- <option value="BarChart">BarChart</option> -->
																		<!--<option value="PieChart">PieChart</option>-->
																		<option value="ColumnChart">ColumnChart</option>
																		<option value="ComboChart">ComboChart</option>
																		<option value="ScatterChart">ScatterChart</option>
																		<option value="SteppedAreaChart">SteppedAreaChart</option>
																		<option value="LineChart">LineChart</option>
																	</select>
			
<button  class="exportsensorfirst euz_btn_add euz_pointer float-right ml-3" type="submit" id="exportsensor" target="_blank" style="display:none">EXPORT</button>
														<!--<button disabled="disabled" style="background-color:#d6d6d6;border:none" class="euz_btn_add euz_pointer float-right ml-3" type="submit" id="exportsensor" target="_blank">EXPORT</button>-->
																</div>
															</div>														
															
															
														</div>
														
														<div class="tab-pane fade" style="display:none;">




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
														
														<div class="tab-pane mt-5 active sl" id="sensorlist">
															<div id="table_data2">
													@include('admin/report/pagination_data2')
												</div>
														</div>
														
														
														
														
														
														
														
														
	<div id="cart" style="margin-top:15px;">



  <?php
for($i=0;$i<=25;$i++){
?>
<div class="euzscrollbar" style="width:100%;overflow-x:scroll;overflow-y:hidden;scrollbar-color: #cacaca white;margin-bottom:15px;">
<div id="demottty<?php echo $i;?>" class="sensdemo"></div></div>
<?php } ?>





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


<input type="hidden" name="dynamicchartval" id="dynamicchartval"  />


													<input type="hidden" name="currentoffsethub" id="currentoffsethub" value="<?php echo $currentoffsethub;?>"  class="cur" />				
													<input type="hidden" name="pagenohub" class="pg" id="pagenohub" value="<?php echo $pagenohub;?>" />								<div class="col-md-12 euz_border">
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
																<input type="text" class="form-control txt_date2hubag" placeholder="dd MM yyyy" id="txt_date22" name="from">
																<div class="input-group-addon" style="display:none;">
																	<i class="fa fa-calendar"></i>
																</div>
																<input type="text" class="form-control txt_date3hubag" placeholder="dd MM yyyy" id="txt_date33" name="to">
																<div class="input-group-addon" style="display:none;">
																	<i class="fa fa-calendar"></i>
																</div>
															</div>	
														</div>
													</div>	
													<div class="row bg-light">
														<div class="col-md-6 p-2">

<input type="hidden" name="senscalendarhub" id="senscalendarhub" value="0">

															<button type="button" name="butSen2" id="butSen2" class="euz_btn_add euz_pointer text-white"><i class="fas fa-search"></i> Search</button>
															&nbsp;&nbsp;
															<button type="reset" class="resethub euz_btn_add euz_pointer bg-danger border-0 text-white"><i class="fas fa-redo-alt"></i> Reset</button>
														</div>
														<div class="col-md-6 p-2">
															<button class="euz_btn_add euz_pointer float-right" type="submit" id="exportsensor1" target="_blank">EXPORT </button>
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
																	<a id="send" onclick="hidecarthub();" class="nav-link active" data-toggle="pill" href="#sensordata"><i class="fas fa-table"></i> Report</a>
																</li>
																
																<li class="nav-item euz_b" style="min-width: 150px;">
																	<a onclick="showcarthub();" id="chb" class="nav-link" data-toggle="pill" href="#carthub"><i class="fas fa-chart-line"></i> Graphical Report</a>
																</li><span id="chdtphub" style="display:none;" class="blink">Generating Graphical Data.....</span>
															</ul>
														</div>	
														
													</div>




<div class="tab-pane active mt-5 col-md-12" id="sensordata">
														<div id="table_data3"></div>
													</div>


	<div class="tab-pane1 fade1" id="carthub">
														<div class="row">
															<div class="col-md-12 mt-3">
																<div class="">
																	<div class="loaderhub" style="display: none; text-align: center;"><img src="{{ url('/loader/2.gif') }}" /></div>
<div class="loaderhub1" style="display: none; text-align: center;"><img src="{{ url('/loader/2.gif') }}" /></div>
<div class="loaderhub2" style="display: none; text-align: center;"><img src="{{ url('/loader/2.gif') }}" /></div>
<div class="loaderhub0" style="display: none; text-align: center;"><img src="{{ url('/loader/2.gif') }}" /></div>

																	<div class="col-md-12 px-0 chart1">
																		<div id="chartajaxhub"></div>
<div id="chartajaxhubnewsensors"><div id="hubchartnewsensors"></div></div>
<div id="chartajaxhubnewsensors3"><div id="hubchartnewsensors3"></div></div>
<?php
for($i=3;$i<=25;$i++){
?>
<div class="loaderhub<?php echo $i;?>" style="display: none; text-align: center;"><img src="{{ url('/loader/2.gif') }}" /></div>
<?php } ?>

<div id="chartajaxhubdy"><span id="app"></span>														</div>
																</div>
															</div>
														</div>
													</div>
				</div>	


<!---div start-->
									
													<!--<div class="tab-pane active mt-5 col-md-12" id="sensordata">
														<div id="table_data3"></div>
													</div>-->


<!---div end--->







												</div>
											</div>
										</div>
									</div>
								</div>
							<!--</div>
							</div>-->
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
												<button type="reset" onclick="this.form.reset();" class="respush btn res btn-danger euz_bt rounded-0" style="margin-top: 40px;"><i class="fas fa-redo-alt"></i> Reset</button>
												
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
$(".exportsensorfirst").css("border","none");
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
$(document).ready(function()
{
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
	$("#tme3").change(function()
	{
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
	var xhr1="";
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
$("#gr").removeClass("active");
$(".sl").show();

$(".greport").css("display","none");
$(".fe").addClass("active");
$("#chdtp").show();
$(".sensdemo").html('');
		//$("#butSen").hide();
$("#gr").attr("disabled",true);
$("#typegraph").val("AreaChart");
//$('#typegraph option[value="AreaChart"]').attr("selected",true);
$("#exportsensor").attr("disabled",true);
$("#exportsensor").css("background-color","#d6d6d6");
$("#exportsensor").css("border","none");
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

$.ajax(
        {
            url: "{{ url('/admin/deletetempdata') }}",
             type: "get",
             data:{},
            success: function(data)
             {
				
 
 

xhr=$.ajax({
			url: "{{ url('/admin/savecharttempdata') }}",
			type: "post",
			data: $('#tmefrm').serialize(),
			success: function(data)
			{
$("#gr").attr("disabled",false);
$("#exportsensor").attr("disabled",false);
$("#exportsensor").css("background-color",'#1a9fd8');
$("#exportsensor").css("display","block");
$("#typegraph").css("display","block");
$(".greport").css("display","block");

$(".loader").show();
		
var val ='AreaChart';
		
google.charts.load('current', {packages: ['corechart']});
   
google.charts.setOnLoadCallback(selectchrtarea);
				
				
			}
		});




}});




	});

function selectchrtarea()
	{	
		var val="AreaChart";
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
				//alert(jsonData.countval);
				if (count==0){
					$("#datalable0").html("Sorry No Data");
				}
				var data=[];
				for (k=0;k<count;k++)
				{
					data[k] = new google.visualization.DataTable();
				
		var hubagent=jsonData.hub[k];
		var hubag=hubagent.split("/");
		var hub=hubag[0];
		var agent=hubag[1];	
		var group=jsonData.grouphub[k];		
					//var title =  'Hub/SensorID - ' + jsonData.hub[k] + '/' + jsonData.sensor_id[k];


var title =  'Agent :  ' + agent + '  |  Group :  ' + group + '  | Hub :  '+hub +'  |  Sensor :  '+jsonData.sensor_id[k];

					var unit =  jsonData.unit[k];
					
						/*var options = 
							{
								title : title,is3D: true,titleTextStyle: {fontSize:15},
backgroundColor: {
        fill: '#e8f8ff',
     },
								vAxis: {title:unit,titleTextStyle: {fontSize:15},textStyle : {
fontSize:15} },
								hAxis: {
									title: 'TIME',titleTextStyle: {fontSize:15}, 
									direction:-1, slantedText:true, slantedTextAngle:90,
									textStyle : {
fontSize:15}
								},
								explorer: {
            
actions: ['dragToZoom', 'rightClickToReset'],
            axis: 'horizontal',
            keepInBounds: true,
            maxZoomIn: 4.0},
          
								width:'100%',
								height: 650,
								chartArea: {
								
								bottom: 200,
								left :"1%",width:"100%",right:"2%"


								},
								
tooltip: { textStyle: { fontSize: 15 },isHtml: true,ignoreBounds:true,  trigger: 'focus' 

							}


,
								
								pieSliceText: 'value',
								
								axes: {
									x: {
										0: {side: 'bottom'} 
									}
								}
							};*/	
					
					if(val == 'AreaChart')
					{
						
						data[k].addColumn('string', 'Date');
					data[k].addColumn('number', 'Value');
						
						

var nameArr = jsonData.value[k][0].split(',');
var nameArr1 = jsonData.hour[k][0].split(',');						
if (nameArr.length>0){
	var m=0;
	var dt="";
for(m=0;m<nameArr.length;m++){
	

data[k].addRow([nameArr1[m],parseInt(nameArr[m])]);

}

$("#cart").show();
						
if (nameArr.length>0){

alert(nameArr.length);
if(nameArr.length < 800)
						{

var options = 
							{
								title : title,is3D: true,titleTextStyle: {fontSize:15},
backgroundColor: {
        fill: '#e8f8ff',
     },
legend: { position: 'right',maxLines: 1,
      textStyle: {
        fontSize: 12
      }}

,

								vAxis: {title:unit,titleTextStyle: {fontSize:15},textStyle : {
fontSize:15} },
								hAxis: {
									title: 'TIME',titleTextStyle: {fontSize:15}, 
									direction:-1, slantedText:true, slantedTextAngle:90,
									textStyle : {
fontSize:15}
								},
								explorer: {
            
actions: ['dragToZoom', 'rightClickToReset'],
            axis: 'horizontal',
            keepInBounds: true,
            maxZoomIn: 4.0},
          
								width:'100%',
								height: 650,
								chartArea: {
								
								bottom: 200,
								left :"1%",width:"100%",right:"2%"


								},
								
tooltip: { textStyle: { fontSize: 15 },isHtml: true,ignoreBounds:true,  trigger: 'focus' 

							}


,
								
								pieSliceText: 'value',
								
								axes: {
									x: {
										0: {side: 'bottom'} 
									}
								}
							};



							$(".sensdemo").width("5000px");
						}
	else if (nameArr.length < 1000)
						{
							var options = 
							{
								title : title,is3D: true,titleTextStyle: {fontSize:15},
backgroundColor: {
        fill: '#e8f8ff',
     },
legend: { position: 'right',
maxLines: 1,
      textStyle: {
        fontSize: 12
      }

}

,

								vAxis: {title:unit,titleTextStyle: {fontSize:15},textStyle : {
fontSize:15} },
								hAxis: {
									title: 'TIME',titleTextStyle: {fontSize:15}, 
									direction:-1, slantedText:true, slantedTextAngle:90,
									textStyle : {
fontSize:15}
								},
								explorer: {
            
actions: ['dragToZoom', 'rightClickToReset'],
            axis: 'horizontal',
            keepInBounds: true,
            maxZoomIn: 4.0},
          
								width:'100%',
								height: 650,
								chartArea: {
								
								bottom: 200,
								left :"0.5%",width:"100%",right:"0.5%"


								},
								
tooltip: { textStyle: { fontSize: 15 },isHtml: true,ignoreBounds:true,  trigger: 'focus' 

							}


,
								
								pieSliceText: 'value',
								
								axes: {
									x: {
										0: {side: 'bottom'} 
									}
								}
							};
							$(".sensdemo").width("17000px");
						}
						else if(nameArr.length < 1200)
						{
							var options = 
							{
								title : title,is3D: true,titleTextStyle: {fontSize:15},
backgroundColor: {
        fill: '#e8f8ff',
     },
legend: { position: 'right',
maxLines: 1,
      textStyle: {
        fontSize: 12
      }

}

,
								vAxis: {title:unit,titleTextStyle: {fontSize:15},textStyle : {
fontSize:15} },
								hAxis: {
									title: 'TIME',titleTextStyle: {fontSize:15}, 
									direction:-1, slantedText:true, slantedTextAngle:90,
									textStyle : {
fontSize:15}
								},
								explorer: {
            
actions: ['dragToZoom', 'rightClickToReset'],
            axis: 'horizontal',
            keepInBounds: true,
            maxZoomIn: 4.0},
          
								width:'100%',
								height: 650,
								chartArea: {
								
								bottom: 200,
								left :"1%",width:"100%",right:"1%"


								},
								
tooltip: { textStyle: { fontSize: 15 },isHtml: true,ignoreBounds:true,  trigger: 'focus' 

							}


,
								
								pieSliceText: 'value',
								
								axes: {
									x: {
										0: {side: 'bottom'} 
									}
								}
							};
							$(".sensdemo").width("19000px");
						}
						else if(nameArr.length < 1400)
						{
							$(".sensdemo").width("21000px");
							var options = 
							{
								title : title,is3D: true,titleTextStyle: {fontSize:15},
backgroundColor: {
        fill: '#e8f8ff',
     },
legend: { position: 'right',
maxLines: 1,
      textStyle: {
        fontSize: 12
      }

}

,
								vAxis: {title:unit,titleTextStyle: {fontSize:15},textStyle : {
fontSize:15} },
								hAxis: {
									title: 'TIME',titleTextStyle: {fontSize:15}, 
									direction:-1, slantedText:true, slantedTextAngle:90,
									textStyle : {
fontSize:15}
								},
								explorer: {
            
actions: ['dragToZoom', 'rightClickToReset'],
            axis: 'horizontal',
            keepInBounds: true,
            maxZoomIn: 4.0},
          
								width:'100%',
								height: 650,
								chartArea: {
								
								bottom: 200,
								left :"1%",width:"100%",right:"1%"


								},
								
tooltip: { textStyle: { fontSize: 15 },isHtml: true,ignoreBounds:true,  trigger: 'focus' 

							}


,
								
								pieSliceText: 'value',
								
								axes: {
									x: {
										0: {side: 'bottom'} 
									}
								}
							};
						}
						else if(nameArr.length < 1600)
						{
							$(".sensdemo").width("23000px");
							var options = 
							{
								title : title,is3D: true,titleTextStyle: {fontSize:15},
backgroundColor: {
        fill: '#e8f8ff',
     },
legend: { position: 'right',
maxLines: 1,
      textStyle: {
        fontSize: 12
      }

}

,
								vAxis: {title:unit,titleTextStyle: {fontSize:15},textStyle : {
fontSize:15} },
								hAxis: {
									title: 'TIME',titleTextStyle: {fontSize:15}, 
									direction:-1, slantedText:true, slantedTextAngle:90,
									textStyle : {
fontSize:15}
								},
								explorer: {
            
actions: ['dragToZoom', 'rightClickToReset'],
            axis: 'horizontal',
            keepInBounds: true,
            maxZoomIn: 4.0},
          
								width:'100%',
								height: 650,
								chartArea: {
								
								bottom: 200,
								left :"1%",width:"100%",right:"1%"


								},
								
tooltip: { textStyle: { fontSize: 15 },isHtml: true,ignoreBounds:true,  trigger: 'focus' 

							}


,
								
								pieSliceText: 'value',
								
								axes: {
									x: {
										0: {side: 'bottom'} 
									}
								}
							};
						}
						else if(nameArr.length < 1800)
						{
							$(".sensdemo").width("25000px");
							var options = 
							{
								title : title,is3D: true,titleTextStyle: {fontSize:15},
backgroundColor: {
        fill: '#e8f8ff',
     },
legend: { position: 'right',
maxLines: 1,
      textStyle: {
        fontSize: 12
      }

}

,
								vAxis: {title:unit,titleTextStyle: {fontSize:15},textStyle : {
fontSize:15} },
								hAxis: {
									title: 'TIME',titleTextStyle: {fontSize:15}, 
									direction:-1, slantedText:true, slantedTextAngle:90,
									textStyle : {
fontSize:15}
								},
								explorer: {
            
actions: ['dragToZoom', 'rightClickToReset'],
            axis: 'horizontal',
            keepInBounds: true,
            maxZoomIn: 4.0},
          
								width:'100%',
								height: 650,
								chartArea: {
								
								bottom: 200,
								left :"1%",width:"100%",right:"1%"


								},
								
tooltip: { textStyle: { fontSize: 15 },isHtml: true,ignoreBounds:true,  trigger: 'focus' 

							}


,
								
								pieSliceText: 'value',
								
								axes: {
									x: {
										0: {side: 'bottom'} 
									}
								}
							};
						}									
						else
						{
							$(".sensdemo").width("30000px");
							var options = 
							{
								title : title,is3D: true,titleTextStyle: {fontSize:15},
backgroundColor: {
        fill: '#e8f8ff',
     },
legend: { position: 'right',
maxLines: 1,
      textStyle: {
        fontSize: 12
      }

}

,
								vAxis: {title:unit,titleTextStyle: {fontSize:15},textStyle : {
fontSize:15} },
								hAxis: {
									title: 'TIME',titleTextStyle: {fontSize:15}, 
									direction:-1, slantedText:true, slantedTextAngle:90,
									textStyle : {
fontSize:15}
								},
								explorer: {
            
actions: ['dragToZoom', 'rightClickToReset'],
            axis: 'horizontal',
            keepInBounds: true,
            maxZoomIn: 4.0},
          
								width:'100%',
								height: 650,
								chartArea: {
								
								bottom: 200,
								left :"1%",width:"100%",right:"1%"


								},
								
tooltip: { textStyle: { fontSize: 15 },isHtml: true,ignoreBounds:true,  trigger: 'focus' 

							}


,
								
								pieSliceText: 'value',
								
								axes: {
									x: {
										0: {side: 'bottom'} 
									}
								}
							};
						}


}


						var chart = new google.visualization.AreaChart(document.getElementById('demottty'+k))
						chart.draw(data[k], options);
						
						
					}
			




				}
			}
$("#cart").hide();
$("#chdtp").hide();
//alert("Chart data generated-");
			}
		});
	}



     



function selectchrtarea_19_8_2020()
	{	
		var val="AreaChart";
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
				//alert(count);
				if (count==0){
					$("#datalable0").html("Sorry No Data");
				}
				var data=[];
				for (k=0;k<count;k++)
				{
					data[k] = new google.visualization.DataTable();
					
					var title =  'Hub/SensorID - ' + jsonData.hub[k] + '/' + jsonData.sensor_id[k];
					var unit =  jsonData.unit[k];
					/*var options = 
							{
								title : title,titleTextStyle: {fontSize:15},

								vAxis: {title:unit,titleTextStyle: {fontSize:15},textStyle : {
fontSize:15} },
								hAxis: {
									title: 'TIME',titleTextStyle: {fontSize:15}, 
									direction:-1, slantedText:true, slantedTextAngle:90,
									textStyle : {
fontSize:15}
								},

								width:5000,
								height:550,
								

							};*/
						var options = 
							{
								title : title,titleTextStyle: {fontSize:15},

								vAxis: {title:unit,titleTextStyle: {fontSize:15},textStyle : {
fontSize:15} },
								hAxis: {
									title: 'TIME',titleTextStyle: {fontSize:15}, 
									direction:-1, slantedText:true, slantedTextAngle:90,
									textStyle : {
fontSize:15}
								},
								explorer: {
            
actions: ['dragToZoom', 'rightClickToReset'],
            axis: 'horizontal',
            keepInBounds: true,
            maxZoomIn: 4.0},
          



        
								/*width: 1200,*/
								/*width:5000,*/
								width:'100%',
								height: 650,
								chartArea: {
								/*bottom: 200,*/
								bottom: 200,
								left :"2%",width:"96%",right:"2%"


								},
								/*tooltip: { textStyle: { fontSize: 15 } },*/
tooltip: { textStyle: { fontSize: 15 },isHtml: true,ignoreBounds:true,  trigger: 'focus' 

							}


,
								
								pieSliceText: 'value',
								
								axes: {
									x: {
										0: {side: 'bottom'} 
									}
								}
							};	
					
					if(val == 'AreaChart')
					{
						//alert("area1");
						data[k].addColumn('string', 'Date');
					data[k].addColumn('number', 'Value');
						//data[k].addColumn({type: 'string', role: 'tooltip'});
						for (var i = 0; i < jsonData.value[k].length; i++) 
					{
						//data[k].addRow([jsonData.hour[k][i],parseInt(jsonData.value[k][i]),jsonData.value[k][i]]);
data[k].addRow([jsonData.hour[k][i],parseInt(jsonData.value[k][i])]);

					}
						//var chart = new google.visualization.AreaChart(document.getElementById('demo'+k))
						$("#cart").show();
						var chart = new google.visualization.AreaChart(document.getElementById('demottty'+k))
						chart.draw(data[k], options);
						//$("#demo"+k).html("hai");
					}
										
				}
$("#cart").hide();
alert("Chart data generated");


			}
		});
	}

//}, 100);


function showcarthub(){
$("#carthub").show();
$("#sensordata").hide();

}

function hidecarthub(){
$("#carthub").hide();
$("#sensordata").show();

}





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
		$('#chartajaxhub').html('');
		$("#chdtphub").show();
		$("#chb").removeClass('active');
		$("#send").addClass('active');
		$("#sensordata").show();


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
$("#carthub").show();
google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(getchart2);
//getchart2();


/*function charthubdisplay(){
	$(".loaderhub1").show();
var xhr1=$.ajax({
			url: "{{ url('/admin/savecharttempdatahub') }}",
			type: "post",
			data: $('#tmefrm2').serialize(),
			success: function(data)
			{


getchart2();
$(".loaderhub1").hide();
alert("Hub Chart data generated");
				
				
			}
		});

}*/




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
				$('#sensor2').on('change', function (e) 
				{
					var count = 3;
					// set limit to SELECT tag
					if (count > 0) {
						$('#sensor2').data('max-options', count)
					}					
					// here you can remove extra values from SELECT
					var values = $('#sensor2').val(); 
					if (values.length > count) {
						// how many items we need to remove
						var toRemove = values.length - count;
						$('#sensor2 option:selected').each(function (index, item) {
						if (toRemove) {
							var option = $(item);
							option.prop('selected', false);
							toRemove--;
						}
						});
					}
					$('#sensor2').selectpicker('refresh');
				});
				//$('#sensor2').selectpicker();
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
				//alert(count);
				
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
						width: '100%',
						height: 550,
						chartArea: {
						bottom: 100,
						left : 50,
						},
						pieSliceText: 'value',
						
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
		google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(selectchrt);
		//selectchrt(val);
	});
	function selectchrt()
	{	
		var val = $('#typegraph').val();
		
		$.ajax(
		{
			url: "{{ url('/admin/getchart2') }}",
			type: "post",
			data: $('#tmefrm').serialize(),
			success: function(data1)
			{	
				$(".loader").hide();
				$("#chdtp").hide();
				var jsonData = $.parseJSON(data1);
				var count = jsonData.count;
				var data=[];
				//alert('onc'+count);
				if (count==0){
					$("#datalable0").html("Sorry No Data");
				}

/*if (count==0){
					$('#chartajax').html("Sorry No data");
				}*/
				for (k=0;k<count;k++)
				{
					data[k] = new google.visualization.DataTable();
					//data[k].addColumn('string', 'Date');
					//data[k].addColumn('number', 'Value');
					//var title =  'Hub/SensorID - ' + jsonData.hub[k] + '/' + jsonData.sensor_id[k];

var hubagent=jsonData.hub[k];
		var hubag=hubagent.split("/");
		var hub=hubag[0];
		var agent=hubag[1];	
		var group=jsonData.grouphub[k];		
					//var title =  'Hub/SensorID - ' + jsonData.hub[k] + '/' + jsonData.sensor_id[k];


//var title =  'Agent : ' + agent + ' Group :' + group + ' Hub :'+hub +' Sensor :'+jsonData.sensor_id[k];
var title =  'Agent :  ' + agent + '  |  Group :  ' + group + '  | Hub :  '+hub +'  |  Sensor :  '+jsonData.sensor_id[k];


					var unit =  jsonData.unit[k];
					

var options = 
							{
								title : title,titleTextStyle: {fontSize:15},backgroundColor: {
        fill: '#e8f8ff',
     },is3D: true,

								vAxis: {title:unit,titleTextStyle: {fontSize:15},textStyle : {
fontSize:15} },
								hAxis: {
									title: 'TIME',titleTextStyle: {fontSize:15}, 
									direction:-1, slantedText:true, slantedTextAngle:90,
									textStyle : {
fontSize:15}
								},
								explorer: {
            
actions: ['dragToZoom', 'rightClickToReset'],
            axis: 'horizontal',
            keepInBounds: true,
            maxZoomIn: 4.0},
          


width:'100%',
								height: 650,
        
								
								chartArea: {
								/*bottom: 200,*/
								bottom: 200,
								left :"2%",width:"96%",right:"2%"


								},
								/*tooltip: { textStyle: { fontSize: 15 } },*/
tooltip: { textStyle: { fontSize: 15 },isHtml: true,ignoreBounds:true,  trigger: 'focus' 

							}


,
								
								pieSliceText: 'value',
								
								axes: {
									x: {
										0: {side: 'bottom'} 
									}
								}
							};

					/*for (var i = 0; i < jsonData.value[k].length; i++) 
					{
						data[k].addRow([jsonData.hour[k][i],parseInt(jsonData.value[k][i])]);
					}*/
					/*if(jsonData.countval < 800)
					{
						$(".sensdemo").width("5000px");
					}
					else
					{
						$(".sensdemo").width("20000px");
					}*/
					if(val == 'AreaChart')
					{
						//alert("area");
						//var chart = new google.visualization.AreaChart(document.getElementById('datalable'+k))

//var chart = new google.visualization.AreaChart(document.getElementById('demottty'+k));


/*new code st*/
data[k].addColumn('string', 'Date');
					data[k].addColumn('number', 'Value');
var nameArr = jsonData.value[k][0].split(',');
var nameArr1 = jsonData.hour[k][0].split(',');						
if (nameArr.length>0){
	var m=0;
	var dt="";
for(m=0;m<nameArr.length;m++){
	

data[k].addRow([nameArr1[m],parseInt(nameArr[m])]);

}
if (nameArr.length>0){

if(nameArr.length < 800)
						{
							$(".sensdemo").width("5000px");
						}
	else if (nameArr.length < 1000)
						{
							$(".sensdemo").width("17000px");
						}
						else if(nameArr.length < 1200)
						{
							$(".sensdemo").width("19000px");
						}
						else if(nameArr.length < 1400)
						{
							$(".sensdemo").width("21000px");
						}
						else if(nameArr.length < 1600)
						{
							$(".sensdemo").width("23000px");
						}
						else if(nameArr.length < 1800)
						{
							$(".sensdemo").width("25000px");
						}									
						else
						{
							$(".sensdemo").width("30000px");
						}



}
$("#cart").show();
						var chart = new google.visualization.AreaChart(document.getElementById('demottty'+k))
						chart.draw(data[k], options);
						
						
					}







/*new code end*/




					}
					
					
					if(val == 'ColumnChart')
					{
						//alert("ColumnChart");
						//var chart = new google.visualization.ColumnChart(document.getElementById('demottty'+k));
						//var chart = new google.visualization.ColumnChart(document.getElementById('datalable'+k));
/*new code st*/
data[k].addColumn('string', 'Date');
					data[k].addColumn('number', 'Value');
var nameArr = jsonData.value[k][0].split(',');
var nameArr1 = jsonData.hour[k][0].split(',');						
if (nameArr.length>0){
	var m=0;
	var dt="";
for(m=0;m<nameArr.length;m++){
	

data[k].addRow([nameArr1[m],parseInt(nameArr[m])]);

}
if (nameArr.length>0){

if(nameArr.length < 800)
						{
							$(".sensdemo").width("5000px");
						}
	else if (nameArr.length < 1000)
						{
							$(".sensdemo").width("17000px");
						}
						else if(nameArr.length < 1200)
						{
							$(".sensdemo").width("19000px");
						}
						else if(nameArr.length < 1400)
						{
							$(".sensdemo").width("21000px");
						}
						else if(nameArr.length < 1600)
						{
							$(".sensdemo").width("23000px");
						}
						else if(nameArr.length < 1800)
						{
							$(".sensdemo").width("25000px");
						}									
						else
						{
							$(".sensdemo").width("30000px");
						}




}

$("#cart").show();
						var chart = new google.visualization.ColumnChart(document.getElementById('demottty'+k))
						chart.draw(data[k], options);
						
						
					}

/*st end*/




					}
					if(val == 'ComboChart')
					{
						//alert("combo");
						//var chart = new google.visualization.ComboChart(document.getElementById('datalable'+k));
						//var chart = new google.visualization.ColumnChart(document.getElementById('demottty'+k));

/*new code st*/
data[k].addColumn('string', 'Date');
					data[k].addColumn('number', 'Value');
var nameArr = jsonData.value[k][0].split(',');
var nameArr1 = jsonData.hour[k][0].split(',');						
if (nameArr.length>0){
	var m=0;
	var dt="";
for(m=0;m<nameArr.length;m++){
	

data[k].addRow([nameArr1[m],parseInt(nameArr[m])]);

}

$("#cart").show();
						/*if(jsonData.countval < 1500)
						{
							$(".sensdemo").width("5000px");
						}
						else
						{
							$(".sensdemo").width("10000px");
						}*/
						if (nameArr.length>0){

if(nameArr.length < 800)
						{
							$(".sensdemo").width("5000px");
						}
	else if (nameArr.length < 1000)
						{
							$(".sensdemo").width("17000px");
						}
						else if(nameArr.length < 1200)
						{
							$(".sensdemo").width("19000px");
						}
						else if(nameArr.length < 1400)
						{
							$(".sensdemo").width("21000px");
						}
						else if(nameArr.length < 1600)
						{
							$(".sensdemo").width("23000px");
						}
						else if(nameArr.length < 1800)
						{
							$(".sensdemo").width("25000px");
						}									
						else
						{
							$(".sensdemo").width("30000px");
						}



}
						var chart = new google.visualization.ComboChart(document.getElementById('demottty'+k))
						chart.draw(data[k], options);
						
						
					}

/*st end*/







					}
					if(val == 'ScatterChart')
					{
						//var chart = new google.visualization.ScatterChart(document.getElementById('datalable'+k));


//var chart = new google.visualization.ScatterChart(document.getElementById('demottty'+k));


/*new code st*/
data[k].addColumn('string', 'Date');
					data[k].addColumn('number', 'Value');
var nameArr = jsonData.value[k][0].split(',');
var nameArr1 = jsonData.hour[k][0].split(',');						
if (nameArr.length>0){
	var m=0;
	var dt="";
for(m=0;m<nameArr.length;m++){
	

data[k].addRow([nameArr1[m],parseInt(nameArr[m])]);

}

if (nameArr.length>0){

if(nameArr.length < 800)
						{
							$(".sensdemo").width("5000px");
						}
	else if (nameArr.length < 1000)
						{
							$(".sensdemo").width("17000px");
						}
						else if(nameArr.length < 1200)
						{
							$(".sensdemo").width("19000px");
						}
						else if(nameArr.length < 1400)
						{
							$(".sensdemo").width("21000px");
						}
						else if(nameArr.length < 1600)
						{
							$(".sensdemo").width("23000px");
						}
						else if(nameArr.length < 1800)
						{
							$(".sensdemo").width("25000px");
						}									
						else
						{
							$(".sensdemo").width("30000px");
						}


}

$("#cart").show();
						var chart = new google.visualization.ScatterChart(document.getElementById('demottty'+k))
						chart.draw(data[k], options);
						
						
					}

/*st end*/





					}
					if(val == 'SteppedAreaChart')
					{
						//alert("sa");
						//var chart = new google.visualization.SteppedAreaChart(document.getElementById('datalable'+k));

//var chart = new google.visualization.SteppedAreaChart(document.getElementById('demottty');

/*new code st*/
data[k].addColumn('string', 'Date');
					data[k].addColumn('number', 'Value');
var nameArr = jsonData.value[k][0].split(',');
var nameArr1 = jsonData.hour[k][0].split(',');						
if (nameArr.length>0){
	var m=0;
	var dt="";
for(m=0;m<nameArr.length;m++){
	

data[k].addRow([nameArr1[m],parseInt(nameArr[m])]);

}
if (nameArr.length>0){

if(nameArr.length < 800)
						{
							$(".sensdemo").width("5000px");
						}
	else if (nameArr.length < 1000)
						{
							$(".sensdemo").width("17000px");
						}
						else if(nameArr.length < 1200)
						{
							$(".sensdemo").width("19000px");
						}
						else if(nameArr.length < 1400)
						{
							$(".sensdemo").width("21000px");
						}
						else if(nameArr.length < 1600)
						{
							$(".sensdemo").width("23000px");
						}
						else if(nameArr.length < 1800)
						{
							$(".sensdemo").width("25000px");
						}									
						else
						{
							$(".sensdemo").width("30000px");
						}




}
$("#cart").show();
						var chart = new google.visualization.SteppedAreaChart(document.getElementById('demottty'+k))
						chart.draw(data[k], options);
						
						
					}

/*st end*/

					}
					
					if(val == 'LineChart')
					{
						//alert("line");
						//var chart = new google.visualization.LineChart(document.getElementById('datalable'+k));


//var chart = new google.visualization.LineChart(document.getElementById('demottty'+k));

/*new code st*/
data[k].addColumn('string', 'Date');
					data[k].addColumn('number', 'Value');
var nameArr = jsonData.value[k][0].split(',');
var nameArr1 = jsonData.hour[k][0].split(',');						
if (nameArr.length>0){
	var m=0;
	var dt="";
for(m=0;m<nameArr.length;m++){
	

data[k].addRow([nameArr1[m],parseInt(nameArr[m])]);

}
if (nameArr.length>0){

if(nameArr.length < 800)
						{
							$(".sensdemo").width("5000px");
						}
	else if (nameArr.length < 1000)
						{
							$(".sensdemo").width("17000px");
						}
						else if(nameArr.length < 1200)
						{
							$(".sensdemo").width("19000px");
						}
						else if(nameArr.length < 1400)
						{
							$(".sensdemo").width("21000px");
						}
						else if(nameArr.length < 1600)
						{
							$(".sensdemo").width("23000px");
						}
						else if(nameArr.length < 1800)
						{
							$(".sensdemo").width("25000px");
						}									
						else
						{
							$(".sensdemo").width("30000px");
						}



}
$("#cart").show();						
						var chart = new google.visualization.LineChart(document.getElementById('demottty'+k))
						chart.draw(data[k], options);
						
						
					}

/*new code end*/




					}
$("#cart").show();

					//chart.draw(data[k], options);
				}
			}
		});
	}	


	
	function selectchrt_20_8_2020()
	{	
		var val = $('#typegraph').val();
		
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
				//alert('onc'+count);
				if (count==0){
					$("#datalable0").html("Sorry No Data");
				}

/*if (count==0){
					$('#chartajax').html("Sorry No data");
				}*/
				for (k=0;k<count;k++)
				{
					data[k] = new google.visualization.DataTable();
					data[k].addColumn('string', 'Date');
					data[k].addColumn('number', 'Value');
					var title =  'Hub/SensorID - ' + jsonData.hub[k] + '/' + jsonData.sensor_id[k];
					var unit =  jsonData.unit[k];
					

var options = 
							{
								title : title,titleTextStyle: {fontSize:15},

								vAxis: {title:unit,titleTextStyle: {fontSize:15},textStyle : {
fontSize:15} },
								hAxis: {
									title: 'TIME',titleTextStyle: {fontSize:15}, 
									direction:-1, slantedText:true, slantedTextAngle:90,
									textStyle : {
fontSize:15}
								},
								explorer: {
            
actions: ['dragToZoom', 'rightClickToReset'],
            axis: 'horizontal',
            keepInBounds: true,
            maxZoomIn: 4.0},
          


width:'100%',
								height: 650,
        
								
								chartArea: {
								/*bottom: 200,*/
								bottom: 200,
								left :"2%",width:"96%",right:"2%"


								},
								/*tooltip: { textStyle: { fontSize: 15 } },*/
tooltip: { textStyle: { fontSize: 15 },isHtml: true,ignoreBounds:true,  trigger: 'focus' 

							}


,
								
								pieSliceText: 'value',
								
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
						//var chart = new google.visualization.AreaChart(document.getElementById('datalable'+k))

var chart = new google.visualization.AreaChart(document.getElementById('demottty'+k));

					}
					if(val == 'BarChart')
					{
						//var chart = new google.visualization.BarChart(document.getElementById('datalable'+k));

						var chart = new google.visualization.BarChart(document.getElementById('demottty'+k));
					}
					if(val == 'PieChart')
					{

//data[k].addRow([jsonData.hour[k][i],parseInt(jsonData.value[k][i])]);
//data[k].addRow([jsonData.value[k][i],parseInt(jsonData.hour[k][i])]);
data[k].addRow([jsonData.value[k][i] + ' - ' + jsonData.hour[k][i],parseInt(jsonData.value[k][i])]);

						//var chart = new google.visualization.PieChart(document.getElementById('datalable'+k));

var chart = new google.visualization.PieChart(document.getElementById('demottty'+k));

					}
					if(val == 'ColumnChart')
					{
						//alert("ColumnChart");
						var chart = new google.visualization.ColumnChart(document.getElementById('demottty'+k));
						//var chart = new google.visualization.ColumnChart(document.getElementById('datalable'+k));
					}
					if(val == 'ComboChart')
					{
						//var chart = new google.visualization.ComboChart(document.getElementById('datalable'+k));
						var chart = new google.visualization.ColumnChart(document.getElementById('demottty'+k));
					}
					if(val == 'ScatterChart')
					{
						//var chart = new google.visualization.ScatterChart(document.getElementById('datalable'+k));


var chart = new google.visualization.ScatterChart(document.getElementById('demottty'+k));



					}
					if(val == 'SteppedAreaChart')
					{
						//var chart = new google.visualization.SteppedAreaChart(document.getElementById('datalable'+k));

var chart = new google.visualization.SteppedAreaChart(document.getElementById('demottty'+k));

					}
					if(val == 'Histogram')
					{
						//var chart = new google.visualization.Histogram(document.getElementById('datalable'+k));

var chart = new google.visualization.Histogram(document.getElementById('demottty'+k));

					}
					if(val == 'LineChart')
					{
						//var chart = new google.visualization.LineChart(document.getElementById('datalable'+k));


var chart = new google.visualization.LineChart(document.getElementById('demottty'+k));

					}
$("#cart").show();
					chart.draw(data[k], options);
				}
			}
		});
	}
	function getchart2_san()
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
						//alert("count"+count);
						for (k=0;k<count;k++)
						{
							//alert(k);
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

//alert(k+"k"+jsonData.value[k].length);

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
		//alert(jsonData.chart[k][i]);							
									data[k].addRow([jsonData.hour[k][i],parseInt(jsonData.value[k][i])]);
									var chart = new google.visualization.ColumnChart(document.getElementById('hubchart'+k));
								}
								if(jsonData.chart[k][i] == 'ComboChart')
								{
									charttype=jsonData.chart[k][i];
		//alert(jsonData.chart[k][i]);	

								data[k].addRow([jsonData.hour[k][i],parseInt(jsonData.value[k][i])]);
									var chart = new google.visualization.ComboChart(document.getElementById('hubchart'+k));
								}
								if(jsonData.chart[k][i] == 'ScatterChart')
								{
									charttype=jsonData.chart[k][i];
		//alert(jsonData.chart[k][i]);							
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

//google.charts.load('current', {'packages':['corechart']});
	//google.charts.setOnLoadCallback(getchart2);
	function getchart2()
	{
		//$(".loaderhub").show();
		$.ajax(
		{
			url: "{{ url('/admin/getsensordatachart') }}",
			type: "post",
			data: $('#tmefrm2').serialize(),
			success: function(data1)
			{	
				//alert(data1);
				//alert("firstchart");
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
						//$(".loaderhub").hide();				
						$('#chartajaxhub').html(datas);							
						var data=[];
					//alert("---count"+count);
					if ((count==0) || (jsonData.msg==0)){
						$('#chartajaxhub').html("Sorry No Data");
							$(".loaderhub").hide();
					}
						for (k=0;k<count;k++)
						{
							var len=jsonData.value[k][0];
							
							data[k] = new google.visualization.DataTable();
							//if (len!=''){
							
							data[k].addColumn('string', 'Date');
							data[k].addColumn('number', 'Value');
							var title =  'Hub/SensorID - ' + jsonData.hub[k] + '/' + jsonData.sensor_id[k];
							
							var unit =  jsonData.unit[k];
							var options = 
							{
								title : title,titleTextStyle: {fontSize:15},backgroundColor: {
        fill: '#e8f8ff',
     },

								vAxis: {title:unit,titleTextStyle: {fontSize:15},textStyle : {
fontSize:15} },
								hAxis: {
									title: 'TIME',titleTextStyle: {fontSize:15}, 
									direction:-1, slantedText:true, slantedTextAngle:90,
									textStyle : {
fontSize:15}
								},
								explorer: {
            
actions: ['dragToZoom', 'rightClickToReset'],
            axis: 'horizontal',
            keepInBounds: true,
            maxZoomIn: 4.0},
          



        width:'100%',
								/*width: 1200,*/
								/*width:5000,*/
								height: 650,
								chartArea: {
								/*bottom: 200,*/
								bottom: 200,
								left :"2%",width:"96%",right:"2%"


								},
								pieSliceText: 'value',
								/*tooltip: { textStyle: { fontSize: 15 } },*/
								tooltip: { textStyle: { fontSize: 15 },isHtml: true,ignoreBounds:true,  trigger: 'focus' 

							}


,
								
								axes: {
									x: {
										0: {side: 'bottom'} 
									}
								}
							};
//}
								var charttype="";
								//charttype=				
								//if(jsonData.chart[k][i] == 'AreaChart')
									//charttype=jsonData.chart[k][i];
									//if(k==0)
/*if(jsonData.chart[k]=='AreaChart')

								{
									
var nameArr = jsonData.value[k][0].split(',');
var nameArr1 = jsonData.hour[k][0].split(',');						
if (nameArr.length>0){
	var m=0;
	var dt="";
for(m=0;m<nameArr.length;m++){
	

data[k].addRow([nameArr1[m],parseInt(nameArr[m])]);

}
	var chart = new google.visualization.AreaChart(document.getElementById('hubchart'+k));
chart.draw(data[k], options);
}

								}*/

if(jsonData.chart[k]=='AreaChart')

								{
									
var nameArr = jsonData.value[k][0].split(',');
var nameArr1 = jsonData.hour[k][0].split(',');						
if (nameArr.length>0){
	var m=0;
	var dt="";
for(m=0;m<nameArr.length;m++){
	
//data[k].addRow([new Date(2020,09,01),parseInt(nameArr[m])]);
data[k].addRow([nameArr1[m],parseInt(nameArr[m])]);

}

$("#carthub").show();

	var chart = new google.visualization.AreaChart(document.getElementById('hubchart'+k));
chart.draw(data[k], options);
}

								}







if(jsonData.chart[k] == 'ColumnChart')
								{
									//charttype=jsonData.chart[k][i];
									
									//data[k].addRow([jsonData.hour[k][i],parseInt(jsonData.value[k][i])]);

var nameArrcolmn = jsonData.value[k][0].split(',');
//alert("namearr---"+nameArr[0]);

var nameArr1colmn = jsonData.hour[k][0].split(',');
//alert("namearr1---"+nameArr1[0]);



									
if (nameArrcolmn.length>0){
	var m=0;
for(m=0;m<nameArrcolmn.length;m++){
	//alert(nameArr1[m],nameArr[m]);
//data[k].addRow([nameArr1[0],parseInt(nameArr[0])]);
data[k].addRow([nameArr1colmn[m],parseInt(nameArrcolmn[m])]);
}

$("#carthub").show();

	var chart = new google.visualization.ColumnChart(document.getElementById('hubchart'+k));

									chart.draw(data[k], options);
}

								}
								if(jsonData.chart[k] == 'ComboChart')
								{
									//charttype=jsonData.chart[k][i];
			

								//data[k].addRow([jsonData.hour[k][i],parseInt(jsonData.value[k][i])]);

var nameArrcomb = jsonData.value[k][0].split(',');
//alert("namearr---"+nameArr[0]);

var nameArr1comb = jsonData.hour[k][0].split(',');
//alert("namearr1---"+nameArr1[0]);



									

if (nameArrcomb.length>0){

var m=0;
for(m=0;m<nameArrcomb.length;m++){
	//alert(nameArr1[m],nameArr[m]);
//data[k].addRow([nameArr1[0],parseInt(nameArr[0])]);
data[k].addRow([nameArr1comb[m],parseInt(nameArrcomb[m])]);
}


	var chart = new google.visualization.ComboChart(document.getElementById('hubchart'+k));

									chart.draw(data[k], options);
}

								}
								if(jsonData.chart[k] == 'ScatterChart')
								{
									//charttype=jsonData.chart[k][i];
									
									//data[k].addRow([jsonData.hour[k][i],parseInt(jsonData.value[k][i])]);
var nameArrscat = jsonData.value[k][0].split(',');
//alert("namearr---"+nameArr[0]);

var nameArr1scat = jsonData.hour[k][0].split(',');
//alert("namearr1---"+nameArr1[0]);






									

if (nameArrscat.length>0){
	var m=0;
for(m=0;m<nameArrscat.length;m++){
	//alert(nameArr1[m],nameArr[m]);
//data[k].addRow([nameArr1[0],parseInt(nameArr[0])]);
data[k].addRow([nameArr1scat[m],parseInt(nameArrscat[m])]);
}
$("#carthub").show();
var chart = new google.visualization.ScatterChart(document.getElementById('hubchart'+k));


									chart.draw(data[k], options);
}

								}




if(jsonData.chart[k]=='SteppedAreaChart')

								{
									//alert("aaa");
//data[k].addRow([jsonData.hour[k][i],parseInt(jsonData.value[k][i])]);
var nameArrstep = jsonData.value[k][0].split(',');
//alert("namearr---"+nameArr[0]);

var nameArr1step = jsonData.hour[k][0].split(',');
//alert("namearr1---"+nameArr1[0]);
var m=0;


if (nameArrstep.length>0){
	for(m=0;m<nameArrstep.length;m++){
	
data[k].addRow([nameArr1step[m],parseInt(nameArrstep[m])]);
}
$("#carthub").show();
	var chart = new google.visualization.SteppedAreaChart(document.getElementById('hubchart'+k));
chart.draw(data[k], options);
}

}





if(jsonData.chart[k]=='LineChart')
								//if (k==1)
								{
									//alert("ennnn---");
									//charttype=jsonData.chart[k][i];
									//data[k].addRow([jsonData.hour[k][i],parseInt(jsonData.value[k][i])]);

var nameArrline = jsonData.value[k][0].split(',');
//alert("namearrline---"+nameArrline[0]);

var nameArr1line = jsonData.hour[k][0].split(',');
//alert("namearr1line---"+nameArr1line[0]);


									
if (nameArrline.length>0){
var m=0;
for(m=0;m<nameArrline.length;m++){
	//alert(nameArr1line[m],nameArrline[m]);
//data[k].addRow([nameArr1[0],parseInt(nameArr[0])]);
data[k].addRow([nameArr1line[m],parseInt(nameArrline[m])]);
}
$("#carthub").show();
var chart = new google.visualization.LineChart(document.getElementById('hubchart'+k));

chart.draw(data[k], options);

}
								}
							//}

							//$("#carthub").hide();
							//$(".loaderhub").hide();

$("#carthub").hide();
//alert("Chart Data generated");

						}

//$(".loaderhub").hide();
$("#chdtphub").hide();
//alert("Chart Data generated");
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

$(".respush").click(function()
	{
		//alert('enter');
		$("#msglists").html('');
		$('#msgload').hide();
		$(".msgld").show();
		$.ajax(
		{
			url: "{{ url('/admin/pushmsgreset') }}",
			type: "post",
			data: $('#frmPush').serialize(),
			success: function(data)
			{
				$("#msglists").html(data);
			}
		});
	});




$( document ).ready(function() {





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
	$("#senscalendar").val(1);
	$("#group").val('default');
	$("#group").selectpicker("refresh");
$("#agent1").val('default');
	$("#agent1").selectpicker("refresh");
$('#chartajax').html("");
$("#hub").val('default');
	$("#hub").selectpicker("refresh");
$("#sensor2").val('default');
	$("#sensor2").selectpicker("refresh");
	$(".exportsensorfirst").css("border","none");
$(".exportsensorfirst").attr("disabled",true);
$(".exportsensorfirst").css("background-color","#d6d6d6");
	$("#table_data2").html('');
	$("#exportsensor").css("display","none");
$("#typegraph").css("display","none");
$(".greport").css("display","none");
$(".fe").addClass("active");
$("#sensorlist").show();
$(".sensdemo").html('');	

if ($("#senscalendar").val()==1)
	{




		$('.txt_date2ag').val("").datepicker("update");
		$('.txt_date3ag').val("").datepicker("update");
		$('.txt_date2ag').datepicker('destroy');
		$(".txt_date2ag").datepicker(
		{
			todayBtn:  1,
			autoclose: true,
		}).on('changeDate', function (selected) 
		{
			var minDate = new Date(selected.date.valueOf());
			$('.txt_date3ag').datepicker('setStartDate', minDate);
			var newDate = new Date(selected.date);
			newDate.setDate(newDate.getDate() + 29);
			$('.txt_date3ag').datepicker('setEndDate', newDate);
		});
   }

$('#tme').find("option:selected").each(function(){
            var optionValue = $('#tme').attr("value");
			
            if(optionValue == 'one')
			{
              
				$(".box").show();
            } 
			else
			{
                $(".box").hide();
            }
        });

xhr.abort();
/*$.ajax(
        {
            url: "{{ url('/admin/deletetempdata') }}",
             type: "get",
             data:{},
            success: function(data)
             {
				
 //$("#butSen").show();
 }});*/





});

$(".fe").click(function(){
//alert("table");
$(".sl").show();
$("#cart").hide();
$(".fe").addClass("active");
$("#gr").removeClass("active");	
});
$("#gr").click(function(){
$("#gr").addClass("active");
$(".fe").removeClass("active");
$(".sl").hide();
$("#cart").show();	
});
$(".resethub").click(function()
	{
		$("#senscalendarhub").val(1);
$("#group2").val('default');
	$("#group2").selectpicker("refresh");

$("#agent2").val('default');
	$("#agent2").selectpicker("refresh");
$("#hub2").val('default');
	$("#hub2").selectpicker("refresh");
$("#sensordata").html('');
$('#chartajaxhub').html('');

var senscalendarhubres=$("#senscalendarhub").val();
if (senscalendarhubres==1){

//$('.txt_date2hubag, .txt_date3hubag').datepicker({ format: "dd MM yyyy" });
$('.txt_date2hubag').val("").datepicker("update");
		$('.txt_date3hubag').val("").datepicker("update");
		$('.txt_date2hubag').datepicker('destroy');
		$(".txt_date2hubag").datepicker(
		{
			todayBtn:  1,
			autoclose: true,
		}).on('changeDate', function (selected) 
		{
			var minDate = new Date(selected.date.valueOf());
			$('.txt_date3hubag').datepicker('setStartDate', minDate);
			var newDate = new Date(selected.date);
			newDate.setDate(newDate.getDate() + 29);
			$('.txt_date3hubag').datepicker('setEndDate', newDate);
		});

}
$("#senscalendarhub").val(0);

$('#tme3').find("option:selected").each(function(){
            var optionValue = $('#tme3').attr("value");
			
            if(optionValue == 'one')
			{
               
				$(".box3").show();
            } 
			else
			{
                $(".box3").hide();
            }
        });


	});


$( document ).ready(function() {
$.ajax(
        {
            url: "{{ url('/admin/getpushmsgload') }}",
            type: "get",
            data:{},
            success: function(data)
            {
$('#msgload').html(data);

            }
            });
});
$( document ).ready(function() {
$.ajax(
        {
            url: "{{ url('/admin/uppushmsgreadflagcount') }}",
            type: "get",
            data:{msgid:0},
            success: function(data)
            {
            	//alert(data);
                $(".cmsg").html("New-"+data);

if (data==0){
                    $(".cmsg").hide();
                     $(".adminmsgc").hide();
                }
                else{
                    
                    $(".cmsg").css("display","block");
                    $(".adminmsgc").css("display","block");
                }

//alert("enter");
            }});

});






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





$(document).ready(function(){

var senscalendarhub=$("#senscalendarhub").val();
if (senscalendarhub==0){
   $(".txt_date2hubag").datepicker({
        todayBtn:  1,
        autoclose: true,
         //clearBtn: true,
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('.txt_date3hubag').datepicker('setStartDate', minDate);
		var newDate = new Date(selected.date);
		newDate.setDate(newDate.getDate() + 29);
		$('.txt_date3hubag').datepicker('setEndDate', newDate);
    });

    $(".txt_date3hubag").datepicker()
        .on('changeDate', function (selected) {
            var maxDate = new Date(selected.date.valueOf());
            $('.txt_date2hubag').datepicker('setEndDate', maxDate);
        });

}
	var currsenscalval=$("#senscalendar").val();
	//alert("change---"+currsenscalval);
	if (currsenscalval==0){
$(".txt_date2ag").datepicker({
        todayBtn:  1,
        autoclose: true,
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('.txt_date3ag').datepicker('setStartDate', minDate);
		var newDate = new Date(selected.date);
		newDate.setDate(newDate.getDate() + 29);
		$('.txt_date3ag').datepicker('setEndDate', newDate);
    });

    $(".txt_date3ag").datepicker()
        .on('changeDate', function (selected) {
            var maxDate = new Date(selected.date.valueOf());
            $('.txt_date2ag').datepicker('setEndDate', maxDate);
        });


}




});





</script>



<style>
.euzscrollbar::-webkit-scrollbar {
  height: 10px;
}
.euzscrollbar::-webkit-scrollbar-track {
  background: #ffffff;  
}
.euzscrollbar::-webkit-scrollbar-thumb {
  background-color: #c1c1c1; 
  border-radius: 10px;    
}
</style>
	
	<style>




		.modal-backdrop.show 
		{
			z-index: 0 !important;
			display:none;
		}

.notify {
background-color: #f00 !important;
color: #fff;
}

		
	</style>
@parent
@endsection

