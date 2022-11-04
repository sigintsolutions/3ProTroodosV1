
<!--Displaying in table-->

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

//$hubdt=DB::table('sensors')->where('sensor_id',$item->sensor_id)->where('sensors.agent',$agent)->first();
$groupid=$hubdt->sensor_group_id;
//$groupid=$hubdt->group_id;
//echo $groupid=$currhubgroup;
//echo "$agent-$item->sensor_id-$item->hub--$groupid";
//dd($groupid,$agent);
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
	@else <!--No Data Found--> @endif


	<?php 
error_reporting(0);
if (isset($items)) {
	if (count($items)==0){?>
Sorry No Data
		<?php }}?>
</div>
			<input type="hidden" name="currentoffset" id="currentoffset" value="<?php echo $currentoffset;?>" />				<input type="hidden" name="pageno" id="pageno" value="<?php echo $pageno;?>" />						
<script type="text/javascript">

	
function getnextpage(currentoffset,pageno){
//Fetching next in table
$.ajax({
			url: "{{ url('/admin/getsensortimefetchpage') }}",
			type: "post",
			data: $('#tmefrm').serialize(),
			success: function(data)
			{
				$(".loader").hide();
				//$("#table_data2").html(currentoffset);
				$("#table_data2").html(data);
			}
		});

	}

	function getprevpage(currentoffset,pageno){
//Fetching prev in table
$.ajax({
			url: "{{ url('/admin/getsensortimefetchpageprev') }}",
			type: "post",
			data: $('#tmefrm').serialize(),
			success: function(data)
			{
				$(".loader").hide();
				//$("#table_data2").html(currentoffset);
				$("#table_data2").html(data);
			}
		});

	}


</script>													