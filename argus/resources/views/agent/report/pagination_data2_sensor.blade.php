<!---Displaying in Table--->
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

$hubdt=DB::table('sensor_hubs')->join('sensors','sensors.hub_id','=','sensor_hubs.id')->where('sensor_id',$item->sensor_id)->where('sensor_hubs.hub_id',$item->hub)->where('sensor_hubs.agent',$agent)->where('sensors.agent',$agent)->where('unit',$item->unit)->first();
$groupid=$hubdt->sensor_group_id;
$grpdt=DB::table('sensor_groups')->where('id',$groupid)->first();
echo $grpdt->name;
				 ?></td>
				<td><?php echo $item->hub; ?></td>
				<td><?php echo $item->unit; ?></td>
				<td><?php echo $item->sensor_id; ?></td>
				<td><?php echo $item->utc; ?></td>
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

	
function getnextpage(currentoffset,pageno){
//Next page link
$(".pg").val(pageno);
$(".cur").val(currentoffset);
$.ajax({
			url: "{{ url('/agent/getsensortimefetchpagealg') }}",
			type: "post",
			data: $('#tmefrm2').serialize(),
			success: function(data)
			{
				$(".loader").hide();
				
				$("#sensordata").html(data);
			}
		});

	}

	function getprevpage(currentoffset,pageno){
//Prev page link
$(".pg").val(pageno);
$(".cur").val(currentoffset);
$.ajax({
			url: "{{ url('/agent/getsensortimefetchpageprevalg') }}",
			type: "post",
			data: $('#tmefrm2').serialize(),
			success: function(data)
			{
				$(".loader").hide();
				
				$("#sensordata").html(data);
			}
		});

	}


</script>													