@extends('layouts.admin')
@section('content')
<!---- euz_div ----->
    <div id="myDiv">
        <div id="loading-image" style="display:none;"></div>
		<!--<img id="loading-image" src="{{ url('/loader/1.gif') }}" style="display:none; background: none repeat scroll 0 0 black; position: fixed; opacity: 0.5; z-index: 1000001; top: 200px; left: 600px;"/>-->
    </div>
    <div class="p-3">
        <div class="row">
            <div class="col-md-12 euz_bar euz_b">
                <a href="{{ url('/admin/agents') }}" class="euz_text_blue"><i class="fas fa-user euz_text_blue"></i> <?php echo $user[0]->fname.' '.$user[0]->lname; ?></a> / <a href="<?php echo  url('/admin/groups/'.$user[0]->id); ?>" class="euz_text_blue"><?php echo $groupname[0]->name; ?></a> / <a href="<?php echo  url('/admin/sensorhubs/'.$user[0]->id.'/'.$group[0]->id); ?>" class="euz_text_blue"><?php echo $hubname[0]->hub_id; ?></a> / <span class="euz_ac_bl euz_text_blue">Sensor</span>
                <a href="{{ url('/excel/sensor.xlsx') }}" class="float-right euz_a_icon"><i class="fas fa-file-download euz_a_icon"></i> Sensor Import Sheet</a>
            </div>
            @if(Session::has('flash_message'))
            <div class="alert alert-success w-100"><button type="button" class="close" data-dismiss="alert">&times;</button>{{ Session::get('flash_message') }}</div>
            @endif
            <div class="col-md-12 euz_border p-3 bg-white">
                <div class="row">
                    <div class="col-md-12 my-2">
                        <a class="btn euz_btn_add float-right euz_pointer" href="<?php echo url('/admin/sensorhubs/'.request()->agentid.'/'.request()->groupid); ?>"><i class="far fa-arrow-alt-circle-left"></i> Back To Sensor Hub</a>
                        <!--<a class="btn btn-success float-right rounded-0 ml-2" href="javascript:void(0)" data-toggle="modal" data-target="#sensorimport"><i class="fas fa-file-upload"></i> Import</a>-->
                    </div>
                    @foreach($sensors as $index =>$item)
                    <?php
                        $typelist = DB::table('types')->where('id', $item->type)->get();
                        //echo $typelist[0]->name;
                    ?>
                    <div class="col-md-4 mt-2">
                        <div class="card">
                            <div class="card-header">
                                <div class="custom-checkbox">
                                    <label class="euz_check_box euz_b">{{ $item->sensor_id }}
                                        <input type="checkbox" class="euz_check_agent" id="checkarray" name="checkarray[]" value="<?php echo $item->sensorid;?>" />
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="card-body pb-0 euz_b">
                                <p class="mb-2">Type : {{ $item->typename }} | Unit : {{ $item->unit }}</p>
                                <p class="mb-2">Brand : {{ $item->brand }}</p>
                            </div> 
                            <?php 
                                $graph = DB::select('select * from sensor_graph where sensor_id ='.$item->sensorid);
                            ?>
                            <div class="card-footer text-right bg-white euz_card_fo pr-2">
                                <a href="javascript:void(0)" class="ml-2" data-toggle="tooltip" data-placement="top" title="Sensor Info" onclick="profileopen(<?php echo $item->sensorid.','.$item->hub_id.','.request()->agentid.','.request()->groupid; ?>)"><i class="fas fa-eye euz_a_icon"></i></a>
                                <?php if(!empty($graph[0]->id)) { ?>
                                <a href="javascript:void(0)" class="ml-2 chartedit"  data-id="{{ $item->sensorid }}" data-toggle="modal" data-target="#chartedit" title="Edit Graph"><i class="fas fa-chart-bar euz_a_icon"></i></a>
                                <?php } else { ?>
                                <a href="javascript:void(0)" class="ml-2 graphpop"  data-id="{{ $item->sensorid }}" data-type="{{ $item->type }}" data-toggle="modal" data-target="#addchart" title="Add Graph"><i class="fas fa-chart-bar euz_a_icon"></i></a>
                                <?php } ?>
                                <a href="javascript:void(0)" class="ml-2 modalLink" title="Edit"  data-id="{{ $item->sensorid }}" data-toggle="modal" data-target="#sensoredit"><i class="fas fa-edit euz_a_icon"></i></a>
                                <a href="<?php echo url('/admin/deleteSensor/'.$item->sensorid); ?>" class="ml-2" title="Delete" onclick="return confirm('Are you sure?')"><i class="fas fa-trash-alt euz_a_icon"></i></a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>			
        </div>
    </div>
    <!---profile---->
	<div id="agentprofile" class="euz_agent_profile"></div>
    <!---End Profile---->
    <a href="#" class="btn euz_float_import sensoreditpop" title="New/Update Import" data-toggle="modal" data-target="#sensoreditpop"><i class="fas fa-file-upload"></i></a>
    <a href="javascript:void(0)" class="btn euz_float_export euz_ied" title="Export" onclick="exportsensor()"><i class="fas fa-file-download"></i></a>
    <a href="javascript:void(0)" class="btn btn-danger euz_float_trash euz_ied" onclick="deletedoc()"><i class="fas fa-trash-alt"></i></a>
    <a href="javascript:void(0)" class="btn euz_float_add" data-toggle="modal" data-target="#sensoradd"><i class="fas fa-plus"></i></a>
    <!---Add Sensor edit import----> 
    <div class="modal fade" id="sensoreditpop">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable euz_w_90">
            <div class="modal-content" style="width: 40%;">
                <div class="modal-header euz_carb p-0">
                    <h5 class="modal-title p-2 text-white">New/Update Sensor</h5>
                    <button type="button" class="close" data-dismiss="modal">
                    <span>×</span>
                    </button>
                </div>
                <form method="post" enctype="multipart/form-data" action="{{ url('admin/import_excel/sensoreditimport') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="sensoreditpopid" id="sensoreditpopid" value="" />
                    <input type="hidden" name="hub_id" value="<?php echo request()->hubid; ?>" /> 
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12">
                                <label class="euz_b" for="">Upload File (Excel file only)</label>
                                <input type="file" class="form-control disname" id="" required name="select_file" accept=".xlsx, .xls" />
                            </div>					
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success rounded-0 euz_bt" name="upload"><i class="fas fa-angle-double-up"></i> Upload</button>
                        <button type="button" class="btn btn-danger rounded-0 euz_bt" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End Sensor edit import--->
    <!--addchart--->   
    <div class="modal fade" id="addchart">
		<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable euz_w_90">
			<div class="modal-content">
                <div class="modal-header euz_carb p-0">
                    <p class="modal-title p-2 text-white">Add Sensor Graph</p>
                </div>
                <div class="modal-body">
                    <form  method="POST" enctype="multipart/form-data" id="createsensorgraph">
                            {{ csrf_field() }}
                            <input type="hidden" name="grapheid" value="" id="grapheid" />
                            <input type="hidden" name="agent" value="<?php echo $user[0]->id; ?>" id="" />                                  
                            <div class="row">
                                <div class="form-group col-md-3 my-2">
                                    <label class="euz_b" for="">Model Name</label>
                                    <input type="text" class="form-control" id="sname" name="" disabled="" value="" />
                                </div>
                                <div class="form-group col-md-3 my-2">
                                    <label class="euz_b" for="">Model</label>
                                    <input type="text" class="form-control" id="modal" name="" disabled="" value="" />
                                </div>
                                <div class="form-group col-md-3 my-2">
                                    <label class="euz_b" for="">Type</label>
                                    <input type="text" class="form-control" id="typename" name="" disabled="">
                                </div>
                                <div class="form-group col-md-3 my-2">
                                    <label class="euz_b" for="">Brand</label>
                                    <input type="text" class="form-control" id="sensorbrand" name="" disabled="">
                                </div>
                                <div class="form-group col-md-3 my-2">
                                    <label class="euz_b" for="">Measurement Unit</label>
                                    <input type="text" class="form-control" id="sensorunit" name="" disabled="">
                                </div>
                                <!-- <div class="form-group col-md-3 my-2">
                                    <label class="euz_b" for="">Graph Type</label>
                                    <select class="form-control" id="my_select" name="type" required>
                                        <option value="">Select Type</option>
                                        <option value="line">Line</option>
                                        <option value="area">Area</option>
                                        <option value="column">Column</option>
                                        <option value="bar">Bar</option>
                                        <option value="pie">Pie</option>
                                        <option value="scatter">Scatter</option>
                                        <option value="spline">Spline</option>
                                    </select>
                                </div> -->
                                <div class="form-group col-md-6 my-2">
                                    <label class="euz_b" for="">Title</label>
                                    <input type="text" class="form-control" id="txt_name" name="title" required />
                                </div>
                                <div class="form-group col-md-3 my-2">
                                    <label class="euz_b" for="">Y Axis Label</label>
                                    <input type="text" class="form-control" id="yaxis" name="yaxis" required />
                                </div>
                                <div class="form-group col-md-3 my-2">
                                    <label class="euz_b" for="">Min Value</label>
                                    <input type="text" class="form-control" id="minadd" name="min" disabled>
                                </div>
                                <div class="form-group col-md-3 my-2">
                                    <label class="euz_b" for="">Max Value</label>
                                    <input type="text" class="form-control" id="maxadd" name="max" disabled>
                                </div>
								<div class="col-md-3 my-2">im
									<img src="../image/tumb/area.PNG" class="img-fluid" style="width:100px;">im
<img id="aimg" src="" class="img-fluid" style="width:100px;">

                                </div>
                                <!--<div class="form-group col-md-3 my-2">
                                    <label class="euz_b" for="">Fake Value</label>
                                    <input type="text" class="form-control" id="" name="fake">
                                </div>-->                    
                                <!--<div class="col-md-12 my-2">
                                    <div class="shadow-sm">
                                        <div class="col-md-12 euz_header">
                                            <p class="text-white euz_b">Sensor Graph View</p>
                                        </div>
                                        <div class="col-md-12 euz_border">
                                            <div id="datalable"></div>
                                        </div>
                                        <div class="col-md-12 euz_border">
                                            <div id="hourly"></div>
                                        </div>
                                        <div class="col-md-12 euz_border">
                                            <div id="basicarea"></div>
                                        </div>
                                        <div class="col-md-12 euz_border">
                                            <div id="negativevalues"></div>
                                        </div>
                                        <div class="col-md-12 euz_border">
                                            <div id="invertedaxes"></div>
                                        </div>
                                        <div class="col-md-12 euz_border">
                                            <div id="areaspline"></div>
                                        </div>
                                        <div class="col-md-12 euz_border">
                                            <div id="arearangeline"></div>
                                        </div>
                                        <div class="col-md-12 euz_border">
                                            <div id="basicbar"></div>
                                        </div>
                                        <div class="col-md-12 euz_border">
                                            <div id="stackedbar"></div>
                                        </div>
                                        <div class="col-md-12 euz_border">
                                            <div id="basiccolumn"></div>
                                        </div>
                                    </div>
                                </div> -->                
                            </div>              
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success euz_all_edc rounded-0 euz_bt" name="submit"><i class="far fa-save"></i> Save</button>
                                <button type="button" class="btn btn-danger euz_all_edc rounded-0 euz_bt" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                            </div>
                        </form>
                </div>
			</div>
		</div>
    </div> 
    <!--End addchart---->
    <!--editchart--->   
    <div class="modal fade" id="chartedit">
		<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable euz_w_90">
			<div class="modal-content">
                <div class="modal-header euz_carb p-0">
                    <p class="modal-title p-2 text-white">Sensor Graph</p>
                </div>
                <div class="modal-body">
                    <form  method="POST" enctype="multipart/form-data" action="{{ url('/admin/updategraph') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="grapheid" value="" id="editgrapheid" />
                        <input type="hidden" name="agent" value="<?php echo $user[0]->id; ?>" id="" />                                  
                        <div class="row">
                            <div class="form-group col-md-3 my-2">
                                <label class="euz_b" for="">Model Name</label>
                                <input type="text" class="form-control" id="snameedit" name="" disabled="disabled" value="" />
                            </div>
                            <div class="form-group col-md-3 my-2">
                                <label class="euz_b" for="">Model</label>
                                <input type="text" class="form-control" id="modaledit" name="" disabled="disabled" value="" />
                            </div>
                            <div class="form-group col-md-3 my-2">
                                <label class="euz_b" for="">Type</label>
                                <input type="text" class="form-control" id="typenameedit" name="" disabled="disabled" />
                            </div>
                            <div class="form-group col-md-3 my-2">
                                <label class="euz_b" for="">Brand</label>
                                <input type="text" class="form-control" id="sensorbrandedit" name="" disabled="disabled" />
                            </div>
                            <div class="form-group col-md-3 my-2">
                                <label class="euz_b" for="">Measurement Unit</label>
                                <input type="text" class="form-control" id="sensorunitedit" name="" disabled="disabled" />
                            </div>
                            <!-- <div class="form-group col-md-3 my-2">
                                <label class="euz_b" for="">Graph Type</label>
                                <select class="form-control disname" id="typegraph" name="type" required disabled="disabled" >
                                    <option value="">Select Type</option>
                                    <option value="line">Line</option>
                                    <option value="area">Area</option>
                                    <option value="column">Column</option>
                                    <option value="bar">Bar</option>
                                    <option value="pie">Pie</option>
                                    <option value="scatter">Scatter</option>
                                    <option value="spline">Spline</option>
                                </select>
                            </div> -->
                            <div class="form-group col-md-6 my-2">
                                <label class="euz_b" for="">Title</label>
                                <input type="text" class="form-control disname" id="title" name="title" required disabled="disabled" />
                            </div>
                            <div class="form-group col-md-3 my-2">
                                <label class="euz_b" for="">Y Axis Label</label>
                                <input type="text" class="form-control disname" id="edityaxis" name="yaxis" required disabled="disabled" />
                            </div>
                            <div class="form-group col-md-3 my-2">
                                <label class="euz_b" for="">Min Value</label>
                                <input type="text" class="form-control" id="min" name="min" disabled="disabled" />
                            </div>
                            <div class="form-group col-md-3 my-2">
                                <label class="euz_b" for="">Max Value</label>
                                <input type="text" class="form-control" id="max" name="max" disabled="disabled" />
                            </div>
							<div class="col-md-3 my-2">
                                    <img src="../image/tumb/area.PNG" class="img-fluid" style="width:100px;">
<img id="eimg" src="" class="img-fluid" style="width:100px;">
                                </div>
                            <!--<div class="form-group col-md-3 my-2">
                                <label class="euz_b" for="">Fake Value</label>
                                <input type="text" class="form-control disname" id="fake" name="fake" disabled="disabled" />
                            </div>--->                  
                            <!--<div class="col-md-12 my-2">
                                <div class="shadow-sm">
                                    <div class="col-md-12 euz_header">
                                        <p class="text-white euz_b">Sensor Graph View</p>
                                    </div>
                                    <div class="col-md-12 euz_border">
                                        <div id="datalable1"></div>
                                    </div>
                                    <div class="col-md-12 euz_border">
                                        <div id="hourly1"></div>
                                    </div>
                                    <div class="col-md-12 euz_border">
                                        <div id="basicarea1"></div>
                                    </div>
                                    <div class="col-md-12 euz_border">
                                        <div id="negativevalues1"></div>
                                    </div>
                                    <div class="col-md-12 euz_border">
                                        <div id="invertedaxes1"></div>
                                    </div>
                                    <div class="col-md-12 euz_border">
                                        <div id="areaspline1"></div>
                                    </div>
                                    <div class="col-md-12 euz_border">
                                        <div id="arearangeline1"></div>
                                    </div>
                                    <div class="col-md-12 euz_border">
                                        <div id="basicbar1"></div>
                                    </div>
                                    <div class="col-md-12 euz_border">
                                        <div id="stackedbar1"></div>
                                    </div>
                                    <div class="col-md-12 euz_border">
                                        <div id="basiccolumn1"></div>
                                    </div>
                                </div>
                            </div>-->                 
                        </div>              
                        <div class="modal-footer">
                            <a class="btn btn-primary float-right euz_all_edc ml-2 btnenable euz_bt" href="#"><i class="far fa-edit"></i> Edit</a>
                            <button type="submit" class="btn btn-success float-right euz_all_edc ml-2 btnupdate euz_bt" name="update" style="display: block;"><i class="fas fa-sync"></i> Update</button>
                            <button type="button" class="btn btn-danger rounded-0 euz_bt" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                        </div>
                    </form>
                </div>
			</div>
		</div>
    </div> 
    <!--End editchart---->
    <!---Add import sensor---->
    <div class="modal fade" id="sensorimport">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable euz_w_90">
            <div class="modal-content" style="width: 40%;">
                <div class="modal-header euz_carb p-0">
                    <h5 class="modal-title p-2 text-white">Import Sensor</h5>
                </div>
                <form method="post" enctype="multipart/form-data" action="{{ url('/admin/import_excel/importsensor') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="hub_id" value="<?php echo request()->hubid; ?>" /> 
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12">
                                <label class="euz_b" for="">Upload File (Excel file only)</label>
                                <input type="file" class="form-control disname" id="" required name="select_file" accept=".xlsx, .xls" />
                            </div>					
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success rounded-0 euz_bt" name="uploadhub"><i class="fas fa-angle-double-up"></i> Upload</button>
                        <button type="button" class="btn btn-danger rounded-0 euz_bt" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End import sensor--->
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
                    <input type="hidden" name="hub_id" value="<?php echo request()->hubid; ?>" />
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="euz_b" for="">Agent</label>
                                <input type="text" class="form-control disname" id="" value=" <?php echo $user[0]->fname.' '.$user[0]->lname; ?>" disabled="disabled">
                            </div>
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="euz_b" for="">Gateway Group Name</label>
                                <input type="text" class="form-control disname" id="" value="<?php echo $groupname[0]->name; ?>" disabled="disabled">
                            </div>
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="euz_b" for="">Sensor Hub Name</label>
                                <input type="text" class="form-control disname" id="" value="<?php echo $hubname[0]->hub_id; ?>" disabled="disabled">
                            </div>
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="euz_b" for="">Sensor ID</label>
                                <select class="form-control" id="country_name" name="sensor_id">
                                    <option value="">-Select Type-</option>
                                    @foreach($data as $item)
                                        <option value="{{ $item->sensor_id }}"><?php echo $item->sensor_id; ?></option>
                                    @endforeach
                                </select>
                            </div>                  
                            <div class="form-group col-lg-6 col-md-4">
                                <label class="euz_b" for="">Model Name - Model - Brand</label>
                                <div class="input-group">
                                    <select class="form-control sensortype" id="sensortype" name="type">
                                        <option value="">-Select Type-</option>
                                        @foreach($types as $item)
                                            <option value="{{ $item->id }}"><?php echo $item->sname.'-'.$item->modal.'-'.$item->brand; ?></option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-prepend">
                                        <a class="btn btn-primary" style="height: 33px;" data-toggle="modal" data-backdrop="static" data-target="#add"><i class="fas fa-plus"></i></a>
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
                                <textarea type="text" class="form-control disname" id="remark" rows="5" name="inform"></textarea>
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
					<input type="hidden" name="eid" value="" id="eid" />
					<input type="hidden" name="hub_id" value="" id="hub_id" />
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="euz_b" for="">Agent</label>
                                <input type="text" class="form-control disname" id="" value="<?php echo $user[0]->fname.' '.$user[0]->lname; ?>" disabled="disabled">
                            </div>
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="euz_b" for="">Gateway Group Name</label>
                                <input type="text" class="form-control disname" id="" value="<?php echo $groupname[0]->name; ?>" disabled="disabled">
                            </div>
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="euz_b" for="">Sensor Hub Name</label>
                                <input type="text" class="form-control disname" id="" value="<?php echo $hubname[0]->hub_id; ?>" disabled="disabled">
                            </div>
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="euz_b" for="">Sensor ID</label>
                                <select class="form-control" id="sensor_id" name="sensor_id">
                                    @foreach($data as $item3)
                                        <option value="{{ $item3->sensor_id }}"><?php echo $item3->sensor_id; ?></option>
                                    @endforeach
                                </select>
                            </div>                 
                            <div class="form-group col-lg-6 col-md-4">
                                <label class="euz_b" for="">Model Name - Model - Brand</label>
                                <div class="input-group">
                                    <select class="form-control sensortype" id="sensortypeedit" name="type">
                                        <option value="">-Select Type-</option>
                                        @foreach($types as $item)
                                            <option value="{{ $item->id }}"><?php echo $item->sname.'-'.$item->modal.'-'.$item->brand; ?></option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-prepend">
                                        <a class="btn btn-primary" style="height: 33px;" data-toggle="modal" data-backdrop="static" data-target="#add"><i class="fas fa-plus"></i></a>
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
    <div class="modal fade" id="add">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable euz_w_90">
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
									<label for="" class="euz_b">Model Name</label>
									<div class="input-group mb-3">								
										<input type="text" class="form-control" required="" id="" value="" name="sname">
									</div>
								</div>
								<div class="form-group col-md-4">
									<label for="" class="euz_b">Model</label>
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
							<div class="modal-footer input-group-append">
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
@endsection
@section('scripts')
    <script>
        $(".euz_ied").hide();
        $(function () 
        {
            $(".euz_check_agent").click(function () 
            {
                var len = $("#checkarray:checked").length;
                if ($(this).is(":checked"))
                {
                    $(".euz_ied").show();
                } 
                else               
                {
                    if(len == 0)
                    {
                        $(".euz_ied").hide();
                    }
                }
            });
        });
        function profileopen(sensorid, hubid, agentid, groupid) 
        {
            //alert(sensorid);
            var url = "{{ url('/admin/editSensor') }}";
            var docurl = url + "/" + sensorid + "/" + hubid+ "/" + agentid+ "/" + groupid;
            $.ajax({
                url : docurl,
                method : "GET",
                beforeSend: function() {
                    $("#loading-image").show();
                },
                success:function(response)
                {
                    //alert(response);
                    $('#agentprofile').html(response);
                    $("#loading-image").hide();
                }
            });	
            document.getElementById("agentprofile").style.width = "80%";
        }	
        function profileclose() 
        {
            document.getElementById("agentprofile").style.width = "0";
        }
        $(document).on("click", ".modalLink", function () 
        {
            var passedID = $(this).data('id'); 
            var url = "{{ url('/admin/editSensorpop') }}";
            var docurl = url + "/" + passedID;
var imgpath="";
alert("hai");
            $.ajax({
                url : docurl,
                method : "GET",
                dataType: 'json',
                success:function(data)
                {

                    //alert(data.sensor_id);
                    $("#eid").val(passedID);
                    $("#hub_id").val(data.hub_id);
                    $("#sensor_id").val(data.sensor_id);
					$("#sensortypeedit").val(data.type);					
					$("#brandsensoredit").val(data.min);
                    $("#brandunitedit").val(data.max);
                    $("#remarkedit").val(data.sensor_inform);
                    $("#typedataedit").val(data.sensor_type);
                    $("#unitdataedit").val(data.unit);
                    $("#valuedataedit").val(data.value);
//$("#eimg.attr("src", "images/card-front.jpg"));

//if (data.cname=='Areachart'){
//imgpath="https://mqtt.eurozapp.eu/argus/image/tumb/area.PNG";
//}
//alert(imgpath);
//$("#eimg").attr("src",imgpath);
                }
            });
        });
        $(document).on("click", ".chartedit", function () 
        {
            var passedID = $(this).data('id'); 
            var url = "{{ url('/admin/editgraph') }}";
            var docurl = url + "/" + passedID;
            $.ajax({
                url : docurl,
                method : "GET",
                dataType: 'json',
                success:function(data)
                {
                    //alert(data);
                    $("#editgrapheid").val(data.graphid);
                    $("#typegraph").val(data.type);
                    $("#title").val(data.title);
					$("#edityaxis").val(data.yaxis);					
					$("#min").val(data.min);
                    $("#max").val(data.max);
                    $("#fake").val(data.fake);
                    $("#snameedit").val(data.sname);
                    $("#modaledit").val(data.modal);
                    $("#typenameedit").val(data.sensor_type);
					$("#sensorbrandedit").val(data.brand);					
					$("#sensorunitedit").val(data.sensorunit);
                    // Highcharts.chart('sensorgraphedit', 
                    // {
                        
                    //     chart: 
                    //     {                 
                    //         type: data.type,
                    //     },
                    //     title: 
                    //     {
                    //         text: data.title
                    //     },
                    //     tooltip: 
                    //     {
                    //         pointFormat: '{series.name}: <b>{point.percentage:.1f}</b>'
                    //     },
                    //     xAxis: 
                    //     {
                    //         categories: ['1/4/2020', '2/4/2020', '3/4/2020', '4/4/2020', '5/4/2020', '6/4/2020', '7/4/2020', '8/4/2020', '9/4/2020'],
                    //     },
                    //     yAxis: 
                    //     {
                    //         title: 
                    //         {
                    //             text: data.yaxis
                    //         },
                    //     },
                    //     plotOptions: 
                    //     {
                    //         pie: {
                    //             allowPointSelect: true,
                    //             cursor: 'pointer',
                    //             dataLabels: {
                    //                 enabled: true,
                    //                 format: '<b>{point.name}</b>: {point.percentage:.1f} '
                    //             }
                    //         }
                    //     },
                    //     series: [
                    //     {
                    //         name: 'Date',
                    //         color: '#6abd3f',
                    //         data: [{
                    //             name: '1/4/2020',
                    //             y: 61.41,
                    //         }, {
                    //             name: '2/4/2020',
                    //             y: 11.84
                    //         }, {
                    //             name: '3/4/2020',
                    //             y: 10.85
                    //         }, {
                    //             name: '4/4/2020',
                    //             y: 4.67
                    //         }, {
                    //             name: '5/4/2020',
                    //             y: 4.18
                    //         }, {
                    //             name: '6/4/2020',
                    //             y: 1.64
                    //         }, {
                    //             name: '7/4/2020',
                    //             y: 1.6
                    //         }, {
                    //             name: '8/4/2020',
                    //             y: 1.2
                    //         }, {
                    //             name: '9/4/2020',
                    //             y: 2.61
                    //         }]
                    //     }]
                    // });
                    var chartname = data.name;
                    if(chartname == 'datalable')
                    {
                        Highcharts.chart('datalable1', 
                        {
                            chart: {
                                type: 'line',
                                scrollablePlotArea: {
                                    minWidth: 600
                                }
                            },
                            title: {
                                text: data.title
                            },
                            subtitle: {
                                text: ''
                            },
                            xAxis: {
                                categories: ['1','2','3','4','5','6','7','8','9']
                            },
                            yAxis: {
                                title: {
                                    text: data.yaxis
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
                    if(chartname == 'hourly')
                    {
                        Highcharts.chart('hourly1', 
                        {
                            chart: {
                                zoomType: 'x'
                            },

                            title: {
                                text: data.title
                            },


                            tooltip: {
                                valueDecimals: 2
                            },

                            xAxis: {
                                type: ['1','2','3','4','5','6','7','8','9']
                            },

                            series: [{
                                data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6],
                                lineWidth: 0.5,
                                name: data.yaxis
                            }]
                        });
                    }
                    if(chartname == 'basicarea')
                    {
                        Highcharts.chart('basicarea1', 
                        {
                            chart: {
                                type: 'area'
                            },
                            title: {
                                text: data.title
                            },
                            xAxis: {
                                allowDecimals: false,
                                // labels: {
                                // 	formatter: function () {
                                // 		return this.value; // clean, unformatted number for year
                                // 	}
                                // },
                            },
                            yAxis: {
                                title: {
                                    text: data.yaxis
                                },
                                // labels: {
                                // 	formatter: function () {
                                // 		return this.value / 1000 + 'k';
                                // 	}
                                // }
                            },
                            tooltip: {
                                pointFormat: 'Value <b>{point.y:,.0f}</b>'
                            },
                            plotOptions: {
                                area: {
                                    pointStart: 1,
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
                    if(chartname == 'negativevalues')
                    {
                        Highcharts.chart('negativevalues1', 
                        {
                            chart: {
                                type: 'area'
                            },
                            title: {
                                text: data.title
                            },
                            xAxis: {
                                categories: ['1','2','3','4','5','6','7','8','9']
                            },
                            credits: {
                                enabled: false
                            },
                            series: [{
                                name: 'Sensor',
                                data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
                            }]
                        });
                    }
                    if(chartname == 'invertedaxes')
                    {
                        Highcharts.chart('invertedaxes1', 
                        {
                            chart: {
                                type: 'area',
                                inverted: true
                            },
                            title: {
                                text: data.title
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
                                categories: ['1','2','3','4','5','6','7','8','9']
                            },
                            yAxis: {
                                title: {
                                    text: data.yaxis
                                },
                                allowDecimals: false,
                                min: -1000
                            },
                            plotOptions: {
                                area: {
                                    fillOpacity: 0.5
                                }
                            },
                            series: [{
                                name: 'Sensors',
                                data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
                            }]
                        });
                    }
                    if(chartname == 'areaspline')
                    {
                        Highcharts.chart('areaspline1', 
                        {
                            chart: {
                                type: 'areaspline'
                            },
                            title: {
                                text: data.title
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
                                categories: ['1','2','3','4','5','6','7','8','9'],
                            },
                            yAxis: {
                                title: {
                                    text: data.yaxis
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
                                name: 'Sensors',
                                data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
                            }]
                        });
                    }
                    if(chartname == 'arearangeline')
                    {
                        Highcharts.chart('arearangeline1', 
                        {
                            chart: {
                                scrollablePlotArea: {
                                    minWidth: 600
                                }
                            },
                            title: {
                                text: data.title
                            },

                            xAxis: {
                                type: ['1','2','3','4','5','6','7','8','9'],
                            },

                            yAxis: {
                                title: {
                                    text: data.yaxis
                                }
                            },

                            tooltip: {
                                crosshairs: true,
                                shared: true,
                                valueSuffix: 'Â°C'
                            },

                            series: [{
                                name: 'Sensors',
                                data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6],
                                zIndex: 1,
                                marker: {
                                    fillColor: 'white',
                                    lineWidth: 2,
                                    lineColor: Highcharts.getOptions().colors[0]
                                }
                            }]
                        });
                    }
                    if(chartname == 'basicbar')
                    {
                        Highcharts.chart('basicbar1', 
                        {
                            chart: {
                                type: 'bar'
                            },
                            title: {
                                text: data.title
                            },
                            xAxis: {
                                categories: ['1','2','3','4','5','6','7','8','9'],
                                title: {
                                    text: ''
                                }
                            },
                            yAxis: {
                                min: -1000,
                                title: {
                                    text: data.yaxis,
                                    align: 'high'
                                },
                                labels: {
                                    overflow: 'justify'
                                }
                            },
                            tooltip: {
                                valueSuffix: ''
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
                                name: 'Sensors',
                                data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
                            }]
                        });
                    }
                    if(chartname == 'stackedbar')
                    {
                        Highcharts.chart('stackedbar1', 
                        {
                            chart: {
                                type: 'bar'
                            },
                            title: {
                                text: data.title
                            },
                            xAxis: {
                                categories: ['1','2','3','4','5','6','7','8','9']
                            },
                            yAxis: {
                                min: -1000,
                                title: {
                                    text: data.yaxis
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
                                name: 'Sensors',
                                data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
                            }]
                        });
                    }
                    if(chartname == 'basiccolumn')
                    {
                        Highcharts.chart('basiccolumn1', 
                        {
                            chart: {
                                type: 'column'
                            },
                            title: {
                                text: data.title
                            },
                            xAxis: {
                                categories: ['1','2','3','4','5','6','7','8','9'],
                                crosshair: true
                            },
                            yAxis: {
                                min: -1000,
                                title: {
                                    text: data.yaxis
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
                                name: 'Sensors',
                                data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
                            }]
                        });
                    }
                }
            });
        });
        function deletedoc()
        {
            if(!confirm("Do you really want to do this?")) 
            {
                return false;
            }
            var selected = new Array();
            $("#checkarray:checked").each(function () 
            {
                selected.push(this.value);
            });
            var sensorid = selected.join(",");
            var url = "{{url('/admin/deleteSensors')}}";
            var docurl = url + "/" + sensorid;
            $.ajax({
                url : docurl,
                method : "GET",
                success:function(response)
                {
                    alert(response);
                    location.reload();
                }
            });	
        }
        function exportsensor()
        {
            var selected = new Array();
            $("#checkarray:checked").each(function () 
            {
                selected.push(this.value);
            });
            var sensorid = selected.join(",");
            var url = "{{url('/admin/exportsensor')}}";
            var docurl = url + "/" + sensorid;
            window.location.href = docurl;	
        }
        $(document).on("click", ".graphpop", function () 
        {
            var passedID = $(this).data('id'); 
            var type = $(this).data('type'); 
            $("#grapheid").val(passedID);
            var url = "{{ url('/admin/addgraph') }}";
            var docurl = url + "/" + passedID;
            $.ajax(
            {
                url : docurl,
                method : "GET",
                dataType: 'json',
                success:function(data)
                {
                    //alert(chartname);
                    $("#sname").val(data.sname);
                    $("#modal").val(data.modal);
                    $("#typename").val(data.sensor_type);
					$("#sensorbrand").val(data.brand);					
					$("#sensorunit").val(data.unit);
                    $("#maxadd").val(data.max);
                    $("#minadd").val(data.min);
                    var chartname = data.name;
                    $("#txt_name").keyup(function()
                    {
                        var txt_name = $(this).val();
                        $("#yaxis").keyup(function()
                        {       
                            var yaxisval = $(this).val();
                            if(chartname == 'datalable')
					        {
                                Highcharts.chart('datalable', 
                                {
                                    chart: {
                                        type: 'line',
                                        scrollablePlotArea: {
                                            minWidth: 600
                                        }
                                    },
                                    title: {
                                        text: txt_name
                                    },
                                    subtitle: {
                                        text: ''
                                    },
                                    xAxis: {
                                        categories: ['1','2','3','4','5','6','7','8','9']
                                    },
                                    yAxis: {
                                        title: {
                                            text: yaxisval
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
                            if(chartname == 'hourly')
                            {
                                Highcharts.chart('hourly', 
                                {
                                    chart: {
                                        zoomType: 'x'
                                    },

                                    title: {
                                        text: txt_name
                                    },


                                    tooltip: {
                                        valueDecimals: 2
                                    },

                                    xAxis: {
                                        type: ['1','2','3','4','5','6','7','8','9']
                                    },

                                    series: [{
                                        data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6],
                                        //lineWidth: 0.5,
                                        // name: yaxisval
                                    }]
                                });
                            }
                            if(chartname == 'basicarea')
                            {
                                Highcharts.chart('basicarea', 
                                {
                                    chart: {
                                        type: 'area'
                                    },
                                    title: {
                                        text: txt_name
                                    },
                                    xAxis: {
                                        allowDecimals: false,
                                        // labels: {
                                        // 	formatter: function () {
                                        // 		return this.value; // clean, unformatted number for year
                                        // 	}
                                        // },
                                    },
                                    yAxis: {
                                        title: {
                                            text: yaxisval
                                        },
                                        // labels: {
                                        // 	formatter: function () {
                                        // 		return this.value / 1000 + 'k';
                                        // 	}
                                        // }
                                    },
                                    tooltip: {
                                        pointFormat: 'Value <b>{point.y:,.0f}</b>'
                                    },
                                    plotOptions: {
                                        area: {
                                            pointStart: 1,
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
                            if(chartname == 'negativevalues')
                            {
                                Highcharts.chart('negativevalues', 
                                {
                                    chart: {
                                        type: 'area'
                                    },
                                    title: {
                                        text: txt_name
                                    },
                                    xAxis: {
                                        categories: ['1','2','3','4','5','6','7','8','9']
                                    },
                                    credits: {
                                        enabled: false
                                    },
                                    series: [{
                                        name: 'Sensor',
                                        data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
                                    }]
                                });
                            }
                            if(chartname == 'invertedaxes')
                            {
                                Highcharts.chart('invertedaxes', 
                                {
                                    chart: {
                                        type: 'area',
                                        inverted: true
                                    },
                                    title: {
                                        text: txt_name
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
                                        categories: ['1','2','3','4','5','6','7','8','9']
                                    },
                                    yAxis: {
                                        title: {
                                            text: yaxisval
                                        },
                                        allowDecimals: false,
                                        min: -1000
                                    },
                                    plotOptions: {
                                        area: {
                                            fillOpacity: 0.5
                                        }
                                    },
                                    series: [{
                                        name: 'Sensors',
                                        data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
                                    }]
                                });
                            }
                            if(chartname == 'areaspline')
                            {
                                Highcharts.chart('areaspline', 
                                {
                                    chart: {
                                        type: 'areaspline'
                                    },
                                    title: {
                                        text: txt_name
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
                                        categories: ['1','2','3','4','5','6','7','8','9'],
                                    },
                                    yAxis: {
                                        title: {
                                            text: yaxisval
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
                                        name: 'Sensors',
                                        data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
                                    }]
                                });
                            }
                            if(chartname == 'arearangeline')
                            {
                                Highcharts.chart('arearangeline', 
                                {
                                    chart: {
                                        scrollablePlotArea: {
                                            minWidth: 600
                                        }
                                    },
                                    title: {
                                        text: txt_name
                                    },

                                    xAxis: {
                                        type: ['1','2','3','4','5','6','7','8','9'],
                                    },

                                    yAxis: {
                                        title: {
                                            text: yaxisval
                                        }
                                    },

                                    tooltip: {
                                        crosshairs: true,
                                        shared: true,
                                        valueSuffix: 'Â°C'
                                    },

                                    series: [{
                                        name: 'Sensors',
                                        data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6],
                                        zIndex: 1,
                                        marker: {
                                            fillColor: 'white',
                                            lineWidth: 2,
                                            lineColor: Highcharts.getOptions().colors[0]
                                        }
                                    }]
                                });
                            }
                            if(chartname == 'basicbar')
                            {
                                Highcharts.chart('basicbar', 
                                {
                                    chart: {
                                        type: 'bar'
                                    },
                                    title: {
                                        text: txt_name
                                    },
                                    xAxis: {
                                        categories: ['1','2','3','4','5','6','7','8','9'],
                                        title: {
                                            text: yaxisval
                                        }
                                    },
                                    yAxis: {
                                        min: -1000,
                                        title: {
                                            text: yaxisval,
                                            align: 'high'
                                        },
                                        labels: {
                                            overflow: 'justify'
                                        }
                                    },
                                    tooltip: {
                                        valueSuffix: ''
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
                                        name: 'Sensors',
                                        data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
                                    }]
                                });
                            }
                            if(chartname == 'stackedbar')
                            {
                                Highcharts.chart('stackedbar', 
                                {
                                    chart: {
                                        type: 'bar'
                                    },
                                    title: {
                                        text: txt_name
                                    },
                                    xAxis: {
                                        categories: ['1','2','3','4','5','6','7','8','9']
                                    },
                                    yAxis: {
                                        min: -1000,
                                        title: {
                                            text: yaxisval
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
                                        name: 'Sensors',
                                        data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
                                    }]
                                });
                            }
                            if(chartname == 'basiccolumn')
                            {
                                Highcharts.chart('basiccolumn', 
                                {
                                    chart: {
                                        type: 'column'
                                    },
                                    title: {
                                        text: txt_name
                                    },
                                    xAxis: {
                                        categories: ['1','2','3','4','5','6','7','8','9'],
                                        crosshair: true
                                    },
                                    yAxis: {
                                        min: -1000,
                                        title: {
                                            text: yaxisval
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
                                        name: 'Sensors',
                                        data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
                                    }]
                                });
                            }
                        });
					});
                }
            });
        });
        /* sensor graph */
        // $('#my_select').on('change', function () 
        // {
        //     var selectData = $(this).val();
        //     if(selectData == 'line')
        //     {
        //         var typegraph = 'line';
        //     }
        //     if(selectData == 'area')
        //     {
        //         var typegraph = 'area';
        //     }
        //     if(selectData == 'column')
        //     {
        //         var typegraph = 'column';
        //     }
        //     if(selectData == 'bar')
        //     {
        //         var typegraph = 'bar';
        //     }
        //     if(selectData == 'pie') 
        //     {
        //         var typegraph = 'pie';
        //     }
        //     if(selectData == 'scatter') 
        //     {
        //         var typegraph = 'scatter';
        //     }
        //     if(selectData == 'spline') 
        //     {
        //         var typegraph = 'spline';
        //     }
        //     $("#txt_name").keyup(function()
        //     {
        //         var txt_name = $(this).val();
        //         $("#yaxis").keyup(function()
        //         {
        //             var yaxisval = $(this).val();         
        //             Highcharts.chart('sensorgraph', 
        //             {
        //                 chart: 
        //                 {                 
        //                     type: typegraph,
        //                 },
        //                 title: 
        //                 {
        //                     text: txt_name
        //                 },
        //                 tooltip: 
        //                 {
        //                     pointFormat: '{series.name}: <b>{point.percentage:.1f}</b>'
        //                 },
        //                 xAxis: 
        //                 {
        //                     categories: ['1/4/2020', '2/4/2020', '3/4/2020', '4/4/2020', '5/4/2020', '6/4/2020', '7/4/2020', '8/4/2020', '9/4/2020'],
        //                 },
        //                 yAxis: 
        //                 {
        //                     title: 
        //                     {
        //                         text: yaxisval
        //                     },
        //                 },
        //                 plotOptions: 
        //                 {
        //                     pie: {
        //                         allowPointSelect: true,
        //                         cursor: 'pointer',
        //                         dataLabels: {
        //                             enabled: true,
        //                             format: '<b>{point.name}</b>: {point.percentage:.1f} '
        //                         }
        //                     }
        //                 },
        //                 series: [
        //                 {
        //                     name: 'Date',
        //                     color: '#6abd3f',
        //                     data: [{
        //                         name: '1/4/2020',
        //                         y: 61.41,
        //                     }, {
        //                         name: '2/4/2020',
        //                         y: 11.84
        //                     }, {
        //                         name: '3/4/2020',
        //                         y: 10.85
        //                     }, {
        //                         name: '4/4/2020',
        //                         y: 4.67
        //                     }, {
        //                         name: '5/4/2020',
        //                         y: 4.18
        //                     }, {
        //                         name: '6/4/2020',
        //                         y: 1.64
        //                     }, {
        //                         name: '7/4/2020',
        //                         y: 1.6
        //                     }, {
        //                         name: '8/4/2020',
        //                         y: 1.2
        //                     }, {
        //                         name: '9/4/2020',
        //                         y: 2.61
        //                     }]
        //                 }]
        //             });
        //         });
        //     });
        // });
        $('#typegraph').on('change', function () 
        {
            var selectData = $(this).val();
            if(selectData == 'line')
            {
                var typegraph = 'line';
            }
            if(selectData == 'area')
            {
                var typegraph = 'area';
            }
            if(selectData == 'column')
            {
                var typegraph = 'column';
            }
            if(selectData == 'bar')
            {
                var typegraph = 'bar';
            }
            if(selectData == 'pie') 
            {
                var typegraph = 'pie';
            }
            if(selectData == 'scatter') 
            {
                var typegraph = 'scatter';
            }
            if(selectData == 'spline') 
            {
                var typegraph = 'spline';
            }
            var title = $('#title').val();
            var edityaxis = $('#edityaxis').val();
            Highcharts.chart('sensorgraphupdate', 
            {
                chart: 
                {                 
                    type: typegraph,
                },
                title: 
                {
                    text: title
                },
                tooltip: 
                {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}</b>'
                },
                xAxis: 
                {
                    categories: ['1/4/2020', '2/4/2020', '3/4/2020', '4/4/2020', '5/4/2020', '6/4/2020', '7/4/2020', '8/4/2020', '9/4/2020'],
                },
                yAxis: 
                {
                    title: 
                    {
                        text: edityaxis
                    },
                },
                plotOptions: 
                {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} '
                        }
                    }
                },
                series: [
                {
                    name: 'Date',
                    color: '#6abd3f',
                    data: [{
                        name: '1/4/2020',
                        y: 61.41,
                    }, {
                        name: '2/4/2020',
                        y: 11.84
                    }, {
                        name: '3/4/2020',
                        y: 10.85
                    }, {
                        name: '4/4/2020',
                        y: 4.67
                    }, {
                        name: '5/4/2020',
                        y: 4.18
                    }, {
                        name: '6/4/2020',
                        y: 1.64
                    }, {
                        name: '7/4/2020',
                        y: 1.6
                    }, {
                        name: '8/4/2020',
                        y: 1.2
                    }, {
                        name: '9/4/2020',
                        y: 2.61
                    }]
                }]
            });
        });
        /* sensor graph */
        $('#createsensorgraph').on('submit', function(event)
        {
            event.preventDefault();					
            $.ajax(
            {
                url:"{{  url('/admin/createsensorgraph') }}",
                method:"POST",
                data:new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                //dataType: 'json',
                success:function(data)
                {    
                    alert('Success'); 
                    location.reload();
                }
            });
        });
        $(".btnupdate").hide();	
        $(".btnenable").click(function() 
        {
            $(".disname").removeAttr("disabled");
            $(".btnupdate").show(); 
            $(".btnenable").hide();
            $("#sensorgraphupdate").show();
            $("#sensorgraphedit").hide();
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
                    $("#remark").val(data.remark);
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
        $(document).on("click", ".sensoreditpop", function () 
        {
            var selected = new Array();
            $("#checkarray:checked").each(function () 
            {
                selected.push(this.value);
            });
            var sensorid = selected[0];
           // alert(groupid);
            $("#sensoreditpopid").val(sensorid);
        });
        $('#addform').on('submit', function(event)
        {
            event.preventDefault();
            $.ajax(
            {      
                url:"{{  url('/admin/insertsensorpop') }}",
                method:"POST",
                data:new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json',
                success: function(data)
                {
                    alert('Type Added');
                    $('#add').modal('hide');
                    $('.sensortype').empty();
                    var i=0;
                    $.each(data, function(key, value) 
                    {		
                        $('.sensortype').append('<option value="'+ data[i].id +'">'+ data[i].sname + '-' + data[i].modal + '-' + data[i].brand + '</option>');
                        i++;
                    });
                }
            });			
        });
        // $('#country_name').keyup(function()
        // { 
        //     var query = $(this).val();
        //     if(query != '')
        //     {
        //         var _token = "{{ csrf_token() }}";
        //         //alert(_token);
        //         $.ajax(
        //         {
        //             url:"{{ url('/admin/autocomplete/fetch') }}",
        //             method:"POST",
        //             data:{query:query, _token:_token},
        //             success:function(data)
        //             {
        //                 //alert(data);
        //                 $('#countryList').fadeIn();  
        //                 $('#countryList').html(data);
        //             }
        //         });
        //     }
        //     else
        //     {
        //         $('#countryList').fadeOut();  
        //     }
        // });
        // $(document).on('click', 'li', function()
        // {  
        //     $('#country_name').val($(this).text());  
        //     $('#countryList').fadeOut();  
        //     var selectData = encodeURIComponent($(this).text());
        //     var url = "{{ url('/admin/sensordata') }}";
        //     var docurl = url + "/" + selectData;
        //     $.ajax(
        //     {
        //         url : docurl,
        //         method : "GET",
        //         dataType: 'json',
        //         success:function(data)
        //         {
        //             //alert(data);
        //             $("#typedata").val(data.sensor_type);
        //             $("#unitdata").val(data.unit);
        //             $("#valuedata").val(data.value);
        //         }
        //     });
        // });  
        $('#country_name').on('change', function () 
        {
            var selectData = encodeURIComponent($('#country_name').val());
            //alert(selectData);
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
        // $('#sensor_id').keyup(function()
        // { 
        //     var query = $(this).val();
        //     if(query != '')
        //     {
        //         var _token = "{{ csrf_token() }}";
        //         //alert(_token);
        //         $.ajax(
        //         {
        //             url:"{{ url('/admin/autocomplete/fetch') }}",
        //             method:"POST",
        //             data:{query:query, _token:_token},
        //             success:function(data)
        //             {
        //                 $('#countryListedit').fadeIn();  
        //                 $('#countryListedit').html(data);
        //             }
        //         });
        //     }
        //     else
        //     {
        //         $('#countryListedit').fadeOut();  
        //     }
        // });
        $('#sensor_id').on('change', function () 
        {  
            var selectData = encodeURIComponent($('#sensor_id').val());
            //var url = "{{ url('/admin/sensordata') }}";
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
@parent
@endsection