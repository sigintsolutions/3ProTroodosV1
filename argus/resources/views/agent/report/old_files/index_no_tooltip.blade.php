@extends('layouts.admin')
@section('content')

<style type="text/css">
    .grcolor{
        /*color:green;*/
        color:#1f3db3 !important;
    }


</style>
<div class="loader" style="display:none"></div>
<?php @$segment_posts = request()->segment(3); 
//dd("hai");

?>
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
							<a class="nav-link euz_tabtex <?php if($segment_posts==1) { ?>active<?php } ?>" data-toggle="tab" href="#PushNotification"><i class="fas fa-user-clock"></i> Push Notification

<?php if ($countmsgagent==0){?>

<span style="display:none;float: right;margin-top: 3px;margin-left: 5px;" class="badge cmsgagent badge-danger">New:<?php echo $countmsgagent;?></span>
<?php } else {?>
<span class="badge cmsgagent badge-danger" style="float: right;margin-top: 3px;margin-left: 5px;">New:<?php echo $countmsgagent;?></span>
 <?php } ?>
							 

							</a>
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
													<!--<div class="form-group col-md-3 py-2 mb-0">
														<label for="" class="euz_b">Sensor Chart</label>
														<div class="input-group mb-3">
															<select class="form-control" name="chartnam" required>
																<option>Select Chart</option>
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
													</div>-->
													<div class="form-group col-md-3 py-2 mb-0">
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

														<button type="button" class="btn btn-info euz_bt rounded-0" id="butSen" name="butSen"><i class="fas fa-search"></i> Search</button>
														&nbsp;&nbsp;
														<button type='reset' class="res btn btn-danger euz_bt rounded-0"><i class="fas fa-redo-alt"></i> Reset</button>
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
																	<a class="nav-link" data-toggle="pill" href="#cart"><i class="fas fa-chart-line"></i> Graphical Report</a>
																</li>
															</ul>
														</div>	
														<div class="col-md-7">
															<div class="input-group float-right w-50">
																<select name="chartname" required="" class="form-control float-right w-50" id="typegraph">
																	<option>Select</option>
																	<option value="AreaChart">AreaChart</option>
																	<!--<option value="BarChart">BarChart</option>-->
																	<option value="PieChart">PieChart</option>
																	<option value="ColumnChart">ColumnChart</option>
																	<option value="ComboChart">ComboChart</option>
																	<option value="ScatterChart">ScatterChart</option>
																	<option value="SteppedAreaChart">SteppedAreaChart</option>
																	<option value="LineChart">LineChart</option>
																</select>
																<button class="euz_btn_add euz_pointer float-right ml-3" disabled="disabled" style="background-color:#d6d6d6;border:none" type="submit" id="exportsensor" target="_blank">EXPORT</button>
															</div>
														</div>													
													</div>												
													<div class="tab-pane" id="cart">
														<div class="row">
															<div class="col-md-12 mt-3">
																<div class="">
																	<div class="col-md-12 px-0 chart1">
																		<div id="chartajax"></div>
																	</div>																	
																</div>
															</div>
														</div>
													</div>
													<div class="tab-pane active mt-5" id="sensorlist">
														<div id="table_data2">
															@include('agent/report/pagination_data2')
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
										<form method="post" action="{{ url('/agent/exporthub') }}" name="tmefrm2" id="tmefrm2">
										{{ csrf_field() }}

<input type="hidden" name="currentoffsethub" id="currentoffsethub" value="<?php echo $currentoffsethub;?>"  class="cur" />				<input type="hidden" name="pagenohub" class="pg" id="pagenohub" value="<?php echo $pagenohub;?>" />			

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
													<select class="form-control group2" name="group" id="group2">
														<option value="">-Select-</option>
														@foreach($groups as $item)
														<option value="{{ @$item->id }}">{{ @$item->name }}</option>
														@endforeach
													</select>	
												</div>
												<div class="form-group col-md-4 py-2 mb-0">
													<label for="" class="euz_b">Sensor Hub</label>
													<div class="hub2">
														<select class="form-control " id="hub2" name="hub" ></select>	
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
														<option value="day">Today</option>
														<option value="week">Last 7 days</option>
														<option value="month">Last 30 days</option>
														<option value="one">Custom</option>
													</select>	
												</div>
												<div class="form-group col-md-4 py-2 mb-0 one box3">
													<label for="" class="euz_b">From - To Date</label>
													<div class="input-group date " data-date-format="dd MM yyyy">
														<input type="text" class="form-control txt_date2hubag fihub" placeholder="dd MM yyyy" id="txt_date22" name="from">
														<div class="input-group-addon" style="display:none;">
															<i class="fa fa-calendar"></i>
														</div>
														<input type="text" class="form-control txt_date3hubag sechub" placeholder="dd MM yyyy" id="txt_date33" name="to">
														<div class="input-group-addon" style="display:none;">
															<i class="fa fa-calendar"></i>
														</div>
													</div>	
												</div>
											</div>	
											<div class="row bg-light">
												<div class="col-md-6 p-2">

<input type="hidden" name="senscalendarhub" id="senscalendarhub" value="0">

													<button type="button" name="butSen2" id="butSen2" class="btn btn-info euz_bt rounded-0"><i class="fas fa-search"></i> Search</button>
													&nbsp;&nbsp;
													<button type="reset" class="btn resethub btn-danger euz_bt rounded-0"><i class="fas fa-redo-alt"></i> Reset</button>
												</div>
												<div class="col-md-6 p-2">
													<button class="euz_btn_add euz_pointer float-right"  style="" type="submit" id="exportsensor" target="_blank">EXPORT</button>									
												</div>
											</div>
											
										</div>
										
										</form>
									</div>
								</div>
								<div class="col-md-12 mt-3">
									<div class="row">													
										<div class="col-md-12">
											<!-- Tab panes -->
											<div class="tab-content euz_border p-3 bg-white">															
												<div class="row">														
													<div class="col-md-12">
														<ul class="nav nav-pills">
															<li class="nav-item euz_b" style="min-width: 150px;">
																<a class="nav-link active" data-toggle="pill" href="#sensordata"><i class="fas fa-table"></i> Report</a>
															</li>
															<li class="nav-item euz_b" style="min-width: 150px;">
																<!--<a class="nav-link" data-toggle="pill" href="#carthub"><i class="fas fa-chart-line"></i>
																<button disabled="disabled" style="background-color:#d6d6d6;border:none" id="gr" type="button" onclick="graph()" class="euz_btn_add euz_pointer float-right" > Graphical Report</button>
																</a>-->
																<button id="gr" onclick="graph()" class="w-100 border-0 nav-link" data-toggle="pill" href="#carthub">
																	<i class="fas fa-chart-line"></i> Graphical Report</button>
																</button>
															</li>
														</ul>
													</div>														
												</div>
												<div class="tab-pane fade" id="carthub">
													<div class="row">
														<div class="col-md-12 mt-3">
															<div class="">
																<div class="col-md-12 px-0 chart1">
																	<div class="loaderhub" style="display: none; text-align: center;"><img src="{{ url('/loader/2.gif') }}" /></div>
<div class="loaderhub1" style="display: none; text-align: center;"><img src="{{ url('/loader/2.gif') }}" /></div>
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
									<div class="row ">
										<div class="col-md-12 p-2">
											<button type="button" class="btn btn-info euz_bt rounded-0" style="margin-top: 40px;" name="butpush" id="butpush"><i class="fas fa-search"></i> Search</button>
											&nbsp;&nbsp;
											<button type="reset" onclick="this.form.reset();" class="btn respush res btn-danger euz_bt rounded-0" style="margin-top: 40px;"><i class="fas fa-redo-alt"></i> Reset</button>
											
											<button type="button" onclick="updatereadall();" class="btn res btn-dark euz_bt rounded-0 float-right" style="margin-top: 40px;"><i class="fas fa-check"></i> Read All</button>
											
										</div>
									</div>
								</div> 
								<div id="msglists" class="msgld px-0 euz_re">
								</div>

<div id="msgload" class="px-0 euz_re">&nbsp; @include('agent/report/pushmsg')</div>

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
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
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
	var xhr="";
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


		if(!($("#group").val()) || !($("#hub").val()) || !($("#sensor2").val()) || !($("#unit").val()) || $("#chartnam").val() == '')
		{
		 	$(".loader").hide();
		}
		else
		{
			$(".loader").show();
		}
$("#butSen").hide();
$("#gr").attr("disabled",true);
//$("#gr").css("background-color","#d6d6d6");
$("#exportsensor").attr("disabled",true);
$("#exportsensor").css("background-color","#d6d6d6");

		var selectData = encodeURIComponent($('#sensor2').val());
		var url1 = "{{ url('/agent/getchartcount?val') }}";
		var docurl = url1 + "=" + selectData;
		$.ajax(
		{
			url: docurl,
			type: "GET",
			success: function(datas)
			{
									
				$('#chartajax').html(datas);
				//getchart();
			}
		});
		$.ajax({
			url: "{{ url('/agent/getsensortime') }}",
			type: "post",
			data: $('#tmefrm').serialize(),
			success: function(data)
			{
				//alert(data);
				$("#table_data2").html(data);
$(".loader").hide();
			}
		});

xhr=$.ajax({
			url: "{{ url('/agent/savecharttempdata') }}",
			type: "post",
			data: $('#tmefrm').serialize(),
			success: function(data)
			{
$("#gr").attr("disabled",false);
$("#exportsensor").attr("disabled",false);
$("#exportsensor").css("background-color",'#1a9fd8');
alert("Chart Data generated");
				$(".loader").hide();
				
			}
		});





	});
	$("#butSen2").click(function()
	{
		$('#chartajaxhub').html('');
		//$("#gr").attr("disabled",false);
		//$("#exportsensor").attr("disabled",false);
		if(!($("#group2").val()) || !($("#hub2").val()))
		{
		 	$(".loader").hide();
		}
		else
		{
			$(".loader").show();
		}		
		$.ajax(
		{
			url: "{{ url('/agent/getsensordata') }}",
			type: "post",
			data: $('#tmefrm2').serialize(),
			success: function(data)
			{
				//alert(data);
				$("#sensordata").html(data);
				$(".loader").hide();
			}
		});
		//charthubdisplay();
		getchart2();
		
	});
	$("#butSen3").click(function()
	{
		getchart3();
	});

$(".resethub").click(function()
	{
		
		$("#senscalendarhub").val(1);
$("#group2").val('default');
	$("#group2").selectpicker("refresh");


$("#hub2").val('default');
	$("#hub2").selectpicker("refresh");

$("#sensordata").html('');
$('#chartajaxhub').html('');

var senscalendarhubres=$("#senscalendarhub").val();
if (senscalendarhubres==1){

$('.txt_date2hubag, .txt_date3hubag').datepicker({ format: "dd MM yyyy" });
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
//$(".fihub").datepicker('setDate', new Date());
//$(".sechub").datepicker('setDate', new Date());

//$('.txt_date2hubag').val('kkkk');
/*var d = new Date();
           var currMonth = d.getMonth();
           var currYear = d.getFullYear();
           var startDate = new Date(currYear, currMonth, 1);

           $(".txt_date2hubag").datepicker();
           $(".txt_date2hubag").datepicker("setDate", startDate);
           
           $( ".txt_date2hubag" ).datepicker( "option", "disabled", false );
var d1 = new Date();
           var currMonth = d1.getMonth();
           var currYear = d1.getFullYear();
           var startDate = new Date(currYear, currMonth, 1);

           $(".txt_date3hubag").datepicker();
           $(".txt_date3hubag").datepicker("setDate", startDate);
            $( ".txt_date3hubag" ).datepicker( "option", "disabled", false );*/
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


$(".respush").click(function()
	{
		//alert('enter');
		$("#msglists").html('');
		$('#msgload').hide();
		$(".msgld").show();
		$.ajax(
		{
			url: "{{ url('/agent/pushmsgreset') }}",
			type: "post",
			data: $('#frmPush').serialize(),
			success: function(data)
			{
				$("#msglists").html(data);
			}
		});
	});









	$("#butpush").click(function()
	{
		//alert();
		$('#msgload').hide();
		$(".msgld").show();
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
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(getchart);
	function getchart()
	{
		$.ajax(
		{
			url: "{{ url('/agent/getchart2') }}",
			type: "post",
			data: $('#tmefrm').serialize(),
			//dataType:'JSON',
			success: function(data1)
			{		
				$(".loader").hide();
				var jsonData = $.parseJSON(data1);
				//alert(jsonData.count);
				var count = jsonData.count;
				var data=[];
				for (k=0;k<count;k++)
				{
					data[k] = new google.visualization.DataTable();
					data[k].addColumn('string', 'Date');
					data[k].addColumn('number', 'Value');
					//var title =  jsonData.hub[k] + '/' + jsonData.sensor_id[k];
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
			url: "{{ url('/agent/getchart2') }}",
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
					data[k].addColumn('string', 'Date');
					data[k].addColumn('number', 'Value');
					//var title =  jsonData.hub[k] + '/' + jsonData.sensor_id[k];
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
          



        
								/*width: 1200,*/
								width:5000,
								height: 750,
								chartArea: {
								/*bottom: 200,*/
								bottom: 200,
								left :"2%",width:"96%",right:"2%"


								},
								pieSliceText: 'value',
								
								axes: {
									x: {
										0: {side: 'bottom'} 
									}
								}
							};
					/*var options = 
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
					};*/
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
	/*function getchart2()
	{
		$(".loaderhub").show();
		$.ajax(
		{
			url: "{{ url('/agent/getsensordatachart') }}",
			type: "post",
			data: $('#tmefrm2').serialize(),
			success: function(data1)
			{	
				var jsonData = $.parseJSON(data1);
				var count = jsonData.count;
				var url = "{{ url('/agent/getchartcounthub') }}";
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
							//var title =  jsonData.hub[k] + '/' + jsonData.sensor_id[k];
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
								if(jsonData.chart[k][i] == 'PieChart')
								{				
									data[k].addRow([jsonData.value[k][i] + ' - ' + jsonData.hour[k][i],parseInt(jsonData.value[k][i])]);									
								}
								else
								{
									data[k].addRow([jsonData.hour[k][i],parseInt(jsonData.value[k][i])]);
								}					
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
	}*/

function getchart2()
	{
		$(".loaderhub").show();
		$.ajax(
		{
			url: "{{ url('/agent/getsensordatachart') }}",
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
								width:5000,
								height: 750,
								chartArea: {
								/*bottom: 200,*/
								bottom: 200,
								left :"2%",width:"96%",right:"2%"


								},
								pieSliceText: 'value',
								
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
var chart = new google.visualization.LineChart(document.getElementById('hubchart'+k));

chart.draw(data[k], options);

}
								}
							//}
							$(".loaderhub").hide();

						}

//$(".loaderhub").hide();

					}
				});
			}
		});
	}





	function getchart2_11_8_2020()
	{
		$(".loaderhub").show();
		$.ajax(
		{
			url: "{{ url('/agent/getsensordatachart') }}",
			type: "post",
			data: $('#tmefrm2').serialize(),
			success: function(data1)
			{	
				$(".loaderhub").hide();
				//alert(data1);
				//alert("firstchart");
				var jsonData = $.parseJSON(data1);
				var count = jsonData.count;
				var url = "{{ url('/agent/getchartcounthub') }}";
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
					if (count==0){
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
if(jsonData.chart[k]=='AreaChart')

								{
									//alert("aaa");
//data[k].addRow([jsonData.hour[k][i],parseInt(jsonData.value[k][i])]);
var nameArr = jsonData.value[k][0].split(',');
//alert("namearr---"+nameArr[0]);

var nameArr1 = jsonData.hour[k][0].split(',');
//alert("namearr1---"+nameArr1[0]);


									
if (nameArr.length>0){
	var m=0;
for(m=0;m<nameArr.length;m++){
	//alert(nameArr1[m],nameArr[m]);
//data[k].addRow([nameArr1[0],parseInt(nameArr[0])]);
data[k].addRow([nameArr1[m],parseInt(nameArr[m])]);
}
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
var chart = new google.visualization.LineChart(document.getElementById('hubchart'+k));

chart.draw(data[k], options);
}
								}
							//}

						}

//$(".loaderhub").hide();

					}
				});
			}
		});
	}





    $( document ).ready(function() {
//alert("push");
    	var url = "{{ url('/agent/getpushmsg') }}";
        setInterval(function(){
$('#msgload').load(url);
//$('.msgld').load(url);
$.ajax(
        {
            url: "{{ url('/agent/uppushmsgreadflagcount') }}",
            type: "get",
            data:{msgid:0},
            success: function(data)
            {
                $(".cmsgagent").html("New "+data);
                if (data==0){
                    $(".cmsgagent").hide();
                     $(".agentmsgc").hide();
                }
                else{
                    //alert("kkk1"+data);
                    // $(".cmsgagent").show();
                    $(".cmsgagent").css("display","block");
                    $(".agentmsgc").css("display","block");
                }
            }});





}, 20000)
$(".msgld").hide();
    });

$(".res").click(function()
	{
		//alert("en");
		$("#senscalendar").val(1);
		$('#msgload').show();
		$(".msgld").html('');
		$(".msgld").hide();
$("#group").val('default');
	$("#group").selectpicker("refresh");
$("#agent1").val('default');
	$("#agent1").selectpicker("refresh");

$("#hub").val('default');
	$("#hub").selectpicker("refresh");
$("#sensor2").val('default');
	$("#sensor2").selectpicker("refresh");
	//xhr.abort();
	$("#table_data2").html('');
	$("#datalable0").html("");
//alert("kkk");
$.ajax(
         {
             url: "{{ url('/admin/deletetempdata') }}",
            type: "get",
            data:{},
             success: function(data)
            {
				
 $("#butSen").show();
 }});
	if ($("#senscalendar").val()==1)
	{

$('.txt_date2ag, .txt_date3ag').datepicker({ format: "dd MM yyyy" });


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




});
	function updatereadall()
	{
		$('td').removeClass("grcolor");
		var msgid = 'all';
		$.ajax(
        {
            url: "{{ url('/agent/uppushmsgreadflag') }}",
            type: "get",
            data:{msgid:msgid},
            success: function(data)
            {
				//$("#tr"+msgid).find('td').removeClass("grcolor");
				$.ajax(
        		{
					url: "{{ url('/agent/uppushmsgreadflagcount') }}",
					type: "get",
					data:{msgid:msgid},
					success: function(data)
					{
						$(".cmsgagent").html("New "+data);
						if (data==0)
						{
							$(".cmsgagent").hide();
							$(".agentmsgc").hide();
							$(".adminmsgc").hide();
						}
						else
						{
							$(".cmsgagent").css("display","block");
							$(".agentmsgc").css("display","block");
							$(".adminmsgc").css("display","block");
						}
					}
				});
			}
		});
	}


function graph(){

getchart2();

}

$(document).ready(function(){

var senscalendarhub=$("#senscalendarhub").val();
if (senscalendarhub==0){
   $(".txt_date2hubag").datepicker({
        todayBtn:  1,
        autoclose: true,
         clearBtn: true,
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
		.modal-backdrop.show 
		{
			z-index: 0 !important;
			display:none;
		}
	</style>

@parent

@endsection

