
<style type="text/css">
    .grcolor{
        color:#1f3db3; !important;
    }
/*td{
    color:green;
}*/

</style>
<!--push msg list during search--->

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

if (isset($messages)){
if (count($messages)==0){
    echo "<tr><td colspan=9>Sorry No Records found</th></tr>";
}
}



                $i = 1; foreach($messages as $index =>$message) { ?>
                <tr id="tr<?php echo $message->udi;?>" >
                    <td <?php if ($message->readflaguserid==0){?> class="grcolor" <?php } ?> ><?php echo $i; //echo $message->readflag;?></td>
                    <td <?php if ($message->readflaguserid==0){?> class="grcolor" <?php } ?>>{{ $message->fname }} {{ $message->lname }}</td>
                    <td <?php if ($message->readflaguserid==0){?> class="grcolor" <?php } ?>>
                        
<?php


if ($message->noofcond==2){
$gid=$message->fcondgrp;
$grpname1="";
$grpname2="";
if ($gid!=0){
$grpdt=DB::table('userdatamessagesagent')->join('gateway_groups', 'gateway_groups.id', '=', 'userdatamessagesagent.fcondgrp')->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')->where('userdatamessagesagent.fcondgrp',$gid)->first();


$grpname1=$grpdt->name;
}
//dd($grpdt);

$gid2=$message->scondgrp;
if ($gid2!=0){
$grpdt2=DB::table('userdatamessagesagent')->join('gateway_groups', 'gateway_groups.id', '=', 'userdatamessagesagent.fcondgrp')->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')->where('userdatamessagesagent.fcondgrp',$gid2)->first();

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
$grpdt=DB::table('userdatamessagesagent')->join('gateway_groups', 'gateway_groups.id', '=', 'userdatamessagesagent.fcondgrp')->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')->where('userdatamessagesagent.fcondgrp',$gid)->first();


$grpname1=$grpdt->name;
}
//dd($grpdt);

$gid2=$message->scondgrp;
if ($gid2!=0){
$grpdt2=DB::table('userdatamessagesagent')->join('gateway_groups', 'gateway_groups.id', '=', 'userdatamessagesagent.fcondgrp')->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')->where('userdatamessagesagent.fcondgrp',$gid2)->first();

$grpname2=$grpdt2->name;
}


$gid3=$message->tcondgrp;
if ($gid3!=0){
$grpdt3=DB::table('userdatamessagesagent')->join('gateway_groups', 'gateway_groups.id', '=', 'userdatamessagesagent.fcondgrp')->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')->where('userdatamessagesagent.fcondgrp',$gid3)->first();

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
$grpdt=DB::table('userdatamessagesagent')->join('gateway_groups', 'gateway_groups.id', '=', 'userdatamessagesagent.fcondgrp')->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')->where('userdatamessagesagent.fcondgrp',$gid)->first();


$grpname1=$grpdt->name;
}
//dd($grpdt);





//}
echo $grpname1;
//echo ",$grpname2";
}




?>


                    </td>
                    <td <?php if ($message->readflaguserid==0){?> class="grcolor" <?php } ?>>

<?php

$hname1="";
$hname2="";
$hname3="";
if ($message->noofcond==2){
$hid=$message->fcondhub;
if ($hid!=0){
$hdt=DB::table('userdatamessagesagent')->join('sensor_hubs', 'sensor_hubs.id', '=', 'userdatamessagesagent.fcondhub')->where('userdatamessagesagent.fcondhub',$hid)->first();

$hname1=$hdt->hub_id;
}

$hid2=$message->scondhub;
if ($hid2!=0){
$hdt2=DB::table('userdatamessagesagent')->join('sensor_hubs', 'sensor_hubs.id', '=', 'userdatamessagesagent.scondhub')->where('userdatamessagesagent.scondhub',$hid2)->first();

$hname2=$hdt2->hub_id;
}



//}
echo $hname1;
echo ",$hname2";
}

if ($message->noofcond==3){
$hid=$message->fcondhub;
if ($hid!=0){
$hdt=DB::table('userdatamessagesagent')->join('sensor_hubs', 'sensor_hubs.id', '=', 'userdatamessagesagent.fcondhub')->where('userdatamessagesagent.fcondhub',$hid)->first();

$hname1=$hdt->hub_id;
}

$hid2=$message->scondhub;
if ($hid2!=0){
$hdt2=DB::table('userdatamessagesagent')->join('sensor_hubs', 'sensor_hubs.id', '=', 'userdatamessagesagent.scondhub')->where('userdatamessagesagent.scondhub',$hid2)->first();

$hname2=$hdt2->hub_id;
}
$hid3=$message->tcondhub;
if ($hid3!=0){
$hdt3=DB::table('userdatamessagesagent')->join('sensor_hubs', 'sensor_hubs.id', '=', 'userdatamessagesagent.tcondhub')->where('userdatamessagesagent.scondhub',$hid3)->first();

$hname3=$hdt3->hub_id;
}


//}
echo $hname1;
echo ",$hname2";
echo ",$hname3";
}






if ($message->noofcond==1){
$hid=$message->fcondhub;
if ($hid!=0){
$hdt=DB::table('userdatamessagesagent')->join('sensor_hubs', 'sensor_hubs.id', '=', 'userdatamessagesagent.fcondhub')->where('userdatamessagesagent.fcondhub',$hid)->first();
if(!empty($hdt->hub_id)) {
$hname1=$hdt->hub_id;
}
else{
    $hname1= '';
}
}





//}
echo $hname1;
//echo ",$hname2";
}








?>


                     </td>
                    <td <?php if ($message->readflaguserid==0){?> class="grcolor" <?php } ?>><?php //echo $message->sensor_id; 




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



//}
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



//}
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


//}
echo $sensname;
echo ",$sensname1";
echo ",$sensname2";
}





if ($message->noofcond==1){
    $sensname="";
    $sensname1="";
$sensid=$message->fcondsens;
if ($sensid!=0){
$sensdt=DB::table('sensors')->where('id',$sensid)->first();
if(!empty($sensdt->sensor_id)) {
    $sensname=$sensdt->sensor_id;
    }
    else{
        $sensname= '';
    }

}



echo $sensname;
//echo ",$sensname1";
}








                    ?>
                        




                    </td>
                    <td <?php if ($message->readflaguserid==0){?> class="grcolor" <?php } ?>><?php echo $message->created_at; ?></td>


                    <td <?php if ($message->readflaguserid==0){?> class="grcolor" <?php } ?>><?php echo $message->formula;?></td>
                    <td <?php if ($message->readflaguserid==0){?> class="grcolor" <?php } ?> ><?php echo $message->sensreading;?></td>
                    <td <?php if ($message->readflaguserid==0){?> class="grcolor" <?php } ?>><?php /* {{ Str::limit($message->push_message, $limit = 10, $end = '...') }}*/ ?><a href="#" onclick="updateread(<?php echo $message->udi;?>);"class="euz_inblue" data-toggle="modal" data-target="#pushinfo{{ $message->udi }}"><i class="fas fa-eye"></i> View</a></td>
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
                                {{ $message->push_message }}
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
       // updating message read flag 

$.ajax(
        {
            url: "{{ url('/agent/uppushmsgreadflag') }}",
            type: "get",
            data:{msgid:msgid},
            success: function(data)
            {
                
$("#tr"+msgid).find('td').removeClass("grcolor");
$.ajax(
        {
            url: "{{ url('/agent/uppushmsgreadflagcount') }}",
            type: "get",
            data:{msgid:msgid},
            success: function(data)
            {
                $(".cmsgagent").html("New "+data);
                if (data==0){
                    $(".cmsgagent").hide();
                    $(".agentmsgc").hide();
                }
                else{
                    
                    $(".cmsgagent").css("display","block");
                    $(".agentmsgc").css("display","block");
                }
            }});



            }
        });
    }


</script>
