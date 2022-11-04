
<!--Displaying sensor--->

					<div class="row p-2">
						<div class="col-md-12 p-0">
							<div class="table-responsive-sm mt-3">
								<table style="width:100%;">
									<colgroup>
										<col width="20%">
										<col width="30%">
										<col width="20%">
										<col width="30%">
									</colgroup>
									<tbody>
										<tr>
											<td class="euz_left_td euz_b">
												Sensor Hub ID
											</td>
											<td class="euz_right_td">{{ $hub[0]->sensor_hub_id}}</td>
											<td class="euz_left_td euz_b">
												Hub Name
											</td>
											<td class="euz_right_td">{{ $hub[0]->name}}</td>
										</tr>
										<tr>
											<td class="euz_left_td euz_b">
												MAC ID
											</td>
											<td class="euz_right_td">{{ $hub[0]->mac_id}}</td>
											<td class="euz_left_td_empty euz_b">
												
											</td>
											<td class="euz_right_td_empty text-white">.</td>
										</tr>
										<tr>
											<td class="euz_left_td euz_b">
												Hub Information
											</td>
											<td class="euz_right_td" colspan="3">
												<p class="text-justify">
													{{ $hub[0]->hub_inform}}
												</p>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						@if($sensor)
						<div class="col-md-12">
							<div class="table-responsive-sm mt-3">
								<table class="table table-bordered table-striped">
									<thead class="euz_agent_table">
										<tr>
											<th class="euz_agent_222">Sl.No</th>
											<th class="euz_agent_222">Type</th>
											<th class="euz_agent_222">Brand</th>
											<th class="euz_agent_222">Measurement Unit</th>
											<th class="euz_agent_222">Sensor Information</th>
										</tr>
									</thead>
									<tbody>
									@foreach($sensor as $item)
										<tr>
											<td>{{ $item->sensor_id }}</td>
											<td>{{ $item->typename }}</td>
											<td>{{ $item->brandname }}</td>
											<td>{{ $item->minimum }} {{ $item->unitname }} - {{ $item->maximum }} {{ $item->unitname }}</td>
											<td>{!! Str::limit($item->sensor_inform, 12, ' ...') !!} <a href="#" class="euz_inblue" data-toggle="modal" data-target="#{{ $item->sensor_id }}"><i class="fas fa-eye"></i> View</a>
											<div class="modal fade" id="{{ $item->sensor_id }}">
									<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
										<div class="modal-content">
										<div class="modal-header euz_bar_agent">
											<p class="modal-title euz_b mb-0">Sensor Information</p>
											<button type="button" class="close" data-dismiss="modal">
											<span><i class="fas fa-times"></i></span>
											</button>
										</div>
										<div class="modal-body euz_border_agent">
											<p class="text-justify">
											{{ $item->sensor_inform }}
											<p>
										</div>
										</div>
									</div>
								</div>
											
											</td>
										</tr>
										
										
										@endforeach
										
										
									</tbody>
								</table>
								
								

							</div>
						</div>
						@endif
					</div>
