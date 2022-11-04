@extends('layouts.admin')
@section('content')

<!--Displaying alg list--->
    <div class="p-3">
        <div class="row">
            <div class="col-md-12 euz_bar">
                <i class="fas fa-user euz_text_blue"></i> <small class="euz_b euz_text_blue">Algorithm</small>
            </div>
            <div class="col-md-12 euz_border p-3 bg-white">
                <div class="row">  
                    <?php foreach($users as $user) { ?>         
                    <div class="col-md-4 mt-2">
                        <div class="card">
                            <div class="card-header">
                                <label class="euz_check_box euz_b pl-0"><?php echo $user->algorithmname; ?></label>
                            </div>
                            <div class="card-body pb-0 euz_b">
                                <p class="mb-2">Gateway Group : <?php echo $user->groupname; ?></p>
                                <p class="mb-2">Sensor Hub : <?php echo $user->hubname; ?></p>
                                <p class="mb-2">Sensor ID : <?php echo $user->sensor_id; ?></p>
                            </div> 
                            <div class="card-footer text-right bg-white euz_card_fo px-2">
                                <a href="javascript:void(0)" class="ml-2" data-toggle="tooltip" data-placement="top" title="View" onclick="profileopen(<?php echo $user->algorithmid;?>)"><i class="fas fa-eye euz_a_icon"></i></a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>			
        </div>
    </div>
    <!---profile---->
	<div id="agentprofile" class="euz_agent_profile euz_set_tabs" style="overflow-x:scroll;"></div>
    <!---End Profile---->
@endsection
@section('scripts')
    <script>
        $(function () 
        {
            $(".euz_a").css({ "color": "#16313c" });
            $("#algorithm").css({ "color": "#3990b3"});
        });
        function profileopen(userid) 
        {
            var url = "{{ url('/agent/editalgorithm') }}";
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
    </script>
@parent

@endsection