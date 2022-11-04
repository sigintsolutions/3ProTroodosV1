
<!--sensor chart module--->

<table class="table table-bordered table-striped">
						<thead class="euz_thead_set">
							<tr>
								<th>Sl.No</th>
								<th>Measuement Unit</th>
								<th>Chart</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php $j = 1; foreach($units as $unit) { ?>
							<tr>
								<td><?php echo $j; ?></td>
								<td><?php echo $unit->unit; ?></td>
								<td><?php echo $unit->name; ?></td>
								<td>
									<a href="javasccript:void()" class="text-info euz_td_a" data-id='{{ $unit->id }}' data-toggle="modal" data-target="#units{{ $unit->id }}"><i class="fas fa-user-edit"></i> Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;
									<!-- <a href="{{ url('/admin/deleteunit/'.$unit->id) }}" class="text-danger euz_td_a"><i class="fas fa-user-times"></i> Delete</a> -->
								</td>
							</tr>
							<div class="modal fade" id="units{{ $unit->id }}">
								<div class="modal-dialog modal-dialog-centered" style="max-width: 80%;">
									<div class="modal-content shadow">
										<div class="modal-header euz_header  rounded-0">
											<p class="text-white euz_b">Edit</p>
											<button type="button" class="close" data-dismiss="modal">
											<span>x</span>
											</button>
										</div>					
										<div class="modal-body row">
											<div class="form-group col-md-12 py-2 mb-0">										
												<form action="{{ url('/admin/editunit') }}" method="POST" enctype="multipart/form-data">
													{{ csrf_field() }}	
													<input type="hidden" name="eid" value="{{ $unit->id }}" id="eid" />
													<div class="row">
														<div class="col-md-4 form-group my-2">
															<label for="" class="euz_b">Unit</label>
															<div class="input-group mb-3">
																<select class="form-control" name="unit" required>
																	<option value="<?php echo $unit->unit; ?>"><?php echo $unit->unit; ?></option>
																	<?php $i = 1; foreach($measureunits as $item) { ?>
																	<option value="<?php echo $item->unit; ?>"><?php echo $item->unit; ?></option>
																	<?php } ?>
																<select>
															</div>
														</div>
														<div class="col-md-4 form-group my-2">
															<label for="" class="euz_b">Sensor Chart</label>
															<div class="input-group mb-3">
																<select class="form-control euztumb1" name="name" required>
																	<option value="<?php echo $unit->name; ?>"><?php echo $unit->name; ?></option>
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
														</div>
														<div class="col-md-2 my-2">
															<img src="../image/tumb/area.PNG" class="img-fluid euztumbs1 AreaChart" style="width:100px;">
															<img src="../image/tumb/bar.PNG" class="img-fluid euztumbs1 BarChart" style="width:100px;">
															<img src="../image/tumb/pie.PNG" class="img-fluid euztumbs1 PieChart" style="width:100px;">
															<img src="../image/tumb/column.PNG" class="img-fluid euztumbs1 ColumnChart" style="width:100px;">
															<img src="../image/tumb/combo.PNG" class="img-fluid euztumbs1 ComboChart" style="width:100px;">
															<img src="../image/tumb/scatter.PNG" class="img-fluid euztumbs1 ScatterChart" style="width:100px;">
															<img src="../image/tumb/stepped.PNG" class="img-fluid euztumbs1 SteppedAreaChart" style="width:100px;">
															<img src="../image/tumb/histogram.PNG" class="img-fluid euztumbs1 Histogram" style="width:100px;">
															<img src="../image/tumb/line.PNG" class="img-fluid euztumbs1 LineChart" style="width:100px;">
														</div>
													</div>
													
													<div class="input-group-append">
														<button class="btn euz_btn_add" type="submit"><i class="fas fa-plus"></i> Update</button> 
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php $j++; } ?>
						</tbody>
					</table>

<style>
		.modal-backdrop.show 
		{
			z-index:999999!important;
display: none;
		}
	</style>
