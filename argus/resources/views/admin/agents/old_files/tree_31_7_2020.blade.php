
<div class="row">
	<div class="col-md-12">
		<div class="card euz_carb rounded-0 text-white">
			<div class="card-body">
				<h4 class="card-title m-0"><i class="fas fa-portrait text-info"></i> <?php echo $user[0]->fname.' '.$user[0]->lname; ?><a href="javascript:void(0)" class="closebtn float-right" onclick="profileclosetree()">×</a></h4>
			</div>
		</div>
		<ul class="nav nav-tabs nav-justified">
			<li class="nav-item">
				<a class="nav-link active" data-toggle="tab" href="#treecom">Visual Hierarchy</a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="treecom">
				<div class="row">
					<div class="col-md-12">
						<ul class="tree">
							<li>
								<span>
									<div class="agent_tree text-white"><?php echo $user[0]->fname.' '.$user[0]->lname; ?></div>
									<div class="agent_tree_in">
										<a href="{{ url('/admin/groups/'.$user[0]->id) }}" class="float-left px-1"><i class="fas fa-eye euz_a_icon"></i></a>
										<a class="float-right px-1" href="<?php echo url('/admin/deleteAgent/'.$user[0]->id); ?>" onclick="return confirm('Are you sure do you want to delete?')"><i class="fas fa-trash-alt text-danger"></i></a>
										<a class="float-left px-1" href="javascript:void(0)" class="modalLinkpop"  data-id="{{ $user[0]->id }}" data-toggle="modal" data-target="#agenteditpop"><i class="fas fa-edit euz_a_icon"></i></a>
										<a class="float-left px-1" href="javascript:void(0)" data-toggle="modal" data-target="#groupadd"><i class="fas fa-plus-square text-info"></i></a>
									</div>
								</span>
								<ul>
									<?php foreach($groups as $group) { ?>
									<li>
										<span>
											<div class="group_tree text-white"><?php echo $group->name; ?></div>
											<div class="agent_tree_in">
												<a class="float-right px-1" href="<?php echo url('/admin/deleteGatewaygroup/'.$group->id); ?>" onclick="return confirm('Are you sure do you want to delete?')"><i class="fas fa-trash-alt text-danger"></i></a>
												<a href="{{ url('/admin/sensorhubs/'.$user[0]->id.'/'.$group->id) }}" class="float-left px-1"><i class="fas fa-eye euz_a_icon"></i></a>
												<a href="javascript:void(0)" class="groupedit float-left px-1" data-id="{{ $group->id }}" data-toggle="modal" data-target="#groupedit"><i class="fas fa-edit euz_a_icon"></i></a>
												<a href="javascript:void(0)" class="hubadd float-left px-1" data-id="{{ $group->id }}" data-toggle="modal" data-target="#hubadd"><i class="fas fa-plus-square text-info"></i></a>
											</div>
										</span>
										<ul>
											<?php
												$hubs = DB::table('sensor_hubs')
												//->join('hubs', 'hubs.id', '=', 'sensor_hubs.hub_id')
												->where('sensor_hubs.agent', $user[0]->id)
												->where('sensor_hubs.group_id', $group->id)
												->select('sensor_hubs.*', 'sensor_hubs.sensor_hub_id')
												->orderBy('added_on', 'DESC')
												->get();
												foreach($hubs as $hub) { 
												//if(!empty($hub->name)) {
											?>
											<li>
												<span>
													<div class="sensorhub_tree text-white"><?php echo $hub->hub_id; ?></div>
													<div class="agent_tree_in">
														<a class="float-right px-1" href="<?php echo url('/admin/deleteSensorhub/'.$hub->id); ?>" onclick="return confirm('Are you sure do you want to delete?')"><i class="fas fa-trash-alt text-danger"></i></a>
														<a href="{{ url('/admin/sensors/'.$user[0]->id.'/'.$group->id.'/'.$hub->id) }}" class="float-left px-1"><i class="fas fa-eye euz_a_icon"></i></a>
														<a href="javascript:void(0)" class="hubedit float-left px-1" data-toggle="modal" data-id="{{ $hub->id }}" data-target="#hubedit"><i class="fas fa-edit euz_a_icon"></i></a>
														<a href="javascript:void(0)" class="sensoradd float-left px-1" data-id="{{ $hub->id }}" data-toggle="modal" data-target="#sensoradd"><i class="fas fa-plus-square text-info"></i></a>
													</div>
												</span>
												<ul>
													<?php
														$sensors = DB::table('sensors')->where('hub_id', $hub->id)->get();
														foreach($sensors as $sensor) {
													?>
													<li>
														<span>
															<div class="sensor_tree"><?php echo $sensor->sensor_id; ?></div>
															<div class="agent_tree_in">
																<a class="float-right px-1" href="<?php echo url('/admin/deleteSensor/'.$sensor->id); ?>" onclick="return confirm('Are you sure do you want to delete?')"><i class="fas fa-trash-alt text-danger"></i></a>
																
																<a href="javascript:void(0)" class="sensoredit float-left px-1" data-id="{{ $sensor->id }}" data-toggle="modal" data-target="#sensoredit"><i class="fas fa-edit euz_a_icon"></i></a>
															</div>
														</span>
													</li>
													<?php } ?>
												</ul>
											</li>
											<?php }//} ?>
										</ul>
									</li>
									<?php } ?>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!---Edit agent---->
<div class="modal fade" id="agenteditpop">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable euz_w_90">
		<div class="modal-content">
			<div class="modal-header euz_carb p-0">
				<h5 class="modal-title p-2 text-white">Edit Agent</h5>
			</div>
			<div class="modal-body"> <form action="{{ url('admin/updateagent') }}" method="POST" enctype="multipart/form-data">
				{{ csrf_field() }}
								
					<input type="hidden" name="eid" value="<?php echo $user[0]->id; ?>" class="hiddenid" />
					<div class="row">
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Customer ID</label>
							<input type="text" class="form-control" id="customer_id" name="customer_id" required value="<?php echo $user[0]->customer_id; ?>" readonly />
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">First Name</label>
							<input type="text" class="form-control" id="fname" name="fname" required value="<?php echo $user[0]->fname; ?>" />
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Last Name</label>
							<input type="text" class="form-control" id="lname" name="lname" required value="<?php echo $user[0]->lname; ?>" />
						</div>
						
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Organization</label>
							<input type="text" class="form-control" id="corporate_name" name="corporate_name" required value="<?php echo $user[0]->corporate_name; ?>" />
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Street</label>
							<input type="text" class="form-control" id="street" name="street" required value="<?php echo $user[0]->street; ?>" />
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">City</label>
							<input type="text" class="form-control" id="city" name="city" required value="<?php echo $user[0]->city; ?>" />
						</div>
						
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">State</label>
							<input type="text" class="form-control" id="state" name="state" required value="<?php echo $user[0]->state; ?>" />
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Post Code</label>
							<input type="text" class="form-control" id="post_code" name="post_code" required value="<?php echo $user[0]->post_code; ?>" />
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Country</label>
							<input type="text" class="form-control" id="country" name="country" required value="<?php echo $user[0]->country; ?>" />
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Subscription Start Date</label>
							<input type="date" class="form-control" id="service_start"  name="service_start" required value="<?php echo date('Y-m-d', strtotime($user[0]->service_start)); ?>" />
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Subscription End & Renew Date</label>
							<input type="date" class="form-control" id="service_expiry"  name="service_expiry" required value="<?php echo date('Y-m-d', strtotime($user[0]->service_expiry)); ?>" />
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Login Email</label>
							<input type="email" class="form-control" id="email" name="email" required value="<?php echo $user[0]->email; ?>" />
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Password</label>
							<input type="password" class="form-control" id="password" name="password" required value="<?php echo $user[0]->original; ?>" />
						</div>                          
						<div class="form-group col-lg-9 col-md-8">
							<label class="euz_b" for="">Remark</label>
							<input type="text" class="form-control" id="remark" name="remark" required value="<?php echo $user[0]->remark; ?>" />
						</div>
						<div class="form-group col-lg-3 col-md-4 py-2 mb-0">
							<label for="" class="euz_b">Active</label><br>
							<div class="custom-control custom-radio custom-control-inline">
								<input type="radio" value="1" class="custom-control-input" id="edityes" name="status" <?php if($user[0]->status == '1') { echo "checked"; } ?> />
								<label class="custom-control-label euz_b" for="edityes">Yes</label>
							</div>
							<div class="custom-control custom-radio custom-control-inline">
								<input type="radio" value="0" class="custom-control-input" id="editno" name="status" <?php if($user[0]->status == '0') { echo "checked"; } ?> />
								<label class="custom-control-label euz_b" for="editno">No</label>
							</div>
						</div>                       
						<div class="form-group col-md-8 py-2 mb-0">
							<label for="" class="euz_b">Send Mail</label>
							<input type="checkbox" name="" value="Y" id="" class="addsend" />
							<span> (System will send profile modification message to the corresponding login email id)</span>
						</div>
						<div class="form-group col-md-12 addsendmailshow">
							<textarea class="form-control disname" rows="10" id="template" placeholder="Dear << firstname >>, ....." name="template">
								<?php 
									if(!empty($user[0]->email_template)) 
									{ 
										echo $user[0]->email_template; 
									} 
									else 
									{ 
										echo $settings[0]->agent_email; 
									} 
								?> 
							</textarea>
						</div>            
					</div>
				
				<div class="modal-footer">
					<button type="submit" class="btn btn-success rounded-0" name="update">Update</button>
					<button type="button" class="btn btn-danger rounded-0" data-dismiss="modal">Cancel</button>
				</div>
			</form></div>
		</div>
	</div>
</div>
<!--End Edit Agent--->
<!---Add GatewayGroup---->
<div class="modal fade" id="groupadd">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable euz_w_90">
		<div class="modal-content">
			<div class="modal-header euz_carb p-0">
				<h5 class="modal-title p-2 text-white">Add New Gateway Group</h5>
				<button type="button" class="close" data-dismiss="modal">
				<span>×</span>
				</button>
			</div>
			<div class="modal-body">
			<form action="{{ url('/admin/insertgatewaygroup') }}" method="POST" enctype="multipart/form-data">
				{{ csrf_field() }}
				<div>          
					<div class="row">
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Agent</label>
							<input type="text" class="form-control" id="" value="<?php echo $user[0]->fname.' '.$user[0]->lname; ?>" disabled="disabled" name="" />
							<input type="hidden" name="agent" value="<?php echo $user[0]->id; ?>" />
						</div>
						<?php   
							$cus_id = DB::table('gateway_groups')->orderBy('id', 'desc')->first();							
							if(empty($cus_id->group_id)) 
							{
								$cusid = 'GW0001';
							}
							else
							{
								$cusid = $cus_id->group_id++;				
								$cusid = substr($cusid, 3, 5);
								$cusid = (int) $cusid + 1;
								$cusid = "GW" . sprintf('%04s', $cusid);
							}
						?>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Gateway Group ID</label>
							<input type="text" class="form-control" id="" value="<?php echo $cusid; ?>" readonly="readonly" name="group"/>
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Gateway Group Name</label>
							<div class="input-group">
								<select class="form-control select1" id="" name="sensor_group_id" required>
									<option value="">-Select Group Name-</option>
									@foreach($groupnames as $item)
									<option value="{{ $item->id }}">{{ $item->name }}</option>
									@endforeach
								</select>
								<div class="input-group-prepend">
									<a class="btn btn-primary" style="height: 33px;" data-toggle="modal" data-backdrop="static" data-target="#add"><i class="fas fa-plus"></i></a>
								</div>
							</div>
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Sim card / Ref:Id</label>
							<input type="text" class="form-control" id="" value="" name="sim_no" required />
						</div>
						
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Router Sensor Number</label>
							<input type="text" class="form-control" id="" value="" name="router_sensor_no" required />
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Longitude</label>
							<input type="text" class="form-control" id="" value="" name="longitude" />
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Latitude</label>
							<input type="text" class="form-control" id="" value="" name="latitude" />
						</div>						
						<div class="form-group col-lg-12 col-md-4">
							<label class="euz_b" for="">Gateway Group Information</label>
							<textarea type="text" class="form-control" id="" value="" rows="5" name="sensor_information" ></textarea>
						</div>					
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success rounded-0" >Save</button>
					<button type="button" class="btn btn-danger rounded-0" data-dismiss="modal">Cancel</button>
				</div>
			</form>
			</div>
		</div>
	</div>
</div>
<!--End AddGatewayGroup--->
<!---Edit GatewayGroup---->
<div class="modal fade" id="groupedit">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable euz_w_90">
		<div class="modal-content">
			<div class="modal-header euz_carb p-0">
				<h5 class="modal-title p-2 text-white">Edit GatewayGroup</h5>
				<button type="button" class="close" data-dismiss="modal">
				<span>×</span>
				</button>
			</div>
			<form action="{{ url('admin/updategatewaygroup') }}" method="POST" enctype="multipart/form-data">
				{{ csrf_field() }}
				<input type="hidden" name="eid" value="" id="groupid" />
				<div class="modal-body">
					<div class="row">
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Agent</label>
							<input type="text" class="form-control disname" id="" value="<?php echo $user[0]->fname.' '.$user[0]->lname; ?>" disabled="disabled">
							<input type="hidden" name="agent" value="<?php echo $user[0]->id; ?>" id="agent" />
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Gateway Group ID</label>
							<input type="text" class="form-control disname" id="groupidedit" value="" readonly name="group" />
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Gateway Group Name</label>
							<div class="input-group">
								<select class="form-control select1"  name="sensor_group_id" id="sensor_group_id" required>
									<option value="">-Select Group Name-</option>
									@foreach($groupnames as $item)
									<option value="{{ $item->id }}">{{ $item->name }}</option>
									@endforeach
								</select>
								<div class="input-group-prepend">
									<a class="btn btn-primary" style="height: 33px;" data-toggle="modal" data-backdrop="static" data-target="#add"><i class="fas fa-plus"></i></a>
								</div>
							</div>
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Sim card / Ref:Id</label>
							<input type="text" class="form-control" id="sim_no" value="" name="sim_no" />
						</div>
						
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Router Sensor Number</label>
							<input type="text" class="form-control" id="router_sensor_no" value="" name="router_sensor_no" />
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Longitude</label>
							<input type="text" class="form-control" id="longitude" value="" name="longitude" />
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Latitude</label>
							<input type="text" class="form-control" id="latitude" value="" name="latitude" />
						</div>
						
						<div class="form-group col-lg-12 col-md-4">
							<label class="euz_b" for="">Gateway Group Information</label>
							<textarea type="text" class="form-control" id="sensor_information" rows="5" name="sensor_information"></textarea>
						</div>                           
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success rounded-0">Update</button>
					<button type="button" class="btn btn-danger rounded-0" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!--End EditGatewayGroup--->
<!---Add SensorHub---->
<div class="modal fade" id="hubadd">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable euz_w_90">
		<div class="modal-content">
			<div class="modal-header euz_carb p-0">
				<h5 class="modal-title p-2 text-white">Add New Sensor Hub</h5>
				<button type="button" class="close" data-dismiss="modal">
				<span>×</span>
				</button>
			</div>
			<form action="{{ url('/admin/insertsensorhub') }}" method="POST" enctype="multipart/form-data">
			{{ csrf_field() }}
				<input type="hidden" value="<?php echo $user[0]->id; ?>" name="agent" id="" />
				<input type="hidden" value="" name="group_id" id="group_id" />
				<input type="hidden" value="" name="group" id="group" />
				<div class="modal-body">
					<div class="row">
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Agent</label>
							<input type="text" class="form-control" id="" value="<?php echo $user[0]->fname.' '.$user[0]->lname; ?>" disabled="disabled">
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Gateway Group Name</label>
							<input type="text" class="form-control" id="groupname" value="" disabled="disabled">
						</div>
						<?php   
							$cus_id = DB::table('sensor_hubs')->orderBy('id', 'desc')->first();							
							if(empty($cus_id->sensor_hub_id)) 
							{
								$cusid = 'SH0001';
							}
							else
							{
								$cusid = $cus_id->sensor_hub_id++;				
								$cusid = substr($cusid, 3, 5);
								$cusid = (int) $cusid + 1;
								$cusid = "SH" . sprintf('%04s', $cusid);
							}
						?>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Sensor Hub ID</label>
							<input type="text" class="form-control" id="" value="<?php echo $cusid; ?>" readonly name="hubid" />
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Sensor Hub Name</label>
							<select class="form-control" id="" name="hub" required>
								<option value="">-Select Hub Name-</option>
								@foreach($hublists as $item)
								<?php
									//$hub = explode('argus/report/', $item->hub);
								?>
								<option value="<?php echo $item->hub; ?>"><?php echo $item->hub; ?></option>
								@endforeach
							</select>
						</div>                           
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">MAC ID</label>
							<input type="text" class="form-control" required id="" value="" name="mac" />
						</div>
						
						<div class="form-group col-lg-12 col-md-4">
							<label class="euz_b" for="">Sensor Hub Information</label>
							<textarea type="text" class="form-control" id="" rows="5" name="inform" ></textarea>
						</div>                            
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success rounded-0">Save</button>
					<button type="button" class="btn btn-danger rounded-0" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!--End AddSensorHub--->
<!---Edit SensorHub---->
<div class="modal fade" id="hubedit">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable euz_w_90">
		<div class="modal-content">
			<div class="modal-header euz_carb p-0">
				<h5 class="modal-title p-2 text-white">Edit Sensor Hub</h5>
				<button type="button" class="close" data-dismiss="modal">
				<span>×</span>
				</button>
			</div>
			<form action="{{ url('admin/updatesensorhub') }}" method="POST" enctype="multipart/form-data">
				{{ csrf_field() }}
				<input type="hidden" name="eid" value="" id="groupsensoridedit" />
				<div class="modal-body">
					<div class="row">
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Agent</label>
							<input type="text" class="form-control" id="" value="<?php echo $user[0]->fname.' '.$user[0]->lname; ?>" disabled="disabled">
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Gateway Group Name</label>
							<input type="text" class="form-control" id="groupnameedit" value="" disabled="disabled">
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Sensor Hub ID</label>
							<input type="text" class="form-control" id="sensor_hub_id" value="" disabled="disabled">
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Sensor Hub Name</label>
							<select class="form-control" id="hub" name="hub" required>
								@foreach($hublists as $item)
								<?php
									//$hub = explode('argus/report/', $item->hub);
								?>
								<option value="<?php echo $item->hub; ?>"><?php echo $item->hub; ?></option>
								@endforeach
							</select>
						</div>
						
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">MAC ID</label>
							<input type="text" class="form-control" id="mac" value="" required name="mac">
						</div>
						
						<div class="form-group col-lg-12 col-md-4">
							<label class="euz_b" for="">Sensor Hub Information</label>
							<textarea type="text" class="form-control" id="inform" rows="5" name="inform" ></textarea>
						</div>
						
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success rounded-0">Update</button>
					<button type="button" class="btn btn-danger rounded-0" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!--End EditSensorHub--->
<!---Add Sensor---->
<div class="modal fade" id="sensoradd">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable euz_w_90">
		<div class="modal-content">
			<div class="modal-header euz_carb p-0">
				<h5 class="modal-title p-2 text-white">Add New Sensor</h5>
				<button type="button" class="close" data-dismiss="modal">
				<span>×</span>
				</button>
			</div>
			<form action="{{ url('/admin/insertsensor') }}" method="POST" enctype="multipart/form-data">
				{{ csrf_field() }}
				<input type="hidden" name="hub_id" id="hub_id" />
				<div class="modal-body">
					<div class="row">
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Agent</label>
							<input type="text" class="form-control" id="" value=" <?php echo $user[0]->fname.' '.$user[0]->lname; ?>" disabled="disabled">
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Gateway Group Name</label>
							<input type="text" class="form-control" id="groupnamesensor" value="" disabled="disabled">
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Sensor Hub Name</label>
							<input type="text" class="form-control" id="hubnamesensor" value="" disabled="disabled">
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Sensor ID</label>
							<select class="form-control" id="country_name" name="sensor_id" required>
								<option value="">-Select Sensor-</option>
							</select>
						</div>                  
						<div class="form-group col-lg-6 col-md-4">
							<label class="euz_b" for="">Name - Modal - Brand</label>
							<div class="input-group">
								<select class="form-control sensortype" id="sensortype" name="type" required>
									<option value="">-Select Type-</option>
									@foreach($types as $item)
										<option value="{{ $item->id }}"><?php echo $item->sname.'-'.$item->modal.'-'.$item->brand; ?></option>
									@endforeach
								</select>
								<div class="input-group-prepend">
									<a class="btn btn-primary" style="height: 33px;" data-toggle="modal" data-backdrop="static" data-target="#add"><i class="fas fa-plus"></i></a>
								</div>
							</div>
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Sensor Type</label>
							<input type="text" class="form-control" id="typedata" value="" name="typedata" required />
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Unit</label>
							<input type="text" class="form-control" id="unitdata" value="" name="unitdata" required />
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Value</label>
							<input type="text" class="form-control" id="valuedata" value="" name="valuedata" required />
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Min Value</label>
							<input type="text" class="form-control" id="brandsensor" value="" name="" disabled="disabled" />
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Max Value</label>
							<input type="text" class="form-control" id="brandunit" value="" name="" disabled="disabled" />
						</div>                       
						<div class="form-group col-lg-12 col-md-4">
							<label class="euz_b" for="">Sensor Information</label>
							<textarea type="text" class="form-control disname" id="remark" rows="5" name="inform"></textarea>
						</div>                
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success rounded-0">Save</button>
					<button type="button" class="btn btn-danger rounded-0" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!--End AddSensor--->
<!---Edit Sensor---->
<div class="modal fade" id="sensoredit">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable euz_w_90">
		<div class="modal-content">
			<div class="modal-header euz_carb p-0">
				<h5 class="modal-title p-2 text-white">Edit Sensor</h5>
				<button type="button" class="close" data-dismiss="modal">
				<span>×</span>
				</button>
			</div>
			<form action="{{ url('admin/updatesensor') }}" method="POST" enctype="multipart/form-data">
				{{ csrf_field() }}
				<input type="hidden" name="eid" value="" id="senosrid" />
				<input type="hidden" name="hub_id" value="" id="sensorhubid" />
				<div class="modal-body">
					<div class="row">
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Agent</label>
							<input type="text" class="form-control disname" id="" value="<?php echo $user[0]->fname.' '.$user[0]->lname; ?>" disabled="disabled">
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Gateway Group Name</label>
							<input type="text" class="form-control disname" id="groupnameeditsensor" value="" disabled="disabled">
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Sensor Hub Name</label>
							<input type="text" class="form-control disname" id="hubnameeditsensor" value="" disabled="disabled">
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Sensor ID</label>
							<select class="form-control" id="sensor_id" name="sensor_id" required></select>
						</div>					
						<div class="form-group col-lg-6 col-md-4">
							<label class="euz_b" for="">Name - Modal - Brand</label>
							<div class="input-group">
								<select class="form-control sensortype" id="sensortypeedit" name="type" required>
									<option value="">-Select Type-</option>
									@foreach($types as $item)
										<option value="{{ $item->id }}"><?php echo $item->sname.'-'.$item->modal.'-'.$item->brand; ?></option>
									@endforeach
								</select>
								<div class="input-group-prepend">
									<a class="btn btn-primary" style="height: 33px;" data-toggle="modal" data-backdrop="static" data-target="#add"><i class="fas fa-plus"></i></a>
								</div>
							</div>
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Sensor Type</label>
							<input type="text" class="form-control" id="typedataedit" value="" name="typedata" required />
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Unit</label>
							<input type="text" class="form-control" id="unitdataedit" value="" name="unitdata" required />
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Value</label>
							<input type="text" class="form-control" id="valuedataedit" value="" name="valuedata" required />
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Min Value</label>
							<input type="text" class="form-control" id="brandsensoredit" value="" name="" disabled="disabled" />
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Max Value</label>
							<input type="text" class="form-control" id="brandunitedit" value="" name="" disabled="disabled" />
						</div> 
						<div class="form-group col-lg-12 col-md-4">
							<label class="euz_b" for="">Sensor Information</label>
							<textarea type="text" class="form-control" rows="5" id="remarkedit" name="inform"></textarea>
						</div>                          
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success rounded-0">Update</button>
					<button type="button" class="btn btn-danger rounded-0" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!--End EditSensor--->
<!-- add groupname popup -->
<div class="modal fade" id="add">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header euz_carb p-0">
				<h5 class="modal-title p-2 text-white">Add New GatewayGroup</h5>
			</div>
			<form method="post" id="addform">
				{{ csrf_field() }}
				<div class="modal-body">
					<div class="row">
						<div class="form-group col-lg-12">
							<label class="euz_b" for="">New GatewayGroup</label>
							<input type="text" class="form-control" id="" value="" name="name" required />
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success rounded-0">Save</button>
					<button type="button" class="btn btn-danger rounded-0" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- add groupname popup -->
<script>
	$(document).on("click", ".groupedit", function () 
	{
		var passedID = $(this).data('id'); 
		var url = "{{ url('/admin/editgrouppop') }}";
		var docurl = url + "/" + passedID;
		$.ajax({
			url : docurl,
			method : "GET",
			dataType: 'json',
			success:function(data)
			{
				//alert(data.sensor_group_id); 
				$("#groupid").val(data.id);
				$("#agent").val(data.agent);
				$("#groupidedit").val(data.group_id);
				$("#sensor_group_id").val(data.sensor_group_id);					
				$("#sim_no").val(data.sim_no);
				$("#router_sensor_no").val(data.router_sensor_no);
				$("#longitude").val(data.longitude);
				$("#latitude").val(data.latitude);					
				$("#sensor_information").val(data.sensor_information);
			}
		});
	});
	$(document).on("click", ".hubadd", function () 
	{
		var passedID = $(this).data('id'); 
		var url = "{{ url('/admin/addgrouppop') }}";
		var docurl = url + "/" + passedID;
		$.ajax({
			url : docurl,
			method : "GET",
			dataType: 'json',
			success:function(data)
			{	
				$("#group_id").val(data.id);
				$("#group").val(data.sensor_group_id);
				$("#groupname").val(data.name);
			}
		});
	});	
	$(document).on("click", ".hubedit", function () 
	{
		var passedID = $(this).data('id'); 
		var url = "{{ url('/admin/editSensorhubpoptree') }}";
		var docurl = url + "/" + passedID;
		$.ajax({
			url : docurl,
			method : "GET",
			dataType: 'json',
			success:function(data)
			{
				$("#groupsensoridedit").val(data.hubid);
				$("#groupnameedit").val(data.groupname);
				$("#sensor_hub_id").val(data.sensor_hub_id);
				$("#hub").val(data.hub_id);
				$("#mac").val(data.mac_id);					
				$("#inform").val(data.hub_inform);
			}
		});
	});
	$(document).on("click", ".sensoradd", function () 
	{
		var passedID = $(this).data('id'); 
		var url = "{{ url('/admin/addsensorpop') }}";
		var docurl = url + "/" + passedID;
		$.ajax({
			url : docurl,
			method : "GET",
			dataType: 'json',
			success:function(data)
			{	
				$("#hub_id").val(data.hubid);
				$("#groupnamesensor").val(data.groupname);
				$("#hubnamesensor").val(data.hubname);
				var urlsensor = "{{ url('/admin/addsensorpopval') }}";
				var docurlsensor = urlsensor + "/" + data.hubname;
				//alert();
				$.ajax({
					url : docurlsensor,
					method : "GET",
					//dataType: 'json',
					success:function(data)
					{	
						//alert(data);
						$("#country_name").html(data);
					}
				});
			}
		});
	});
	$(document).on("click", ".sensoredit", function () 
	{
		var passedID = $(this).data('id'); 
		var url = "{{ url('/admin/editSensorpoptree') }}";
		var docurl = url + "/" + passedID;
		$.ajax({
			url : docurl,
			method : "GET",
			dataType: 'json',
			success:function(data)
			{
				$("#senosrid").val(data.sensorid);
				$("#sensorhubid").val(data.hubid);
				$("#groupnameeditsensor").val(data.groupname);
				$("#hubnameeditsensor").val(data.hubname);			
				$("#sensor_id").val(data.sensor_id);
				$("#sensortypeedit").val(data.type);					
				$("#brandsensoredit").val(data.min);
				$("#brandunitedit").val(data.max);
				$("#remarkedit").val(data.sensor_inform);
				$("#typedataedit").val(data.sensor_type);
				$("#unitdataedit").val(data.unitname);
				$("#valuedataedit").val(data.value);
				var sensorid = encodeURIComponent(data.sensor_id);
				var urlsensor = "{{ url('/admin/addsensorpopval2') }}";
				var docurlsensor = urlsensor + "/" + data.hubname + "/" + sensorid;
				//alert(data.sensor_id);
				$.ajax(
				{
					url : docurlsensor,
					method : "GET",
					success:function(data)
					{	
						//alert(data);
						$("#sensor_id").html(data);
					}
				});
			}
		});
	});
	$(".addsendmailshow").hide();
	$(function () 
	{
		$(".addsend").click(function () 
		{
			if ($(this).is(":checked")) 
			{
				$(".addsendmailshow").show();
			} 
			else 
			{
				$(".addsendmailshow").hide();
			}
		});
	});
	$('#addform').on('submit', function(event)
	{
		event.preventDefault();
		$.ajax(
		{      
			url:"{{  url('/admin/insertgrouppop') }}",
			method:"POST",
			data:new FormData(this),
			contentType: false,
			cache: false,
			processData: false,
			dataType: 'json',
			success: function(data)
			{
				if(data.error != 'exists')
				{
					alert('Group Name Added')
					$('#add').modal('hide');
					$('.select1').empty();
					var i=0;
					$.each(data, function(key, value) 
					{		
						$('.select1').append('<option value="'+ data[i].id +'">'+ data[i].name +'</option>');
						i++;
					});
				}  
				else
				{
					alert('You entered Gateway Group Name is already in list');
				}
			}
		});			
	}); 
	$('#country_name').on('change', function () 
	{
		var selectData = encodeURIComponent($('#country_name').val());
		// var url = "{{ url('/admin/sensordata') }}";
		// var docurl = url + "/" + selectData;
		var url = "{{ url('/admin/sensordata?val') }}";
		var docurl = url + "=" + selectData;
		$.ajax(
		{
			url : docurl,
			method : "GET",
			dataType: 'json',
			success:function(data)
			{
				//alert(data);
				$("#typedata").val(data.sensor_type);
				$("#unitdata").val(data.unit);
				$("#valuedata").val(data.value);
			}
		});
	});
	$('#sensortype').on('change', function () 
	{
		var selectData = $(this).val();
		// alert(selectData);
		var url = "{{ url('/admin/sensortype') }}";
		var docurl = url + "/" + selectData;
		//alert(docurl);
		$.ajax(
		{
			url : docurl,
			method : "GET",
			dataType: 'json',
			success:function(data)
			{
				$("#brandsensor").val(data.min);
				$("#brandunit").val(data.max);
				$("#remark").val(data.remark);
			}
		});
	});
	$('#sensortypeedit').on('change', function () 
	{
		var selectData = $(this).val();
		var url = "{{ url('/admin/sensortype') }}";
		var docurl = url + "/" + selectData;
		$.ajax(
		{
			url : docurl,
			method : "GET",
			dataType: 'json',
			success:function(data)
			{
				$("#brandsensoredit").val(data.min);
				$("#brandunitedit").val(data.max);
				$("#remarkedit").val(data.remark);
			}
		});
	});
	$('#sensor_id').on('change', function () 
	{  
		var selectData = encodeURIComponent($('#sensor_id').val());
		var url = "{{ url('/admin/sensordata?val') }}";
		var docurl = url + "=" + selectData;
		$.ajax(
		{
			url : docurl,
			method : "GET",
			dataType: 'json',
			success:function(data)
			{
				//alert(data);
				$("#typedataedit").val(data.sensor_type);
				$("#unitdataedit").val(data.unit);
				$("#valuedataedit").val(data.value);
			}
		});
	});
</script>
<style>
	.modal-backdrop.show 
	{
		z-index: 0 !important;
	}
</style>
