<div class="table-responsive-sm">
	@if(@$items)
	<table class="table table-bordered table-striped">
		<thead class="euz_thead">
			<tr>
				<th>Sl.No</th>
				<th>Agent Name</th>
				<th>Gateway Group</th>
				<th>Sensor Hub</th>
				<th>Unit</th>
				<th>Sensor</th>
				<th>Time Stamp</th>
				<th>Value</th>
			</tr>
		</thead>
		<tbody>
			<?php 
error_reporting(0);

			$i = 1; 
$j=$currentoffset+1;
			foreach($items as $item) { ?>
			<tr>
				<td><?php echo $j; ?></td>
				<td><?php //echo $item->id;
				//dd($agent);
$agentdt=DB::table('users')->where('Id',$agent)->first();
//dd()
echo $agentdt->fname." ".$agentdt->lname;
				 //echo $item->fname; ?></td>
				<td><?php //echo $item->name;
/*$sensdt=DB::table('sensors')->where('sensor_id',$item->sensor_id)->where('unit',$item->unit)->first();
$hubid=$sensdt->hub_id;
$hubdt=DB::table('sensor_hubs')->where('id',$hubid)->first();*/
/*$hubdt=DB::table('sensor_hubs')->join('sensors','sensors.hub_id','=','sensor_hubs.id')->where('sensor_id',$item->sensor_id)->where('unit',$item->unit)->where('sensor_hubs.hub_id',$item->hub)->where('agent',$agent)->first();*/
$hubdt=DB::table('sensors')->where('sensor_id',$item->sensor_id)->where('sensors.agent',$agent)->first();
$groupid=$hubdt->sensor_group_id;
$grpdt=DB::table('sensor_groups')->where('id',$groupid)->first();
echo $grpdt->name;
				 ?></td>
				<td><?php echo $item->hub; ?></td>
				<td><?php echo $item->unit; ?></td>
				<td><?php echo $item->sensor_id; ?></td>
				<td><?php echo $item->time; ?></td>
				<td><?php echo $item->value; ?></td>
			</tr>
			<?php $j++; } ?>
			<tr>
				<td colspan="3" align="center"></td>
			</tr>
		</tbody>
	</table>
	<?php if (count($items)>=100){

		?>
      <!--<a href="admin/getpagesens?=<?php //echo $currentoffset;?>">Next</a>-->

<a href="#" onclick="getnextpage(<?php echo $currentoffset;?>,<?php echo $pageno;?>);">Next</a>&nbsp;&nbsp;

	<?php } 
	//else{
//$currentoffset=0;
		if ($pageno!=1){
		?>

<a href="#" onclick="getprevpage(<?php echo $currentoffset;?>,<?php echo $pageno;?>);">Prev</a>

	<?php } //}
	
	

?>
	@else No Data Found @endif


	<?php 
error_reporting(0);
if (isset($items)) {
if (count($items)==0){
?>
Sorry No Data
<?php }} ?>
</div>
			<input type="hidden" name="currentoffseterr" id="currentoffset" value="<?php echo $currentoffset;?>" />				<input type="hidden" name="pagenoerr" id="pageno" value="<?php echo $pageno;?>" />						
<script type="text/javascript">

	/*function getnextpage(currentoffset){
alert(currentoffset);
var unit=$("#hidunit").val();
alert("unit"+unit);
var sensor="<?php //echo $sensor;?>";
alert("sensor"+sensor);
var hub_id="<?php //echo $hubsname;?>";
alert("hub_id"+hub_id);
var start_month="<?php //echo $start_month;?>";
alert("fromdate"+start_month);
var end_month="<?php //echo $end_month;?>";
alert("todate"+end_month);
var url = "{{URL('admin/getsensortimefetchpage')}}";
				$.ajax(
				{
					url:url,
					method:"get",
					data:{currentoffset:currentoffset,unit:unit,sensor:sensor,hubsname:hub_id,start_month:start_month,end_month:end_month},
					success:function(response)
					{
$(".loader").hide();
				$("#table_data2").html(data);
						
					}});

}*/
function getnextpage(currentoffset,pageno){
//alert(currentoffset);
//alert("pageno"+pageno);
$(".pg").val(pageno);
$(".cur").val(currentoffset);
$.ajax({
			url: "{{ url('/agent/getsensortimefetchpagealg') }}",
			type: "post",
			data: $('#tmefrm2').serialize(),
			success: function(data)
			{
				$(".loader").hide();
				//$("#table_data2").html(currentoffset);
				//$("#table_data2").html(data);
				$("#sensordata").html(data);
			}
		});

	}

	function getprevpage(currentoffset,pageno){
//alert(currentoffset);
//alert("pageno"+pageno+"pppp");
$(".pg").val(pageno);
$(".cur").val(currentoffset);
$.ajax({
			url: "{{ url('/agent/getsensortimefetchpageprevalg') }}",
			type: "post",
			data: $('#tmefrm2').serialize(),
			success: function(data)
			{
				$(".loader").hide();
				//$("#table_data2").html(currentoffset);
				//$("#table_data2").html(data);
				$("#sensordata").html(data);
			}
		});

	}


</script>													