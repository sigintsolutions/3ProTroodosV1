<div class="table-responsive-sm">
	@if(@$items)
	<table class="table table-bordered table-striped">
		<thead class="euz_thead">
			<tr>
				<th>Sl.No</th>
				<th>Agent Name</th>
				<th>Gateway Groupp</th>
				<th>Sensor Hub</th>
				<th>Unit</th>
				<th>Sensor</th>
				<th>Time Stamp</th>
				<th>Value</th>
			</tr>
		</thead>
		<tbody>
			<?php $i = 1; foreach($items as $item) { ?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php //echo $item->fname; ?></td>
				<td><?php //echo $item->name; ?></td>
				<td><?php //echo $item->hub; ?></td>
				<td><?php echo $item->unit; ?></td>
				<td><?php echo $item->sensor_id; ?></td>
				<td><?php echo $item->time; ?></td>
				<td><?php echo $item->value; ?></td>
			</tr>
			<?php $i++; } ?>
			<tr>
				<td colspan="3" align="center"></td>
			</tr>
		</tbody>
	</table>
	{{ $items->links() }}
	@else No Data Found @endif
</div>
													
													