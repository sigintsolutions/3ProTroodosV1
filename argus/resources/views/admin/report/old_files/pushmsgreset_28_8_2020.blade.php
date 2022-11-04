
<style type="text/css">
    .grcolor{
        color:#1f3db3; !important;
    }
/*td{
    color:green;
}*/

</style>


<div class="col-md-12">
    <div class="table-responsive-sm mt-3">
        <table class="table table-bordered table-striped">
            <thead class="euz_agent_table">
                <tr>
                    <th class="euz_agent_222">Sl.No</th>
                    <th class="euz_agent_222">Agent Name</th>
                    <th class="euz_agent_222">Gateway group</th>
                    <th class="euz_agent_222">Sensor Hub</th>
                    <th class="euz_agent_222">Sensor Id</th>
                    <th class="euz_agent_222">Notification Time</th>
                    <th class="euz_agent_222">Formula</th>
                    <th class="euz_agent_222">Sensor Reading</th>
                    <th class="euz_agent_222">Message</th>
                </tr>
            </thead>
            <tbody>
                <?php

error_reporting(0);
 $i = 1; foreach($messages as $index =>$message) { ?>
                <tr id="tr<?php echo $message->udi;?>" >
                    <td <?php if ($message->readflag==0){?> class="grcolor" <?php } ?> ><?php echo $i; //echo $message->readflag;?></td>
                    <td <?php if ($message->readflag==0){?> class="grcolor" <?php } ?>>{{ $message->fname }} {{ $message->lname }}</td>
                    <td <?php if ($message->readflag==0){?> class="grcolor" <?php } ?>>
                        
<?php
//$getgroup=DB::table('algorithm_sensor')->where('algorithm_id',$message->pid)->get();
//$grpname="";
//foreach($getgroup as $gg){
   //echo "$gg->"
    //$gid=$gg->groupid;
    //$hubdt=DB::table('sensor_hubs')->where('id',$hubid)->first();

//$grpdt=DB::table('algorithm_sensor')->join('gateway_groups', 'gateway_groups.id', '=', 'algorithm_sensor.groupid')->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')->where('gateway_groups.id',$gid)->first();

if ($message->noofcond==2){
$gid=$message->fcondgrp;
$grpname1="";
$grpname2="";
if ($gid!=0){
$grpdt=DB::table('userdatamessages')->join('gateway_groups', 'gateway_groups.id', '=', 'userdatamessages.fcondgrp')->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')->where('userdatamessages.fcondgrp',$gid)->first();


$grpname1=$grpdt->name;
}
//dd($grpdt);

$gid2=$message->scondgrp;
if ($gid2!=0){
$grpdt2=DB::table('userdatamessages')->join('gateway_groups', 'gateway_groups.id', '=', 'userdatamessages.fcondgrp')->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')->where('userdatamessages.fcondgrp',$gid2)->first();

$grpname2=$grpdt2->name;
}



//}
echo $grpname1;
echo ",$grpname2";
}

if ($message->noofcond==3){
$gid=$message->fcondgrp;
$grpname1="";
$grpname2="";
$grpname3="";
if ($gid!=0){
$grpdt=DB::table('userdatamessages')->join('gateway_groups', 'gateway_groups.id', '=', 'userdatamessages.fcondgrp')->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')->where('userdatamessages.fcondgrp',$gid)->first();


$grpname1=$grpdt->name;
}
//dd($grpdt);

$gid2=$message->scondgrp;
if ($gid2!=0){
$grpdt2=DB::table('userdatamessages')->join('gateway_groups', 'gateway_groups.id', '=', 'userdatamessages.fcondgrp')->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')->where('userdatamessages.fcondgrp',$gid2)->first();

$grpname2=$grpdt2->name;
}


$gid3=$message->tcondgrp;
if ($gid3!=0){
$grpdt3=DB::table('userdatamessages')->join('gateway_groups', 'gateway_groups.id', '=', 'userdatamessages.fcondgrp')->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')->where('userdatamessages.fcondgrp',$gid3)->first();

$grpname3=$grpdt3->name;
}




//}
echo $grpname1;
echo ",$grpname2";
echo ",$grpname3";
}






if ($message->noofcond==1){
$gid=$message->fcondgrp;
$grpname1="";
$grpname2="";
if ($gid!=0){
$grpdt=DB::table('userdatamessages')->join('gateway_groups', 'gateway_groups.id', '=', 'userdatamessages.fcondgrp')->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')->where('userdatamessages.fcondgrp',$gid)->first();


$grpname1=$grpdt->name;
}
//dd($grpdt);

/*$gid2=$message->scondgrp;
if ($gid2!=0){
$grpdt2=DB::table('userdatamessages')->join('gateway_groups', 'gateway_groups.id', '=', 'userdatamessages.fcondgrp')->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')->where('userdatamessages.fcondgrp',$gid2)->first();

$grpname2=$grpdt2->name;
}*/



//}
echo $grpname1;
//echo ",$grpname2";
}




?>


                    </td>
                    <td <?php if ($message->readflag==0){?> class="grcolor" <?php } ?>>

<?php

$hname1="";
$hname2="";
$hname3="";
if ($message->noofcond==2){
$hid=$message->fcondhub;
if ($hid!=0){
$hdt=DB::table('userdatamessages')->join('sensor_hubs', 'sensor_hubs.id', '=', 'userdatamessages.fcondhub')->where('userdatamessages.fcondhub',$hid)->first();

$hname1=$hdt->hub_id;
}

$hid2=$message->scondhub;
if ($hid2!=0){
$hdt2=DB::table('userdatamessages')->join('sensor_hubs', 'sensor_hubs.id', '=', 'userdatamessages.scondhub')->where('userdatamessages.scondhub',$hid2)->first();

$hname2=$hdt2->hub_id;
}




echo $hname1;
echo ",$hname2";
}

if ($message->noofcond==3){
$hid=$message->fcondhub;
if ($hid!=0){
$hdt=DB::table('userdatamessages')->join('sensor_hubs', 'sensor_hubs.id', '=', 'userdatamessages.fcondhub')->where('userdatamessages.fcondhub',$hid)->first();

$hname1=$hdt->hub_id;
}

$hid2=$message->scondhub;
if ($hid2!=0){
$hdt2=DB::table('userdatamessages')->join('sensor_hubs', 'sensor_hubs.id', '=', 'userdatamessages.scondhub')->where('userdatamessages.scondhub',$hid2)->first();

$hname2=$hdt2->hub_id;
}
$hid3=$message->tcondhub;
if ($hid3!=0){
$hdt3=DB::table('userdatamessages')->join('sensor_hubs', 'sensor_hubs.id', '=', 'userdatamessages.tcondhub')->where('userdatamessages.scondhub',$hid3)->first();

$hname3=$hdt3->hub_id;
}


echo $hname1;
echo ",$hname2";
echo ",$hname3";
}






if ($message->noofcond==1){
$hid=$message->fcondhub;
if ($hid!=0){
$hdt=DB::table('userdatamessages')->join('sensor_hubs', 'sensor_hubs.id', '=', 'userdatamessages.fcondhub')->where('userdatamessages.fcondhub',$hid)->first();

$hname1=$hdt->hub_id;
}

/*$hid2=$message->scondhub;
if ($hid2!=0){
$hdt2=DB::table('userdatamessages')->join('sensor_hubs', 'sensor_hubs.id', '=', 'userdatamessages.fcondhub')->where('userdatamessages.scondhub',$hid2)->first();

$hname2=$hdt2->hub_id;
}*/



//}
echo $hname1;
//echo ",$hname2";
}








?>


                     </td>
                    <td <?php if ($message->readflag==0){?> class="grcolor" <?php } ?>><?php //echo $message->sensor_id; 




if ($message->noofcond==2){
    $sensname="";
    $sensname1="";
$sensid=$message->fcondsens;
if ($sensid!=0){
$sensdt=DB::table('sensors')->where('id',$sensid)->first();
$sensname=$sensdt->sensor_id;
}


$sensid1=$message->scondsens;
if ($sensid1!=0){
$sensdt1=DB::table('sensors')->where('id',$sensid1)->first();
$sensname1=$sensdt1->sensor_id;
}




echo $sensname;
echo ",$sensname1";
}

if ($message->noofcond==2){
    $sensname="";
    $sensname1="";
$sensid=$message->fcondsens;
if ($sensid!=0){
$sensdt=DB::table('sensors')->where('id',$sensid)->first();
$sensname=$sensdt->sensor_id;
}


$sensid1=$message->scondsens;
if ($sensid1!=0){
$sensdt1=DB::table('sensors')->where('id',$sensid1)->first();
$sensname1=$sensdt1->sensor_id;
}




echo $sensname;
echo ",$sensname1";
}
if ($message->noofcond==3){
    $sensname="";
    $sensname1="";
    $sensname2="";
$sensid=$message->fcondsens;
if ($sensid!=0){
$sensdt=DB::table('sensors')->where('id',$sensid)->first();
$sensname=$sensdt->sensor_id;
}


$sensid1=$message->scondsens;
if ($sensid1!=0){
$sensdt1=DB::table('sensors')->where('id',$sensid1)->first();
$sensname1=$sensdt1->sensor_id;
}
$sensid2="";
$sensid2=$message->tcondsens;
if ($sensid2!=0){
$sensdt2=DB::table('sensors')->where('id',$sensid2)->first();
$sensname2=$sensdt2->sensor_id;
}



echo $sensname;
echo ",$sensname1";
echo ",$sensname2";
}





if ($message->noofcond==1){
    $sensname="";
    $sensname1="";
$sensid=$message->fcondsens;
//dd($sensid);
if ($sensid!=0){
$sensdt=DB::table('sensors')->where('id',$sensid)->first();
$sensname=$sensdt->sensor_id;
}



echo $sensname;
//echo ",$sensname1";
}








                    ?>
                        




                    </td>
                    <td <?php if ($message->readflag==0){?> class="grcolor" <?php } ?>><?php echo $message->created_at; ?></td>


                    <td <?php if ($message->readflag==0){?> class="grcolor" <?php } ?>><?php echo $message->formula;?></td>
                    <td <?php if ($message->readflag==0){?> class="grcolor" <?php } ?> ><?php echo $message->sensreading;?></td>
                    <td <?php if ($message->readflag==0){?> class="grcolor" <?php } ?>><?php /* {{ Str::limit($message->push_message, $limit = 10, $end = '...') }}*/ ?><a href="#" onclick="updateread(<?php echo $message->udi;?>);"class="euz_inblue" data-toggle="modal" data-target="#pushinfo{{ $message->udi }}"><i class="fas fa-eye"></i> View</a></td>
                </tr>
                <div class="modal fade" id="pushinfo{{ $message->udi }}">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                        <div class="modal-content">
                            <div class="modal-header euz_bar_agent">
                                <p class="modal-title euz_b mb-0">Push Notification Content</p>
                                <button type="button" class="close" data-dismiss="modal">
                                <span>×</span>
                                </button>
                            </div>
                            <div class="modal-body euz_border_agent">
                                <p class="text-justify">
                                {{$message->push_message}}

                                <p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $i++; } ?>
            </tbody>
        </table>
    </div>


</div>

<script type="text/javascript">



    function updateread(msgid){
       // alert(msgid);

$.ajax(
        {
            url: "{{ url('/admin/uppushmsgreadflag') }}",
            type: "get",
            data:{msgid:msgid},
            success: function(data)
            {
                //alert("Read");
                //$("#msglists").html(data);
//$("#tr"+msgid).removeClass('grcolor');
$("#tr"+msgid).find('td').removeClass("grcolor");
$.ajax(
        {
            url: "{{ url('/admin/uppushmsgreadflagcount') }}",
            type: "get",
            data:{msgid:msgid},
            success: function(data)
            {
               // $(".cmsg").html(data);

                //$(".agentmsgc").hide();

if (data==0){
                    $(".cmsg").hide();
                    $(".adminmsgc").hide();
                }
                else{
                    //alert("kkk"+data);
                    // $(".cmsgagent").show();
                    //$(".cmsg").html(data);
                    $(".cmsg").html("New "+data);
                    $(".cmsg").css("display","block");
                    $(".adminmsgc").css("display","block");
                    //$(".adminmsgc").html(data);
                }







            }});



            }
        });
    }


</script>