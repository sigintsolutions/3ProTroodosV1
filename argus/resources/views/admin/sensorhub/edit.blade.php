<!--Edit Sensor Hub-->
<div class="row">
	<div class="col-md-12">
		<div class="card euz_carb rounded-0 text-white">
			<div class="card-body">
				<h4 class="card-title m-0"><i class="fas fa-portrait text-info"></i> <?php echo $agents[0]->fname.' '.$agents[0]->lname; ?> / <?php echo $groups[0]->name; ?> /  <?php echo $group[0]->hub_id; ?><a href="javascript:void(0)" class="closebtn float-right" onclick="profileclose()">×</a></h4>
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
							<select class="form-control disname select1" id="" name="hub" disabled="disabled">
								<option value="">-Select Hub Name-</option>
								@foreach($hubs as $item3)
								<?php
									//$hub = explode('argus/report/', $item3->hub);
									if($group[0]->hub_id==$item3) {
								?>   								
								<option value="<?php echo $item3; ?>" selected="selected"><?php echo $item3; ?></option>
								<?php } else { ?>
								<option value="<?php echo $item3; ?>"><?php echo $item3; ?></option>
								<?php } ?>
								@endforeach
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
							<a class="btn btn-danger float-right euz_all_edc ml-2" href="javascript:void()" onclick="profileclose()"><i class="fas fa-times"></i> Cancel</a>
							<button class="btn btn-success float-right euz_all_edc ml-2 btnupdate" type="submit"><i class="far fa-save"></i> Update</button>
							<a class="btn btn-primary float-right euz_all_edc ml-2 btnenable" href="#"><i class="far fa-edit"></i> Edit</a>
						</div>				
					</div>
				</form>
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
<style>
	.modal-backdrop.show 
	{
		z-index: 0 !important;
	}
</style>
	