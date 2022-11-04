@extends('layouts.admin')
@section('content')
	<!-- <div class="loader" style="display:none"></div> -->
    <div id="loading-image" style="display:none;"></div>
    <div class="p-3">
            <div class="row">
                <div class="col-md-12 euz_bar euz_b">
                    <div class="w-50 float-left">
						<ul class="m-0 p-0">
							<li class="nav-item dropdown" style="list-style:none;">					
							<a class="float-left euz_text_blue mr-2" href="{{ url('/admin/agents') }}"><i class="fas fa-user euz_text_blue"></i>  <?php echo $user[0]->fname.' '.$user[0]->lname; ?> / </a><a class="float-left euz_text_blue mr-2" href="<?php echo  url('/admin/groups/'.$user[0]->id); ?>"><?php echo $groupname[0]->name; ?> / </a>
							<a class="nav-link dropdown-toggle p-0 euz_text_blue float-left" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Sensor Hub
							</a>
							<ul class="dropdown-menu py-0">
                                <?php foreach($hubs as $hub) { ?>
                                <li><a class="dropdown-item" href="{{ url('/admin/sensors/'.$hub->agent.'/'.$hub->group_id.'/'.$hub->id) }}"><?php echo $hub->hub_id; ?></a></li>
                                <?php } ?>
                            </ul>
						</li>
						</ul>
					</div>					
                    <a href="{{ url('/excel/sensor.xlsx') }}" class="float-right euz_a_icon ml-3 euz_ied"><i class="fas fa-file-download euz_a_icon"></i> Sensor Import Sheet</a>
					<span class="float-right euz_b euz_text_blue ml-3 euz_ied">|</span>
					<a href="{{ url('/excel/hub.xlsx') }}" class="float-right euz_a_icon ml-3"><i class="fas fa-file-download euz_a_icon"></i> Sensor Hub Import Sheet</a>			
                </div>
                @if(Session::has('flash_message'))
                <div class="alert alert-success w-100"><button type="button" class="close" data-dismiss="alert">&times;</button>{{ Session::get('flash_message') }}</div>
                @endif
                <div class="col-md-12 euz_border p-3 bg-white">
                    <div class="row">
                        <div class="col-md-12 my-2">
                            <a class="btn euz_btn_add float-right euz_pointer" href="<?php echo url('/admin/groups/'.request()->agentid); ?>"><i class="far fa-arrow-alt-circle-left"></i> Back To Gateway Group</a>
                        </div>
                        <?php foreach($hubs as $hub) { ?>
                        <div class="col-md-4 mt-2">
                            <div class="card">
                                <div class="card-header">
                                    <div class="custom-checkbox">
                                        <label class="euz_check_box euz_b">{{ $hub->hub_id }}            
                                            <input type="checkbox" class="euz_check_agent" id="checkarray" name="checkarray[]" value="<?php echo $hub->id;?>" />
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="card-body pb-0 euz_b px-2">
                                    <p class="mb-2">Sensor Hub ID : {{ $hub->sensor_hub_id }}</p>
                                    <p class="mb-2">MAC ID : {{ $hub->mac_id }}</p>
                                </div> 
                                <?php $sensorcnt = DB::table('sensors')->where('hub_id', $hub->id)->get(); ?>
                                <div class="card-footer text-right bg-white euz_card_fo">
                                    <span class="ml-2 float-left euz_gren" style="font-size:16px;">Number of Sensor : <?php echo count($sensorcnt); ?></span>
                                    <a href="javascript:void(0)" class="ml-2" data-toggle="tooltip" data-placement="top" title="Hub Info" onclick="profileopen(<?php echo $hub->id;?>)"><i class="fas fa-eye euz_a_icon"></i></a>
                                    
                                    <a href="javascript:void(0)" class="ml-2 modalLink"  data-id="{{ $hub->id }}" title="Edit" data-toggle="modal" data-target="#hubedit"><i class="fas fa-edit euz_a_icon"></i></a>
                                    <a href="<?php echo url('/admin/deleteSensorhub/'.$hub->id); ?>" class="ml-2" title="Delete" onclick="return confirm('Are you sure do you want to delete?')"><i class="fas fa-trash-alt euz_a_icon"></i></a>
									
									<a href="<?php echo url('/admin/sensors/'.$hub->agent.'/'.$hub->group_id.'/'.$hub->id); ?>" class="sens ml-2 euz_tree_in" data-toggle="tooltip" data-placement="top" title="Sensor"><i class="fas fa-microchip"></i></a><a href="javascript:void(0)" class="euz_tree_in" data-toggle="tooltip" data-placement="top" title="Visual Hierarchy" onclick="profileopentree(<?php echo $hub->id;?>)"><i class="fas fa-sitemap"></i></a>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>			
            </div>
        </div>
    </div>
    <!---profile---->
    <div id="agentprofile" class="euz_agent_profile" style="overflow-x: auto;"></div>
    <div id="agentprofiletree" class="euz_agent_profile" style="overflow-x: auto;"></div>
    <!---End Profile---->
    <a href="#" class=" btn euz_float_grexport euz_ied sensormulimport" title="Sensor Import" data-toggle="modal" data-target="#sensormulimport"><i class="fas fa-microchip"></i></a>
    <a href="javascript:void(0)" class="btn euz_float_export euz_ied" title="Export" onclick="exporthub()"><i class="fas fa-file-download"></i></a>
    <a href="javascript:void(0)" class="btn euz_float_import hubeditpop" title="Hub Edit" data-toggle="modal" data-target="#hubeditpop"><i class="fas fa-file-upload"></i></a>		
    <a href="javascript:void(0)" class="btn btn-danger euz_float_trash euz_ied" onclick="deletedoc()"><i class="fas fa-trash-alt"></i></a>
    <a href="javascript:void(0)" class="btn euz_float_add" data-toggle="modal" data-target="#hubadd"><i class="fas fa-plus"></i></a>
    <!---Add import hub---->
    <div class="modal fade" id="hubimport">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable euz_w_90">
            <div class="modal-content" style="width: 40%;">
                <div class="modal-header euz_carb p-0">
                    <h5 class="modal-title p-2 text-white">Import New/Update Sensor Hubs</h5>
                </div>
                <form method="post" enctype="multipart/form-data" action="{{ url('/admin/import_excel/importhub') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="agent" value="<?php echo $user[0]->id; ?>" /> 
                    <input type="hidden" name="group_id" value="<?php echo $group[0]->id; ?>" />
                    <input type="hidden" name="sensor_group_id" value="<?php echo $groupname[0]->id; ?>" />
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
    <!--End import hub--->
    <!---Add mul import sensor---->
    <div class="modal fade" id="sensormulimport">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable euz_w_90">
            <div class="modal-content" style="width: 40%;">
                <div class="modal-header euz_carb p-0">
                    <h5 class="modal-title p-2 text-white">Import New Sensor</h5>
                </div>
                <form method="post" enctype="multipart/form-data" action="{{ url('/admin/import_excel/importmulsensor') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="hub_id" value="" id="hubidimport" /> 
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12">
                                <label class="euz_b" for="">Upload File (Excel file only)</label>
                                <input type="file" class="form-control disname" id="" required name="select_file" accept=".xlsx, .xls" />
                            </div>					
                        </div>
                    </div>
                    <div class="modal-footer">
						<a href="{{ url('/excel/sensor.xlsx') }}" class="float-right euz_a_icon mr-3 euz_ied"><i class="fas fa-file-download euz_a_icon"></i> Sensor Import Sheet</a>
                        <button type="submit" class="btn btn-success rounded-0 euz_bt" name="uploadhub"><i class="fas fa-angle-double-up"></i> Upload</button>
                        <button type="button" class="btn btn-danger rounded-0 euz_bt" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End mul import sensor--->
    <!---Add SensorHub---->
    <div class="modal fade" id="hubadd">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable euz_w_90">
            <div class="modal-content">
                <div class="modal-header euz_carb p-0">
                    <h5 class="modal-title p-2 text-white">Add New Sensor Hub</h5>
                </div>
				<div class="modal-body">
                <form action="{{ url('/admin/insertsensorhub') }}" method="POST" enctype="multipart/form-data" id="tmefrm">
                {{ csrf_field() }}
                    <input type="hidden" value="<?php echo $user[0]->id; ?>" name="agent" id="hubgetagent" />
                    <input type="hidden" value="<?php echo $group[0]->id; ?>" name="group_id" id="" />
                    <input type="hidden" value="<?php echo $groupname[0]->id; ?>" name="group" id="" />
                    
                        <div class="row">
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="euz_b" for="">Agent</label>
                                <input type="text" class="form-control disname" id="" value="<?php echo $user[0]->fname.' '.$user[0]->lname; ?>" disabled="disabled">
                            </div>
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="euz_b" for="">Gateway Group Name</label>
                                <input type="text" class="form-control disname" id="" value="<?php echo $groupname[0]->name; ?>" disabled="disabled">
                            </div>
                            <?php   
                                $cus_id = DB::table('sensor_hubs')->orderBy('id', 'desc')->first();							
                                if(empty($cus_id->sensor_hub_id)) 
                                {
                                    $cusid = 'SH0001';
                                }
                                else
                                {
                                    $cusid = $cus_id->sensor_hub_id++;				
                                    $cusid = substr($cusid, 3, 5);
                                    $cusid = (int) $cusid + 1;
                                    $cusid = "SH" . sprintf('%04s', $cusid);
                                }
                            ?>
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="euz_b" for="">Sensor Hub ID</label>
                                <input type="text" class="form-control disname" id="" value="<?php echo $cusid; ?>" readonly name="hubid" />
                            </div>
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="euz_b" for="">Sensor Hub Name</label>
                                <!-- <div class="input-group"> -->
                                    <select class="form-control select1" id="hubagentget" name="hub" required>
                                        <option value="">-Select Hub Name-</option>
                                        @foreach($hublists as $item)
                                        <?php
                                            //$hub = explode('argus/report/', $item->hub);
                                        ?>
                                        <option value="<?php echo $item; ?>"><?php echo $item; ?></option>
                                        @endforeach
                                    </select>
                                    <!-- <div class="input-group-prepend">
                                        <a class="btn btn-primary" style="height: 33px;" data-toggle="modal" data-backdrop="static" data-target="#add"><i class="fas fa-plus"></i></a>
                                    </div>
                                </div> -->
                            </div>                           
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="euz_b" for="">MAC ID</label>
                                <input type="text" class="form-control disname" required id="" value="" name="mac" onblur="checkmacid();" />
                            </div>
                            
                            <div class="form-group col-lg-12 col-md-4">
                                <label class="euz_b" for="">Sensor Hub Information</label>
                                <textarea type="text" class="form-control disname" id="" rows="5" name="inform" ></textarea>
                            </div>                            
                        </div>
                    
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success rounded-0 euz_bt" id="butSen"><i class="far fa-save"></i> Save</button>
                        <button type="button" class="btn btn-danger rounded-0 euz_bt" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                    </div>
                </form>
				</div>
            </div>
        </div>
    </div>
    <!--End AddSensorHub--->
    <!---Edit SensorHub---->
    <div class="modal fade" id="hubedit">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable euz_w_90">
            <div class="modal-content">
                <div class="modal-header euz_carb p-0">
                    <h5 class="modal-title p-2 text-white">Edit Sensor Hub</h5>
                </div>
                <form action="{{ url('admin/updatesensorhub') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="eid" value="" id="eid" />
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
                                <label class="euz_b" for="">Sensor Hub ID</label>
                                <input type="text" class="form-control disname" id="sensor_hub_id" value="" disabled="disabled">
                            </div>
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="euz_b" for="">Sensor Hub Name</label>
                                <!-- <div class="input-group"> -->
                                    <select class="form-control disname select1" required id="hub" name="hub">
                                        @foreach($hublists as $item3)
                                        <?php
                                            //$hub = explode('argus/report/', $item3->hub);
                                            //print_r($hub);
                                        ?>
                                        <option value="<?php echo $item3; ?>"><?php echo $item3; ?></option>
                                        @endforeach
                                    </select>
                                    <!-- <div class="input-group-prepend">
                                        <a class="btn btn-primary" style="height: 33px;" data-toggle="modal" data-backdrop="static" data-target="#add"><i class="fas fa-plus"></i></a>
                                    </div>
                                </div> -->
                            </div>
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="euz_b" for="">MAC ID</label>
                                <input type="text" class="form-control disname" required id="mac" value="" name="mac">
                            </div>
                            
                            <div class="form-group col-lg-12 col-md-4">
                                <label class="euz_b" for="">Sensor Hub Information</label>
                                <textarea type="text" class="form-control disname" id="inform" rows="5" name="inform" ></textarea>
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
    <!--End EditSensorHub--->
    <!---Add Hub edit import----> 
    <div class="modal fade" id="hubeditpop">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable euz_w_90">
            <div class="modal-content" style="width: 40%;">
                <div class="modal-header euz_carb p-0">
                    <h5 class="modal-title p-2 text-white">New/Update Hub</h5>
                    <button type="button" class="close" data-dismiss="modal">
                    <span>×</span>
                    </button>
                </div>
                <form method="post" enctype="multipart/form-data" action="{{ url('admin/import_excel/hubeditimport') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="hubeditpopid" id="hubeditpopid" value="" />
                    <input type="hidden" name="agent" value="<?php echo $user[0]->id; ?>" /> 
                    <input type="hidden" name="group_id" value="<?php echo $group[0]->id; ?>" />
                    <input type="hidden" name="sensor_group_id" value="<?php echo $groupname[0]->id; ?>" />
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
    <!--End Hub edit import--->
    <!-- add groupname popup -->
    <div class="modal fade" id="add">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header euz_carb p-0">
                    <h5 class="modal-title p-2 text-white">Add New Sensor Hub</h5>
                </div>
                <form method="post" id="addform">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="euz_b" for="">New SensorHub</label>
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
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css" rel="stylesheet" />
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
	

    // $('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
    // if (!$(this).next().hasClass('show')) {
    //     $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
    // }
    // var $subMenu = $(this).next(".dropdown-menu");
    // $subMenu.toggleClass('show');


    // $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
    //     $('.dropdown-submenu .show').removeClass("show");
    // });


    // return false;
    // });
</script>

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
        function profileopen(hubid) 
        {
            var url = "{{ url('/admin/editSensorhub') }}";
            var docurl = url + "/" + hubid;
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
            var url = "{{ url('/admin/editSensorhubtree') }}";
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
        $(document).on("click", ".modalLink", function () 
        {
            var passedID = $(this).data('id'); 
            //alert(passedID);
            var url = "{{ url('/admin/editSensorhubpop') }}";
            var docurl = url + "/" + passedID;
            $.ajax({
                url : docurl,
                method : "GET",
                dataType: 'json',
                success:function(data)
                {
                   //alert(data.hub_id); 
                    $("#eid").val(data.id);
                    $("#sensor_hub_id").val(data.sensor_hub_id);
                    $("#hub").val(data.hub_id);
					$("#mac").val(data.mac_id);					
					$("#inform").val(data.hub_inform);
                }
            });
        });
        function deletedoc()
        {
            if(!confirm("Are you sure do you want to delete?")) 
            {
                return false;
            }
            var selected = new Array();
            $("#checkarray:checked").each(function () 
            {
                selected.push(this.value);
            });
            var hubid = selected.join(",");
            var url = "{{url('/admin/deleteSensorhubs')}}";
            var docurl = url + "/" + hubid;
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
        $(document).on("click", ".sensormulimport", function () 
        {
            var selected = new Array();
            $("#checkarray:checked").each(function () {
                selected.push(this.value);
            });
            var groupid = selected.join(",");
            $("#hubidimport").val(groupid);
        });
        function exporthub()
        {
            //alert();
            var selected = new Array();
            $("#checkarray:checked").each(function () 
            {
                selected.push(this.value);
            });
            var hubid = selected.join(",");
            var url = "{{url('/admin/exporthub')}}";
            var docurl = url + "/" + hubid;
            window.location.href = docurl;	
        }
        $(document).on("click", ".hubeditpop", function () 
        {
            var selected = new Array();
            $("#checkarray:checked").each(function () 
            {
                selected.push(this.value);
            });
            var groupid = selected[0];
           // alert(groupid);
            $("#hubeditpopid").val(groupid);
        });
        $('#addform').on('submit', function(event)
        {
            event.preventDefault();
            $.ajax(
            {      
                url:"{{  url('/admin/inserthubpop') }}",
                method:"POST",
                data:new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json',
                success: function(data)
                {
                    alert('Hub Name Added')
                    $('#add').modal('hide');
                    $('.select1').empty();
                    var i=0;
                    $.each(data, function(key, value) 
                    {		
                        $('.select1').append('<option value="'+ data[i].id +'">'+ data[i].name +'</option>');
                        i++;
                    });
                }
            });			
        });       
        $("#butSen").click(function()
        {
            // $.ajax(
            // {
            //     url: "{{ url('/admin/insertsensorhub') }}",
            //     type: "post",
            //     data: $('#tmefrm').serialize(),
            //     success: function(data)
            //     {
            //         $("#hubadd").hide();
            //         if(data == 'fail')
            //         {                        
            //             ConfirmDialog('This Sensor Hub already assigned to Agent Full Name Here . Do you want to continue?');
            //             function ConfirmDialog(message) 
            //             {
            //                 $('<div></div>').appendTo('body')
            //                 .html('<div><h6>' + message + '?</h6></div>')
            //                 .dialog({
            //                 modal: true,
            //                 title: 'Alert',
            //                 zIndex: 10000,
            //                 autoOpen: true,
            //                 width: 'auto',
            //                 resizable: false,
            //                 buttons: {
            //                     Continue: function() 
            //                     {
            //                         //$(this).dialog("close");
            //                         $.ajax(
            //                         {
            //                             url: "{{ url('/admin/insertsensorhubalert') }}",
            //                             type: "post",
            //                             data: $('#tmefrm').serialize(),
            //                             success: function(data)
            //                             {
            //                                 alert('Success');
            //                                 location.reload();
            //                             }
            //                         });                              
            //                     },
            //                     Cancel: function() 
            //                     {
            //                         $(this).dialog("close");
            //                     }
            //                 },
            //                 close: function(event, ui) {
            //                     $(this).remove();
            //                 }
            //                 });
            //             };
            //         }
            //         else
            //         {
            //             alert('Success');
            //             location.reload();
            //         }
            //     }
            // });
        });
        // $(document).ready(function() 
        // {
        //     $('.sens').click(function() 
        //     {
        //         $(".loader").show();
        //     }); 
        // });
        $('#hubagentget').on('change', function () 
        {
            var selectData = $('#hubagentget').val();
            var agent = $("#hubgetagent").val();
            var url1 = "{{ url('/admin/gethubdrop?val1') }}";
            var url2 = "&val2";
            var docurl = url1 + "=" + agent + url2 + "=" + selectData;
            $.ajax(
            {
                url : docurl,
                method : "GET",
                //dataType: 'json',
                success:function(data)
                {
                    //var jsonData = $.parseJSON(data);
                    //alert(data);
                    var name = data;
                    $("#hubadd").hide();                  
                    if(data != '')
                    {
                        //$("#hubadd").hide();
                        ConfirmDialog('This Sensor Hub already assigned to ' + name +'. Do you want to continue?');
                        function ConfirmDialog(message) 
                        {
                            $('<div></div>').appendTo('body')
                            .html('<div><h6>' + message + '?</h6></div>')
                            .dialog({
                            modal: true,
                            title: 'Alert',
                            zIndex: 10000,
                            autoOpen: true,
                            width: 'auto',
                            resizable: false,
                            buttons: 
                            {
                                Continue: function() 
                                {
                                    $(this).dialog("close"); 
                                    $("#hubadd").show();                            
                                },
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
        });


function checkmacid(){
	alert("hai");
}


    </script>
    <style>
        .modal-backdrop.show 
        {
            opacity: 0 !important;
            display:none;
        }
    </style>
@parent
@endsection
