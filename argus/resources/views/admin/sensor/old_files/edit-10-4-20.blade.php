<div class="row">
	<div class="col-md-12">
		<div class="card euz_carb rounded-0 text-white">
			<div class="card-body">
				<h4 class="card-title m-0"><i class="fas fa-portrait text-info"></i> <?php echo $user[0]->fname.' '.$user[0]->lname; ?> / <?php echo $groupname[0]->name; ?> / <?php echo $hubname[0]->name; ?><a href="javascript:void(0)" class="closebtn float-right" onclick="profileclose()">×</a></h4>
			</div>
		</div>
		<ul class="nav nav-tabs nav-justified">
			<li class="nav-item">
				<a class="nav-link active" data-toggle="tab" href="#agprofile">Sensor</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#treecom">Tree Strucrure</a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active p-3" id="agprofile">
				<form action="{{ url('admin/updatesensor') }}" method="POST" enctype="multipart/form-data">
					{{ csrf_field() }}
					<input type="hidden" name="eid" value="{{ $group[0]->id }}" id="" />
					<input type="hidden" name="hub_id" value="{{ $group[0]->hub_id }}" id="" />
					<div class="row">
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Agent</label>
							<input type="text" class="form-control " id="" value="<?php echo $user[0]->fname.' '.$user[0]->lname; ?>" disabled="disabled">
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Groupway Group Name</label>
							<input type="text" class="form-control" id="" value="<?php echo $groupname[0]->name; ?>" disabled="disabled">
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Sensor Hub Name</label>
							<input type="text" class="form-control" id="" value="<?php echo $hubname[0]->name; ?>" disabled="disabled">
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Sensor ID</label>
							<input type="text" class="form-control disname" id="" name="sensor_id" value="{{ $group[0]->sensor_id }}" disabled="disabled" />
						</div>
						
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Type</label>
							<select class="form-control disname" name="type" disabled="disabled">
								@foreach($types as $item)
								@if($item->id==$group[0]->type)
								<option value="{{ $item->id }}" selected="selected">{{ $item->name }}</option>
								@else
								<option value="{{ $item->id }}">{{ $item->name }}</option>
								@endif
								@endforeach
							</select>
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Brand</label>
							<select class="form-control disname" id="" name="brand" disabled="disabled">
								@foreach($brands as $item2)
								@if($item2->id==$group[0]->brand)
								<option value="{{ $item2->id }}" selected="selected">{{ $item2->name }}</option>
								@else
								<option value="{{ $item2->id }}">{{ $item2->name }}</option>
								@endif
								@endforeach
							</select>
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Measurement Unit</label>
							<select class="form-control disname" id="" name="unit" disabled="disabled">
								@foreach($units as $item3)
								@if($item3->id==$group[0]->measure_unit)
								<option value="{{ $item3->id }}" selected="selected">{{ $item3->minimum }} - {{ $item3->maximum }}</option>
								@else
								<option value="{{ $item3->id }}">{{ $item3->minimum }} - {{ $item3->maximum }}</option>
								@endif
								@endforeach
							</select>
						</div>					
						<div class="form-group col-lg-12 col-md-4">
							<label class="euz_b" for="">Sensor Information</label>
							<textarea type="text" class="form-control disname" id="" rows="5" disabled="disabled" name="inform">{{ $group[0]->sensor_inform }}</textarea>
						</div>						
						<div class="col-md-12">
							<a class="btn btn-danger float-right euz_all_edc ml-2" href="javascript:void(0)" onclick="profileclose()"><i class="fas fa-times" ></i> Cancel</a>
							<button class="btn btn-success float-right euz_all_edc ml-2 btnupdate" type="submit"><i class="far fa-save"></i> Update</button>
							<a class="btn btn-primary float-right euz_all_edc ml-2 btnenable" href="#"><i class="far fa-edit"></i> Edit</a>
						</div>						
					</div>
				</form>
			</div>
			<div class="tab-pane fade" id="treecom">
				<div class="row">
					<div class="col-md-12">
						<ul class="tree">
							<li>
								<span>
									<div class="agent_tree text-white">Test Agent1</div>
									<div class="agent_tree1">
										<a href="#"><i class="fas fa-trash-alt text-danger"></i></a>
										<a href="#" data-toggle="modal" data-target="#agentedit"><i class="fas fa-edit euz_a_icon"></i></a>
										<a href="#" data-toggle="modal" data-target="#groupadd"><i class="fas fa-plus-square text-info"></i></a>
									</div>
								</span>
								<ul>
									<li>
										<span>
											<div class="group_tree text-white">GatewayGroup1</div>
											<div class="group_tree1">
												<a href="#"><i class="fas fa-trash-alt text-danger"></i></a>
												<a href="#" data-toggle="modal" data-target="#groupedit"><i class="fas fa-edit euz_a_icon"></i></a>
												<a href="#" data-toggle="modal" data-target="#hubadd"><i class="fas fa-plus-square text-info"></i></a>
											</div>
										</span>
										<ul>
											<li>
												<span>
													<div class="sensorhub_tree text-white">Sensor Hub1</div>
													<div class="sensorhub_tree1">
														<a href="#"><i class="fas fa-trash-alt text-danger"></i></a>
														<a href="#" data-toggle="modal" data-target="#hubedit"><i class="fas fa-edit euz_a_icon"></i></a>
														<a href="#" data-toggle="modal" data-target="#sensoradd"><i class="fas fa-plus-square text-info"></i></a>
													</div>
												</span>
												<ul>
													<li>
														<span>
															<div class="sensor_tree">B4:E6:2D:DD:83:35</div>
															<div class="sensor_tree1">
																<a href="#"><i class="fas fa-trash-alt text-danger"></i></a>
																<a href="#" data-toggle="modal" data-target="#sensoredit"><i class="fas fa-edit euz_a_icon"></i></a>
															</div>
														</span>
													</li>
												</ul>
											</li>
											<li>
												<span>
													<div class="sensorhub_tree text-white">Sensor Hub2</div>
													<div class="sensorhub_tree1">
														<a href="#"><i class="fas fa-trash-alt text-danger"></i></a>
														<a href="#" data-toggle="modal" data-target="#hubedit"><i class="fas fa-edit euz_a_icon"></i></a>
														<a href="#" data-toggle="modal" data-target="#sensoradd"><i class="fas fa-plus-square text-info"></i></a>
													</div>
												</span>
												<ul>
													<li>
														<span>
															<div class="sensor_tree">B4:E0:2D:SD:23:35</div>
															<div class="sensor_tree1">
																<a href="#"><i class="fas fa-trash-alt text-danger"></i></a>
																<a href="#" data-toggle="modal" data-target="#sensoredit"><i class="fas fa-edit euz_a_icon"></i></a>
															</div>
														</span>
													</li>
													<li>
														<span>
															<div class="sensor_tree">B4:E7:GD:DG:83:47</div>
															<div class="sensor_tree1">
																<a href="#"><i class="fas fa-trash-alt text-danger"></i></a>
																<a href="#" data-toggle="modal" data-target="#sensoredit"><i class="fas fa-edit euz_a_icon"></i></a>
															</div>
														</span>
													</li>
												</ul>
											</li>
										</ul>
									</li>
									<li>
										<span>
											<div class="group_tree text-white">GatewayGroup2</div>
											<div class="group_tree1">
												<a href="#"><i class="fas fa-trash-alt text-danger"></i></a>
												<a href="#" data-toggle="modal" data-target="#groupedit"><i class="fas fa-edit euz_a_icon"></i></a>
												<a href="#" data-toggle="modal" data-target="#hubadd"><i class="fas fa-plus-square text-info"></i></a>
											</div>
										</span>
										<ul>
											<li>
												<span>
													<div class="sensorhub_tree text-white">Sensor Hub3</div>
													<div class="sensorhub_tree1">
														<a href="#"><i class="fas fa-trash-alt text-danger"></i></a>
														<a href="#" data-toggle="modal" data-target="#hubedit"><i class="fas fa-edit euz_a_icon"></i></a>
														<a href="#" data-toggle="modal" data-target="#sensoradd"><i class="fas fa-plus-square text-info"></i></a>
													</div>
												</span>
												<ul>
													<li>
														<span>
															<div class="sensor_tree text-white">C4:E7:A3:D0:G3:17</div>
															<div class="sensor_tree1">
																<a href="#"><i class="fas fa-trash-alt text-danger"></i></a>
																<a href="#" data-toggle="modal" data-target="#sensoredit"><i class="fas fa-edit euz_a_icon"></i></a>
															</div>
														</span>
													</li>
												</ul>
											</li>
										</ul>
									</li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(".btnupdate").hide();	
	$(".btnenable").click(function() {
		$(".disname").removeAttr("disabled");
		$(".btnupdate").show(); 
		$(".btnenable").hide();
	});
</script>