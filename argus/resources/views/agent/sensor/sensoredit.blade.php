<!--Editing Sensor--->

<div class="row">
	<div class="col-md-12">
		<div class="card euz_carb rounded-0 text-white">
			<div class="card-body">
				<h4 class="card-title m-0"><i class="fas fa-portrait text-info"></i> <?php echo $user[0]->fname.' '.$user[0]->lname; ?> / <?php echo $groupname[0]->name; ?> / <?php echo $hubname[0]->hub_id; ?><a href="javascript:void(0)" class="closebtn float-right" onclick="profileclose()">×</a></h4>
			</div>
		</div>
		<ul class="nav nav-tabs nav-justified">
			<li class="nav-item">
				<a class="nav-link active" data-toggle="tab" href="#agprofile">Sensor</a>
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
							<label class="euz_b" for="">Gateway Group Name</label>
							<input type="text" class="form-control" id="" value="<?php echo $groupname[0]->name; ?>" disabled="disabled">
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Sensor Hub Name</label>
							<input type="text" class="form-control" id="" value="<?php echo $hubname[0]->hub_id; ?>" disabled="disabled">
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Sensor ID</label>
							<input type="text" class="form-control disname" id="" name="sensor_id" value="{{ $group[0]->sensor_id }}" disabled="disabled" />
						</div>
						<div class="form-group col-lg-6 col-md-4">
							<label class="euz_b" for="">Name - Modal - Brand</label>
							<select class="form-control disname" name="type" disabled="disabled" id="sensortype">
								@foreach($types as $item)
								@if($item->id==$group[0]->type)
								<option value="{{ $item->id }}" selected="selected"><?php echo $item->sname.'-'.$item->modal.'-'.$item->brand; ?></option>
								@else
								<option value="{{ $item->id }}"><?php echo $item->sname.'-'.$item->modal.'-'.$item->brand; ?></option>
								@endif
								@endforeach
							</select>
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Sensor Type</label>
							<input type="text" class="form-control" id="brandsensorpro" value="{{ $group[0]->sensor_type }}" name="" disabled="disabled" />
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Unit</label>
							<input type="text" class="form-control" id="brandunitpro" value="{{ $group[0]->unit }}" name="" disabled="disabled" />
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Value</label>
							<input type="text" class="form-control" id="brandsensorpro" value="{{ $group[0]->value }}" name="" disabled="disabled" />
						</div>

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
							<textarea type="text" class="form-control disname" id="" rows="5" disabled="disabled" name="inform">{{ $group[0]->sensor_inform }}</textarea>
						</div>						
						<div class="col-md-12">
							<a class="btn btn-danger float-right euz_all_edc ml-2" href="javascript:void(0)" onclick="profileclose()"><i class="fas fa-times" ></i> Cancel</a>
						</div>						
					</div>
				</form>
			</div>
		</div>
	</div>
</div>