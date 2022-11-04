@extends('layouts.admin')
@section('content')

<?php //print_r($user); ?>

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
									<a class="nav-link euz_tabtex" href="/admin/gatewaygroups"><i class="fas fa-users"></i> Add Gateway Group</a>
								</li>
								<li class="nav-item">
									<a class="nav-link euz_tabtex active" href="/admin/sensorhubs"><i class="fas fa-microchip"></i> Add Sensor Hub</a>
								</li>
							</ul>
			
								<!-- Tab panes -->
							<div class="tab-content px-3">
								<div id="agent11" class="tab-pane active"><br>
									
									<div class="row euz_newadmin_form_q">
										<div class="col-md-12 mb-1 p-0">
											<a class="btn euz_btn_add float-right euz_pointer mb-3 euz_back_btn_q" href="/admin/sensorhubs"><i class="far fa-arrow-alt-circle-left"></i> Back</a>										
										</div>
										<div class="col-md-12 shadow-sm">
										<div class="row">
										
										<div class="col-md-12 euz_header">
											<p class="text-white euz_b">Edit Sensor Hub</p>
										</div>
										<form action="{{ url('admin/updatesensorhub') }}" method="POST" enctype="multipart/form-data">
										{{ csrf_field() }}
										<input type="hidden" name="eid" value="{{ $group[0]->id }}" id="eid" />
										<div class="col-md-12 euz_border">
											<div class="row p-2">
												<div class="form-group col-md-3 py-2 mb-0">
													<label for="" class="euz_b">Sensor Hub ID</label>
													<input type="text" class="form-control" id="hub_id" name="hub_id" value="{{ $group[0]->sensor_hub_id }}" disabled>
													<input type="hidden" value="{{ $group[0]->sensor_hub_id }}" name="hubid" id="hubid" />
												</div>
												<div class="form-group col-md-3 py-2 mb-0">
													<label for="" class="euz_b">Agent</label>
													<select class="form-control" id="agent" name="agent">
														<option value="">-Select Agent-</option>
														@foreach($agents as $item2)
														@if($group[0]->agent==$item2->id)
														<option value="{{ $item2->id }}" selected="selected">{{ $item2->fname }}</option>
														@else
														<option value="{{ $item2->id }}">{{ $item2->fname }}</option>
														@endif
														@endforeach
													</select>
												</div>
												<div class="form-group col-md-3 py-2 mb-0">
													<label for="" class="euz_b">Sensor Group Name</label>
													<div class="input-group">
														<select class="form-control" id="group" name="group">
															<option value="">-Select Sensor Group-</option>
															@foreach($groups as $item2)
															@if($group[0]->sensor_group_id==$item2->id)
															<option value="{{ $item2->id }}" selected="selected">{{ $item2->name }}</option>
															@else
															<option value="{{ $item2->id }}">{{ $item2->name }}</option>
															@endif
															@endforeach
														</select>
														<div class="input-group-append">
															<button class="btn euz_btn_add" type="button" data-toggle="modal" data-target="#sensorgroup"><i class="fas fa-plus"></i></button> 
														</div>
													</div>
													<!--- MODAL -->
													
													<!--- END MODAL -->
												</div>
												<div class="form-group col-md-3 py-2 mb-0">
													<label for="" class="euz_b">Hub Name</label>
													<div class="input-group">
														<select class="form-control" id="hub" name="hub">
															<option value="">-Select Hub Name-</option>
															@foreach($hubs as $item3)
															@if($group[0]->hub_id==$item3->id)
															<option value="{{ $item3->id }}" selected="selected">{{ $item3->name }}</option>
															@else
															<option value="{{ $item3->id }}">{{ $item3->name }}</option>
															@endif
															@endforeach
														</select>
														<div class="input-group-append">
															<button class="btn euz_btn_add" type="button" data-toggle="modal" data-target="#hubgroup"><i class="fas fa-plus"></i></button> 
														</div>
													</div>
													<!--- MODAL HUB NAME -->
													
													<!--- END MODAL HUB NAME -->
												</div>
												
												<div class="form-group col-md-3 py-2 mb-0">
													<label for="" class="euz_b">MAC ID</label>
													<input type="text" class="form-control" id="mac" name="mac" value="{{ $group[0]->mac_id}}">
												</div>
												<div class="form-group col-md-9 py-2 mb-0">
													<label for="" class="euz_b">Hub Information</label>
													<textarea type="text" class="form-control" rows="1" id="inform" name="inform" >{{ $group[0]->hub_inform}}</textarea>
												</div>
											
											</div>									
											<div class="row bg-light">
												<div class="col-md-12 p-2">
													<button type="submit" class="euz_ingreen"><i class="fas fa-save"></i> Update</button>
													&nbsp;&nbsp;
													<a href="/admin/sensorhubs" class="euz_inred"><i class="fas fa-broom"></i> Cancel</a>
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
		
		<div class="modal fade" id="hubgroup">
														<div class="modal-dialog modal-dialog-centered">
															<div class="modal-content shadow">
															<div class="modal-header euz_header  rounded-0">
																<p class="text-white euz_b">Add Hub Name</p>
																<button type="button" class="close" data-dismiss="modal">
																<span>×</span>
																</button>
															</div>
															
															<div class="modal-body row">
																<div class="form-group col-md-12 py-2 mb-0">
																	<label for="" class="euz_b">Hub Name</label>
																	<form action="inserthub" method="POST" enctype="multipart/form-data">
																	<div class="input-group mb-3">
																		<input type="text" class="form-control" id="name" name="name" pattern="[a-zA-Z0-9 ]+" title="Only Alpha-Numeric Values" required>
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
					<i class="fas fa-user-tie euz_text_blue"></i> <small class="euz_b euz_text_blue"><a class="euz_text_blue euz_pointer add_admin_back">Admin</a> / <i class="fas fa-user-plus"></i> Edit Admin</small>
				</div>
				@if(Session::has('flash_message'))
				<div class="alert alert-success w-100"><button type="button" class="close" data-dismiss="alert">&times;</button>{{ Session::get('flash_message') }}</div>
				@endif
				<div class="col-md-12 euz_border p-3 bg-white">
					<div class="row">
						<div class="col-md-12 mt-2">
							<div class="shadow-sm">
								<div class="col-md-12 euz_box_head">
									<p class="text-white euz_b mb-0">Edit Admin</p>
								</div>
								<form action="{{ url('admin/updateuser') }}" method="POST" enctype="multipart/form-data" >
								{{ csrf_field() }}
								<input type="hidden" name="eid" value="{{ $user[0]->id }}" id="eid" />
								<div class="col-md-12 euz_border">
									<div class="row">
										<div class="form-group col-md-4 py-2 mb-0">
											<label for="" class="euz_b">First Name</label>
											<input class="form-control" type="text" id="fname" name="fname" value="{{ $user[0]->fname }}" required>
										</div>
										<div class="form-group col-md-4 py-2 mb-0">
											<label for="" class="euz_b">Last Name</label>
											<input class="form-control" type="text" id="lname" name="lname" value="{{ $user[0]->lname }}" required>
										</div>
										<div class="form-group col-md-4 py-2 mb-0">
											<label for="" class="euz_b">Admin User Name</label>
											<input class="form-control" type="email" id="username" name="username" value="{{ $user[0]->email }}" required>
										</div>
										<div class="form-group col-md-4 py-2 mb-0">
											<label for="" class="euz_b">Admin User Old Password</label>
											<input class="form-control" type="password" id="oldpassword" name="oldpassword" >
										</div>
										<div class="form-group col-md-4 py-2 mb-0">
											<label for="" class="euz_b">Admin User New Password</label>
											<input class="form-control" type="password" id="password" name="password" >
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

<?php /*?><div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('global.product.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.products.update", [$product->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name">{{ trans('global.product.fields.name') }}*</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($product) ? $product->name : '') }}">
                @if($errors->has('name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.product.fields.name_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                <label for="description">{{ trans('global.product.fields.description') }}</label>
                <textarea id="description" name="description" class="form-control ">{{ old('description', isset($product) ? $product->description : '') }}</textarea>
                @if($errors->has('description'))
                    <em class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.product.fields.description_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
                <label for="price">{{ trans('global.product.fields.price') }}</label>
                <input type="number" id="price" name="price" class="form-control" value="{{ old('price', isset($product) ? $product->price : '') }}" step="0.01">
                @if($errors->has('price'))
                    <em class="invalid-feedback">
                        {{ $errors->first('price') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.product.fields.price_helper') }}
                </p>
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div><?php */?>

@endsection
@section('scripts')
@parent

@endsection