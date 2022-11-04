@extends('layouts.admin')
@section('content')


<!--Sensor group--->
	<div class="loader" style="display:none"></div>
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
					<div class="col-md-3 mt-2">
						<div class="card">
							<div class="card-header" style="background-color: #0a587b !important;">
								<div class="custom-checkbox">
									<label class="euz_b mb-0 text-white">Gateway Group</label>
								</div>
							</div>
							<div class="card-body pb-0">
								<p class="euz_b"><label style="color: #a6a6a6;margin-right: 10px;">Total</label> <span class="totgrp badge badge-success fa-3x p-2"><?php echo count($groups); ?></span></p>
							</div> 
							<div class="card-footer text-right bg-white euz_card_fo px-2"> 
							    <a href="{{ url('/excel/groupname.xlsx') }}" title="Download Import Sheet"><i class="fas fa-file-download euz_a_icon"></i></a>
								<a href="" class="ml-2" data-toggle="modal" data-target="#groupimport" title="Import"><i class="fas fa-upload euz_a_icon"></i></a>
								<a href="javascript:void(0)" class="ml-2" data-toggle="tooltip" data-placement="top" title="Add New/Edit" onclick="addgate()"><i class="fas fa-plus-square euz_a_icon"></i></a>
							</div>
						</div>
					</div>
					<!-- <div class="col-md-3 mt-2">
						<div class="card">
							<div class="card-header">
								<div class="custom-checkbox">
									<label class="euz_b mb-0">Sensor Hub</label>
								</div>
							</div>
							<div class="card-body pb-0">
								<p class="euz_b">Total Added : <?php //echo count($hubs); ?></p>
							</div> 
							<div class="card-footer text-right bg-white euz_card_fo">
								<a href="{{ url('/excel/hubname.xlsx') }}" title="Download Import Sheet"><i class="fas fa-file-download euz_a_icon"></i></a>
								<a href="" class="ml-2" data-toggle="modal" data-target="#hubimport" title="Import"><i class="fas fa-upload euz_a_icon"></i></a>
								<a href="javascript:void(0)" class="ml-2" data-toggle="tooltip" data-placement="top" title="Add New" onclick="addhub()"><i class="fas fa-plus-square euz_a_icon"></i></a>
							</div>
						</div>
					</div>				 -->
					<!--<div class="col-md-3 mt-2">-->
					<!--	<div class="card">-->
					<!--		<div class="card-header">-->
					<!--			<div class="custom-checkbox">-->
					<!--				<label class="euz_b mb-0">Sensor Unit</label>-->
					<!--			</div>-->
					<!--		</div>-->
					<!--		<div class="card-body pb-0">-->
					<!--			<p class="euz_b">Total Added : <?php //echo count($measureunits); ?></p>-->
					<!--		</div> -->
					<!--		<div class="card-footer text-right bg-white euz_card_fo">-->
					<!--			<a href="#" class="ml-2" data-toggle="modal" data-target="#unitimport" title="Import"><i class="fas fa-upload euz_a_icon"></i></a>-->
					<!--			<a href="javascript:void(0)" class="ml-2" data-toggle="tooltip" data-placement="top" title="Add New" onclick="addunit()"><i class="fas fa-plus-square euz_a_icon"></i></a>-->
					<!--		</div>-->
					<!--	</div>-->
					<!--</div>				-->
					<div class="col-md-3 mt-2">
						<div class="card">
							<div class="card-header" style="background-color: #0a587b !important;">
								<div class="custom-checkbox">
									<label class="euz_b mb-0 text-white">Sensor Type</label>
								</div>
							</div>
							<div class="card-body pb-0">
								<p class="euz_b"><label style="color: #a6a6a6;margin-right: 10px;">Total </label> <span class="totgrpty badge badge-success fa-3x p-2"><?php echo count($types); ?></span></p>
							</div> 
							<div class="card-footer text-right bg-white euz_card_fo px-2">
								<a href="{{ url('/excel/type.xlsx') }}" title="Download Import Sheet"><i class="fas fa-file-download euz_a_icon"></i></a>
								<a href="" class="ml-2" data-toggle="modal" data-target="#typeimport" title="Import"><i class="fas fa-upload euz_a_icon"></i></a>
								<a href="javascript:void(0)" class="ml-2" data-toggle="tooltip" data-placement="top" title="Add New/Edit" onclick="addtype()"><i class="fas fa-plus-square euz_a_icon"></i></a>
							</div>
						</div>
					</div>				
					<!--<div class="col-md-3 mt-2">-->
					<!--	<div class="card">-->
					<!--		<div class="card-header">-->
					<!--			<div class="custom-checkbox">-->
					<!--				<label class="euz_b mb-0">Sensor Brand</label>-->
					<!--			</div>-->
					<!--		</div>-->
					<!--		<div class="card-body pb-0">-->
					<!--			<p class="euz_b">Total Added : <?php echo count($brands); ?></p>-->
					<!--		</div> -->
					<!--		<div class="card-footer text-right bg-white euz_card_fo">-->
					<!--			<a href="" class="ml-2" data-toggle="modal" data-target="#brandimport" title="Import"><i class="fas fa-upload euz_a_icon"></i></a>-->
					<!--			<a href="javascript:void(0)" class="ml-2" data-toggle="tooltip" data-placement="top" title="Add New" onclick="addbrand()"><i class="fas fa-plus-square euz_a_icon"></i></a>-->
					<!--		</div>-->
					<!--	</div>-->
					<!--</div>-->
					
					<div class="col-md-3 mt-2">
						<div class="card">
							<div class="card-header" style="background-color: #0a587b !important;">
								<div class="custom-checkbox">
									<label class="euz_b mb-0 text-white">Sensor Chart</label>
								</div>
							</div>
							<div class="card-body pb-0">
								<p class="euz_b"><label style="color: #a6a6a6;margin-right: 10px;">Total </label> <span class="totchart badge badge-success fa-3x p-2"><?php echo count($units); ?></span></p>
							</div> 
							<div class="card-footer text-right bg-white euz_card_fo px-2">
								<a href="#" class="ml-2" data-toggle="tooltip" data-placement="top" title="Add New/Edit" onclick="addchart()"><i class="fas fa-plus-square euz_a_icon"></i></a>
							</div>
						</div>
					</div>
					
					
				</div>
			</div>		
		</div>
	</div>

	<div id="addchartw" class="euz_agent_profile">
		<div class="row">
			<div class="col-md-12">
				<div class="card euz_carb rounded-0 text-white">
					<div class="card-body">
						<h4 class="card-title m-0"><i class="fas fa-portrait text-info"></i> Setting / Sensor Chart<a href="javascript:void(0)" class="closebtn float-right" onclick="addchartc()">×</a></h4>
					</div>
				</div>
			</div>
		</div>
		<div id="loader" style="background: #ffffffe0 none repeat scroll 0px 0px; position: fixed;  z-index: 1000001;   display: none;width: 90%;height: 90%;"><center><img src="{{ url('/loader/3.gif') }}"></center></div>
		<!--<form method="post" action="{{ url('/admin/addunit') }}">-->

<form id="addunitfrm" method="post">


			<div class="row p-2">
				{{ csrf_field() }}
				<div class="col-md-4 form-group my-2">
					<label for="" class="euz_b">Measuement Unit</label>
					<div class="input-group mb-3">
						<select class="form-control" name="unit" required>
							<option value="">Select</option>
							<?php $i = 1; foreach($measureunits as $item) { ?>
							<option value="<?php echo $item->unit; ?>"><?php echo $item->unit; ?></option>
							<?php } ?>
						<select>
					</div>
				</div>	
				<div class="col-md-4 form-group my-2">
					<label for="" class="euz_b">Sensor Chart</label>
					<div class="input-group mb-3">
						<select class="form-control euztumb" name="name" required id="my_select">
							<option selected value="">Select Chart</option>
							<option value="AreaChart">AreaChart</option>
							<!-- <option value="BarChart">BarChart</option> -->
							<option value="PieChart">PieChart</option>
							<option value="ColumnChart">ColumnChart</option>
							<option value="ComboChart">ComboChart</option>
							<option value="ScatterChart">ScatterChart</option>
							<option value="SteppedAreaChart">SteppedAreaChart</option>
							<!--<option value="Histogram">Histogram</option>-->
							<option value="LineChart">LineChart</option>
						<select>
					</div>
				</div>	
				<div class="col-md-2 my-2">
					<img src="../image/tumb/area.PNG" id="AreaChart" class="img-fluid euztumbs " style="width:100px;">
					<img src="../image/tumb/bar.PNG" id="BarChart" class="img-fluid euztumbs " style="width:100px;">
					<img src="../image/tumb/pie.PNG" id="PieChart" class="img-fluid euztumbs " style="width:100px;">
					<img src="../image/tumb/column.PNG" id="ColumnChart" class="img-fluid euztumbs " style="width:100px;">
					<img src="../image/tumb/combo.PNG" id="ComboChart" class="img-fluid euztumbs " style="width:100px;">
					<img src="../image/tumb/scatter.PNG" id="ScatterChart" class="img-fluid euztumbs " style="width:100px;">
					<img src="../image/tumb/stepped.PNG" id="SteppedAreaChart" class="img-fluid euztumbs " style="width:100px;">
					<img src="../image/tumb/histogram.PNG" id="Histogram" class="img-fluid euztumbs " style="width:100px;">
					<img src="../image/tumb/line.PNG" id="LineChart" class="img-fluid euztumbs " style="width:100px;">
				</div>
				<div class="col-md-2 my-2">
					<button class="btn euz_ne_add btn-success mt30 mr-2" type="submit"><i class="fas fa-plus"></i> ADD</button> 
					<!-- <button class="btn euz_ne_add btn-info mt30" type="submit">Export</button>  -->
				</div>
				
			</div>
		</form>
		<div class="row p-2">	
			<div class="col-md-12 my-2">
				<div class="tblunit tblsenchart table-responsive-sm">
					<table class="table table-bordered table-striped">
						<thead class="euz_thead_set">
							<tr>
								<th>Sl.No</th>
								<th>Measuement Unit</th>
								<th>Chart</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php $j = 1; foreach($units as $unit) { ?>
							<tr>
								<td><?php echo $j; ?></td>
								<td><?php echo $unit->unit; ?></td>
								<td><?php echo $unit->name; ?></td>
								<td>
									<a onclick="hideimg()" href="javasccript:void()" class="text-info euz_td_a" data-id='{{ $unit->id }}' data-toggle="modal" data-target="#units{{ $unit->id }}"><i class="far fa-edit"></i> Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;
									<!-- <a href="{{ url('/admin/deleteunit/'.$unit->id) }}" class="text-danger euz_td_a"><i class="fas fa-user-times"></i> Delete</a> -->
								</td>
							</tr>
							<div class="modal fade" id="units{{ $unit->id }}">
								<div class="modal-dialog modal-dialog-centered" style="max-width: 80%;">
									<div class="modal-content shadow">
										<div class="modal-header euz_header  rounded-0">
											<p class="text-white euz_b">Edit</p>
											<button type="button" class="close" data-dismiss="modal">
											<span>x</span>
											</button>
										</div>					
										<div class="modal-body row">
											<div class="form-group col-md-12 py-2 mb-0">							<form class="editunit" method="POST" enctype="multipart/form-data">			
												<!--<form action="{{ url('/admin/editunit') }}" method="POST" enctype="multipart/form-data">-->
													{{ csrf_field() }}	
													<input type="hidden" name="eid" value="{{ $unit->id }}" id="eid" />
													<div class="row">
														<div class="col-md-4 form-group my-2">
															<label for="" class="euz_b">Unit</label>
															<div class="input-group mb-3">
																<select class="form-control" name="unit" required>
																	<option value="<?php echo $unit->unit; ?>"><?php echo $unit->unit; ?></option>
																	<?php $i = 1; foreach($measureunits as $item) { ?>
																	<option value="<?php echo $item->unit; ?>"><?php echo $item->unit; ?></option>
																	<?php } ?>
																<select>
															</div>
														</div>
														<div class="col-md-4 form-group my-2">
															<label for="" class="euz_b">Sensor Chart</label>
															<div class="input-group mb-3">
																<select class="form-control euztumb1" name="name" required>
																	<!--<option value="<?php //echo $unit->name; ?>"><?php //echo $unit->name; ?></option>-->
																	<option value="AreaChart" <?php if ($unit->name=="AreaChart"){?> selected <?php } ?> >AreaChart</option>
																	<!-- <option value="BarChart" <?php if ($unit->name=="BarChart"){?> selected <?php } ?>>BarChart</option> -->
																	<option value="PieChart" <?php if ($unit->name=="PieChart"){?> selected <?php } ?>>PieChart</option>
																	<option value="ColumnChart" <?php if ($unit->name=="ColumnChart"){?> selected <?php } ?>>ColumnChart</option>
																	<option value="ComboChart" <?php if ($unit->name=="ComboChart"){?> selected <?php } ?>>ComboChart</option>
																	<option value="ScatterChart" <?php if ($unit->name=="ScatterChart"){?> selected <?php } ?>>ScatterChart</option>
																	<option value="SteppedAreaChart" <?php if ($unit->name=="SteppedAreaChart"){?> selected <?php } ?>>SteppedAreaChart</option>
																	<!--<option value="Histogram" <?php //if ($unit->name=="Histogram"){?> selected <?php //} ?>>Histogram</option>-->
																	<option value="LineChart" <?php if ($unit->name=="LineChart"){?> selected <?php } ?>>LineChart</option>
																<select>
															</div>
														</div>
<div class="col-md-2 my-2">
<?php //echo url("image/tumb/area.PNG");?>
<?php if ($unit->name=="AreaChart"){?>

<img src="<?php echo url("image/tumb/area.PNG");?>" class="img-fluid ld" style="width:100px;">
															
															
															
															
															
															
															
															
<?php }?>
															<!--<img id="eduimg" src="" class="eduimg img-fluid euztumbs1 AreaChart" style="width:100px;">-->
<?php if ($unit->name=="BarChart"){?><img src="<?php echo url("image/tumb/bar.PNG");?>" class="img-fluid ld" style="width:100px;"><?php }?>
<?php if ($unit->name=="PieChart"){?><img src="<?php echo url("image/tumb/pie.PNG");?>" class="img-fluid ld" style="width:100px;"><?php }?>
<?php if ($unit->name=="ColumnChart"){?><img src="<?php echo url("image/tumb/column.PNG");?>" class="img-fluid ld" style="width:100px;"><?php }?>
<?php if ($unit->name=="ComboChart"){?><img src="<?php echo url("image/tumb/combo.PNG");?>" class="img-fluid ld" style="width:100px;"><?php }?>
<?php if ($unit->name=="ScatterChart"){?><img src="<?php echo url("image/tumb/Scatter.PNG");?>" class="img-fluid ld" style="width:100px;"><?php }?>
<?php if ($unit->name=="SteppedAreaChart"){?><img src="<?php echo url("image/tumb/stepped.PNG");?>" class="img-fluid ld" style="width:100px;"><?php }?>
<?php if ($unit->name=="Histogram"){?><img src="<?php echo url("image/tumb/histogram.PNG");?>" class="img-fluid ld" style="width:100px;"><?php }?>
<?php if ($unit->name=="LineChart"){?><img src="<?php echo url("image/tumb/line.PNG");?>" class="img-fluid ld" style="width:100px;"><?php }?>
															
														</div>


														<div class="col-md-2 my-2">

															<img src="../image/tumb/area.PNG" class="img-fluid euztumbs1 AreaChart" style="width:100px;">
															<img src="../image/tumb/bar.PNG" class="img-fluid euztumbs1 BarChart" style="width:100px;">
															<img src="../image/tumb/pie.PNG" class="img-fluid euztumbs1 PieChart" style="width:100px;">
															<img src="../image/tumb/column.PNG" class="img-fluid euztumbs1 ColumnChart" style="width:100px;">
															<img src="../image/tumb/combo.PNG" class="img-fluid euztumbs1 ComboChart" style="width:100px;">
															<img src="../image/tumb/scatter.PNG" class="img-fluid euztumbs1 ScatterChart" style="width:100px;">
															<img src="../image/tumb/stepped.PNG" class="img-fluid euztumbs1 SteppedAreaChart" style="width:100px;">
															<img src="../image/tumb/histogram.PNG" class="img-fluid euztumbs1 Histogram" style="width:100px;">
															<img src="../image/tumb/line.PNG" class="img-fluid euztumbs1 LineChart" style="width:100px;">
														</div>
													</div>
													
													<div class="input-group-append">
														<button class="btn euz_btn_add" type="submit"><i class="fas fa-plus"></i> Update</button> 
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php $j++; } ?>
						</tbody>
					</table>
				</div>
			</div>
			
		</div>
	</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css" rel="stylesheet" />
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>

$('.euztumbs, .euztumbs1').hide();


$(function() {
  $('.euztumb').change(function(){
    $('.euztumbs').hide();

    $('#' + $(this).val()).show();
  });
});

$(function() {
  $('.euztumb1').change(function(){
    $('.euztumbs1').hide();
    $('.ld').hide();
    $('.' + $(this).val()).show();
  });
});


function addchart() {
	document.getElementById("addchartw").style.width = "80%";
	}
	
	function addchartc() {
	document.getElementById("addchartw").style.width = "0";
	}
</script>

	<!---Add groupname import---->
    <div class="modal fade" id="groupimport">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable euz_w_90">
            <div class="modal-content" style="width: 40%;">
                <div class="modal-header euz_carb p-0">
                    <h5 class="modal-title p-2 text-white">Import Gateway Group</h5>
                    <button type="button" class="close" data-dismiss="modal">
                    <span>×</span>
                    </button>
                </div>
                <form method="post" enctype="multipart/form-data" action="{{ url('/admin/import_excel/importgroupname') }}">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12">
                                <label class="euz_b" for="">Upload File (Excel file only)</label>
                                <input type="file" class="form-control disname" id="" required name="select_file" accept=".xlsx, .xls" />
                            </div>					
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success rounded-0" name="upload">Upload</button>
                        <button type="button" class="btn btn-danger rounded-0" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End groupname import--->
	<!---Add hubname import---->
    <div class="modal fade" id="hubimport">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable euz_w_90">
            <div class="modal-content" style="width: 40%;">
                <div class="modal-header euz_carb p-0">
                    <h5 class="modal-title p-2 text-white">Import Sensor Hub</h5>
                    <button type="button" class="close" data-dismiss="modal">
                    <span>×</span>
                    </button>
                </div>
                <form method="post" enctype="multipart/form-data" action="{{ url('/admin/import_excel/importhubname') }}">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12">
                                <label class="euz_b" for="">Upload File (Excel file only)</label>
                                <input type="file" class="form-control disname" id="" required name="select_file" accept=".xlsx, .xls" />
                            </div>					
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success rounded-0" name="upload">Upload</button>
                        <button type="button" class="btn btn-danger rounded-0" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End hubname import--->
	<!---Add unit import---->
    <div class="modal fade" id="unitimport">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable euz_w_90">
            <div class="modal-content" style="width: 40%;">
                <div class="modal-header euz_carb p-0">
                    <h5 class="modal-title p-2 text-white">Import Sensor Unit</h5>
                    <button type="button" class="close" data-dismiss="modal">
                    <span>×</span>
                    </button>
                </div>
                <form method="post" enctype="multipart/form-data" action="{{ url('/admin/import_excel/importunit') }}">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12">
                                <label class="euz_b" for="">Upload File (Excel file only)</label>
                                <input type="file" class="form-control disname" id="" required name="select_file" accept=".xlsx, .xls" />
                            </div>					
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success rounded-0" name="upload">Upload</button>
                        <button type="button" class="btn btn-danger rounded-0" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End unit import--->
	<!---Add Type import---->
    <div class="modal fade" id="typeimport">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable euz_w_90">
            <div class="modal-content" style="width: 40%;">
                <div class="modal-header euz_carb p-0">
                    <h5 class="modal-title p-2 text-white">Import Sensor Types</h5>
                    <button type="button" class="close" data-dismiss="modal">
                    <span>×</span>
                    </button>
                </div>
                <form method="post" enctype="multipart/form-data" action="{{ url('/admin/import_excel/importtype') }}">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12">
                                <label class="euz_b" for="">Upload File (Excel file only)</label>
                                <input type="file" class="form-control disname" id="" required name="select_file" accept=".xlsx, .xls" />
                            </div>					
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success rounded-0" name="upload">Upload</button>
                        <button type="button" class="btn btn-danger rounded-0" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End Type import--->
	<!---Add Type import---->
    <div class="modal fade" id="brandimport">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable euz_w_90">
            <div class="modal-content" style="width: 40%;">
                <div class="modal-header euz_carb p-0">
                    <h5 class="modal-title p-2 text-white">Import Sensor Brand</h5>
                    <button type="button" class="close" data-dismiss="modal">
                    <span>×</span>
                    </button>
                </div>
                <form method="post" enctype="multipart/form-data" action="{{ url('/admin/import_excel/importbrand') }}">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12">
                                <label class="euz_b" for="">Upload File (Excel file only)</label>
                                <input type="file" class="form-control disname" id="" required name="select_file" accept=".xlsx, .xls" />
                            </div>					
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success rounded-0" name="upload">Upload</button>
                        <button type="button" class="btn btn-danger rounded-0" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End Type import--->
	<!---groupname---->
	<div id="addgateway" class="euz_agent_profile">
		<div class="row">
			<div class="col-md-12">
				<div class="card euz_carb rounded-0 text-white">
					<div class="card-body">
						<h4 class="card-title m-0"><i class="fas fa-portrait text-info"></i> Setting / Gateway Group<a href="javascript:void(0)" class="closebtn float-right" onclick="addgateclos()">×</a></h4>
					</div>
				</div>
			</div>
		</div>
		<div class="row p-2">
			<div class="col-md-4 form-group my-2">
				<!--<form action="{{ url('/admin/insertgroup') }}" method="POST" enctype="multipart/form-data">-->

<form id="addsens" method="POST" enctype="multipart/form-data">

					{{ csrf_field() }}
					<label for="" class="euz_b">Sensor Group Name</label>
					<div class="input-group mb-3">
						<input type="text" class="form-control" name="name" id="name" required />
						<div class="input-group-append">
							<button class="btn euz_ne_add btn-success" type="submit"><i class="fas fa-plus"></i> ADD</button> 
						</div>
					</div>
				</form>
			</div>	
			<div class="col-md-4 my-2">
				<a class="btn euz_ne_add btn-info mt30" href="{{ url('/admin/exportgroupname') }}" >Export</a> 
			</div>

			<div class="col-md-12 my-2">
				<div class="tblsen table-responsive-sm">
					<table class="table table-bordered table-striped">
						<thead class="euz_thead_set">
							<tr>
								<!--<th>Sl.No</th>-->
								<th>Sensor Group Name</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 1; foreach($groups as $group) { ?>
							<tr id="gr<?php echo $group->id;?>">
								<!--<td><?php //echo $i; ?></td>-->
								<td><?php echo $group->name; ?></td>
								<td>
									<a href="" class="text-info euz_td_a" data-id='{{ $group->id }}' data-name='{{ $group->name }}' data-toggle="modal" data-target="#sensorgroup{{ $group->id }}"><i class="far fa-edit"></i> Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;
									<a href="#" onclick=delitem("<?php echo $group->id;?>");  class="text-danger euz_td_a"><i class="far fa-trash-alt"></i> Delete</a>
									<!--<a href="<?php //echo url('/admin/deleteGroup/'.$group->id); ?>" onclick="return confirm('Are you sure to delete this item?')"  class="text-danger euz_td_a"><i class="fas fa-user-times"></i> Delete</a>-->
								</td>
							</tr>
							<div class="modal fade" id="sensorgroup{{ $group->id }}">
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
											<!--<form action="{{ url('/admin/updategroup') }}" method="POST" enctype="multipart/form-data">-->

<form id="sengrp" method="POST" enctype="multipart/form-data">


											<div class="input-group mb-3">
											{{ csrf_field() }}
												<input type="hidden" name="eid" value="{{ $group->id }}" id="eid" />
												<input type="text" class="form-control" required id="name" value="{{ $group->name }}" name="name" />
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
							<?php $i++; } ?>
						</tbody>
					</table>
				</div>
			</div>		
		</div>
	</div>
	<!---End groupname---->
	<!---hubname---->
	<div id="addhub" class="euz_agent_profile">
		<div class="row">
			<div class="col-md-12">
				<div class="card euz_carb rounded-0 text-white">
					<div class="card-body">
						<h4 class="card-title m-0"><i class="fas fa-portrait text-info"></i> Setting /  Hub Name<a href="javascript:void(0)" class="closebtn float-right" onclick="addhubclos()">×</a></h4>
					</div>
				</div>
			</div>
		</div>
		<div class="row p-2">
			<div class="col-md-4 form-group my-2">
				<form action="{{ url('/admin/inserthub') }}" method="POST" enctype="multipart/form-data">
					{{ csrf_field() }}
					<label for="" class="euz_b">Sensor  Hub Name</label>
					<div class="input-group mb-3">
						<input type="text" class="form-control" name="name" id="name" required />
						<div class="input-group-append">
							<button class="btn euz_ne_add btn-success" type="submit"><i class="fas fa-plus"></i> ADD</button> 
						</div>
					</div>
				</form>
			</div>	
			<div class="col-md-4 my-2">
				<a class="btn euz_ne_add btn-info mt30" href="{{ url('/admin/exporthubname') }}" >Export</a> 
			</div>
			<div class="col-md-12 my-2">
				<div class="table-responsive-sm">
					<table class="table table-bordered table-striped">
						<thead class="euz_thead_set">
							<tr>
								<th>Sl.No</th>
								<th>Hub Name</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 1; foreach($hubs as $item) { ?>
							<tr>
								<td><?php echo $i; ?></td>
								<td><?php echo $item->name; ?></td>
								<td><a href="" class="text-info euz_td_a" data-id='{{ $item->id }}' data-name='{{ $item->name }}' data-toggle="modal" data-target="#hubs{{ $item->id }}"><i class="fas fa-user-edit"></i> Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;
									<a href="<?php echo url('/admin/deleteHub/'.$item->id); ?>" onclick="return confirm('Are you sure to delete this item?')"  class="text-danger euz_td_a"><i class="fas fa-user-times"></i> Delete</a>
								</td>
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
												<form action="{{ url('/admin/updatehub') }}" method="POST" enctype="multipart/form-data">
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
											<button type="button" class="btn euz_inred" data-dismiss="modal" ><i class="fas fa-times"></i> Close</button>
										</div>
									</div>
								</div>
							</div>
							<?php $i++; } ?>
						</tbody>
					</table>
				</div>
			</div>		
		</div>
	</div>
	<!---End hubname---->
	<!---unit---->
	<div id="addunit" class="euz_agent_profile">
		<div class="row">
			<div class="col-md-12">
				<div class="card euz_carb rounded-0 text-white">
					<div class="card-body">
						<h4 class="card-title m-0"><i class="fas fa-portrait text-info"></i> Setting /  Sensor Unit<a href="javascript:void(0)" class="closebtn float-right" onclick="addunitclos()">×</a></h4>
					</div>
				</div>
			</div>
		</div>
		<div class="row  p-2">
			<div class="col-md-12">
				<form action="{{ url('/admin/insertmeasureunit') }}" method="POST" enctype="multipart/form-data">
					<div class="row">				
						{{ csrf_field() }}
						<div class="col-md-3 py-2 mb-0">
							<label for="" class="euz_b">Min value</label>
							<input type="text" class="min form-control" id="min" name="min" required>
						</div>					
						<div class="col-md-3 py-2 mb-0">
							<label for="" class="euz_b">Max value</label>
							<input type="text" class="max form-control" id="max" name="max" required>
						</div>
						<div class="col-md-3 py-2 mb-0">
							<label for="" class="euz_b">Unit</label>
							<input type="text" class="form-control" id="unit" name="unit" required>
						</div>
						<div class="col-md-3 py-2 mb-0">
							<button class="btn euz_ne_add btn-success mt30" type="submit">ADD</button> 
						</div>
						
					</div>	
				</form>
			</div>
			<div class="col-md-12 my-2 text-right">
				<a class="btn euz_ne_add btn-info mt30" href="{{ url('/admin/exportunit') }}" >Export</a> 
			</div>
		</dic>	
		<?php /*<div class="col-md-12 my-2">
			<div class="table-responsive-sm">
				<table class="table table-bordered table-striped">
					<thead class="euz_thead_set">
						<tr>
							<th>Sl.No</th>
							<th>Min Unit</th>
							<th>Max Unit</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $i = 1; foreach($measureunits as $item) { ?>
						<tr>
							<td><?php echo $i; ?></td>
							<td><?php echo $item->minimum; ?></td>
							<td><?php echo $item->maximum; ?></td>
							<td><a href="" class="text-info euz_td_a" data-id='{{ $item->id }}' data-name='{{ $item->minimum }}' data-toggle="modal" data-target="#units{{ $item->id }}"><i class="fas fa-user-edit"></i> Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;
								<a href="<?php echo url('/admin/deleteMeasureUnit/'.$item->id); ?>" onclick="return confirm('Are you sure to delete this item?')"  class="text-danger euz_td_a"><i class="fas fa-user-times"></i> Delete</a>
							</td>
						</tr>
						<div class="modal fade" id="units{{ $item->id }}">
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
											
											<form action="{{ url('/admin/updatemeasureunit') }}" method="POST" enctype="multipart/form-data">
												<div class="input-group mb-3">
												{{ csrf_field() }}
													<input type="hidden" name="eid" value="{{ $item->id }}" id="eid" />
													<label for="" class="euz_b">Minimum</label>
													 <input type="text" class="form-control" required id="min" value="{{ $item->minimum }}" name="min">
													<label for="" class="euz_b">Maximum</label>
													 <input type="text" class="form-control" required id="max" value="{{ $item->maximum }}" name="max">
													<label for="" class="euz_b">Unit</label>
													 <input type="text" class="form-control" required id="unit" value="{{ $item->unit }}" name="unit">
													<div class="input-group-append">
														<button class="btn euz_btn_add" type="submit"><i class="fas fa-plus"></i> Update</button> 
													</div>
												</div>
											</form>
										</div>
									</div>								
									<div class="modal-footer bg-light py-0 rounded-0">
										<button type="button" class="btn euz_inred" data-dismiss="modal" ><i class="fas fa-times"></i> Close</button>
									</div>
								</div>
							</div>
						</div>
						<?php $i++; } ?>
					</tbody>
				</table>
			</div>
		</div>*/ ?>		
	</div>
	<!---End unit---->
	<!---Type---->
	<div id="addtype" class="euz_agent_profile">
		<div class="row">
			<div class="col-md-12">
				<div class="card euz_carb rounded-0 text-white">
					<div class="card-body">
						<h4 class="card-title m-0"><i class="fas fa-portrait text-info"></i> Setting /  Sensor Type<a href="javascript:void(0)" class="closebtn float-right" onclick="addtypeclos()">×</a></h4>
					</div>
				</div>
			</div>
		</div>

<form id="instype" method="POST" enctype="multipart/form-data">


		<!--<form action="{{ url('/admin/inserttype') }}" method="POST" enctype="multipart/form-data">-->
			<div class="row  p-2">	
				{{ csrf_field() }}
				<div class="col-md-3 form-group my-2">
					<label for="" class="euz_b">Sensor Name</label>
					<input type="text" class="form-control" name="sname" id="sname" required />
				</div>
				<div class="col-md-3 form-group my-2">
					<label for="" class="euz_b">Model</label>
					<input type="text" class="form-control" name="modal" id="modal" required />
				</div>
				<!-- <div class="col-md-3 form-group my-2">
					<label for="" class="euz_b">Sensor Type</label>
					<input type="text" class="form-control" name="name" id="name" required />
				</div> -->
				<div class="col-md-3 form-group my-2">
					<label for="" class="euz_b">Sensor Brand</label>
					<input type="text" class="form-control" name="brand" id="brand" required />
				</div>
				<!-- <div class="col-md-3 form-group my-2">
					<label for="" class="euz_b">Sensor Unit</label>
					<input type="text" class="form-control" name="unit" id="" required />
				</div> -->
				<div class="col-md-3 form-group my-2">
					<label for="" class="euz_b">Min Value</label>
					<input type="text" class="min form-control" name="min" id="min" required />
				</div>
				<div class="col-md-3 form-group my-2">
					<label for="" class="euz_b">Max Value</label>
					<input type="text" class="max form-control" name="max" id="max" required />
				</div>
				<div class="col-md-12 form-group my-2">
					<label for="" class="euz_b">Remark</label>
					<textarea id="remark" class="form-control" rows="5" name="remark" ></textarea>
				</div>
				<div class="col-md-3 my-2">
					<button class="btn euz_ne_add btn-success mt30" type="submit"><i class="fas fa-plus"></i> ADD</button>
					<a class="btn euz_ne_add btn-info mt30 float-right" href="{{ url('/admin/exporttype') }}">Export</a>
				</div>		
			</div>	
		</form>
		<div class="col-md-12 my-2">
			<div class="tblsenbrand table-responsive-sm">
				<table class="table table-bordered table-striped">
					<thead class="euz_thead_set">
						<tr>
							<!--<th>Sl.No</th>-->
							<th>Sensor Name</th>
							<th>Brand</th>
							<th>Model</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $i = 1; foreach($types as $item) { ?>
						<tr id="grty<?php echo $item->id;?>">
							<!--<td><?php //echo $i; ?></td>-->
							<td>{{ $item->sname }}</td>
							<td>{{ $item->brand }}</td>
							<td>{{ $item->modal }}</td>
							<td><a href="" class="text-info euz_td_a" data-id='{{ $item->id }}' data-name='{{ $item->name }}' data-toggle="modal" data-target="#types{{ $item->id }}"><i class="far fa-edit"></i> Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;
								<!--<a href="<?php //echo url('/admin/deleteType/'.$item->id); ?>" onclick="return confirm('Are you sure to delete this item?')"  class="text-danger euz_td_a"><i class="fas fa-user-times"></i> Delete</a>-->
								<a href="#" onclick=delsensortype("<?php echo $item->id;?>");  class="text-danger euz_td_a"><i class="far fa-trash-alt"></i> Delete</a>



							</td>
						</tr>
						<div class="modal fade" id="types{{ $item->id }}">
							<div class="modal-dialog modal-dialog-centered" style="max-width: 80%;">
								<div class="modal-content shadow">
								<div class="modal-header euz_header  rounded-0">
									<p class="text-white euz_b">Edit</p>
									<button type="button" class="close" data-dismiss="modal">
									<span>x</span>
									</button>
								</div>					
								<div class="modal-body row">
									<div class="form-group col-md-12 py-2 mb-0">
											<form class="updatetype" id="updatetype" method="POST" enctype="multipart/form-data">								
										<!--<form action="updatetype" method="POST" enctype="multipart/form-data">-->
											{{ csrf_field() }}	
											<input type="hidden" name="eid" value="{{ $item->id }}" id="eid" />
											<div class="row">
												<div class="form-group col-md-4">
													<label for="" class="euz_b">Sensor Name</label>
													<div class="input-group mb-3">								
														<input type="text" class="form-control" required id="sname" value="{{ $item->sname }}" name="sname" />
													</div>
												</div>
												<div class="form-group col-md-4">
													<label for="" class="euz_b">Model</label>
													<div class="input-group mb-3">								
														<input type="text" class="form-control" required id="modal" value="{{ $item->modal }}" name="modal" />
													</div>
												</div>
												<!-- <div class="form-group col-md-4">
													<label for="" class="euz_b">Type Name</label>
													<div class="input-group mb-3">								
														<input type="text" class="form-control" required id="name" value="{{ $item->name }}" name="name" />
													</div>
												</div> -->
												<div class="form-group col-md-4">
													<label for="" class="euz_b">Brand</label>
													<div class="input-group mb-3">
														<input type="text" class="form-control" required id="brand" value="{{ $item->brand }}" name="brand" />
													</div>
												</div>	
												<!-- <div class="form-group col-md-4">
													<label for="" class="euz_b">Unit</label>
													<div class="input-group mb-3">
														<input type="text" class="form-control" required id="unit" value="{{ $item->unit }}" name="unit" />
													</div>
												</div>							 -->
												<div class="form-group col-md-4">
													<label for="" class="euz_b">Max Value</label>
													<div class="input-group mb-3">
														<input type="text" class="max form-control" required id="max" value="{{ $item->max }}" name="max" />
													</div>
												</div>
												<div class="form-group col-md-4">
													<label for="" class="euz_b">Min Value</label>
													<div class="input-group mb-3">
														<input type="text" class="min form-control" required id="min" value="{{ $item->min }}" name="min" />
													</div>
												</div>
												<div class="form-group col-md-12">
													<label for="" class="euz_b">Remark</label>
													<div class="input-group mb-3">
														<textarea class="form-control" id="remark" name="remark" rows="5">{{ $item->remark }}</textarea>
													</div>
												</div>
											</div>
											<div class="input-group-append">
												<button class="btn euz_btn_add" type="submit"><i class="fas fa-plus"></i> Update</button> 
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
						<?php $i++; } ?>
					</tbody>
				</table>
			</div>
		</div>		
	</div>
	<!---End Type---->
	<!---Brand---->
	<div id="addbrand" class="euz_agent_profile">
		<div class="row">
			<div class="col-md-12">
				<div class="card euz_carb rounded-0 text-white">
					<div class="card-body">
						<h4 class="card-title m-0"><i class="fas fa-portrait text-info"></i> Setting /  Sensor Brand<a href="javascript:void(0)" class="closebtn float-right" onclick="addbrandclos()">×</a></h4>
					</div>
				</div>
			</div>
		</div>
		<div class="row  p-2">
		<div class="col-md-4 form-group my-2">
				<form action="{{ url('/admin/insertbrand') }}" method="POST" enctype="multipart/form-data">
					{{ csrf_field() }}
					<label for="" class="euz_b">Brand Name</label>
					<div class="input-group mb-3">
						<input type="text" class="form-control" name="name" id="name" required />
						<div class="input-group-append">
							<button class="btn euz_ne_add btn-success" type="submit"><i class="fas fa-plus"></i> ADD</button> 
						</div>
					</div>
				</form>
			</div>	
			<div class="col-md-4 my-2">
				<a class="btn euz_ne_add btn-info mt30" href="{{ url('/admin/exportbrand') }}" >Export</a> 
			</div>
		</dic>	
		<div class="col-md-12 my-2">
			<div class="table-responsive-sm">
				<table class="table table-bordered table-striped">
					<thead class="euz_thead_set">
						<tr>
							<th>Sl.No</th>
							<th>Brand Name</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $i = 1; foreach($brands as $item) { ?>
						<tr>
							<td><?php echo $i; ?></td>
							<td>{{ $item->name }}</td>
							<td><a href="" class="text-info euz_td_a" data-id='{{ $item->id }}' data-name='{{ $item->name }}' data-toggle="modal" data-target="#brands{{ $item->id }}"><i class="fas fa-user-edit"></i> Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;
								<a href="<?php echo url('/admin/deleteBrand/'.$item->id); ?>" onclick="return confirm('Are you sure to delete this item?')"  class="text-danger euz_td_a"><i class="fas fa-user-times"></i> Delete</a>
							</td>
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

										<form id="updatebrand" method="POST" enctype="multipart/form-data">
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
						<?php $i++; } ?>
					</tbody>
				</table>
			</div>
		</div>		
	</div>
	<!---End Brand---->

@endsection
@section('scripts')
	<script src="{{ url('/js/highcharts.js') }}"></script>
    <script src="{{ url('/js/highcharts-more.js') }}"></script>
	<script>
		function addgate() 
		{
			document.getElementById("addgateway").style.width = "80%";
		}
		function addgateclos() 
		{
			document.getElementById("addgateway").style.width = "0";
		}
		
		function addhub() 
		{
			document.getElementById("addhub").style.width = "80%";
		}
		function addhubclos() 
		{
			document.getElementById("addhub").style.width = "0";
		}

		function addunit() 
		{
			document.getElementById("addunit").style.width = "80%";
		}
		function addunitclos() 
		{
			document.getElementById("addunit").style.width = "0";
		}

		function addtype() 
		{
			document.getElementById("addtype").style.width = "80%";
		}
		function addtypeclos() 
		{
			document.getElementById("addtype").style.width = "0";
		}

		function addbrand() 
		{
			document.getElementById("addbrand").style.width = "80%";
		}
		function addbrandclos() 
		{
			document.getElementById("addbrand").style.width = "0";
		}
		/* sensor graph */
        $('#my_select').on('change', function () 
        {
            var selectData = $(this).val();
			//alert(selectData);
			//$('.').hide();
            if(selectData == 'datalable')
            {	
				$('.chart1').show();
				$('.chart2').hide();	
				$('.chart3').hide();	
				$('.chart4').hide();	
				$('.chart5').hide();	
				$('.chart6').hide();	
				$('.chart7').hide();	
				$('.chart8').hide();	
				$('.chart9').hide();	
				$('.chart10').hide();
				Highcharts.chart('datalable', 
				{
					chart: {
						type: 'line',
						scrollablePlotArea: {
							minWidth: 600
						}
					},
					title: {
						text: 'Temperature'
					},
					subtitle: {
						text: 'Sub heading'
					},
					xAxis: {
						categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
					},
					yAxis: {
						title: {
							text: 'Temperature (Â°C)'
						}
					},
					plotOptions: {
						line: {
							dataLabels: {
								enabled: true
							},
							enableMouseTracking: false
						}
					},
					series: [{
						name: 'Tokyo',
						data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
					}, {
						name: 'London',
						data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
					}]
				});
            }
			if(selectData == 'hourly')
            {		
				$('.chart2').show();
				$('.chart6').hide();	
				$('.chart3').hide();	
				$('.chart4').hide();	
				$('.chart5').hide();	
				$('.chart1').hide();	
				$('.chart7').hide();	
				$('.chart8').hide();	
				$('.chart9').hide();	
				$('.chart10').hide();		
                function getData(n) 
				{
					var arr = [],
						i,
						x,
						a,
						b,
						c,
						spike;
					for (
						i = 0, x = Date.UTC(new Date().getUTCFullYear(), 0, 1) - n * 36e5;
						i < n;
						i = i + 1, x = x + 36e5
					) {
						if (i % 100 === 0) {
							a = 2 * Math.random();
						}
						if (i % 1000 === 0) {
							b = 2 * Math.random();
						}
						if (i % 10000 === 0) {
							c = 2 * Math.random();
						}
						if (i % 50000 === 0) {
							spike = 10;
						} else {
							spike = 0;
						}
						arr.push([
							x,
							2 * Math.sin(i / 100) + a + b + c + spike + Math.random()
						]);
					}
					return arr;
				}
				var n = 1000,
					data = getData(n);


				console.time('line');
				Highcharts.chart('hourly', {

					chart: {
						zoomType: 'x'
					},

					title: {
						text: 'Heading'
					},


					tooltip: {
						valueDecimals: 2
					},

					xAxis: {
						type: 'datetime'
					},

					series: [{
						data: data,
						lineWidth: 0.5,
						name: 'Hourly data points'
					}]

				});
				console.timeEnd('line');
            }
			if(selectData == 'basicarea')
            {
				$('.chart3').show();
				$('.chart2').hide();	
				$('.chart6').hide();	
				$('.chart4').hide();	
				$('.chart5').hide();	
				$('.chart1').hide();	
				$('.chart7').hide();	
				$('.chart8').hide();	
				$('.chart9').hide();	
				$('.chart10').hide();
				Highcharts.chart('basicarea', 
				{
					chart: {
						type: 'area'
					},
					title: {
						text: 'Head'
					},
					xAxis: {
						allowDecimals: false,
						labels: {
							formatter: function () {
								return this.value; // clean, unformatted number for year
							}
						},
					},
					yAxis: {
						title: {
							text: 'left Label'
						},
						labels: {
							formatter: function () {
								return this.value / 1000 + 'k';
							}
						}
					},
					tooltip: {
						pointFormat: 'Value <b>{point.y:,.0f}</b><br/> Year {point.x}'
					},
					plotOptions: {
						area: {
							pointStart: 2020,
							marker: {
								enabled: false,
								symbol: 'circle',
								radius: 2,
								states: {
									hover: {
										enabled: true
									}
								}
							}
						}
					},
					series: [{
						name: 'sensor1',
						data: [ 6, 11, 32, 110, 235, 369, 640, 1005, 1436]
					}, {
						name: 'sensor2',
						data: [5, 25, 50, 120, 150, 200, 426, 660, 869, 1060]
					}]
				});
            }
			if(selectData == 'negativevalues')
            {
				$('.chart4').show();
				$('.chart2').hide();	
				$('.chart3').hide();	
				$('.chart6').hide();	
				$('.chart5').hide();	
				$('.chart1').hide();	
				$('.chart7').hide();	
				$('.chart8').hide();	
				$('.chart9').hide();	
				$('.chart10').hide();	
				Highcharts.chart('negativevalues', 
				{
					chart: {
						type: 'area'
					},
					title: {
						text: 'Heading'
					},
					xAxis: {
						categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May']
					},
					credits: {
						enabled: false
					},
					series: [{
						name: 'Sensor1',
						data: [5, 3, 4, 7, 2]
					}, {
						name: 'Sensor2',
						data: [2, -2, -3, 2, 1]
					}, {
						name: 'Sensor3',
						data: [3, 4, 4, -2, 5]
					}]
				});
            }
			if(selectData == 'invertedaxes') 
            {	
				$('.chart5').show();
				$('.chart2').hide();	
				$('.chart3').hide();	
				$('.chart4').hide();	
				$('.chart6').hide();	
				$('.chart1').hide();	
				$('.chart7').hide();	
				$('.chart8').hide();	
				$('.chart9').hide();	
				$('.chart10').hide();				
                Highcharts.chart('invertedaxes', 
				{
					chart: {
						type: 'area',
						inverted: true
					},
					title: {
						text: 'Heading'
					},
					legend: {
						layout: 'vertical',
						align: 'right',
						verticalAlign: 'top',
						x: -150,
						y: 100,
						floating: true,
						borderWidth: 1,
						backgroundColor:
							Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF'
					},
					xAxis: {
						categories: [
							'Monday',
							'Tuesday',
							'Wednesday',
							'Thursday',
							'Friday',
							'Saturday',
							'Sunday'
						]
					},
					yAxis: {
						title: {
							text: 'Number of units'
						},
						allowDecimals: false,
						min: 0
					},
					plotOptions: {
						area: {
							fillOpacity: 0.5
						}
					},
					series: [{
						name: 'sensor1',
						data: [3, 4, 3, 5, 4, 10, 12]
					}, {
						name: 'sensor2',
						data: [1, 3, 4, 3, 3, 5, 4]
					}]
				});
            }
			if(selectData == 'areaspline') 
            {
				$('.chart6').show();
				$('.chart2').hide();	
				$('.chart3').hide();	
				$('.chart4').hide();	
				$('.chart5').hide();	
				$('.chart1').hide();	
				$('.chart7').hide();	
				$('.chart8').hide();	
				$('.chart9').hide();	
				$('.chart10').hide();	
				Highcharts.chart('areaspline', 
				{
					chart: {
						type: 'areaspline'
					},
					title: {
						text: 'Heading'
					},
					legend: {
						layout: 'vertical',
						align: 'left',
						verticalAlign: 'top',
						x: 150,
						y: 100,
						floating: true,
						borderWidth: 1,
						backgroundColor:
							Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF'
					},
					xAxis: {
						categories: [
							'Monday',
							'Tuesday',
							'Wednesday',
							'Thursday',
							'Friday',
							'Saturday',
							'Sunday'
						],
					},
					yAxis: {
						title: {
							text: 'Left Label'
						}
					},
					tooltip: {
						shared: true,
						valueSuffix: ' units'
					},
					credits: {
						enabled: false
					},
					plotOptions: {
						areaspline: {
							fillOpacity: 0.5
						}
					},
					series: [{
						name: 'sensor1',
						data: [3, 4, 3, 5, 4, 10, 12]
					}, {
						name: 'sensor2',
						data: [1, 3, 4, 3, 3, 5, 4]
					}]
				});
            }
            if(selectData == 'arearangeline') 
            {
				$('.chart7').show();	
				$('.chart2').hide();	
				$('.chart3').hide();	
				$('.chart4').hide();	
				$('.chart5').hide();	
				$('.chart1').hide();	
				$('.chart6').hide();	
				$('.chart8').hide();	
				$('.chart9').hide();	
				$('.chart10').hide();
				var ranges = 
				[
					[1246406400000, 14.3, 27.7],
					[1246492800000, 14.5, 27.8],
					[1246579200000, 15.5, 29.6],
					[1246665600000, 16.7, 30.7],
					[1246752000000, 16.5, 25.0],
					[1246838400000, 17.8, 25.7],
					[1246924800000, 13.5, 24.8],
					[1247011200000, 10.5, 21.4],
					[1247097600000, 9.2, 23.8],
					[1247184000000, 11.6, 21.8],
					[1247270400000, 10.7, 23.7],
					[1247356800000, 11.0, 23.3],
					[1247443200000, 11.6, 23.7],
					[1247529600000, 11.8, 20.7],
					[1247616000000, 12.6, 22.4],
					[1247702400000, 13.6, 19.6],
					[1247788800000, 11.4, 22.6],
					[1247875200000, 13.2, 25.0],
					[1247961600000, 14.2, 21.6],
					[1248048000000, 13.1, 17.1],
					[1248134400000, 12.2, 15.5],
					[1248220800000, 12.0, 20.8],
					[1248307200000, 12.0, 17.1],
					[1248393600000, 12.7, 18.3],
					[1248480000000, 12.4, 19.4],
					[1248566400000, 12.6, 19.9],
					[1248652800000, 11.9, 20.2],
					[1248739200000, 11.0, 19.3],
					[1248825600000, 10.8, 17.8],
					[1248912000000, 11.8, 18.5],
					[1248998400000, 10.8, 16.1]
				],
				averages = [
					[1246406400000, 21.5],
					[1246492800000, 22.1],
					[1246579200000, 23],
					[1246665600000, 23.8],
					[1246752000000, 21.4],
					[1246838400000, 21.3],
					[1246924800000, 18.3],
					[1247011200000, 15.4],
					[1247097600000, 16.4],
					[1247184000000, 17.7],
					[1247270400000, 17.5],
					[1247356800000, 17.6],
					[1247443200000, 17.7],
					[1247529600000, 16.8],
					[1247616000000, 17.7],
					[1247702400000, 16.3],
					[1247788800000, 17.8],
					[1247875200000, 18.1],
					[1247961600000, 17.2],
					[1248048000000, 14.4],
					[1248134400000, 13.7],
					[1248220800000, 15.7],
					[1248307200000, 14.6],
					[1248393600000, 15.3],
					[1248480000000, 15.3],
					[1248566400000, 15.8],
					[1248652800000, 15.2],
					[1248739200000, 14.8],
					[1248825600000, 14.4],
					[1248912000000, 15],
					[1248998400000, 13.6]
				];
				Highcharts.chart('arearangeline', 
				{
					chart: 
					{
						scrollablePlotArea: {
							minWidth: 600
						}
					},
					title: {
						text: 'Temperatures'
					},

					xAxis: {
						type: 'datetime',
					},

					yAxis: {
						title: {
							text: null
						}
					},

					tooltip: {
						crosshairs: true,
						shared: true,
						valueSuffix: 'Â°C'
					},

						series: 
						[{
							name: 'Temperature',
							data: averages,
							zIndex: 1,
							marker: {
								fillColor: 'white',
								lineWidth: 2,
								lineColor: Highcharts.getOptions().colors[0]
							}
						}, {
							name: 'Range',
							data: ranges,
							type: 'arearange',
							lineWidth: 0,
							linkedTo: ':previous',
							color: Highcharts.getOptions().colors[0],
							fillOpacity: 0.3,
							zIndex: 0,
							marker: {
								enabled: false
						}
					}]
				});
            }
			if(selectData == 'basicbar') 
            {
				$('.chart8').show();
				$('.chart2').hide();	
				$('.chart3').hide();	
				$('.chart4').hide();	
				$('.chart5').hide();	
				$('.chart1').hide();	
				$('.chart7').hide();	
				$('.chart6').hide();	
				$('.chart9').hide();	
				$('.chart10').hide();	
				Highcharts.chart('basicbar', 
				{
					chart: {
						type: 'bar'
					},
					title: {
						text: 'Heading'
					},
					xAxis: {
						categories: ['sensor1', 'sensor2', 'sensor3', 'sensor4', 'sensor5'],
						title: {
							text: null
						}
					},
					yAxis: {
						min: 0,
						title: {
							text: 'Population (millions)',
							align: 'high'
						},
						labels: {
							overflow: 'justify'
						}
					},
					tooltip: {
						valueSuffix: ' millions'
					},
					plotOptions: {
						bar: {
							dataLabels: {
								enabled: true
							}
						}
					},
					legend: {
						layout: 'vertical',
						align: 'right',
						verticalAlign: 'top',
						x: -40,
						y: 80,
						floating: true,
						borderWidth: 1,
						backgroundColor:
							Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
						shadow: true
					},
					credits: {
						enabled: false
					},
					series: [{
						name: 'Year 2017',
						data: [10.1, 5.1, 0.10, 20.3, 2]
					}, {
						name: 'Year 2018',
						data: [13.3, 7.6, 9.47, 30.8, 0.6]
					}, {
						name: 'Year 2019',
						data: [8.14, 4.21, 7.14, 17.7, 3.1]
					}, {
						name: 'Year 2020',
						data: [12.6, 10.1, 4.36, 13.8, 4.0]
					}]
				});
            }
			if(selectData == 'stackedbar') 
            {
				$('.chart9').show();
				$('.chart2').hide();	
				$('.chart3').hide();	
				$('.chart4').hide();	
				$('.chart5').hide();	
				$('.chart1').hide();	
				$('.chart7').hide();	
				$('.chart8').hide();	
				$('.chart6').hide();	
				$('.chart10').hide();	
				Highcharts.chart('stackedbar', 
				{
					chart: {
						type: 'bar'
					},
					title: {
						text: 'Heading'
					},
					xAxis: {
						categories: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']
					},
					yAxis: {
						min: 0,
						title: {
							text: 'Week report'
						}
					},
					legend: {
						reversed: true
					},
					plotOptions: {
						series: {
							stacking: 'normal'
						}
					},
					series: [{
						name: 'sensor1',
						data: [5, 3, 4, 7, 2]
					}, {
						name: 'sensor1',
						data: [2, 2, 3, 2, 1]
					}, {
						name: 'sensor1',
						data: [3, 4, 4, 2, 5]
					}]
				});
            }
			if(selectData == 'basiccolumn') 
            {
				$('.chart10').show();
				$('.chart2').hide();	
				$('.chart3').hide();	
				$('.chart4').hide();	
				$('.chart5').hide();	
				$('.chart1').hide();	
				$('.chart7').hide();	
				$('.chart8').hide();	
				$('.chart9').hide();	
				$('.chart6').hide();
                Highcharts.chart('basiccolumn', 
				{
					chart: {
						type: 'column'
					},
					title: {
						text: 'Heading'
					},
					xAxis: {
						categories: [
							'Jan',
							'Feb',
							'Mar',
							'Apr',
							'May',
							'Jun',
							'Jul',
							'Aug',
							'Sep',
							'Oct',
							'Nov',
							'Dec'
						],
						crosshair: true
					},
					yAxis: {
						min: 0,
						title: {
							text: 'Rainfall (mm)'
						}
					},
					tooltip: {
						headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
						pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
							'<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
						footerFormat: '</table>',
						shared: true,
						useHTML: true
					},
					plotOptions: {
						column: {
							pointPadding: 0.2,
							borderWidth: 0
						}
					},
					series: [{
						name: 'sensor1',
						data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]

					}, {
						name: 'sensor2',
						data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, 106.6, 92.3]

					}, {
						name: 'sensor3',
						data: [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6, 52.4, 65.2, 59.3, 51.2]

					}, {
						name: 'sensor4',
						data: [42.4, 33.2, 34.5, 39.7, 52.6, 75.5, 57.4, 60.4, 47.6, 39.1, 46.8, 51.1]

					}]
				});
            }
        });
	function delitem(delid)
	{	
		var url = "{{URL('admin/deleteGroup')}}";
		var dltUrl = url+"/"+delid;
		$.ajax(
		{
			url : dltUrl,
			method : "GET",
			success:function(response)
			{
				//alert(response)
				if(response == 'del')
				{
					if(confirm("Are you sure to delete this item?"))
					{
						var url = "{{URL('admin/deleteGroupcnt')}}";
						$.ajax(
						{
							url : url,
							method : "GET",
							success:function(response)
							{
								$("#gr"+delid).remove();
								$('.totgrp').html(response);
								alert("Deleted Successfully");
							}
						});
					}	
				}	
				else
				{
					ConfirmDialog(response);
					function ConfirmDialog(message) 
					{
						$('<div></div>').appendTo('body')
						.html('<div><h6>' + message + '</h6></div>')
						.dialog(
						{
							modal: true,
							title: 'Caution',
							zIndex: 10000,
							autoOpen: true,
							width: 'auto',
							resizable: false,
							buttons: 
							{
								Cancel: function() 
								{
									$(this).dialog("close");                                   
								}
							},
							close: function(event, ui) {
								$(this).remove();
							}
						});
					};
				}			
			}
		});
	}
	function delsensortype(delid)
	{	
		var url = "{{URL('admin/deleteType')}}";
		var dltUrl = url+"/"+delid;
		$.ajax(
		{
			url : dltUrl,
			method : "GET",
			success:function(response)
			{
				//alert(response);
				if(response == 'del')
				{
					if(confirm("Are you sure to delete this item?"))
					{
						var url = "{{URL('admin/deleteTypecnt')}}";
						$.ajax(
						{
							url : url,
							method : "GET",
							success:function(response)
							{
								$("#grty"+delid).remove();
								$('.totgrpty').html(response);
								alert("Deleted Successfully");
							}
						});
					}
				}
				else
				{
					ConfirmDialog(response);
					function ConfirmDialog(message) 
					{
						$('<div></div>').appendTo('body')
						.html('<div><h6>' + message + '</h6></div>')
						.dialog(
						{
							modal: true,
							title: 'Alert',
							zIndex: 10000,
							autoOpen: true,
							width: 'auto',
							resizable: false,
							buttons: 
							{
								Cancel: function() 
								{
									$(this).dialog("close");                                   
								}
							},
							close: function(event, ui) {
								$(this).remove();
							}
						});
					};
				}					
			}
		});
	}

$('body, html').on('submit','#sengrp', function(e) {
	//$('#sengrp').on('submit', function(e){
e.preventDefault();

//alert("hai");
 $.ajax(
        {
          
           url:"{{url('/admin/updategroup')}}",
            method:"POST",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            async: false,
            
            success:function(data)
            {    
                      
                $(".tblsen").html(data);
                alert("Updated Successfully");
                
            }
        });			




});

/*$('#sengrp').on('submit', function(event)
    {
        event.preventDefault();	
        		alert("en1");	
        $.ajax(
        {
          
           url:"{{url('/admin/updategroup')}}",
            method:"POST",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            
            success:function(data)
            {    
                      
                $(".tblsen").html(data);
                alert("Updated Successfully");
                
            }
        });			
    }); */ 



$('.updatetype').on('submit', function(event){
//$('#updatetype').on('submit', function(event)
    
        event.preventDefault();	
        	//alert("en");		
        $.ajax(
        {
           // url:"{{  url('/editarchive') }}",
           url:"{{url('admin/updatetype')}}",
            method:"POST",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            //dataType: 'json',
            success:function(data)
            {    
                      //$("#name").val('');
                $(".tblsenbrand").html(data);
                alert("Updated Successfully");
                //$("#archive").load("#archive");
            }
        });			
    });  



$('.editunit').on('submit', function(event){
//$('#updatetype').on('submit', function(event)
    
        event.preventDefault();	
//alert("editunit")
 $.ajax(
        {
           // url:"{{  url('/editarchive') }}",
           url:"{{url('admin/editunit')}}",
            method:"POST",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            //dataType: 'json',
            success:function(data)
            {    
                      //$("#name").val('');
                $(".tblunit").html(data);
                alert("Updated Successfully");
                //$("#archive").load("#archive");
            }
        });			








    });








$('#addsens').on('submit', function(event)
    {
        event.preventDefault();	
        			
        $.ajax(
        {
           // url:"{{  url('/editarchive') }}",
           url:"{{url('/admin/insertgroup')}}",
            method:"POST",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            //dataType: 'json',
            success:function(data)
            {    
                      $("#name").val('');
                $(".tblsen").html(data);

$.ajax({
            type: 'get',
            url:"{{url('/admin/getsensoreditdetailscount')}}",
            
            async: false,
            
            success: function (data) {
$('.totgrp').html(data);
alert("Added Successfully");
            }});

    //});



                
                //$("#archive").load("#archive");
            }
        });			
    });  






$('#instype').on('submit', function(event)
    {
        event.preventDefault();	
        			
        $.ajax(
        {
           // url:"{{  url('/editarchive') }}",
           url:"{{url('/admin/inserttype')}}",
            method:"POST",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            //dataType: 'json',
            success:function(data)
            {    
                      //$("#name").val('');


                      $("#eid").val('');
$("#sname").val('');
$("#modal").val('');
$("#brand").val('');
$("#max").val('');
$("#min").val('');
$(".max").val('');
$(".min").val('');
$("#remark").val('');
                $(".tblsenbrand").html(data);
$.ajax({
            type: 'get',
            url:"{{url('/admin/getsensoreditdetailstypecount')}}",
            
            data:{},
            success: function (data) {
$('.totgrpty').html(data);
 alert("Added Successfully");
            }});

    //});


               




                //$("#archive").load("#archive");
            }
        });			
    });  


$('#addunitfrm').on('submit', function(event)
    {
		$("#loader").show();
        event.preventDefault();				
        $.ajax(
        {
           // url:"{{  url('/editarchive') }}",
           url:"{{url('/admin/addunit')}}",
            method:"POST",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            //dataType: 'json',
            success:function(data)
            {    
                $(".tblsenchart").html(data);
				$.ajax(
				{
					type: 'get',
					url:"{{url('/admin/getchartcount')}}",
					
					data:{},
					success: function (data) 
					{
						$("#loader").hide();
						$('.totchart').html(data);
						alert("Added Successfully");
					}
				});
            }
        });			
    });  
function hideimg(){

	//alert("sss");
$('.ld').show();
$('.euztumbs1').hide();
}







	</script>
	<style>
		.modal-backdrop.show 
		{
			z-index: 0 !important;
display:none;
		}
	</style>
@parent
@endsection