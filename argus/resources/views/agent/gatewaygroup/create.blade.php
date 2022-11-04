@extends('layouts.admin')
@section('content')


<!--Adding Group--->
<div class="p-3">
			<div class="row">
				<div class="col-md-12 euz_bar">
					<i class="fas fa-user-tie euz_text_blue"></i> <small class="euz_b euz_text_blue">Agents</small>
				</div>
				<div class="col-md-12 euz_border p-3 bg-white">
					<div class="row">
						<div class="col-md-12 mt-2">
							<ul class="nav nav-tabs euz_tab" role="tablist">
								<li class="nav-item">
									<a class="nav-link euz_tabtex " href="/admin/agents"><i class="fas fa-user-plus"></i> Add Agent</a>
								</li>
								<li class="nav-item">
									<a class="nav-link euz_tabtex active" href="/admin/gatewaygroups"><i class="fas fa-users"></i> Add Gateway Group</a>
								</li>
								<li class="nav-item">
									<a class="nav-link euz_tabtex" href="/admin/sensorhubs"><i class="fas fa-microchip"></i> Add Sensor Hub</a>
								</li>
							</ul>
			
								<!-- Tab panes -->
							<div class="tab-content px-3">
								<div id="agent11" class="tab-pane active"><br>
									
									<div class="row euz_newadmin_form_q">
										<div class="col-md-12 mb-1 p-0">
											<a class="btn euz_btn_add float-right euz_pointer mb-3 euz_back_btn_q" href="/admin/gatewaygroups"><i class="far fa-arrow-alt-circle-left"></i> Back</a>										
										</div>
										<div class="col-md-12 shadow-sm">
										<div class="row">
										
										<div class="col-md-12 euz_header">
											<p class="text-white euz_b">Add Gateway Group</p>
										</div>
										<form action="insertgatewaygroup" method="POST" enctype="multipart/form-data">
										{{ csrf_field() }}
										<div class="col-md-12 euz_border">
											<div class="row">
												<div class="form-group col-md-3 py-2 mb-0">
													<label for="" class="euz_b">Group ID</label>
													<input type="text" class="form-control" id="group_id" name="group_id" value="{{ $group_id }}" disabled>
													<input type="hidden" class="form-control" id="group" name="group" value="{{ $group_id }}" >
												</div>
												<div class="form-group col-md-3 py-2 mb-0">
													<label for="" class="euz_b">Agent</label>
													<select class="form-control" id="agent" name="agent">
														<option value="">-Select Agent-</option>
														@foreach($agents as $item)
														<option value="{{ $item->id }}">{{ $item->fname }}</option>
														@endforeach
													</select>
												</div>
												<div class="form-group col-md-3 py-2 mb-0">
													<label for="" class="euz_b">Sensor Group Name</label>
													<div class="input-group">
														<select class="form-control" id="sensor_group_id" name="sensor_group_id">
															<option value="">-Select Sensor Group-</option>
															@foreach($groups as $item)
															<option value="{{ $item->id }}">{{ $item->name }}</option>
															@endforeach
														</select>
														<div class="input-group-append">
															<button class="btn euz_btn_add" type="button" data-toggle="modal" data-target="#sensorgroup"><i class="fas fa-plus"></i></button> 
														</div>
													</div>
												</div>
												<div class="form-group col-md-3 py-2 mb-0">
													<label for="" class="euz_b">SIM Card Number</label>
													<input type="text" class="form-control" id="sim_no" name="sim_no" required>
												</div>
												
												<div class="form-group col-md-3 py-2 mb-0">
													<label for="" class="euz_b">Router Sensor Number</label>
													<input type="text" class="form-control" id="router_sensor_no" name="router_sensor_no" required>
												</div>
												<div class="form-group col-md-3 py-2 mb-0">
													<label for="" class="euz_b">Longitude</label>
													<input type="text" class="form-control" id="longitude" name="longitude">
												</div>
												<div class="form-group col-md-3 py-2 mb-0">
													<label for="" class="euz_b">Latitude</label>
													<input type="text" class="form-control" id="latitude" name="latitude">
												</div>
												<div class="form-group col-md-12 py-2 mb-0">
													<label for="" class="euz_b">Sensor Information</label>
													<textarea class="form-control" rows="3" id="sensor_information" name="sensor_information"></textarea>
												</div>
												
											</div>									
											<div class="row bg-light">
												<div class="col-md-12 p-2">
													<button type="submit" class="euz_ingreen"><i class="fas fa-save"></i> Save</button>
													&nbsp;&nbsp;
													<a href="/admin/gatewaygroups" class="euz_inred"><i class="fas fa-broom"></i> Cancel</a>
												</div>
											</div>
										</div>
									</form>
									
									
									
										</div>
										</div>
									</div>
									
								</div>
								
							</div>
						</div>
					</div>
				</div>			
			</div>
        </div>

<div class="modal fade" id="sensorgroup">
														<div class="modal-dialog modal-dialog-centered">
															<div class="modal-content shadow">
															<div class="modal-header euz_header  rounded-0">
																<p class="text-white euz_b">Add Sensor Group Name</p>
																<button type="button" class="close" data-dismiss="modal">
																<span>×</span>
																</button>
															</div>
															
															<div class="modal-body row">
																<div class="form-group col-md-12 py-2 mb-0">
																	<label for="" class="euz_b">Sensor Group Name</label>
																	<form action="insertgroup" method="POST" enctype="multipart/form-data">
																	{{ csrf_field() }}
																	<div class="input-group mb-3">
																		<input type="text" class="form-control" name="name" id="name" pattern="[a-zA-Z0-9 ]+" title="Only Alpha-Numeric Values" required>
																		<div class="input-group-append">
																			<button class="btn euz_btn_add" type="submit"><i class="fas fa-plus"></i> ADD</button> 
																		</div>
																	</div>
																	</form>
																</div>
															</div>
															
															<div class="modal-footer bg-light py-0 rounded-0">
																<button type="button" class="btn euz_inred" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
															</div>
															</div>
														</div>
													</div>

<?php /*?><div class="p-3 add_admin_form">
			<div class="row">
				<div class="col-md-12 euz_bar">
					<i class="fas fa-user-tie euz_text_blue"></i> <small class="euz_b euz_text_blue"><a class="euz_text_blue euz_pointer add_admin_back">Admin</a> / <i class="fas fa-user-plus"></i> Add new Admin</small>
				</div>
				<div class="col-md-12 euz_border p-3 bg-white">
					<div class="row">
						<div class="col-md-12 mt-2">
							<div class="shadow-sm">
								<div class="col-md-12 euz_box_head">
									<p class="text-white euz_b mb-0">Add New Admin</p>
								</div>
								<form action="insertuser" method="POST" enctype="multipart/form-data" oninput='confirm.setCustomValidity(confirm.value != password.value ? "Passwords do not match." : "")'>
								{{ csrf_field() }}
								<div class="col-md-12 euz_border">
									<div class="row">
										<div class="form-group col-md-4 py-2 mb-0">
											<label for="" class="euz_b">First Name</label>
											<input class="form-control" type="text" id="fname" name="fname" required>
										</div>
										<div class="form-group col-md-4 py-2 mb-0">
											<label for="" class="euz_b">Last Name</label>
											<input class="form-control" type="text" id="lname" name="lname" required>
										</div>
										<div class="form-group col-md-4 py-2 mb-0">
											<label for="" class="euz_b">Admin User Name</label>
											<input class="form-control" type="email" id="username" name="username" required>
										</div>
										<div class="form-group col-md-4 py-2 mb-0">
											<label for="" class="euz_b">Admin User Password</label>
											<input class="form-control" type="password" id="password" name="password" required>
										</div>
										<div class="form-group col-md-4 py-2 mb-0">
											<label for="" class="euz_b">Confirm User Password</label>
											<input class="form-control" type="password" id="confirm" name="confirm">
										</div>
									</div>	
									<div class="row bg-light">
										<div class="col-md-12 p-2">
											<button type="submit" class="euz_ingreen"><i class="fas fa-save"></i> Save</button>
											&nbsp;&nbsp;
											<a href="/admin/users" class="euz_inred"><i class="fas fa-broom"></i> Cancel</a>
										</div>
									</div>
								</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
        </div><?php */?>


@endsection
@section('scripts')
@parent

@endsection