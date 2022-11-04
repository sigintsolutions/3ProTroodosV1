<!--Editing hub--->
<div class="row">
	<div class="col-md-12">
		<div class="card euz_carb rounded-0 text-white">
			<div class="card-body">
				<h4 class="card-title m-0"><i class="fas fa-portrait text-info"></i> <?php echo $agents[0]->fname.' '.$agents[0]->lname; ?> / <?php echo $groups[0]->name; ?> /  <?php echo $hubname[0]->hub_id; ?><a href="javascript:void(0)" class="closebtn float-right" onclick="profileclose()">×</a></h4>
			</div>
		</div>
		<ul class="nav nav-tabs nav-justified">
			<li class="nav-item">
				<a class="nav-link active" data-toggle="tab" href="#agprofile">Sensor Hub</a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active p-3" id="agprofile">
				<form action="{{ url('admin/updatesensorhub') }}" method="POST" enctype="multipart/form-data">
					{{ csrf_field() }}
					<input type="hidden" name="eid" value="{{ $group[0]->id }}" id="eid" />
					<div class="row">
							<div class="form-group col-lg-3 col-md-4">
								<label class="euz_b" for="">Agent</label>
								<input type="text" class="form-control" id="" value="<?php echo $agents[0]->fname.' '.$agents[0]->lname; ?>" disabled>
							</div>
							<div class="form-group col-lg-3 col-md-4">

								<label class="euz_b" for="">Gateway Group Name</label>
								<input type="text" class="form-control" id="" value="<?php echo $groups[0]->name; ?>" disabled>
							</div>
							<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Sensor Hub ID</label>
							<input type="text" class="form-control" id="" value="{{ $group[0]->sensor_hub_id }}" disabled>
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Sensor Hub Name</label>
							<select class="form-control disname" id="" name="hub" disabled="disabled">
								<option value="<?php echo $hubname[0]->hub_id; ?>"><?php echo $hubname[0]->hub_id; ?></option>
							</select>						
						</div>			
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">MAC ID</label>
							<input type="text" class="form-control disname" id="" name="mac" value="{{ $group[0]->mac_id}}" disabled="disabled">
						</div>
						
						<div class="form-group col-lg-12 col-md-4">
							<label class="euz_b" for="">Sensor Hub Information</label>
							<textarea type="text" class="form-control disname" id="" rows="5" disabled="disabled" name="inform" >{{ $group[0]->hub_inform}}</textarea>
						</div>
						
						<div class="col-md-12">
							<a class="btn btn-danger float-right euz_all_edc ml-2" href="javascript:void(0)" onclick="profileclose()"><i class="fas fa-times"></i> Cancel</a>
						</div>				
					</div>
				</form>
			</div>
		</div>
	</div>
</div>