<?php error_reporting(0);?>
<div class="row">
	<div class="col-md-12">
		<div class="card euz_carb rounded-0 text-white">
			<div class="card-body">
				<h4 class="card-title m-0"><i class="fas fa-portrait text-info"></i> <?php echo $agents[0]->fname.' '.$agents[0]->lname; ?> / <?php echo $groups[0]->name; ?> /  <?php echo $group[0]->hub_id; ?><a href="javascript:void(0)" class="closebtn float-right" onclick="profileclosetree()">×</a></h4>
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
								<ul>
									<?php foreach($grouplists as $group) { ?>
									<li>
										<ul>
											<?php
												$hubs = DB::table('sensor_hubs')
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
														<a href="{{ url('/admin/sensors/'.$hub->agent.'/'.$hub->group_id.'/'.$hub->id) }}" class="float-left px-1"><i class="fas fa-eye euz_a_icon"></i></a>
														<a class="float-right px-1" href="<?php echo url('/admin/deleteSensorhub/'.$hub->id); ?>" onclick="return confirm('Are you sure do you want to delete?')"><i class="fas fa-trash-alt text-danger"></i></a>
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
                            <div class="input-group">
                                <select class="form-control disname select1" id="hub" name="hub" required>
                                    @foreach($hublists as $item3)
									<?php
										//$hub = explode('argus/report/', $item3->hub);
									?>
									<!--<option value="<?php //echo $item3->hub; ?>"><?php //echo $item3->hub; ?></option>-->
<option value="<?php echo $item3->hub_id; ?>"><?php echo $item3->hub_id; ?></option>

									@endforeach
                                </select>
                            </div>
                        </div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">MAC ID</label>
							<input type="text" class="form-control" id="mac" value="" name="mac" required>
						</div>
						
						<div class="form-group col-lg-12 col-md-4">
							<label class="euz_b" for="">Sensor Hub Information</label>
							<textarea type="text" class="form-control" id="inform" rows="5" name="inform" ></textarea>
						</div>
						
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success rounded-0 euz_bt"><i class="fas fa-sync"></i> Update</button>
					<button type="button" class="btn btn-danger rounded-0 euz_bt" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
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
									<a class="btn btn-primary" style="height: 33px;" data-toggle="modal" data-backdrop="static" data-target="#addtype"><i class="fas fa-plus"></i></a>
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
							<textarea type="text" class="form-control disname" id="remarksensor" rows="5" name="inform"></textarea>
						</div>                
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success rounded-0 euz_bt"><i class="far fa-save"></i> Save</button>
					<button type="button" class="btn btn-danger rounded-0 euz_bt" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
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
									<a class="btn btn-primary" style="height: 33px;" data-toggle="modal" data-backdrop="static" data-target="#addtype"><i class="fas fa-plus"></i></a>
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
					<button type="submit" class="btn btn-success rounded-0 euz_bt"><i class="fas fa-sync"></i> Update</button>
					<button type="button" class="btn btn-danger rounded-0 euz_bt" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!--End EditSensor--->
<!-- add type popup -->
<div class="modal fade" id="addtype">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header euz_carb p-0">
				<h5 class="modal-title p-2 text-white">Add New Type</h5>
			</div>
			<div class="modal-body row">
				<div class="form-group col-md-12 py-2 mb-0">										
					<form method="POST" enctype="multipart/form-data" id="addform">
						{{ csrf_field() }}
						<div class="row">
							<div class="form-group col-md-4">
								<label for="" class="euz_b">Sensor Name</label>
								<div class="input-group mb-3">								
									<input type="text" class="form-control" required="" id="" value="" name="sname">
								</div>
							</div>
							<div class="form-group col-md-4">
								<label for="" class="euz_b">Modal</label>
								<div class="input-group mb-3">								
									<input type="text" class="form-control" required="" id="" value="" name="modal">
								</div>
							</div>
							<!-- <div class="form-group col-md-4">
								<label for="" class="euz_b">Type Name</label>
								<div class="input-group mb-3">								
									<input type="text" class="form-control" required="" id="" value="" name="name">
								</div>
							</div> -->
							<div class="form-group col-md-4">
								<label for="" class="euz_b">Brand</label>
								<div class="input-group mb-3">
									<input type="text" class="form-control" required="" id="" value="" name="brand">
								</div>
							</div>	
							<!-- <div class="form-group col-md-4">
								<label for="" class="euz_b">Unit</label>
								<div class="input-group mb-3">
									<input type="text" class="form-control" required="" id="" value="" name="unit">
								</div>
							</div>							 -->
							<div class="form-group col-md-4">
								<label for="" class="euz_b">Min Value</label>
								<div class="input-group mb-3">
									<input type="text" class="form-control" required="" id="" value="" name="min">
								</div>
							</div>
							<div class="form-group col-md-4">
								<label for="" class="euz_b">Max Value</label>
								<div class="input-group mb-3">
									<input type="text" class="form-control" required="" id="" value="" name="max">
								</div>
							</div>
							<div class="form-group col-md-12">
								<label for="" class="euz_b">Remark</label>
								<div class="input-group mb-3">
									<textarea class="form-control" id="" name="remark" rows="5"></textarea>
								</div>
							</div>
						</div>
						<div class="input-group-append">
							<button type="submit" class="btn btn-success rounded-0 euz_bt"><i class="far fa-save"></i> Save</button>
							<button type="button" class="btn btn-danger rounded-0 euz_bt" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- add type popup -->
<script>	
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
				//var sensorid = encodeURIComponent(data.sensor_id);
				var sensorid = data.sensor_id;
				//var urlsensor = "{{ url('/admin/addsensorpopval2') }}";
				//var docurlsensor = urlsensor + "/" + data.hubname + "/" + sensorid;
				var hb=data.hubname;
				var urlsensor="{{ url('/admin/addsensorpopval2edit') }}";
				var docurlsensor = urlsensor+ "/1/2";
				
				$.ajax(
				{
					url : docurlsensor,
					method : "GET",
					data:{sensorid:sensorid,hb:hb},
					success:function(data)
					{	
						//alert(data);
						$("#sensor_id").html(data);
					}
				});
			}
		});
	});
	$('#country_name').on('change', function () 
	{
		var selectData = encodeURIComponent($('#country_name').val());
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
				$("#remarksensor").val(data.remark);
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
	