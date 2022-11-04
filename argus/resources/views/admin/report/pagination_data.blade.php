
<!--Displaying in table-->

<div class="table-responsive-sm">
@if(@$items)
														<table class="table table-bordered table-striped">
															<thead class="euz_thead">
																<tr>
																	<th>Sl.No</th>
																	<th>Name</th>
																	<th>Status</th>
																</tr>
															</thead>
															<tbody>
															@foreach(@$items as $index =>$item)
																<tr>
																	<td>{{ $index + $items->firstItem() }}</td>
																	<td>{{ (@$item->fname)?$item->fname:@$item->sensor_id }}</td>
																	<td>{{ ($item->status==1)? 'Active': 'Inactive' }}</td>
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