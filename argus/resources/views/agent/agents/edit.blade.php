@extends('layouts.admin')
@section('content')

<?php //print_r($user); ?>

<!--Editing Agent-->
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
									<a class="nav-link euz_tabtex active" href="/admin/agents"><i class="fas fa-user-plus"></i> Add Agent</a>
								</li>
								<li class="nav-item">
									<a class="nav-link euz_tabtex" href="/admin/gatewaygroups"><i class="fas fa-users"></i> Add Gateway Group</a>
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
											<a class="btn euz_btn_add float-right euz_pointer mb-3 euz_back_btn_q" href="/admin/agents"><i class="far fa-arrow-alt-circle-left"></i> Back</a>										
										</div>
										<div class="col-md-12 shadow-sm">
										<div class="row">
										
										<div class="col-md-12 euz_header">
											<p class="text-white euz_b">Edit Agent</p>
										</div>
										<form action="{{ url('admin/updateagent') }}" method="POST" enctype="multipart/form-data">
										{{ csrf_field() }}
										<input type="hidden" name="eid" value="{{ $user[0]->id }}" id="eid" />
										<div class="col-md-12 euz_border">
											<div class="row">
												<div class="form-group col-md-3 py-2 mb-0">
													<label for="" class="euz_b">Customer ID</label>
													<input type="text" class="form-control" id="customer_id" name="customer_id" required value="{{ $user[0]->customer_id }}">
												</div>
												<div class="form-group col-md-3 py-2 mb-0">
													<label for="" class="euz_b">First Name</label>
													<input type="text" class="form-control" id="fname" name="fname" required value="{{ $user[0]->fname }}">
												</div>
												<div class="form-group col-md-3 py-2 mb-0">
													<label for="" class="euz_b">Last Name</label>
													<input type="text" class="form-control" id="lname" name="lname" required value="{{ $user[0]->lname }}">
												</div>
												<div class="form-group col-md-3 py-2 mb-0">
													<label for="" class="euz_b">Corporate Name</label>
													<input type="text" class="form-control" id="corporate_name" name="corporate_name" required value="{{ $user[0]->corporate_name }}">
												</div>
												<div class="form-group col-md-3 py-2 mb-0">
													<label for="" class="euz_b">Street</label>
													<input type="text" class="form-control" id="street" name="street" required value="{{ $user[0]->street }}">
												</div>
												<div class="form-group col-md-3 py-2 mb-0">
													<label for="" class="euz_b">City</label>
													<input type="text" class="form-control" id="city" name="city" required value="{{ $user[0]->city }}">
												</div>
												<div class="form-group col-md-3 py-2 mb-0">
													<label for="" class="euz_b">State</label>
													<input type="text" class="form-control" id="state" name="state" required value="{{ $user[0]->state }}">
												</div>
												<div class="form-group col-md-3 py-2 mb-0">
													<label for="" class="euz_b">Post Code</label>
													<input type="text" class="form-control" id="post_code" name="post_code" required value="{{ $user[0]->post_code }}"> 
												</div>
												<div class="form-group col-md-3 py-2 mb-0">
													<label for="" class="euz_b">Country</label>
													<input type="text" class="form-control" id="country" name="country" required value="{{ $user[0]->country }}">
												</div>
												<div class="form-group col-md-3 py-2 mb-0">
													<label for="" class="euz_b">Service Expiry</label>
													<input type="text" class="form-control" id="service_expiry" name="service_expiry" required value="{{ $user[0]->service_expiry }}">
												</div>
												<div class="form-group col-md-3 py-2 mb-0">
													<label for="" class="euz_b">User Name</label>
													<input type="email" class="form-control" id="email" name="email" required value="{{ $user[0]->email }}">
												</div>
												<div class="form-group col-md-3 py-2 mb-0">
													<label for="" class="euz_b">Password</label>
													<input type="password" class="form-control" id="password" name="password" >
												</div>
												<div class="form-group col-md-9 py-2 mb-0">
													<label for="" class="euz_b">Remark</label>
													<input type="text" class="form-control" id="remark" name="remark" required value="{{ $user[0]->remark }}">
												</div>
												<div class="form-group col-md-3 py-2 mb-0">
													<label for="" class="euz_b">Active</label><br>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" value="1" class="custom-control-input" id="yes" {{ ($user[0]->status==1)? "checked" : "" }}  name="status">
														<label class="custom-control-label euz_b" for="yes">Yes</label>
													</div>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" value="0" class="custom-control-input" id="no"  {{ ($user[0]->status==0)? "checked" : "" }} name="status">
														<label class="custom-control-label euz_b" for="no">No</label>
													</div>
												</div>
											</div>									
											<div class="row bg-light">
												<div class="col-md-12 p-2">
													<button type="submit" class="euz_ingreen"><i class="fas fa-save"></i> Save</button>
													&nbsp;&nbsp;
													<a href="/admin/agents" class="euz_inred"><i class="fas fa-broom"></i> Cancel</a>
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