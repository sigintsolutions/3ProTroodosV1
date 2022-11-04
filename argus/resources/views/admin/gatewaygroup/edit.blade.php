<!--Editing Gateway Groups-->

<div class="row">
	<div class="col-md-12">
		<div class="card euz_carb rounded-0 text-white">
			<div class="card-body">
				<h4 class="card-title m-0"><i class="fas fa-portrait text-info"></i> <?php echo $user[0]->fname.' '.$user[0]->lname; ?> / @foreach($groups as $item2) @if($group[0]->sensor_group_id==$item2->id) {{ $item2->name }} @endif @endforeach<a href="javascript:void(0)" class="closebtn float-right" onclick="profileclose()">×</a></h4>
			</div>
		</div>
		<ul class="nav nav-tabs nav-justified">
			<li class="nav-item">
				<a class="nav-link active" data-toggle="tab" href="#agprofile">Gateway Group</a>
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
							<label class="euz_b" for="">Gateway Group ID</label>
							<input type="text" class="form-control" id="" value="<?php echo $group[0]->group_id; ?>" readonly="readonly" name="group" />
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Gateway Group Name</label>
							<div class="input-group">
    							<select class="form-control disname select1" id="" name="sensor_group_id" disabled="disabled">
    								<option value="">-Select Sensor Group-</option>
    								@foreach($groups as $item2)
    								@if($group[0]->sensor_group_id==$item2->id)
    								<option value="{{ $item2->id }}" selected="selected">{{ $item2->name }}</option>
    								@else
    								<option value="{{ $item2->id }}">{{ $item2->name }}</option>
    								@endif
    								@endforeach
    							</select>
    							<div class="input-group-prepend">
                                    <a class="btn btn-primary" style="height: 33px;" data-toggle="modal" data-backdrop="static" data-target="#add"><i class="fas fa-plus"></i></a>
                                </div>
							</div>
						</div>
						<div class="form-group col-lg-3 col-md-4">
							<label class="euz_b" for="">Sim card / Ref:Id</label>
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