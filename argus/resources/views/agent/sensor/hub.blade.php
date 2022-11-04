@extends('layouts.admin')
@section('content')
    <div class="p-3">
        <div class="row">
            <div class="col-md-12 euz_bar euz_b">
                <a href="{{ url('/agent/gateway') }}"><i class="fas fa-user euz_text_blue"></i>  <?php echo $user[0]->fname.' '.$user[0]->lname; ?></a> / <a href="<?php echo  url('/agent/gateway'); ?>"><?php echo $groupname[0]->name; ?></a> / <span class="euz_ac_bl">Sensor Hub</span>
            </div>
            @if(Session::has('flash_message'))
            <div class="alert alert-success w-100"><button type="button" class="close" data-dismiss="alert">&times;</button>{{ Session::get('flash_message') }}</div>
            @endif
            <div class="col-md-12 euz_border p-3 bg-white">
                <div class="row">
                    <div class="col-md-12 my-2">
                        <a class="btn btn-primary float-right rounded-0 euz_bt ml-2" href="<?php echo url('/agent/gateway'); ?>"><i class="far fa-arrow-alt-circle-left"></i> Back To Gateway Group</a>
                    </div>
                    <?php foreach($hubs as $hub) { ?>
                    <div class="col-md-4 mt-2">
                        <div class="card">
                            <div class="card-header">
                                <div class="custom-checkbox">
                                    <label class="euz_check_box euz_b pl-0">{{ $hub->hub_id }}</label>
                                </div>
                            </div>
                            <div class="card-body pb-0 euz_b">
                                <p class="mb-2">Sensor Hub ID : {{ $hub->sensor_hub_id }}</p>
                                <p class="mb-2">MAC ID : {{ $hub->mac_id }}</p>
                            </div> 
                            <?php $sensorcnt = DB::table('sensors')->where('hub_id', $hub->id)->get(); ?>
                            <div class="card-footer text-right bg-white euz_card_fo px-0">
                                <span class="ml-2 float-left euz_gren"><i>Sensor : <?php echo count($sensorcnt); ?></i></span>
                                <a href="javascript:void(0)" class="ml-2" data-toggle="tooltip" data-placement="top" title="Hub Info" onclick="profileopen(<?php echo $hub->id;?>)"><i class="fas fa-eye euz_a_icon"></i></a>
                                <a href="<?php echo url('/agent/sensors/'.$hub->agent.'/'.$hub->group_id.'/'.$hub->id); ?>" class="ml-2" data-toggle="tooltip" data-placement="top" title="Sensor"><i class="fas fa-microchip euz_a_icon"></i></a>
								<a href="javascript:void(0)" class="euz_tree_in" data-toggle="tooltip" data-placement="top" title="Visual Hierarchy" onclick="profileopentree(<?php echo $hub->id;?>)"><i class="fas fa-sitemap"></i></a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>			
            </div>
        </div>
    </div>
    <!---profile---->
    <div id="agentprofile" class="euz_agent_profile" style="overflow-x: auto;"></div>
    <div id="agentprofiletree" class="euz_agent_profile" style="overflow-x: auto;"></div>
@endsection
@section('scripts')
    <script>
        function profileopen(hubid) 
        {


            //Getting Agent Profile
            var url = "{{ url('/agent/profileSensorhub') }}";
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

            //Agent Profile tree
            var url = "{{ url('/agent/editSensorhubtree') }}";
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
    </script>
@parent
@endsection
