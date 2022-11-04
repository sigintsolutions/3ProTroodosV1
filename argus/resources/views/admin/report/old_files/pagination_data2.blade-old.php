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
															@foreach(@$items as $index =>$item)
																<tr>
																	<td>{{ $index + $items->firstItem() }}</td>
																	<td>{{ (@$item->fname) }}</td>
																	<td>{{ (@$item->sensor_id) }}</td>
																	<td>{{\Carbon\Carbon::parse($item->RecordedDate)->format('l')}}</td>
																	<td>{{ $item->Value }}</td>
																</tr>
															@endforeach
																<tr>
       <td colspan="3" align="center">
        {!! $items->links() !!}
       </td>
      </tr>
															</tbody>
														</table>
														@else
														No Data Found
														@endif
													</div>
													
													