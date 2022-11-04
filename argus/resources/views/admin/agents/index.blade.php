@extends('layouts.admin')
@section('content')
    <!---- euz_div ----->
    <?php error_reporting(0);?>
    <div id="myDiv">
		<div id="loading-image" style="display:none;"></div>
        <!--Displaying agents list-->
    </div>
    <div class="p-3">
        <div class="row">
            <div class="col-md-12 euz_bar">
                 <!--<small class="euz_b euz_text_blue">Agent</small>-->
				<div class="w-50 float-left">
					<ul class="m-0 p-0">
						<li class="nav-item dropdown" style="list-style:none;">
						<a class="nav-link dropdown-toggle p-0 euz_text_blue" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fas fa-user euz_text_blue"></i> Agent
						</a>
						<ul class="dropdown-menu py-0" aria-labelledby="navbarDropdownMenuLink">
                            <?php 
                                foreach($agents as $agent) 
                                { 
                                    $groups = DB::table('gateway_groups')
                                    ->join('users', 'gateway_groups.agent', '=', 'users.id')
                                    ->join('role_user', 'role_user.user_id', '=', 'users.id')
                                    ->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
                                    ->where('role_user.role_id', 2)
                                    ->where('gateway_groups.agent', $agent->id)
                                    ->where('users.status', 1)
                                    ->select('gateway_groups.*', 'gateway_groups.group_id','users.fname','sensor_groups.name')
                                    ->orderBy('added_on', 'DESC')
                                    ->get();
                                    //print_r($groups);
                            ?>
                            <?php if(count($groups) == '0') { ?>
                            <li><a class="dropdown-item" href="{{ url('/admin/groups/'.$agent->id) }}"><?php echo $agent->fname.' '.$agent->lname; ?></a></li>
                            <?php } else { ?>
                            <li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="{{ url('/admin/groups/'.$agent->id) }}"><?php echo $agent->fname.' '.$agent->lname; ?></a>
                            <?php } ?>
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
                                            ->where('sensor_hubs.agent', $agent->id)
                                            ->where('sensor_hubs.group_id', $group->id)
                                            ->select('sensor_hubs.*', 'sensor_hubs.sensor_hub_id','users.fname','sensor_groups.name as groupname')
                                            ->orderBy('added_on', 'DESC')
                                            ->get();
                                    ?>
                                    <?php if(count($hubs) == '0') { ?>
                                    <li><a class="dropdown-item" href="{{ url('/admin/sensorhubs/'.$agent->id.'/'.$group->id) }}"><?php echo $group->name; ?></a></li>
                                    <?php } else { ?>
                                    <li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="{{ url('/admin/sensorhubs/'.$agent->id.'/'.$group->id) }}"><?php echo $group->name; ?></a>
                                    <?php } ?>
                                        <ul class="dropdown-menu py-0">
                                            <?php foreach($hubs as $hub) { ?>
                                            <li><a class="dropdown-item" href="{{ url('/admin/sensors/'.$agent->id.'/'.$group->id.'/'.$hub->id) }}"><?php echo $hub->hub_id; ?></a></li>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <?php } ?>
						</ul>
					</li>
					</ul>
				</div>
				<a href="{{ url('/excel/group.xlsx') }}" class="float-right euz_a_icon ml-3 euz_ied"><i class="fas fa-file-download euz_a_icon"></i> GatewayGroup Import Sheet</a> 
				<span class="float-right euz_b euz_text_blue ml-3 euz_ied">|</span>
                <a href="{{ url('/excel/agent.xlsx') }}" class="float-right euz_a_icon"><i class="fas fa-file-download euz_a_icon"></i> Agent Import Sheet</a>
            </div>
            @if(Session::has('flash_message'))
            <div class="alert alert-success w-100"><button type="button" class="close" data-dismiss="alert">&times;</button>{{ Session::get('flash_message') }}</div>
            @endif
            <script>
                var msg = '{{Session::get('jsAlert')}}';
                var exist = '{{Session::has('jsAlert')}}';
                if(exist)
                {
                    alert(msg);
                }
            </script>
            <script>
                var msg = '{{Session::get('jsAlert1')}}';
                var exist = '{{Session::has('jsAlert1')}}';
                if(exist)
                {
                    alert(msg);
                }
            </script>
            <div class="col-md-12 euz_border p-3 bg-white">
                <div class="row">
                    <!--<div class="col-md-12 my-2">
                        <a class="btn btn-success float-right rounded-0 ml-2" href="" data-toggle="modal" data-target="#agentimport"><i class="fas fa-file-upload"></i> Import</a>
                    </div>--->
                    <?php foreach($agents as $agent) { ?>
                    <div class="col-md-4 mt-2">
                        <div class="card">
                            <div class="card-header">
                                <div class="custom-checkbox">
                                    <label class="euz_check_box euz_b"><?php echo $agent->fname.' '.$agent->lname;

//echo $agent->status;
                                     ?>
                                        <input type="checkbox" id="checkarray" class="euz_check_agent" name="checkarray[]" value="<?php echo $agent->id;?>" />
                                        <span class="checkmark"></span>
<?php if ($agent->status==1){?>
<i class="fas fa-circle float-right text-success"></i>

<?php } else{?>
<i class="fas fa-circle float-right text-danger"></i>

<?php }?>

                                        
                                    </label>
                                </div>
                            </div>
                            <div class="card-body pb-0">
                                <h6>Address : </h6>
                                <p><?php echo $agent->street.', '.$agent->city.', '.$agent->country; ?></p>
                            </div> 
                            <?php
                                $groupsag = DB::table('gateway_groups') 
                                    ->join('users', 'gateway_groups.agent', '=', 'users.id')
                                    ->join('role_user', 'role_user.user_id', '=', 'users.id')
                                    ->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
                                    ->where('role_user.role_id', 2)
                                    ->where('gateway_groups.agent', $agent->id)
                                   // ->where('users.status', 1)
                                    ->select('gateway_groups.*', 'gateway_groups.group_id','users.fname','sensor_groups.name')
                                    ->orderBy('added_on', 'DESC')
                                    ->get();
                                    //echo $agent->id;
                                $hubcnt = DB::table('sensor_hubs')
                                            ->join('gateway_groups', 'gateway_groups.id', '=', 'sensor_hubs.group_id')
                                            ->join('users', 'sensor_hubs.agent', '=', 'users.id')
                                            ->join('role_user', 'role_user.user_id', '=', 'users.id')
                                            ->where('role_user.role_id', 2)
                                            //->where('users.status', 1)
                                            ->where('gateway_groups.agent', $agent->id)
                                            ->where('sensor_hubs.agent', $agent->id)
                                            ->get(); 
                                $sensorcnt = DB::table('sensors')
                                            ->join('sensor_hubs', 'sensor_hubs.id', '=', 'sensors.hub_id')
                                            ->join('gateway_groups', 'gateway_groups.id', '=', 'sensor_hubs.group_id')
                                            ->join('users', 'sensor_hubs.agent', '=', 'users.id')
                                            ->join('role_user', 'role_user.user_id', '=', 'users.id')
                                            ->where('role_user.role_id', 2)
                                            //->where('users.status', 1)
                                            ->where('gateway_groups.agent', $agent->id)
                                            ->where('sensor_hubs.agent', $agent->id)
                                            ->get();
                            ?>
							<div class="card-footer bg-white euz_card_fo py-0">
								<label style="font-size:14px;width: 33%;color: #666;" class="m-0 euz_tree_in p-1">Group/s : <?php echo count($groupsag); ?></label><label style="font-size:14px;width: 33%;color: #666;" class="m-0 euz_tree_in p-1">Hub/s : <?php echo count($hubcnt); ?></label><label style="font-size:14px;width: 33%;color: #666;" class="m-0 euz_tree_in p-1">Sensor/s : <?php echo count($sensorcnt); ?></label>
							</div>
                            <div class="card-footer text-right bg-white euz_card_fo">
                                <a href="javascript:void(0)" class="ml-2" data-toggle="tooltip" data-placement="top" title="Profile" onclick="profileopen(<?php echo $agent->id;?>)"><i class="fas fa-portrait euz_a_icon"></i></a>
                                
                                <a href="<?php echo url('/admin/dashboard/'.$agent->id); ?>" class="ml-2" data-toggle="tooltip" data-placement="top" title="Agent Dashboard"><i class="fas fa-chart-pie euz_a_icon"></i></a>
                                <a href="javascript:void(0)" class="ml-2" title="Edit"  data-id="{{ $agent->id }}" data-toggle="modal" data-target="#agentedit{{ $agent->id }}"><i class="fas fa-edit euz_a_icon"></i></a>
                                <a href="<?php echo url('/admin/deleteAgent/'.$agent->id); ?>" class="ml-2" title="Delete" onclick="return confirm('Are you sure do you want to delete?')"><i class="fas fa-trash-alt euz_a_icon"></i></a>
                                <a href="<?php echo url('/admin/groups/'.$agent->id); ?>" class="ml-2 euz_tree_in" data-toggle="tooltip" data-placement="top" title="Gateway Group"><i class="fas fa-broadcast-tower"></i></a><a href="javascript:void(0)" class="euz_tree_in" data-toggle="tooltip" data-placement="top" title="Visual Hierarchy" onclick="profileopentree(<?php echo $agent->id;?>)"><i class="fas fa-sitemap"></i></a>
                            </div>
                        </div>
                    </div>
                    <!---Edit agent---->
                    <div class="modal fade" id="agentedit{{ $agent->id }}">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable euz_w_90">
                            <div class="modal-content">
                                <div class="modal-header euz_carb p-0">
                                    <h5 class="modal-title p-2 text-white">Edit Agent</h5>
                                </div>
                                <div class="modal-body"> 
                                    <form action="{{ url('admin/updateagent') }}" method="POST" enctype="multipart/form-data">
                                        {{ csrf_field() }}                          
                                        <input type="hidden" name="eid" value="<?php echo $agent->id; ?>" class="hiddenid" />
                                        <div class="row">
                                            <div class="form-group col-lg-3 col-md-4">
                                                <label class="euz_b" for="">Customer ID</label>
                                                <input type="text" class="form-control" id="customer_id" name="customer_id" required value="<?php echo $agent->customer_id; ?>" readonly />
                                            </div>
                                            <div class="form-group col-lg-3 col-md-4">
                                                <label class="euz_b" for="">First Name</label>
                                                <input type="text" class="form-control" id="fname" name="fname" required value="<?php echo $agent->fname; ?>" />
                                            </div>
                                            <div class="form-group col-lg-3 col-md-4">
                                                <label class="euz_b" for="">Last Name</label>
                                                <input type="text" class="form-control" id="lname" name="lname" required value="<?php echo $agent->lname; ?>" />
                                            </div>
                                            
                                            <div class="form-group col-lg-3 col-md-4">
                                                <label class="euz_b" for="">Organization</label>
                                                <input type="text" class="form-control" id="corporate_name" name="corporate_name" required value="<?php echo $agent->corporate_name; ?>" />
                                            </div>
                                            <div class="form-group col-lg-3 col-md-4">
                                                <label class="euz_b" for="">Street</label>
                                                <input type="text" class="form-control" id="street" name="street" required value="<?php echo $agent->street; ?>" />
                                            </div>
                                            <div class="form-group col-lg-3 col-md-4">
                                                <label class="euz_b" for="">City</label>
                                                <input type="text" class="form-control" id="city" name="city" required value="<?php echo $agent->city; ?>" />
                                            </div>
                                            
                                            <div class="form-group col-lg-3 col-md-4">
                                                <label class="euz_b" for="">State</label>
                                                <input type="text" class="form-control" id="state" name="state" required value="<?php echo $agent->state; ?>" />
                                            </div>
                                            <div class="form-group col-lg-3 col-md-4">
                                                <label class="euz_b" for="">Post Code</label>
                                                <input type="text" class="form-control" id="post_code" name="post_code" required value="<?php echo $agent->post_code; ?>" />
                                            </div>
                                            <div class="form-group col-lg-3 col-md-4">
                                                <label class="euz_b" for="">Country</label>
                                                <input type="text" class="form-control" id="country" name="country" required value="<?php echo $agent->country; ?>" />
                                            </div>
                                            <div class="form-group col-lg-3 col-md-4">
                                                <label class="euz_b" for="">Subscription Start Date</label>
                                                <input type="date" class="form-control" id="service_start"  name="service_start" required value="<?php echo date('Y-m-d', strtotime($agent->service_start)); ?>" />
                                            </div>
                                            <div class="form-group col-lg-3 col-md-4">
                                                <label class="euz_b" for="">Subscription End & Renew Date</label>
                                                <input type="date" class="form-control" id="service_expiry"  name="service_expiry" required value="<?php echo date('Y-m-d', strtotime($agent->service_expiry)); ?>" />
                                            </div>
                                            <div class="form-group col-lg-3 col-md-4">
                                                <label class="euz_b" for="">Login Email</label>
                                                <input type="email" class="form-control" id="email" name="email" required value="<?php echo $agent->email; ?>" />
                                            </div>
                                            <div class="form-group col-lg-3 col-md-4">
                                                <label class="euz_b" for="">Password</label>
                                                <input type="password" class="form-control" id="password" name="password" required value="<?php echo $agent->original; ?>" />
                                            </div>                          
                                            <div class="form-group col-lg-9 col-md-8">
                                                <label class="euz_b" for="">Remark</label>
                                                <input type="text" class="form-control" id="remark" name="remark" required value="<?php echo $agent->remark; ?>" />
                                            </div>
<div class="form-group col-lg-3 col-md-4 py-2 mb-0">
     <label for="" class="euz_b">Active</label><br>  <input type="radio" class="" name="status" value="1" id="edityes"  <?php if($agent->status == '1') { echo "checked"; } ?> /> Yes
                       
<input type="radio" class="" name="status" value="0" id="editno"  <?php if($agent->status == '0') { echo "checked"; } ?> />No
</div>

                                            <!--<div class="form-group col-lg-3 col-md-4 py-2 mb-0">-->
                                                <!--<label for="" class="euz_b">Active</label><br>-->
                                               <!-- <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" value="1" class="custom-control-input" id="edityes1" name="status1" --><?php //if($agent->status == '1') { echo "checked"; } ?> <!--/>-->
                                                    <!--<label class="custom-control-label euz_b" for="edityes1">Yess</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" value="0" class="custom-control-input" id="editno1" name="status1"--> <?php //if($agent->status == '0') { echo "checked"; } ?><!-- />
                                                    <!--<label class="custom-control-label euz_b" for="editno1">Noo</label>
                                                </div>
                                            </div>  -->                     
                                            <div class="form-group col-md-8 py-2 mb-0">
                                                <label for="" class="euz_b">Send Mail</label>
                                                <input type="checkbox" name="" value="Y" id="" class="addsend" />
                                                <span> (System will send profile modification message to the corresponding login email id)</span>
                                            </div>
                                            <div class="form-group col-md-12 addsendmailshow">
                                                <textarea class="form-control" rows="10" id="template" placeholder="Dear << firstname >>, ....." name="template">
                                                    <?php 
                                                        if(!empty($agent->email_template)) 
                                                        { 
                                                            echo $agent->email_template; 
                                                        } 
                                                        else 
                                                        { 
                                                            echo $settings[0]->agent_email; 
                                                        } 
                                                    ?> 
                                                </textarea>
                                            </div>            
                                        </div>
                                    
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success rounded-0 euz_bt" name="update"><i class="fas fa-sync"></i> Update</button>
                                        <button type="button" class="btn btn-danger rounded-0 euz_bt" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                                    </div>
                                </form></div>
                            </div>
                        </div>
                    </div>
                    <!--End Edit Agent--->
                    <?php } ?>
                </div>
            </div>			
        </div>
    </div>
    <!---Add agent---->
    <div class="modal fade" id="agentimport">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable euz_w_90">
            <div class="modal-content" style="width: 40%;">
                <div class="modal-header euz_carb p-0">
                    <h5 class="modal-title p-2 text-white">Import Agents</h5>
                    <button type="button" class="close" data-dismiss="modal">
                    <span>×</span>
                    </button>
                </div>
                <form method="post" enctype="multipart/form-data" action="{{ url('/admin/import_excel/import') }}">
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
                        <button type="submit" class="btn btn-success rounded-0 euz_bt" name="upload"><i class="fas fa-angle-double-up"></i> Upload</button>
                        <button type="button" class="btn btn-danger rounded-0 euz_bt" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End AddAgent--->
    <!---Add agent multi import---->
    <div class="modal fade" id="groupmulimport">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable euz_w_90">
            <div class="modal-content" style="width: 40%;">
                <div class="modal-header euz_carb p-0">
                    <h5 class="modal-title p-2 text-white">Import New Gateway Group</h5>
                </div>
                <form method="post" enctype="multipart/form-data" action="{{ url('/admin/import_excel/importmulgroup') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="agentidimport" id="agentidimport" value="" />
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12">
                                <label class="euz_b" for="">Upload File (Excel file only)</label>
                                <input type="file" class="form-control disname" id="" required name="select_file" accept=".xlsx, .xls" />
                            </div>					
                        </div>
                    </div>
                    <div class="modal-footer">
						<a href="{{ url('/excel/group.xlsx') }}" class="euz_a_icon mr-5 pr-5 euz_ied"><i class="fas fa-file-download euz_a_icon"></i> GatewayGroup Import Sheet</a>
                        <button type="submit" class="btn btn-success rounded-0 euz_bt" name="upload"><i class="fas fa-angle-double-up"></i> Upload</button>
                        <button type="button" class="btn btn-danger rounded-0 euz_bt" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End AddAgent multi import--->
    <!---profile---->
	<div id="agentprofile" class="euz_agent_profile euz_set_tabs" style="overflow-x:scroll; overflow-x: auto;"></div>
    <div id="agentprofiletree" class="euz_agent_profile euz_set_tabs" style="overflow-x:scroll; overflow-x: auto;"></div>
    <!---End Profile---->
    <a href="javascript:void(0)" class="btn euz_float_grexport euz_ied groupmulimport" title="Group import" data-toggle="modal" data-target="#groupmulimport"><i class="fas fa-sitemap"></i></a>
    <a href="javascript:void(0)" class="btn euz_float_export euz_ied" title="Export" onclick="exportagent()"><i class="fas fa-file-download"></i></a>
    <a href="javascript:void(0)" class="btn euz_float_import profileedit" title="Profile" data-toggle="modal" data-target="#profileedit"><i class="fas fa-portrait"></i></a>	
    <a href="javascript:void(0)" class="btn btn-danger euz_float_trash euz_ied"  onclick="deletedoc()"><i class="fas fa-trash-alt"></i></a>
    <a href="javascript:void(0)" class="btn euz_float_add" data-toggle="modal" data-target="#agentadd"><i class="fas fa-plus"></i></a>
    <!---Add agent---->
    <div class="modal fade" id="agentadd">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable euz_w_90">
            <div class="modal-content">
                <div class="modal-header euz_carb p-0">
                    <h5 class="modal-title p-2 text-white">Add New Agent</h5>
                </div>
                <div class="modal-body"><form action="insertagent" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                    <div class="">              
                        <div class="row">
                            <?php
                               $cus_id = DB::table('users')->orderBy('id', 'desc')->first();
                               $cusid = $cus_id->customer_id++;				
                               $cusid = substr($cusid, 3, 5);
                               $cusid = (int) $cusid + 1;
                               $cusid = "AG" . sprintf('%04s', $cusid);
                            ?> 
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="euz_b" for="">Customer ID</label>
                                <input type="text" class="form-control" id="" name="customer_id" required value="<?php echo $cusid; ?>" readonly />
                            </div>
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="euz_b" for="">First Name</label>
                                <input type="text" class="form-control disname" id="" value="" name="fname" required />
                            </div>
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="euz_b" for="">Last Name</label>
                                <input type="text" class="form-control disname" id="" value="" name="lname" required />
                            </div>
                            
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="euz_b" for="">Organization</label>
                                <input type="text" class="form-control disname" id="" value="" name="corporate_name" required />
                            </div>
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="euz_b" for="">Street</label>
                                <input type="text" class="form-control disname" id="" value="" name="street" required />
                            </div>
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="euz_b" for="">City</label>
                                <input type="text" class="form-control disname" id="" value="" name="city" required />
                            </div>                  
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="euz_b" for="">State</label>
                                <input type="text" class="form-control disname" id="" value="" name="state" required />
                            </div>
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="euz_b" for="">Post Code</label>
                                <input type="text" class="form-control disname" id="" value="" name="post_code" required />
                            </div>
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="euz_b" for="">Country</label>
                                <input type="text" class="form-control disname" id="" value="" name="country" required />
                            </div> 
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="euz_b" for="">Subscription Start Date</label>
                                <input type="date" class="form-control" id=""  name="service_start" required value="" />
                            </div>
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="euz_b" for="">Subscription End & Renew Date</label>
                                <input type="date" class="form-control disname" id="" value="" name="service_expiry" required />
                            </div>
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="euz_b" for="">Login Email</label>
                                <input type="email" class="form-control disname" id="" value="" name="email" required />
                            </div>
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="euz_b" for="">Password</label>
                                <input type="password" class="form-control disname" id="" value="" name="password" required />
                            </div>                   
                            <div class="form-group col-lg-9 col-md-8">
                                <label class="euz_b" for="">Remark</label>
                                <input type="text" class="form-control disname" id="" value="" name="remark" required />
                            </div>
                            <div class="form-group col-lg-3 col-md-4 py-2 mb-0">
                                <label for="" class="euz_b">Active</label><br>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" value="1" class="custom-control-input" id="addyes" name="status" checked />
                                    <label class="custom-control-label euz_b" for="addyes">Yes</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" value="0" class="custom-control-input" id="addno" name="status">
                                    <label class="custom-control-label euz_b" for="addno">No</label>
                                </div>
                            </div>                   
                            <div class="form-group col-md-8 py-2 mb-0">
                                <label for="" class="euz_b">Send Mail</label>
                                <input type="checkbox" name="sendmail" value="Y" class="addsend">
                                <span> (System will send profile modification message to the corresponding login email id)</span>
                            </div>
                            <div class="form-group col-md-12 addsendmailshow" id="">
                                <textarea type="text" class="form-control disname" rows="10" name="template" placeholder="Dear << firstname >>, .....">{{ (@$settings[0]->agent_email)?@$settings[0]->agent_email:"" }}</textarea>
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
    </div>
    <!--End AddAgent--->
    <!---Add profile edit import----> 
    <div class="modal fade" id="profileedit">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable euz_w_90">
            <div class="modal-content" style="width: 40%;">
                <div class="modal-header euz_carb p-0">
                    <h5 class="modal-title p-2 text-white">Import Agents</h5>
                    <button type="button" class="close" data-dismiss="modal">
                    <span>×</span>
                    </button>
                </div>
                <form method="post" enctype="multipart/form-data" action="{{ url('/admin/import_excel/profileimport') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="profileagentid" id="profileagentid" value="" />
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
    <!--End profile edit import--->
    
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
        function profileopen(userid) 
        {

            //Edit Agent
            var url = "{{ url('/admin/editAgent') }}";
            var docurl = url + "/" + userid;
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
            //Agent tree
            var url = "{{ url('/admin/editAgenttree') }}";
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
        //Agent Card checkcox
        $(".euz_ied").hide();
        $(function () {
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
        $(document).on("click", ".modalLink", function () 
        {
            var passedID = $(this).data('id');
            var url = "{{ url('/admin/editAgentpop') }}";
            var docurl = url + "/" + passedID;
            $.ajax({
                url : docurl,
                method : "GET",
                dataType: 'json',
                success:function(data)
                {
                    //alert(data.status);
                    if(data.status == '1')
                    {
                        //$("#edityes").attr('checked', 'checked');
                    }
                    else
                    {
                        
                        //$("#editno").attr('checked', 'checked');
                    }
                    $(".hiddenid").val(data.id);
                    $("#customer_id").val(data.customer_id);
					$("#fname").val(data.fname);					
					$("#lname").val(data.lname);
					$("#corporate_name").val(data.corporate_name);
                    $("#street").val(data.street);
					$("#city").val(data.city);					
					$("#state").val(data.state);
					$("#post_code").val(data.post_code);
                    $("#country").val(data.country);
					$("#service_expiry").val(data.service_expiry);
					$("#service_start").val(data.service_start);
					$("#email").val(data.email);
					$("#password").val(data.original);
                    $("#remark").val(data.remark);
                    $("#template").val(data.email_template);
                }
            });
        });
        function deletedoc()
        {

            //Deleting Agent
            if(!confirm("Are you sure do you want to delete?")) 
            {
                return false;
            }
            var selected = new Array();
            $("#checkarray:checked").each(function () {
                selected.push(this.value);
            });
            var agentid = selected.join(",");
            var url = "{{url('/admin/deleteagnt')}}";
            var docurl = url + "/" + agentid;
            $.ajax({
                url : docurl,
                method : "GET",
                success:function(response)
                {
                    alert('Delete successfully.');
                    location.reload();
                }
            });	
        }
        $(".addsendmailshow").hide();
        $(function () {
            $(".addsend").click(function () {
                if ($(this).is(":checked")) {
                    $(".addsendmailshow").show();
                } else {
                    $(".addsendmailshow").hide();
                }
            });
        });
        $(document).on("click", ".groupmulimport", function () 
        {
            var selected = new Array();
            $("#checkarray:checked").each(function () {
                selected.push(this.value);
            });
            var agentid = selected.join(",");
            $("#agentidimport").val(agentid);
        });
        function exportagent()
        {
            //Export agent
            var selected = new Array();
            $("#checkarray:checked").each(function () 
            {
                selected.push(this.value);
            });
            var agentid = selected.join(",");
            var url = "{{url('/admin/exportagent')}}";
            var docurl = url + "/" + agentid;
            window.location.href = docurl;	
        }
        $(document).on("click", ".profileedit", function () 
        {
            //Agent Edit
            var selected = new Array();
            $("#checkarray:checked").each(function () 
            {
                selected.push(this.value);
            });
            var agentid = selected[0];
            $("#profileagentid").val(agentid);
        });
    </script>
@parent
@endsection