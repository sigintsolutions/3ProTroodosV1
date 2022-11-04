<div class="table-responsive-sm">
@if(@$items)
														<table class="table table-bordered table-striped">
															<thead class="euz_thead">
																<tr>
																		<th>Sl.No</th>
																		<th>Agent Name</th>
																		<th>Sensor</th>
																		<th>Time Stamp</th>
																		<th>Value</th>
																</tr>
															</thead>
															<tbody>
															<?php 
																//foreach ($items as $item) { 
															// 	$myDetails = array();
															// 	foreach ($items as $key => $value) {
															// 		if ($value instanceof StdClass) {
															// 			$myDetails[$key] = $value->toArray();
															// 		} else {
															// 			$myDetails[$key] = $value;
															// 		}
															// 	}
															// print_r($myDetails);
															foreach($items as $item) {
																//foreach($item as $ite) {
																	//print_r($item);
															?>
															<tr>
																<td><?php echo $item->fname; ?></td>
																<td><?php //echo $myDetail['fname']; ?></td>
																<td><?php //echo $item[]->sensor_id; ?></td>
																<td><?php //echo $item[]->time; ?></td>
																<td><?php //echo $item[]->value; ?></td>
															</tr>
															<?php } //} ?>
																<tr>
       <td colspan="3" align="center">
       </td>
      </tr>
															</tbody>
														</table>
														@else
														No Data Found
														@endif
													</div>
													
													