<div class="row">
	<div class="col-md-12">
		<div class="card euz_carb rounded-0 text-white">
			<div class="card-body">
				<h4 class="card-title m-0"><i class="fas fa-portrait text-info"></i> Test agent1 / Gateway Group1<a href="javascript:void(0)" class="closebtn float-right" onclick="profileclose()">×</a></h4>
			</div>
		</div>
		<ul class="nav nav-tabs nav-justified">
			<li class="nav-item">
				<a class="nav-link active" data-toggle="tab" href="#agprofile">Gateway Group</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#treecom">Tree Strucrure</a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active p-3" id="agprofile">
				<form action="{{ url('admin/updategatewaygroup') }}" method="POST" enctype="multipart/form-data">
					{{ csrf_field() }}
					<input type="hidden" name="eid" value="{{ $group[0]->id }}" id="eid" />
					<div class="row">
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Agent</label>
							<select name="agent" class="form-control" readonly>
								@foreach($agents as $item2)
								@if($group[0]->agent==$item2->id)
								<option value="{{ $item2->id }}" selected="selected">{{ $item2->fname }}</option>
								<?php /*@else
								<option value="{{ $item2->id }}">{{ $item2->fname }}</option>*/ ?>
								@endif
								@endforeach
							</select>
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Groupway Group ID</label>
							<input type="text" class="form-control" id="" value="<?php echo $group[0]->group_id; ?>" readonly="readonly" name="group" />
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Gateway Group Name</label>
							<select class="form-control disname" id="sensor_group_id" name="sensor_group_id" disabled="disabled">
								<option value="">-Select Sensor Group-</option>
								@foreach($groups as $item2)
								@if($group[0]->sensor_group_id==$item2->id)
								<option value="{{ $item2->id }}" selected="selected">{{ $item2->name }}</option>
								@else
								<option value="{{ $item2->id }}">{{ $item2->name }}</option>
								@endif
								@endforeach
							</select>
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">SIM Card Number</label>
							<input type="text" class="form-control disname" id="" name="sim_no" value="{{ $group[0]->sim_no }}" disabled="disabled">
						</div>
						
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Router Sensor Number</label>
							<input type="text" class="form-control disname" id="" value="{{ $group[0]->router_sensor_no }}" name="router_sensor_no" disabled="disabled">
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Longitude</label>
							<input type="text" class="form-control disname" id="" name="longitude" value="{{ $group[0]->longitude }}" disabled="disabled">
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Latitude</label>
							<input type="text" class="form-control disname" id="" value="{{ $group[0]->latitude }}" name="latitude" disabled="disabled">
						</div>
						
						<div class="form-group col-lg-12 col-md-4">
							<label class="euz_b" for="">Gateway Group Information</label>
							<textarea type="text" class="form-control disname" id="" value="" rows="5" disabled="disabled" name="sensor_information">{{ $group[0]->sensor_information }}</textarea>
						</div>				
						<div class="col-md-12">
							<a class="btn btn-danger float-right euz_all_edc ml-2" href="javascript:void(0)" onclick="profileclose()"><i class="fas fa-times"></i> Cancel</a>
							<button type="submit" class="btn btn-success float-right euz_all_edc ml-2 btnupdate" name="update"><i class="far fa-save"></i> Update</button>
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