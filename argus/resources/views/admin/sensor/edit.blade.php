
<!--Edit Sensor-->

<div class="row">
	<div class="col-md-12">
		<div class="card euz_carb rounded-0 text-white">
			<div class="card-body">
				<h4 class="card-title m-0"><i class="fas fa-portrait text-info"></i> <?php echo $user[0]->fname.' '.$user[0]->lname; ?> / <?php echo $groupname[0]->name; ?> / <?php echo $hubname[0]->hub_id; ?>/ {{ $group[0]->sensor_id }}<a href="javascript:void(0)" class="closebtn float-right" onclick="profileclose()">×</a></h4>
			</div>
		</div>
		<ul class="nav nav-tabs nav-justified">
			<li class="nav-item">
				<a class="nav-link active" data-toggle="tab" href="#agprofile">Sensor</a>
			</li>
			<!--<li class="nav-item">-->
			<!--	<a class="nav-link" data-toggle="tab" href="#treecom">Tree View</a>-->
			<!--</li>-->
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
							<input type="text" class="form-control" id="" value="<?php echo $hubname[0]->hub_id; ?>" disabled="disabled">
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Sensor ID</label>
							<!-- <input type="text" class="form-control disname" id="sensor_idpro" name="sensor_id" value="{{ $group[0]->sensor_id }}" disabled="disabled" autocomplete="off" />
							<div id="countryListpro"></div> -->
							<select class="form-control disname" id="sensor_idpro" name="sensor_id" disabled="disabled" required>
								<option value="{{ $group[0]->sensor_id }}">{{ $group[0]->sensor_id }}</option>
								@foreach($data as $item)
									<option value="{{ $item->sensor_id }}"><?php echo $item->sensor_id; ?></option>
								@endforeach
							</select>
						</div>
						<div class="form-group col-lg-6 col-md-4">
							<label class="euz_b" for="">Model Name - Model - Brand</label>
							<div class="input-group">
							    <select class="form-control disname sensortype" name="type" disabled="disabled" id="sensortype" required>
    								@foreach($types as $item)
    								@if($item->id==$group[0]->type)
    								<option value="{{ $item->id }}" selected="selected"><?php echo $item->sname.'-'.$item->modal.'-'.$item->brand; ?></option>
    								@else
    								<option value="{{ $item->id }}"><?php echo $item->sname.'-'.$item->modal.'-'.$item->brand; ?></option>
    								@endif
    								@endforeach
    							</select>
    							<div class="input-group-prepend">
                                    <a class="btn btn-primary" style="height: 33px;" data-toggle="modal" data-backdrop="static" data-target="#add"><i class="fas fa-plus"></i></a>
                                </div>
                            </div>
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Sensor Type</label>
							<input type="text" class="form-control disname" id="typedatapro" value="<?php echo $group[0]->sensor_type; ?>" name="typedata" required disabled="disabled" />
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Unit</label>
							<input type="text" class="form-control disname" id="unitdatapro" value="<?php echo $group[0]->unit; ?>" name="unitdata" required disabled="disabled" />
						</div>
						<!--<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Value</label>
							<input type="text" class="form-control disname" id="valuedatapro" value="<?php //echo $group[0]->value; ?>" name="valuedata" required disabled="disabled" />
						</div>-->
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Min Value</label>
							<input type="text" class="form-control" id="brandsensorpro" value="<?php echo $typname[0]->min; ?>" name="" disabled="disabled" />
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Max Value</label>
							<input type="text" class="form-control" id="brandunitpro" value="<?php echo $typname[0]->max; ?>" name="" disabled="disabled" />
						</div>
						<div class="form-group col-lg-12 col-md-4">
							<label class="euz_b" for="">Sensor Information</label>
							<textarea type="text" class="form-control disname" id="remarkeditpro" rows="5" disabled="disabled" name="inform">{{ $group[0]->sensor_inform }}</textarea>
						</div>						
						<div class="col-md-12">
							<a class="btn btn-danger float-right euz_all_edc ml-2" href="javascript:void(0)" onclick="profileclose()"><i class="fas fa-times" ></i> Cancel</a>
							<button class="btn btn-success float-right euz_all_edc ml-2 btnupdate" type="submit"><i class="far fa-save"></i> Update</button>
							<a class="btn btn-primary float-right euz_all_edc ml-2 btnenable" href="javascript:void(0)"><i class="far fa-edit"></i> Edit</a>
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
									<div class="agent_tree text-white"><?php echo $user[0]->fname.' '.$user[0]->lname; ?></div>
									<div class="agent_tree1">
										<a href="<?php echo url('/admin/deleteAgent/'.$user[0]->id); ?>"><i class="fas fa-trash-alt text-danger"></i></a>
										<a href="javascript:void(0)" class="modalLink"  data-id="{{ $user[0]->id }}" data-toggle="modal" data-target="#agentedit"><i class="fas fa-edit euz_a_icon"></i></a>
										<a href="javascript:void(0)" data-toggle="modal" data-target="#groupadd"><i class="fas fa-plus-square text-info"></i></a>
									</div>
								</span>
								<ul>
									<?php foreach($grouplists as $group) { ?>
									<li>
										<span>
											<div class="group_tree text-white"><?php echo $group->name; ?></div>
											<div class="group_tree1">
												<a href="<?php echo url('/admin/deleteGatewaygroup/'.$group->id); ?>"><i class="fas fa-trash-alt text-danger"></i></a>
												<a href="javascript:void(0)" class="groupedit" data-id="{{ $group->id }}" data-toggle="modal" data-target="#groupedit"><i class="fas fa-edit euz_a_icon"></i></a>
												<a href="javascript:void(0)" class="hubadd" data-id="{{ $group->id }}" data-toggle="modal" data-target="#hubadd"><i class="fas fa-plus-square text-info"></i></a>
											</div>
										</span>
										<ul>
											<?php
												$hubs = DB::table('sensor_hubs')
												->join('hubs', 'hubs.id', '=', 'sensor_hubs.hub_id')
												->where('sensor_hubs.agent', $user[0]->id)
												->where('sensor_hubs.group_id', $group->id)
												->select('sensor_hubs.*', 'sensor_hubs.sensor_hub_id','hubs.name','hubs.id as hid')
												->orderBy('added_on', 'DESC')
												->get();
												foreach($hubs as $hub) { 
												//if(!empty($hub->name)) {
											?>
											<li>
												<span>
													<div class="sensorhub_tree text-white"><?php echo $hub->name; ?></div>
													<div class="sensorhub_tree1">
														<a href="<?php echo url('/admin/deleteSensorhub/'.$hub->id); ?>"><i class="fas fa-trash-alt text-danger"></i></a>
														<a href="javascript:void(0)" class="hubedit" data-toggle="modal" data-id="{{ $hub->id }}" data-target="#hubedit"><i class="fas fa-edit euz_a_icon"></i></a>
														<a href="javascript:void(0)" class="sensoradd" data-id="{{ $hub->id }}" data-toggle="modal" data-target="#sensoradd"><i class="fas fa-plus-square text-info"></i></a>
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
															<div class="sensor_tree1">
																<a href="<?php echo url('/admin/deleteSensor/'.$sensor->id); ?>"><i class="fas fa-trash-alt text-danger"></i></a>
																<a href="javascript:void(0)" class="sensoredit" data-id="{{ $sensor->id }}" data-toggle="modal" data-target="#sensoredit"><i class="fas fa-edit euz_a_icon"></i></a>
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
<div class="modal fade" id="agentedit">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable euz_w_90">
		<div class="modal-content">
			<div class="modal-header euz_carb p-0">
				<h5 class="modal-title p-2 text-white">Edit Agent</h5>
				<button type="button" class="close" data-dismiss="modal">
				<span>×</span>
				</button>
			</div>
			<form action="{{ url('admin/updateagent') }}" method="POST" enctype="multipart/form-data">
				{{ csrf_field() }}
				<div class="modal-body">              
					<input type="hidden" name="eid" value="" class="hiddenid" />
					<div class="row">
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Customer ID</label>
							<input type="text" class="form-control" id="customer_id" name="customer_id" required value="" readonly />
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">First Name</label>
							<input type="text" class="form-control" id="fname" name="fname" required value="" />
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Last Name</label>
							<input type="text" class="form-control" id="lname" name="lname" required value="" />
						</div>
						
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Corporate Name</label>
							<input type="text" class="form-control" id="corporate_name" name="corporate_name" required value="" />
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Street</label>
							<input type="text" class="form-control" id="street" name="street" required value="" />
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">City</label>
							<input type="text" class="form-control" id="city" name="city" required value="" />
						</div>
						
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">State</label>
							<input type="text" class="form-control" id="state" name="state" required value="" />
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Post Code</label>
							<input type="text" class="form-control" id="post_code" name="post_code" required value="" />
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Country</label>
							<input type="text" class="form-control" id="country" name="country" required value="" />
						</div>
						
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Service Expiry</label>
							<input type="text" class="form-control" id="service_expiry"  name="service_expiry" required value="" />
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">User Email</label>
							<input type="email" class="form-control" id="email" name="email" required value="" />
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Password</label>
							<input type="password" class="form-control" id="passowrd" name="passowrd" required value="" />
						</div>                          
						<div class="form-group col-lg-9 col-md-8">
							<label class="euz_b" for="">Remark</label>
							<input type="text" class="form-control" id="remark" name="remark" required value="" />
						</div>
						<div class="form-group col-lg-3 col-md-4 py-2 mb-0">
							<label for="" class="euz_b">Active</label><br>
							<div class="custom-control custom-radio custom-control-inline">
						<input type="radio" value="1" class="custom-control-input" id="edityes" name="status" />
								<label class="custom-control-label euz_b" for="edityes">Yes</label>
							</div>
							<div class="custom-control custom-radio custom-control-inline">
								<input type="radio" value="0" class="custom-control-input" id="editno" name="status" />
								<label class="custom-control-label euz_b" for="editno">No</label>
							</div>
						</div>                       
						<div class="form-group col-md-6 py-2 mb-0">
							<label for="" class="euz_b">Send Mail</label>
							<input type="checkbox" name="" value="Y" id="" class="addsend" checked>
						</div>
						<div class="form-group col-md-12">
							<textarea type="text" class="form-control disname" rows="10" id="template" placeholder="Dear << firstname >>, ....." name="template"></textarea>
						</div>            
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success rounded-0" name="update">Update</button>
					<button type="button" class="btn btn-danger rounded-0 close" data-dismiss="modal" >Cancel</button>
				</div>
			</form>
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
			<form action="{{ url('/admin/insertgatewaygroup') }}" method="POST" enctype="multipart/form-data">
				{{ csrf_field() }}
				<div class="modal-body">          
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
							<label class="euz_b" for="">Groupway Group ID</label>
							<input type="text" class="form-control" id="" value="<?php echo $cusid; ?>" readonly="readonly" name="group" />
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Gateway Group Name</label>
							<select class="form-control" id="" name="sensor_group_id" required>
								<option value="">-Select Group Name-</option>
								@foreach($groupnames as $item)
								<option value="{{ $item->id }}">{{ $item->name }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">SIM Card Number</label>
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
					<button type="button" class="btn btn-danger rounded-0 close" data-dismiss="modal">Cancel</button>
				</div>
			</form>
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
							<label class="euz_b" for="">Groupway Group ID</label>
							<input type="text" class="form-control disname" id="groupidedit" value="" readonly name="group" />
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Gateway Group Name</label>
							<select class="form-control"  name="sensor_group_id" id="sensor_group_id" required>
								<option value="">-Select Group Name-</option>
								@foreach($groupnames as $item)
								<option value="{{ $item->id }}">{{ $item->name }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">SIM Card Number</label>
							<input type="text" class="form-control" id="sim_no" value="" name="sim_no" required />
						</div>
						
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Router Sensor Number</label>
							<input type="text" class="form-control" id="router_sensor_no" required value="" name="router_sensor_no" />
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
							<label class="euz_b" for="">Groupway Group Name</label>
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
							<select class="form-control" id="" name="hub">
								<option value="">-Select Hub Name-</option>
								@foreach($hublists as $item)
								<option value="{{ $item->id }}">{{ $item->name }}</option>
								@endforeach
							</select>
						</div>                           
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">MAC ID</label>
							<input type="text" class="form-control" id="" value="" name="mac" />
						</div>
						
						<div class="form-group col-lg-12 col-md-4">
							<label class="euz_b" for="">Sensor Hub Information</label>
							<textarea type="text" class="form-control" id="" rows="5" name="inform" ></textarea>
						</div>                            
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success rounded-0">Save</button>
					<button type="button" class="btn btn-danger rounded-0 close" data-dismiss="modal">Cancel</button>
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
							<label class="euz_b" for="">Groupway Group Name</label>
							<input type="text" class="form-control" id="groupnameedit" value="" disabled="disabled">
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Sensor Hub ID</label>
							<input type="text" class="form-control" id="sensor_hub_id" value="" disabled="disabled">
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Sensor Hub Name</label>
							<select class="form-control" id="hub" name="hub">
								@foreach($hublists as $item3)
								<option value="{{ $item3->id }}">{{ $item3->name }}</option>
								@endforeach
							</select>
						</div>
						
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">MAC ID</label>
							<input type="text" class="form-control" id="mac" value="" name="mac">
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
<!--<div class="modal fade" id="sensoradd">
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
							<label class="euz_b" for="">Groupway Group Name</label>
							<input type="text" class="form-control" id="groupnamesensor" value="" disabled="disabled">
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Sensor Hub Name</label>
							<input type="text" class="form-control" id="hubnamesensor" value="" disabled="disabled">
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Sensor ID</label>
							<input type="text" class="form-control" id="" value="" name="sensor_id" />
						</div>                  
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Type</label>
							<select class="form-control" id="" name="type">
								<option value="">-Select Type-</option>
								@foreach($types as $item)
									<option value="{{ $item->id }}">{{ $item->name }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Brand</label>
							<select class="form-control" id="" name="brand">
								<option value="">-Select Brand-</option>
								@foreach($brands as $item)
								<option value="{{ $item->id }}">{{ $item->name }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Measurement Unit</label>
							<select class="form-control" id="" name="unit">
								<option value="">-Select Unit-</option>
								@foreach($units as $item)
								<option value="{{ $item->id }}">{{ $item->minimum }} {{ $item->unit }} - {{ $item->maximum }} {{ $item->unit }}</option>
								@endforeach
							</select>
						</div>                          
						<div class="form-group col-lg-12 col-md-4">
							<label class="euz_b" for="">Sensor Information</label>
							<textarea type="text" class="form-control disname" id="" rows="5" name="inform"></textarea>
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
</div>-->
<!--End AddSensor--->
<!---Edit Sensor---->
<!--<div class="modal fade" id="sensoredit">
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
							<label class="euz_b" for="">Groupway Group Name</label>
							<input type="text" class="form-control disname" id="groupnameeditsensor" value="" disabled="disabled">
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Sensor Hub Name</label>
							<input type="text" class="form-control disname" id="hubnameeditsensor" value="" disabled="disabled">
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Sensor ID</label>
							<input type="text" class="form-control disname" id="sensor_id" value="" name="sensor_id">
						</div>
						
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Type</label>
								<select class="form-control disname" id="type" name="type">
								@foreach($types as $item)
								<option value="{{ $item->id }}">{{ $item->name }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Brand</label>
							<select class="form-control disname" id="brand" name="brand">
								@foreach($brands as $item2)
								<option value="{{ $item2->id }}">{{ $item2->name }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Measurement Unit</label>
							<select class="form-control disname" id="unit" name="unit">
								@foreach($units as $item3)
								<option value="{{ $item3->id }}">{{ $item3->minimum }} - {{ $item3->maximum }}</option>
								@endforeach
							</select>
						</div>                          
						<div class="form-group col-lg-12 col-md-4">
							<label class="euz_b" for="">Sensor Information</label>
							<textarea type="text" class="form-control disname" rows="5" id="sensorinform" name="inform"></textarea>
						</div>                           
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success rounded-0">Update</button>
					<button type="button" class="btn btn-danger rounded-0 close" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>-->
<!--End EditSensor--->
<script>
	$(".btnupdate").hide();	
	$(".btnenable").click(function() {
		$(".disname").removeAttr("disabled");
		$(".btnupdate").show(); 
		$(".btnenable").hide();
	});
	$(document).on("click", ".modalLink", function () 
	{
		var passedID = $(this).data('id'); 
		var url = "{{ url('/admin/editAgentpop') }}";
		var docurl = url + "/" + passedID;
		$.ajax({
			url : docurl,
			method : "GET",
			dataType: 'json',
			success:function(data)
			{
				
				if(data.status == '1')
				{
					$("#edityes").attr('checked', 'checked');
				}
				else
				{
					$("#editno").attr('checked', 'checked');
				}
				$(".hiddenid").val(data.id);
				$("#customer_id").val(data.customer_id);
				$("#fname").val(data.fname);					
				$("#lname").val(data.lname);
				$("#corporate_name").val(data.corporate_name);
				$("#street").val(data.street);
				$("#city").val(data.city);					
				$("#state").val(data.state);
				$("#post_code").val(data.post_code);
				$("#country").val(data.country);
				$("#service_expiry").val(data.service_expiry);					
				$("#email").val(data.email);
				$("#passowrd").val(data.original);
				$("#remark").val(data.remark);
				$("#template").val(data.email_template);
			}
		});
	});
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
			}
		});
	});
	// $(document).on("click", ".sensoredit", function () 
	// {
	// 	var passedID = $(this).data('id'); 
	// 	var url = "{{ url('/admin/editSensorpoptree') }}";
	// 	var docurl = url + "/" + passedID;
	// 	$.ajax(
	// 	{
	// 		url : docurl,
	// 		method : "GET",
	// 		dataType: 'json',
	// 		success:function(data)
	// 		{
	// 			$("#senosrid").val(data.sensorid);
	// 			$("#sensorhubid").val(data.hubid);
	// 			$("#groupnameeditsensor").val(data.groupname);
	// 			$("#hubnameeditsensor").val(data.hubname);
	// 			$("#sensor_id").val(data.sensor_id);
	// 			$("#type").val(data.type);					
	// 			$("#brand").val(data.brand);
	// 			$("#unit").val(data.measure_unit);
	// 			$("#sensorinform").val(data.sensor_inform);
	// 		}
	// 	});
	// });
	$('#sensortype').on('change', function () 
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
				$("#brandsensorpro").val(data.min);
				$("#brandunitpro").val(data.max);
				$("#remarkeditpro").val(data.remark);
			}
		});
	});
	$(document).ready(function()
	{
		$('#sensor_idpro').on('change', function () 
		{  
			var selectData = encodeURIComponent($('#sensor_idpro').val());
			var url = "{{ url('/admin/sensordata') }}";
			var docurl = url + "/" + selectData;
			$.ajax(
			{
				url : docurl,
				method : "GET",
				dataType: 'json',
				success:function(data)
				{
					//alert(data);
					$("#typedatapro").val(data.sensor_type);
					$("#unitdatapro").val(data.unit);
					$("#valuedatapro").val(data.value);
				}
			});
		});
	});
</script>
<style>
	.modal-backdrop.show 
	{
		z-index: 0 !important;
	}
</style>