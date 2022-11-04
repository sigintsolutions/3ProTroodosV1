@extends('layouts.admin')
@section('content')
<!--Adding Sensor group name-->
<div class="p-3 add_Algorithm_table">
			<div class="row">
				<div class="col-md-12 euz_bar">
					<i class="fas fa-cog euz_text_blue"></i> <small class="euz_b euz_text_blue">Settings</small>
				</div>
				@if(Session::has('flash_message'))
				<div class="alert alert-success w-100"><button type="button" class="close" data-dismiss="alert">&times;</button>{{ Session::get('flash_message') }}</div>
				@endif
				<div class="col-md-12 euz_border p-3 bg-white">
					<div class="row">
						<!---- euz sensor Group Name ----->
						<div class="col-md-6 mt-4">
							<div class="col-md-12 euz_bar">
								<small class="euz_b euz_text_blue">Add Sensor Group Name</small>
							</div>
							
							<div class="col-md-12 euz_border p-3">
								<form action="insertgroup" method="POST" enctype="multipart/form-data">
								<div class="form-group col-md-8 p-0 mb-0">
									<label for="" class="euz_b">Sensor Group Name</label>
									<div class="input-group mb-3">
									{{ csrf_field() }}
										<input type="text" name="name" id="name" pattern="[a-zA-Z0-9 ]+" title="Only Alpha-Numeric Values" required class="form-control" >
										<div class="input-group-append">
											<button class="btn euz_btn_add" type="submit"><i class="fas fa-plus"></i> ADD</button> 
										</div>
									</div>
								</div>
								</form>
								<div class="table-responsive-sm">
									<table class="table table-bordered table-striped">
										<thead class="euz_thead">
											<tr>
												<th>Sl.No</th>
												<th>Sensor Group Name</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
										@foreach($groups as $item)
											<tr>
												<td>{{ $loop->iteration }}</td>
												<td>{{ $item->name }}</td>
												<td><a href="#" class="euz_inblue" data-id='{{ $item->id }}' data-name='{{ $item->name }}' data-toggle="modal" data-target="#sensorgroup{{ $item->id }}"><i class="fas fa-user-edit"></i> Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="deleteGroup/{{ $item->id }}" onclick="return confirm('Are you sure to delete this item?')" class="euz_inred"><i class="fas fa-user-times"></i> Delete</a></td>
											</tr>
											<div class="modal fade" id="sensorgroup{{ $item->id }}">
														<div class="modal-dialog modal-dialog-centered">
															<div class="modal-content shadow">
															<div class="modal-header euz_header  rounded-0">
																<p class="text-white euz_b">Edit Sensor Group Name</p>
																<button type="button" class="close" data-dismiss="modal">
																<span>x</span>
																</button>
															</div>
															
															<div class="modal-body row">
																<div class="form-group col-md-12 py-2 mb-0">
																	<label for="" class="euz_b">Sensor Group Name</label>
																	<form action="updategroup" method="POST" enctype="multipart/form-data">
																	<div class="input-group mb-3">
																	{{ csrf_field() }}
																		<input type="hidden" name="eid" value="{{ $item->id }}" id="eid" />
																		<input type="text" class="form-control" pattern="[a-zA-Z0-9 ]+" title="Only Alpha-Numeric Values" required id="name" value="{{ $item->name }}" name="name">
																		<div class="input-group-append">
																			<button class="btn euz_btn_add" type="submit"><i class="fas fa-plus"></i> Update</button> 
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
											 @endforeach
											
										</tbody>
									</table>
								</div>
							</div>
							
							
							
						</div>
						<!---- euz Hub Name ----->
						<div class="col-md-6 mt-4">
							<div class="col-md-12 euz_bar">
								<small class="euz_b euz_text_blue">Add Hub Name</small>
							</div>
							<div class="col-md-12 euz_border p-3">
								<form action="inserthub" method="POST" enctype="multipart/form-data">
								<div class="form-group col-md-8 p-0 mb-0">
									<label for="" class="euz_b">Hub Name</label>
									<div class="input-group mb-3">
									{{ csrf_field() }}
										<input type="text" class="form-control" name="name" id="name" pattern="[a-zA-Z0-9 ]+" title="Only Alpha-Numeric Values" required>
										<div class="input-group-append">
											<button class="btn euz_btn_add" type="submit"><i class="fas fa-plus"></i> ADD</button> 
										</div>
									</div>
								</div>
								</form>
								<div class="table-responsive-sm">
								<table class="table table-bordered table-striped">
									<thead class="euz_thead">
										<tr>
											<th>Sl.No</th>
											<th>Hub Name</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
									@foreach($hubs as $item)
										<tr>
											<td>{{ $loop->iteration }}</td>
											<td>{{ $item->name }}</td>
											<td><a href="#" class="euz_inblue" data-id='{{ $item->id }}' data-name='{{ $item->name }}' data-toggle="modal" data-target="#hubs{{ $item->id }}"><i class="fas fa-user-edit"></i> Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;
											<a href="deleteHub/{{ $item->id }}" onclick="return confirm('Are you sure to delete this item?')" class="euz_inred"><i class="fas fa-user-times"></i> Delete</a></td>
										</tr>
										
											<div class="modal fade" id="hubs{{ $item->id }}">
														<div class="modal-dialog modal-dialog-centered">
															<div class="modal-content shadow">
															<div class="modal-header euz_header  rounded-0">
																<p class="text-white euz_b">Edit Hub Name</p>
																<button type="button" class="close" data-dismiss="modal">
																<span>x</span>
																</button>
															</div>
															
															<div class="modal-body row">
																<div class="form-group col-md-12 py-2 mb-0">
																	<label for="" class="euz_b">Hub Name</label>
																	<form action="updatehub" method="POST" enctype="multipart/form-data">
																	<div class="input-group mb-3">
																	{{ csrf_field() }}
																		<input type="hidden" name="eid" value="{{ $item->id }}" id="eid" />
																		<input type="text" class="form-control" pattern="[a-zA-Z0-9 ]+" title="Only Alpha-Numeric Values" required id="name" value="{{ $item->name }}" name="name">
																		<div class="input-group-append">
																			<button class="btn euz_btn_add" type="submit"><i class="fas fa-plus"></i> Update</button> 
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
											 @endforeach
										
									</tbody>
								</table>
								</div>
							</div>
						</div>
						<!---- euz Type Name ----->
						<div class="col-md-6 mt-4">
							<div class="col-md-12 euz_bar">
								<small class="euz_b euz_text_blue">Add Type</small>
							</div>
							<div class="col-md-12 euz_border p-3">
								<form action="inserttype" method="POST" enctype="multipart/form-data">
								<div class="form-group col-md-8 p-0 mb-0">
									<label for="" class="euz_b">Type Name</label>
									<div class="input-group mb-3">
									{{ csrf_field() }}
										<input type="text" class="form-control" name="name" id="name" pattern="[a-zA-Z0-9 ]+" title="Only Alpha-Numeric Values" required>
										<div class="input-group-append">
											<button class="btn euz_btn_add" type="submit"><i class="fas fa-plus"></i> ADD</button> 
										</div>
									</div>
								</div>
								</form>
								<div class="table-responsive-sm">
									<table class="table table-bordered table-striped">
										<thead class="euz_thead">
											<tr>
												<th>Sl.No</th>
												<th>Type Name</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
										@foreach($types as $item)
											<tr>
												<td>{{ $loop->iteration }}</td>
												<td>{{ $item->name }}</td>
												<td><a href="#" class="euz_inblue" data-id='{{ $item->id }}' data-name='{{ $item->name }}' data-toggle="modal" data-target="#types{{ $item->id }}"><i class="fas fa-user-edit"></i> Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;
											<a href="deleteType/{{ $item->id }}" onclick="return confirm('Are you sure to delete this item?')" class="euz_inred"><i class="fas fa-user-times"></i> Delete</a></td>
											</tr>
											
										<div class="modal fade" id="types{{ $item->id }}">
														<div class="modal-dialog modal-dialog-centered">
															<div class="modal-content shadow">
															<div class="modal-header euz_header  rounded-0">
																<p class="text-white euz_b">Edit Type Name</p>
																<button type="button" class="close" data-dismiss="modal">
																<span>x</span>
																</button>
															</div>
															
															<div class="modal-body row">
																<div class="form-group col-md-12 py-2 mb-0">
																	<label for="" class="euz_b">Type Name</label>
																	<form action="updatetype" method="POST" enctype="multipart/form-data">
																	<div class="input-group mb-3">
																	{{ csrf_field() }}
																		<input type="hidden" name="eid" value="{{ $item->id }}" id="eid" />
																		<input type="text" class="form-control" pattern="[a-zA-Z0-9 ]+" title="Only Alpha-Numeric Values" required id="name" value="{{ $item->name }}" name="name">
																		<div class="input-group-append">
																			<button class="btn euz_btn_add" type="submit"><i class="fas fa-plus"></i> Update</button> 
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
											 @endforeach
											
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<!---- euz Brand Name ----->
						<div class="col-md-6 mt-4">
							<div class="col-md-12 euz_bar">
								<small class="euz_b euz_text_blue">Add Brand</small>
							</div>
							<div class="col-md-12 euz_border p-3">
								<form action="insertbrand" method="POST" enctype="multipart/form-data">
								<div class="form-group col-md-8 p-0 mb-0">
									<label for="" class="euz_b">Brand Name</label>
									<div class="input-group mb-3">
									{{ csrf_field() }}
										<input type="text" class="form-control" name="name" id="name" pattern="[a-zA-Z0-9 ]+" title="Only Alpha-Numeric Values" required>
										<div class="input-group-append">
											<button class="btn euz_btn_add" type="submit"><i class="fas fa-plus"></i> ADD</button> 
										</div>
									</div>
								</div>
								</form>
								<div class="table-responsive-sm">
									<table class="table table-bordered table-striped">
										<thead class="euz_thead">
											<tr>
												<th>Sl.No</th>
												<th>Brand Name</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
										@foreach($brands as $item)
											<tr>
												<td>{{ $loop->iteration }}</td>
												<td>{{ $item->name }}</td>
												<td><a href="#" class="euz_inblue" data-id='{{ $item->id }}' data-name='{{ $item->name }}' data-toggle="modal" data-target="#brands{{ $item->id }}"><i class="fas fa-user-edit"></i> Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;
											<a href="deleteBrand/{{ $item->id }}" onclick="return confirm('Are you sure to delete this item?')" class="euz_inred"><i class="fas fa-user-times"></i> Delete</a></td>
											</tr>
										<div class="modal fade" id="brands{{ $item->id }}">
														<div class="modal-dialog modal-dialog-centered">
															<div class="modal-content shadow">
															<div class="modal-header euz_header  rounded-0">
																<p class="text-white euz_b">Edit Brand Name</p>
																<button type="button" class="close" data-dismiss="modal">
																<span>x</span>
																</button>
															</div>
															
															<div class="modal-body row">
																<div class="form-group col-md-12 py-2 mb-0">
																	<label for="" class="euz_b">Brand Name</label>
																	<form action="updatebrand" method="POST" enctype="multipart/form-data">
																	<div class="input-group mb-3">
																	{{ csrf_field() }}
																		<input type="hidden" name="eid" value="{{ $item->id }}" id="eid" />
																		<input type="text" class="form-control" pattern="[a-zA-Z0-9 ]+" title="Only Alpha-Numeric Values" required id="name" value="{{ $item->name }}" name="name">
																		<div class="input-group-append">
																			<button class="btn euz_btn_add" type="submit"><i class="fas fa-plus"></i> Update</button> 
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
											 @endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
						
						<!---- euz Measurement Unit ----->
						<div class="col-md-12 mt-4">
							<div class="col-md-12 euz_bar">
								<small class="euz_b euz_text_blue">Add Measurement Unit</small>
							</div>
							<div class="col-md-12 euz_border p-3">
							<form action="insertmeasureunit" method="POST" enctype="multipart/form-data">
							{{ csrf_field() }}
								<div class="row">
									<div class="form-group col-md-3 py-2 mb-0">
										<label for="" class="euz_b">Sensor Type</label>
										<select class="form-control" id="type" name="type" required>
											<option value="">-Select Type-</option>
											@foreach($types as $item)
											<option value="{{ $item->id }}">{{ $item->name }}</option>
											@endforeach
										</select>
									</div>
									
									<div class="form-group col-md-3 py-2 mb-0">
										<label for="" class="euz_b">Min value</label>
										<input type="text" class="form-control" id="min" name="min" required>
									</div>
									
									<div class="form-group col-md-3 py-2 mb-0">
										<label for="" class="euz_b">Max value</label>
										<input type="text" class="form-control" id="max" name="max" required>
									</div>
									<div class="form-group col-md-3 py-2 mb-0">
										<label for="" class="euz_b">Unit</label>
										<div class="input-group">
											<select class="form-control" id="units" name="units" required>
												<option>-Select Unit-</option>
												@foreach($units as $item)
												<option value="{{ $item->id }}">{{ $item->name }}</option>
												@endforeach
											</select>
											<div class="input-group-append">
												<button class="btn euz_btn_add" type="button" data-toggle="modal" data-target="#unit"><i class="fas fa-plus"></i></button> 
											</div>
											
										</div>
										
									</div>
									<div class="col-md-12 my-2"><button class="btn euz_btn_add" type="submit"><i class="fas fa-plus"></i> ADD</button></div>
								</div>
								</form>
								
								<!--- MODAL -->
										<div class="modal fade" id="unit">
											<div class="modal-dialog modal-dialog-centered">
												<div class="modal-content shadow">
												<div class="modal-header euz_header  rounded-0">
													<p class="text-white euz_b">Add Unit</p>
													<button type="button" class="close" data-dismiss="modal" onclick="$('.modal-backdrop').remove()">
													<span>x</span>
													</button>
												</div>
												
												<div class="modal-body row">
												<form action="insertunit" method="POST" enctype="multipart/form-data">
													<div class="form-group col-md-12 py-2 mb-0">
														<label for="" class="euz_b">Unit</label>
														<div class="input-group mb-3">
														{{ csrf_field() }}
															<input type="text" class="form-control" id="name" name="name" required>
															<div class="input-group-append">
																<button class="btn euz_btn_add" type="submit"><i class="fas fa-plus"></i> ADD</button> 
															</div>
														</div>
													</div>
													</form>
													<div class="col-md-12">
														<table class="table table-bordered table-striped">
															<thead class="euz_thead">
																<tr>
																	<th>Sl.No</th>
																	<th>Unit</th>
																	<th>Action</th>
																</tr>
															</thead>
															<tbody>
															@foreach($units as $item)
																<tr>
																	<td>{{ $loop->iteration }}</td>
																	<td>{{ $item->name }}</td>
																	<td><a href="#" class="euz_inblue" data-id='{{ $item->id }}' data-name='{{ $item->name }}' data-toggle="modal" data-target="#units{{ $item->id }}"><i class="fas fa-user-edit"></i> Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="deleteUnit/{{ $item->id }}" onclick="return confirm('Are you sure to delete this item?')" class="euz_inred"><i class="fas fa-user-times"></i> Delete</a></td>
																</tr>
																<div class="modal fade" id="units{{ $item->id }}">
														<div class="modal-dialog modal-dialog-centered">
															<div class="modal-content shadow">
															<div class="modal-header euz_header  rounded-0">
																<p class="text-white euz_b">Edit Unit Name</p>
																<button type="button" class="close" onclick="document.getElementById('units{{ $item->id }}').style.display='none';" >
																<span>x</span>
																</button>
															</div>
															
															<div class="modal-body row">
															
																<div class="form-group col-md-12 py-2 mb-0">
																	<label for="" class="euz_b">Unit Name</label>
																	<form action="updateunit" method="POST" enctype="multipart/form-data">
																	<div class="input-group mb-3">
																	{{ csrf_field() }}
																		<input type="hidden" name="eid" value="{{ $item->id }}" id="eid" />
																		<input type="text" class="form-control" pattern="[a-zA-Z0-9 ]+" title="Only Alpha-Numeric Values" required id="name" value="{{ $item->name }}" name="name">
																		<div class="input-group-append">
																			<button class="btn euz_btn_add" type="submit"><i class="fas fa-plus"></i> Update</button> 
																		</div>
																	</div>
																	</form>
																</div>
															</div>
															
															<div class="modal-footer bg-light py-0 rounded-0">
																<button type="button" class="btn euz_inred" onclick="document.getElementById('units{{ $item->id }}').style.display='none';"><i class="fas fa-times" ></i> Close</button>
															</div>
															</div>
														</div>
													</div>
															@endforeach
															</tbody>
														</table>
													</div>
												</div>
												
												<div class="modal-footer bg-light py-0 rounded-0">
													<button type="button" class="btn euz_inred" data-dismiss="modal" onclick="$('.modal-backdrop').remove()"><i class="fas fa-times"></i> Close</button>
												</div>
												</div>
											</div>
										</div>
										<!--- END MODAL -->
								
								<div class="table-responsive-sm">
									<table class="table table-bordered table-striped">
										<thead class="euz_thead">
											<tr>
												<th>Sl.No</th>
												<th>Type</th>
												<th>Unit</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
										@foreach($measureunits as $item)
											<tr>
												<td>{{ $loop->iteration }}</td>
												<td>{{ $item->types }}</td>
												<td>{{ $item->units }}</td>
												<td><a href="#" class="euz_inblue" data-id='{{ $item->id }}' data-toggle="modal" data-target="#measureunits{{ $item->id }}"><i class="fas fa-user-edit"></i> Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;
											<a href="deleteMeasureUnit/{{ $item->id }}" onclick="return confirm('Are you sure to delete this item?')" class="euz_inred"><i class="fas fa-user-times"></i> Delete</a></td>
											</tr>
										<div class="modal fade" id="measureunits{{ $item->id }}">
														<div class="modal-dialog modal-dialog-centered">
															<div class="modal-content shadow">
															<div class="modal-header euz_header  rounded-0">
																<p class="text-white euz_b">Edit Measurement Unit</p>
																<button type="button" class="close" data-dismiss="modal">
																<span>x</span>
																</button>
															</div>
															
															<div class="modal-body row">
															
										<form action="updatemeasureunit" method="POST" enctype="multipart/form-data">
										{{ csrf_field() }}
										<div class="form-group col-md-12 py-2 mb-0">
										<label for="" class="euz_b">Sensor Type</label>
										<input type="hidden" name="eid" value="{{ $item->id }}" id="eid" />
										<select class="form-control" id="type" name="type" required>
											<option value="">-Select Type-</option>
											@foreach($types as $item2)
											@if($item->type==$item2->id)
											<option value="{{ $item2->id }}" selected="selected">{{ $item2->name }}</option>
											@else
											<option value="{{ $item2->id }}" >{{ $item2->name }}</option>
											@endif
											@endforeach
										</select>
									</div>
									
									<div class="form-group col-md-12 py-2 mb-0">
										<label for="" class="euz_b">Min value</label>
										<input type="text" class="form-control" id="min" name="min" value="{{ $item->minimum }}" required>
									</div>
									
									<div class="form-group col-md-12 py-2 mb-0">
										<label for="" class="euz_b">Max value</label>
										<input type="text" class="form-control" id="max" name="max" value="{{ $item->maximum }}" required>
									</div>
									<div class="form-group col-md-12 py-2 mb-0">
										<label for="" class="euz_b">Unit</label>
										<div class="input-group">
											<select class="form-control" id="units" name="units" required>
												<option>-Select Unit-</option>
												@foreach($units as $item3)
												@if($item->unit==$item3->id)
												<option value="{{ $item3->id }}" selected="selected">{{ $item3->name }}</option>
												@else
												<option value="{{ $item3->id }}" >{{ $item3->name }}</option>
												@endif
												@endforeach
											</select>
											<?php /*?><div class="input-group-append">
												<button class="btn euz_btn_add" type="button" data-toggle="modal" data-target="#unit"><i class="fas fa-plus"></i></button> 
											</div><?php */?>
											
										</div>
										
									</div>
									<div class="col-md-12 my-2"><button class="btn euz_btn_add" type="submit"><i class="fas fa-plus"></i> Update</button></div>
									</form>
															
															
															
															
																<?php /*?><div class="form-group col-md-12 py-2 mb-0">
																	<label for="" class="euz_b">Measurement Unit</label>
																	<form action="updatemeasureunit" method="POST" enctype="multipart/form-data">
																	<div class="input-group mb-3">
																	{{ csrf_field() }}
																		<input type="hidden" name="eid" value="{{ $item->id }}" id="eid" />
																		<input type="text" class="form-control" pattern="[a-zA-Z0-9 ]+" title="Only Alpha-Numeric Values" required id="name" value="{{ $item->name }}" name="name">
																		<div class="input-group-append">
																			<button class="btn euz_btn_add" type="submit"><i class="fas fa-plus"></i> Update</button> 
																		</div>
																	</div>
																	</form>
																</div><?php */?>
															</div>
															
															<div class="modal-footer bg-light py-0 rounded-0">
																<button type="button" class="btn euz_inred" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
															</div>
															</div>
														</div>
													</div>
											 @endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				
			</div>
        </div>

@endsection
@section('scripts')
@parent

@endsection









<?php /*?>@extends('layouts.admin')
@section('content')
@can('product_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.products.create") }}">
                {{ trans('global.add') }} {{ trans('global.product.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('global.product.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('global.product.fields.name') }}
                        </th>
                        <th>
                            {{ trans('global.product.fields.description') }}
                        </th>
                        <th>
                            {{ trans('global.product.fields.price') }}
                        </th>
                        <th>&nbsp;
                            
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $key => $product)
                        <tr data-entry-id="{{ $product->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $product->name ?? '' }}
                            </td>
                            <td>
                                {{ $product->description ?? '' }}
                            </td>
                            <td>
                                {{ $product->price ?? '' }}
                            </td>
                            <td>
                                @can('product_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.products.show', $product->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan
                                @can('product_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.products.edit', $product->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan
                                @can('product_delete')
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@section('scripts')
@parent
<script>
    $(function () {
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.products.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('product_delete')
  dtButtons.push(deleteButton)
@endcan

  $('.datatable:not(.ajaxTable)').DataTable({ buttons: dtButtons })
})

</script>
@endsection
@endsection<?php */?>