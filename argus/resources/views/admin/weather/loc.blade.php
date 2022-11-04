@extends('layouts.admin')
@section('content')
    <!---- euz_div ----->

    <!--Displaying locations--->
	<div class="p-3 add_admin_table">
		<div class="row">
			@if(Session::has('flash_message'))
            <div class="alert alert-success w-100"><button type="button" class="close" data-dismiss="alert">&times;</button>{{ Session::get('flash_message') }}</div>
            @endif		
			
			<div class="col-md-12 pr-0">
				<a class="btn euz_btn_add float-right euz_pointer ml-3" href="<?php echo url('/admin/weather'); ?>"><i class="far fa-arrow-alt-circle-left"></i> Back</a>
				<a href="javascript:void(0)" data-toggle="modal" data-target="#addloc" class="btn btn-success rounded-0 float-right text-white euz_bt">Add Location</a>
			</div>
			
			<div class="col-md-12 mt-3 p-0">
				<div class="shadow-sm">
					<div class="col-md-12 euz_header">
						<span class="text-white euz_b">Location List</span>
                        
					</div>
					<div class="col-md-12 euz_border bg-white">
						<div class="table-responsive-sm py-3">
							<table class="table table-bordered table-striped">
								<thead class="euz_agent_table">
									<tr>
										<th style="width:50px;" class="euz_agent_222">Sl.No</th>
										<th class="euz_agent_222">Location Name</th>
										<th style="width:150px;" class="euz_agent_222">Action</th>
									</tr>
								</thead>
								<tbody>
                                    <?php $i =1; foreach($value as $val) { ?>
									<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo $val->loc; ?></td>
										<td>
											<a href="#" class="text-info euz_td_a" data-toggle="modal" data-target="#editloc{{ $val->id }}">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;
											<a href="<?php echo url('/admin/deleteloc/'.$val->id); ?>" onclick="return confirm('Are you sure to delete this location?')" class="text-danger euz_td_a">Delete</a>
										</td>
									</tr>
                                    <!-- edit location popup -->
                                    <div class="modal fade" id="editloc{{ $val->id }}">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable euz_w_90">
                                            <div class="modal-content">
                                                <div class="modal-header euz_carb p-0">
                                                    <h5 class="modal-title p-2 text-white">Edit Location</h5>
                                                    <button type="button" class="close" data-dismiss="modal">
                                                    <span>×</span>
                                                    </button>
                                                </div>
                                                <form action="{{ url('/admin/editloc') }}" method="POST">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="locid" value="{{ $val->id }}" />
                                                    <div class="modal-body">              
                                                        <div class="row">                        
                                                            <div class="form-group col-lg-3 col-md-4">
                                                                <label class="euz_b" for="">Location Name</label>
                                                                <input type="text" class="form-control" id="" name="loc" required value="{{ $val->loc }}" />
                                                            
																<br>
								
																<a href="https://weatherwidget.io/" class="w-100 btn btn-info euz_bt rounded-0" target="_blank"><i class="fas fa-link"></i> Generate Code</a>
								
																<p class="text-dark text-justify"> <b>Step01:</b> Click the above “Generate Code” button.<br>
	<b>Step02:</b> The link will open a webpage, type the location in the setting tab then click on the “GET CODE” button.<br>
	<b>Step03:</b> Once you click on the “GET CODE” you will get a popup window with the location code. Simply copy and paste the code in to the “Weather Template” and then click the “SAVE” button. </p>
															
															
															</div>
                                                            <div class="form-group col-md-9" id="">
                                                                <label class="euz_b" for="">Weather Template</label>
                                                                <textarea class="form-control disname" rows="10" name="template">{{ $val->template }}</textarea>
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
                                    <!-- edit location popup -->	
                                    <?php $i++; } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- addlocation popup -->
	<div class="modal fade" id="addloc">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable euz_w_90">
            <div class="modal-content">
                <div class="modal-header euz_carb p-0">
                    <h5 class="modal-title p-2 text-white">Add Location</h5>
                    <button type="button" class="close" data-dismiss="modal">
                    <span>×</span>
                    </button>
                </div>
                <form action="{{ url('/admin/insertloc') }}" method="POST">
                	{{ csrf_field() }}
                    <div class="modal-body">              
                        <div class="row">                        
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="euz_b" for="">Location Name</label>
                                <input type="text" class="form-control" id="" name="loc" required />
								
								<br>
								
								<a href="https://weatherwidget.io/" class="w-100 btn btn-info euz_bt rounded-0" target="_blank"><i class="fas fa-link"></i> Generate Code</a>
								
								<p class="text-dark text-justify"> <b>Step01:</b> Click the above “Generate Code” button.<br>
<b>Step02:</b> The link will open a webpage, type the location in the setting tab then click on the “GET CODE” button.<br>
<b>Step03:</b> Once you click on the “GET CODE” you will get a popup window with the location code. Simply copy and paste the code in to the “Weather Template” and then click the “SAVE” button. </p>
								
                            </div>
                            <div class="form-group col-md-9" id="">
								<label class="euz_b" for="">Weather Template</label>
                                <textarea class="form-control disname" rows="10" name="template"></textarea>
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
	<!-- add location popup -->		
@parent
@endsection