@extends('layouts.admin')
@section('content')
    <div id="myDiv">
        <!-- <div class="loader" style="display:none"></div> -->
		<div id="loading-image" style="display:none;"></div>
        <!--<img id="loading-image" src="{{ url('/loader/1.gif') }}" style="display:none; background: none repeat scroll 0 0 black; position: fixed; opacity: 0.5; z-index: 1000001; top: 200px; left: 600px;"/>-->
    </div>
    <div class="p-3">
        <div class="row">
            <div class="col-md-12 euz_bar euz_b">
                <!--<a href="{{ url('/admin/agents') }}"><i class="fas fa-user euz_text_blue"></i> <?php echo $user[0]->fname; ?></a> / <span class="euz_ac_bl">Gateway Group</span>-->
				 
				<div class="w-50 float-left">
					<ul class="m-0 p-0">
						<li class="nav-item dropdown" style="list-style:none;">
						<a class="float-left euz_text_blue mr-2" href="{{ url('/admin/agents') }}"><i class="fas fa-user euz_text_blue"></i> <?php echo $user[0]->fname; ?> / </a>
						<a class="nav-link dropdown-toggle p-0 euz_text_blue float-left" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						 Gateway Group
						</a>
						<ul class="dropdown-menu py-0">
                            <?php 
                                foreach($groups as $group) 
                                { 
                                    $hubs = DB::table('sensor_hubs')
                                    ->join('users', 'sensor_hubs.agent', '=', 'users.id')
                                    ->join('role_user', 'role_user.user_id', '=', 'users.id')
                                    ->join('sensor_groups', 'sensor_groups.id', '=', 'sensor_hubs.sensor_group_id')
                                    ->join('gateway_groups', 'gateway_groups.id', '=', 'sensor_hubs.group_id')
                                    ->where('role_user.role_id', 2)
                                    ->where('users.status', 1)
                                    ->where('sensor_hubs.agent', $group->agent)
                                    ->where('sensor_hubs.group_id', $group->id)
                                    ->select('sensor_hubs.*', 'sensor_hubs.sensor_hub_id','users.fname','sensor_groups.name as groupname')
                                    ->orderBy('added_on', 'DESC')
                                    ->get();
                            ?>
                            <?php if(count($hubs) == '0') { ?>
                            <li><a class="dropdown-item" href="{{ url('/admin/sensorhubs/'.$group->agent.'/'.$group->id) }}"><?php echo $group->name; ?></a></li>
                            <?php } else { ?>
                            <li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="{{ url('/admin/sensorhubs/'.$group->agent.'/'.$group->id) }}"><?php echo $group->name; ?></a>
                            <?php } ?>
                                <ul class="dropdown-menu py-0">
                                    <?php foreach($hubs as $hub) { ?>
                                    <li><a class="dropdown-item" href="{{ url('/admin/sensors/'.$group->agent.'/'.$group->id.'/'.$hub->id) }}"><?php echo $hub->hub_id; ?></a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <?php } ?>
                        </ul>
					</li>
					</ul>
				</div>
				<a href="{{ url('/excel/hub.xlsx') }}" class="float-right euz_a_icon ml-3 euz_ied"><i class="fas fa-file-download euz_a_icon"></i> Sensor Hub Import Sheet</a>
				<span class="float-right euz_b euz_text_blue ml-3 euz_ied">|</span>
                <a href="{{ url('/excel/group.xlsx') }}" class="float-right euz_a_icon ml-3"><i class="fas fa-file-download euz_a_icon"></i> Gateway Group Import Sheet</a>
				
            </div>
            @if(Session::has('flash_message'))
            <div class="alert alert-success w-100"><button type="button" class="close" data-dismiss="alert">&times;</button>{{ Session::get('flash_message') }}</div>
            @endif
            <div class="col-md-12 euz_border p-3 bg-white">
                <div class="row">
                    <div class="col-md-12 my-2">
                        <a class="btn euz_btn_add float-right euz_pointer" href="<?php echo url('/admin/agents'); ?>"><i class="far fa-arrow-alt-circle-left"></i> Back To Agent</a>
                        <!--<a class="btn btn-success float-right rounded-0 ml-2" href="#" href="" data-toggle="modal" data-target="#groupimport"><i class="fas fa-file-upload"></i> Import</a>-->
                    </div>
                    <?php foreach($groups as $group) {

$hubs = DB::table('sensor_hubs')
                                    ->join('users', 'sensor_hubs.agent', '=', 'users.id')
                                    ->join('role_user', 'role_user.user_id', '=', 'users.id')
                                    ->join('sensor_groups', 'sensor_groups.id', '=', 'sensor_hubs.sensor_group_id')
                                    ->join('gateway_groups', 'gateway_groups.id', '=', 'sensor_hubs.group_id')
                                    ->where('role_user.role_id', 2)
                                    ->where('users.status', 1)
                                    ->where('sensor_hubs.agent', $group->agent)
                                    ->where('sensor_hubs.group_id', $group->id)
                                    ->select('sensor_hubs.*', 'sensor_hubs.sensor_hub_id','users.fname','sensor_groups.name as groupname')
                                    ->orderBy('added_on', 'DESC')
                                    ->get();


$sensorcnt = DB::table('sensors')
                                            ->join('sensor_hubs', 'sensor_hubs.id', '=', 'sensors.hub_id')
                                            ->join('users', 'sensor_hubs.agent', '=', 'users.id')
                                            ->join('role_user', 'role_user.user_id', '=', 'users.id')
                                            ->where('role_user.role_id', 2)
                                            ->where('users.status', 1)
                                            ->where('sensor_hubs.agent', $group->agent)->where('sensor_hubs.group_id', $group->id)
                                            ->get();





                     ?>
                    <div class="col-md-4 mt-2">
                        <div class="card">
                            <div class="card-header">
                                <div class="custom-checkbox">
                                    <label class="euz_check_box euz_b"><?php echo $group->name; ?>
                                        <input type="checkbox" id="checkarray" value="<?php echo $group->id;?>" class="euz_check_agent" name="checkarray[]" >
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="card-body pb-0 euz_b px-2">
                                <p class="mb-2"><label style="min-width: 115px;">Sim card / Ref:Id </label>: <?php echo $group->sim_no; ?></p>
                                <p class="mb-2"><label style="min-width: 115px;">Longitude </label>: <?php echo $group->longitude; ?><br> <label style="min-width: 115px;">Latitude </label>: <?php echo $group->latitude; ?></p>
                            </div> 
							
							<div class="card-footer bg-white euz_card_fo py-0">
								<label style="font-size:14px;width: 50%;color: #666;" class="m-0 euz_tree_in p-1">Hub/s : <?php echo count($hubs); ?></label><label style="font-size:14px;width: 50%;color: #666;" class="m-0 euz_tree_in p-1">Sensor/s : <?php echo count($sensorcnt); ?></label>
							</div>
                            
                            <div class="card-footer text-right bg-white euz_card_fo">
                                <a href="#" class="ml-2" data-toggle="tooltip" data-placement="top" title="Gateway Info" onclick="profileopen(<?php echo $group->id;?>)"><i class="fas fa-eye euz_a_icon"></i></a>
                                
                                <a href="#" class="ml-2 modalLink"  data-id="{{ $group->id }}" title="Edit" data-toggle="modal" data-target="#groupedit"><i class="fas fa-edit euz_a_icon"></i></a>
                                <a href="<?php echo url('/admin/deleteGatewaygroup/'.$group->id); ?>" title="Delete" class="ml-2" onclick="return confirm('Are you sure do you want to delete?')"><i class="fas fa-trash-alt euz_a_icon"></i></a>
								
                                <a href="<?php echo url('/admin/sensorhubs/'.$group->agent.'/'.$group->id); ?>" class="senhub ml-2 euz_tree_in" data-toggle="tooltip" data-placement="top" title="Sensor Hub"><i class="fab fa-hubspot"></i></a><a href="javascript:void(0)" class="euz_tree_in" data-toggle="tooltip" data-placement="top" title="Visual Hierarchy" onclick="profileopentree(<?php echo $group->id;?>)"><i class="fas fa-sitemap"></i></a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>			
        </div>
    </div>
    <!---Add import group---->
    <div class="modal fade" id="groupimport">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable euz_w_90">
            <div class="modal-content" style="width: 40%;">
                <div class="modal-header euz_carb p-0">
                    <h5 class="modal-title p-2 text-white">Import Gateway Group</h5>
                </div>
                <form method="post" enctype="multipart/form-data" action="{{ url('/admin/import_excel/importgroup') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="agent" value="<?php echo $user[0]->id; ?>" /> 
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
    <!--End import group--->
    <!---Add hub multi import---->
    <div class="modal fade" id="hubmulimport">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable euz_w_90">
            <div class="modal-content" style="width: 40%;">
                <div class="modal-header euz_carb p-0">
                    <h5 class="modal-title p-2 text-white">Import New Sensor Hub</h5>
                </div>
                <form method="post" enctype="multipart/form-data" action="{{ url('/admin/import_excel/importmulhub') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="agent" value="<?php echo $user[0]->id; ?>" /> 
                    <input type="hidden" name="group_id" id="groupidimport" value="" />
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12">
                                <label class="euz_b" for="">Upload File (Excel file only)</label>
                                <input type="file" class="form-control disname" id="" required name="select_file" accept=".xlsx, .xls" />
                            </div>					
                        </div>
                    </div>
                    <div class="modal-footer">
						<a href="{{ url('/excel/hub.xlsx') }}" class="float-right euz_a_icon pr-5 mr-5 euz_ied"><i class="fas fa-file-download euz_a_icon"></i> Sensor Hub Import Sheet</a>
                        <button type="submit" class="btn btn-success rounded-0 euz_bt" name="upload"><i class="fas fa-angle-double-up"></i> Upload</button>
                        <button type="button" class="btn btn-danger rounded-0 euz_bt" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End Addhub multi import--->
    <!---profile---->
    <div id="agentprofile" class="euz_agent_profile" style="overflow-x: auto;"></div>
    <div id="agentprofiletree" class="euz_agent_profile" style="overflow-x: auto;"></div>
    <!---End Profile---->
    <a href="#" class="btn euz_float_grexport euz_ied hubmulimport" title="SensorHub Import" data-toggle="modal" data-target="#hubmulimport"><i class="fab fa-hubspot"></i></a>
    <a href="javascript:void(0)" class="btn euz_float_export euz_ied" title="Export" onclick="exportgroup()"><i class="fas fa-file-download"></i></a>
    <a href="javascript:void(0)" class="btn euz_float_import groupeditpop" title="Group Edit" data-toggle="modal" data-target="#groupeditpop"><i class="fas fa-file-upload"></i></a>
    <a href="javascript:void(0)" class="btn btn-danger euz_float_trash euz_ied" onclick="deletedoc()"><i class="fas fa-trash-alt"></i></a>
    <a href="javascript:void(0)" class="btn euz_float_add" data-toggle="modal" data-target="#groupadd" data-backdrop="static"><i class="fas fa-plus"></i></a>
    <!---Add GatewayGroup---->
    <div class="modal fade" id="groupadd">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable euz_w_90">
            <div class="modal-content">
                <div class="modal-header euz_carb p-0">
                    <h5 class="modal-title p-2 text-white">Add New Gateway Group</h5>
                </div>
                <form action="{{ url('/admin/insertgatewaygroup') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modal-body">          
                        <div class="row">
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="euz_b" for="">Agent</label>
                                <input type="text" class="form-control disname" id="" value="<?php echo $user[0]->fname.' '.$user[0]->lname; ?>" disabled="disabled" name="" />
                                <input type="hidden" name="agent" value="<?php echo $user[0]->id; ?>" />
                            </div>
                            <?php   
                                $cus_id = DB::table('gateway_groups')->orderBy('id', 'desc')->first();							
                                if(empty($cus_id->group_id)) 
                                {
                                    $cusid = 'GW0001';
                                }
                                else
                                {
                                    $cusid = $cus_id->group_id++;				
                                    $cusid = substr($cusid, 3, 5);
                                    $cusid = (int) $cusid + 1;
                                    $cusid = "GW" . sprintf('%04s', $cusid);
                                }
                            ?>
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="euz_b" for="">Gateway Group ID</label>
                                <input type="text" class="form-control disname" id="" value="<?php echo $cusid; ?>" readonly="readonly" name="group" />
                            </div>
                            
                            <div class="form-group col-lg-3 col-md-4">    
                                <label class="euz_b" for="">Gateway Group Name</label>
                                <div class="input-group">
                                    <select class="form-control select1" id="" name="sensor_group_id">
                                        <option value="">-Select Group Name-</option>
                                        @foreach($groupnames as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-prepend">
                                        <a class="btn btn-primary" style="height: 33px;" data-toggle="modal" data-backdrop="static" data-target="#add"><i class="fas fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="euz_b" for="">Sim card / Ref:Id</label>
                                <input type="text" class="form-control disname" id="" value="" name="sim_no" required />
                            </div>
                            
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="euz_b" for="">Router Sensor Number</label>
                                <input type="text" class="form-control disname" id="" value="" name="router_sensor_no" required />
                            </div>
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="euz_b" for="">Longitude</label>
                                <input type="text" class="form-control disname" id="" value="" name="longitude" />
                            </div>
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="euz_b" for="">Latitude</label>
                                <input type="text" class="form-control disname" id="" value="" name="latitude" />
                            </div>
                            
                            <div class="form-group col-lg-12 col-md-4">
                                <label class="euz_b" for="">Gateway Group Information</label>
                                <textarea type="text" class="form-control disname" id="" value="" rows="5" name="sensor_information" ></textarea>
                            </div>
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success rounded-0 euz_bt" ><i class="far fa-save"></i> Save</button>
                        <button type="button" class="btn btn-danger rounded-0 euz_bt" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End AddGatewayGroup--->
    <!---Edit GatewayGroup---->
    <div class="modal fade" id="groupedit">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable euz_w_90">
            <div class="modal-content">
                <div class="modal-header euz_carb p-0">
                    <h5 class="modal-title p-2 text-white">Edit GatewayGroup</h5>
                </div>
                <form action="{{ url('admin/updategatewaygroup') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="eid" value="" id="eid" />
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="euz_b" for="">Agent</label>
                                <input type="text" class="form-control disname" id="" value="<?php echo $user[0]->fname.' '.$user[0]->lname; ?>" disabled="disabled">
                                <input type="hidden" name="agent" value="<?php echo $user[0]->id; ?>" id="agent" />
                            </div>
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="euz_b" for="">Gateway Group ID</label>
                                <input type="text" class="form-control disname" id="groupidedit" value="" readonly name="group" />
                            </div>
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="euz_b" for="">Gateway Group Name</label>
                                <div class="input-group">
                                    <select class="form-control select1"  name="sensor_group_id" id="sensor_group_id">
                                        <option value="">-Select Group Name-</option>
                                        @foreach($groupnames as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-prepend">
                                        <a class="btn btn-primary" style="height: 33px;" data-toggle="modal" data-backdrop="static" data-target="#add"><i class="fas fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="euz_b" for="">Sim card / Ref:Id</label>
                                <input type="text" class="form-control disname" id="sim_no" value="" name="sim_no" />
                            </div>
                            
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="euz_b" for="">Router Sensor Number</label>
                                <input type="text" class="form-control disname" id="router_sensor_no" value="" name="router_sensor_no" />
                            </div>
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="euz_b" for="">Longitude</label>
                                <input type="text" class="form-control disname" id="longitude" value="" name="longitude" />
                            </div>
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="euz_b" for="">Latitude</label>
                                <input type="text" class="form-control disname" id="latitude" value="" name="latitude" />
                            </div>
                            
                            <div class="form-group col-lg-12 col-md-4">
                                <label class="euz_b" for="">Gateway Group Information</label>
                                <textarea type="text" class="form-control disname" id="sensor_information" rows="5" name="sensor_information"></textarea>
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
    <!--End EditGatewayGroup--->
    <!---Add Group edit import----> 
    <div class="modal fade" id="groupeditpop">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable euz_w_90">
            <div class="modal-content" style="width: 40%;">
                <div class="modal-header euz_carb p-0">
                    <h5 class="modal-title p-2 text-white">New/Update GatewayGroup</h5>
                    <button type="button" class="close" data-dismiss="modal">
                    <span>×</span>
                    </button>
                </div>
                <form method="post" enctype="multipart/form-data" action="{{ url('admin/import_excel/groupeditimport') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="agentid" id="" value="<?php echo $user[0]->id; ?>" />
                    <input type="hidden" name="groupeditpopid" id="groupeditpopid" value="" />
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
    <!--End Group edit import--->
    <!-- add groupname popup -->
    <div class="modal fade" id="add">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header euz_carb p-0">
                    <h5 class="modal-title p-2 text-white">Add New Gateway Group</h5>
                </div>
                <form method="post" id="addform">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="euz_b" for="">New Gateway Group</label>
                                <input type="text" class="form-control" id="" value="" name="name" required />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success rounded-0 euz_bt"><i class="far fa-save"></i> Save</button>
                        <button type="button" class="btn btn-danger rounded-0 euz_bt" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- add groupname popup -->
<script>
    $('#myModal').modal({
    backdrop: 'static',
    keyboard: false
})
</script>
    <!---end add-->
    
@endsection
@section('scripts')

<script>
$('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
  if (!$(this).next().hasClass('show')) {
    $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
  }
  var $subMenu = $(this).next(".dropdown-menu");
  $subMenu.toggleClass('show');


  $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
    $('.dropdown-submenu .show').removeClass("show");
  });


  return false;
});
</script>


    <script>
        function profileopen(groupid) 
        {
            var url = "{{ url('/admin/editGatewaygroup') }}";
            var docurl = url + "/" + groupid;
            $.ajax({
                url : docurl,
                method : "GET",
                success:function(response)
                {
                    $('#agentprofile').html(response);
                }
            });	
            document.getElementById("agentprofile").style.width = "80%";
        }	
        function profileclose() 
        {
            document.getElementById("agentprofile").style.width = "0";
        }
        function profileopentree(userid) 
        {
            var url = "{{ url('/admin/editGatewaygrouptree') }}";
            var docurl = url + "/" + userid;
            $.ajax({
                url : docurl,
                method : "GET",
                beforeSend: function() {
                    $("#loading-image").show();
                },
                success:function(response)
                {
                    $('#agentprofiletree').html(response);
                    $("#loading-image").hide();
                }
            });	
            document.getElementById("agentprofiletree").style.width = "80%";
        }	
        function profileclosetree() 
        {
            document.getElementById("agentprofiletree").style.width = "0";
        }
        $(".euz_ied").hide();
        $(function () {
            $(".euz_check_agent").click(function () 
            {
                var len = $("#checkarray:checked").length;
                if ($(this).is(":checked")) {
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
        $(document).on("click", ".modalLink", function () 
        {
            var passedID = $(this).data('id'); 
            var url = "{{ url('/admin/editgrouppop') }}";
            var docurl = url + "/" + passedID;
            $.ajax({
                url : docurl,
                method : "GET",
                dataType: 'json',
                success:function(data)
                {
                    //alert(data.group_id); 
                    $("#eid").val(data.id);
                    $("#agent").val(data.agent);
                    $("#groupidedit").val(data.group_id);
					$("#sensor_group_id").val(data.sensor_group_id);					
					$("#sim_no").val(data.sim_no);
					$("#router_sensor_no").val(data.router_sensor_no);
                    $("#longitude").val(data.longitude);
					$("#latitude").val(data.latitude);					
					$("#sensor_information").val(data.sensor_information);
                }
            });
        });
        function deletedoc()
        {
            //alert();
            if(!confirm("Are you sure do you want to delete?")) 
            {
                return false;
            }
            var selected = new Array();
            $("#checkarray:checked").each(function () 
            {
                selected.push(this.value);
            });
            var groupid = selected.join(",");
            //alert(groupid);
            var url = "{{ url('/admin/deleteGatewaygroups') }}";
            var docurl = url + "/" + groupid;
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
        $(document).on("click", ".hubmulimport", function () 
        {
            var selected = new Array();
            $("#checkarray:checked").each(function () {
                selected.push(this.value);
            });
            var groupid = selected.join(",");
            $("#groupidimport").val(groupid);
        });
        function exportgroup()
        {
            //alert();
            var selected = new Array();
            $("#checkarray:checked").each(function () 
            {
                selected.push(this.value);
            });
            var groupid = selected.join(",");
            var url = "{{url('/admin/exportgroup')}}";
            var docurl = url + "/" + groupid;
            window.location.href = docurl;	
        }
        $(document).on("click", ".groupeditpop", function () 
        {
            var selected = new Array();
            $("#checkarray:checked").each(function () 
            {
                selected.push(this.value);
            });
            var groupid = selected[0];
           // alert(groupid);
            $("#groupeditpopid").val(groupid);
        });
        $('#addform').on('submit', function(event)
        {
            event.preventDefault();
            $.ajax(
            {      
                url:"{{  url('/admin/insertgrouppop') }}",
                method:"POST",
                data:new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json',
                success: function(data)
                {
                    if(data.error != 'exists')
                    {
                        alert('Group Name Added');
                        $('#add').modal('hide');
                        $('.select1').empty();
                        var i=0;
                        $.each(data, function(key, value) 
                        {		
                            $('.select1').append('<option value="'+ data[i].id +'">'+ data[i].name +'</option>');
                            i++;
                        }); 
                    }  
                    else
                    {
                        alert('You entered Gateway Group Name is already in list');
                    }        
                }
            });			
        }); 



//         $('.senhub').click(function(event) {
// //alert("ls");
// $(".loader").show();
//         });
    </script>
@parent
@endsection
